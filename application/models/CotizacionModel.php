<?php
class CotizacionModel extends CI_Model
{
	public function cargar_tarifa($tarifa_elegida)
	{
		switch ($tarifa_elegida) {
			case 'tarifa_dac':
				$query = $this->db->query("SELECT dac, suministro_residencial FROM tarifas_cfe");
				break;
			case 'tarifa_pdbt':
				$query = $this->db->query("SELECT pdbt, suministro_comercial FROM tarifas_cfe");
				break;
			case 'tarifa_01':
				$query = $this->db->query("SELECT d1, d1_limite_inferior, d1_limite_superior, d2, d2_limite_inferior, d2_limite_superior, d3, d3_limite_inferior, d3_limite_superior, suministro_residencial FROM tarifas_cfe");
				break;
		}

		return $query->row();
	}

	public function costos_generales()
	{
		$query = $this->db->query("SELECT * FROM costos_generales");
		return $query->row();
	}

	public function datos_generales()
	{
		$query = $this->db->query("SELECT * FROM datos_generales");
		return $query->row();
	}

	public function tasa_cambio()
	{
		$query = $this->db->query("SELECT id_tasa_cambio,tasa_cambio,DATE_FORMAT(fecha_tasa,'%d - %b - %Y') as fecha_tasa,tipo_obtencion FROM tasa_cambio");
		return $query->row();
	}

	public function cargar_panel($id_panel)
	{
		$query = $this->db->query("SELECT * FROM paneles WHERE id_panel = ?", $id_panel);
		return $query->row();
	}

	public function obtener_datos_iniciales()
	{
		$query = $this->db->query("SELECT *, DATE_FORMAT(fecha_tasa,'%d/%m/%Y') as solo_fecha_tasa, TIME_FORMAT(fecha_tasa, '%H:%i %p') as solo_hora_tasa FROM tasa_cambio");
		if ($query->num_rows() > 0) {
			$obj['tasa_cambio'] = $query->row();
		} else {
			$obj['resultado'] = false;
		}

		$query = $this->db->query("SELECT *, DATE_FORMAT(fecha_actualizacion,'%d/%m/%Y') as solo_fecha_cfe, TIME_FORMAT(fecha_actualizacion, '%H:%i %p') as solo_hora_cfe FROM tarifas_cfe");

		if ($query->num_rows() > 0) {
			$obj['tarifas_cfe'] = $query->row();
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function obtener_elementos_cotizacion()
	{
		$obj['paneles'] = $this->db->query("SELECT id_panel, codigo FROM paneles WHERE estado = 'ACTIVO'")->result();
		$obj['sistemas_monitoreo'] = $this->db->query("SELECT id_sistema_monitoreo, codigo FROM sistemas_monitoreo WHERE estado = 'ACTIVO'")->result();
		$obj['inversores'] = $this->db->query("SELECT id_inversor, codigo FROM inversores WHERE estado = 'ACTIVO'")->result();
		$obj['optimizadores'] = $this->db->query("SELECT id_optimizador, codigo FROM optimizadores WHERE estado = 'ACTIVO'")->result();
		$obj['microinversores'] = $this->db->query("SELECT id_microinversor, codigo FROM microinversores WHERE estado = 'ACTIVO'")->result();
		$obj['tipos_estructura'] = $this->db->query("SELECT id_tipo_estructura, codigo FROM tipos_estructura")->result();

		return $obj;
	}

	public function cargar_cotizacion_temporal($datos_usuario)
	{
		$query = $this->db->query("SELECT id_cotizacion_temporal FROM usuarios WHERE id_usuario = ?", $datos_usuario['id_usuario']);

		if ($query->num_rows() > 0) {
			$id_usuario = $datos_usuario['id_usuario'];
			$id_cotizacion_temporal = $query->row_array()['id_cotizacion_temporal'];

			$query = $this->db->query("SELECT * FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

			if ($query->num_rows() > 0) {
				$obj['tipo_cotizacion'] = "existente";
				$datos_usuario['id_cotizacion_temporal'] = $id_cotizacion_temporal;
				$obj['usuario'] = $datos_usuario;
				$obj['cotizacion_temporal'] = $query->row_array();
				$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
				if ($calcular_totales['resultado']) {
					$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
					$obj['totales'] = $calcular_totales['totales'];
					if ($obj['cotizacion_temporal']['paneles_elegidos'] == 1) {
						$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$obj['cotizacion_temporal']['produccion_periodo'], $obj['cotizacion_temporal'], $obj['totales']['total_final']);
					}
				} else {
					$obj['productos_temporales'] = false;
					$obj['totales'] = false;
				}
			} else {
				$obj['tipo_cotizacion'] = "nueva";
				$id_usuario = $datos_usuario['id_usuario'];

				$query = $this->db->query("SELECT * FROM costos_generales");
				$costos_generales = $query->row_array();

				$query = $this->db->query("SELECT * FROM datos_generales");
				$datos_generales = $query->row_array();

				$query = $this->db->query("SELECT * FROM tasa_cambio");
				$tasa_cambio = $query->row_array();

				$this->db->query("INSERT INTO cotizaciones_temporales (id_usuario, dap, eficiencia, hps, indice_utilidad, tasa_cambio, fecha_tasa, tasa_iva, periodo_dias, fecha_cotizacion, costo_metro) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)", array($id_usuario, $costos_generales['dap'], $datos_generales['eficiencia'], $datos_generales['hps'], $costos_generales['indice_utilidad'], $tasa_cambio['tasa_cambio'], $tasa_cambio['fecha_tasa'], $costos_generales['iva'], $datos_generales['periodo'], $costos_generales['costo_metro']));

				$nuevo_id_cotizacion_temporal = $this->db->insert_id();

				$this->db->query("UPDATE usuarios SET id_cotizacion_temporal = ? WHERE id_usuario = ?", array($nuevo_id_cotizacion_temporal, $id_usuario));

				$query = $this->db->query("SELECT * FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $nuevo_id_cotizacion_temporal);

				$obj['cotizacion_temporal'] = $query->row_array();
				$datos_usuario['id_cotizacion_temporal'] = $nuevo_id_cotizacion_temporal;
				$obj['nuevo_id_cotizacion_temporal'] = $nuevo_id_cotizacion_temporal;
				$obj['usuario'] = $datos_usuario;
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function reiniciar_cotizacion_temporal($datos_usuario)
	{
		$id_usuario = $datos_usuario['id_usuario'];
		$query = $this->db->query("SELECT id_cotizacion_temporal FROM usuarios WHERE id_usuario = ?", $id_usuario);

		if ($query->num_rows() > 0) {
			$id_cotizacion_temporal = $query->row_array()['id_cotizacion_temporal'];

			$query = $this->db->query("SELECT * FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

			if ($query->num_rows() > 0) {
				$this->db->trans_begin();

				$this->db->query("UPDATE usuarios SET id_cotizacion_temporal = NULL WHERE id_usuario = ?", array($id_usuario));

				$this->db->query("DELETE FROM cotizaciones_temporales_ahorro WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

				$this->db->query("DELETE FROM cotizaciones_productos_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

				$this->db->query("DELETE FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

				if ($this->db->trans_status() === FALSE) {
					$obj['resultado'] = false;
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();

					$obj['resultado'] = true;
					$datos_usuario['id_cotizacion_temporal'] = null;
					$obj['usuario'] = $datos_usuario;
				}
			} else {
				$obj['resultado'] = true;
				$datos_usuario['id_cotizacion_temporal'] = null;
				$obj['usuario'] = $datos_usuario;
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function cargar_productos_temporales($id_cotizacion_temporal)
	{
		$query = $this->db->query("SELECT * FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);
		$obj['resultado'] = $query->num_rows() > 0;
		$obj['cotizacion_temporal'] = $query->row();
		return $obj;
	}

	public function guardar_nombre($id_cotizacion_temporal, $nombre)
	{
		$query = $this->db->query("UPDATE cotizaciones_temporales SET nombre = ? WHERE id_cotizacion_temporal = ?", array($nombre, $id_cotizacion_temporal));
		$obj['resultado'] = $this->db->affected_rows() >= 0;
		return $obj;
	}

	public function guardar_ubicacion($id_cotizacion_temporal, $ubicacion)
	{
		$query = $this->db->query("UPDATE cotizaciones_temporales SET ubicacion = ? WHERE id_cotizacion_temporal = ?", array($ubicacion, $id_cotizacion_temporal));
		$obj['resultado'] = $this->db->affected_rows() >= 0;
		return $obj;
	}

	public function guardar_telefono($id_cotizacion_temporal, $telefono)
	{
		$query = $this->db->query("UPDATE cotizaciones_temporales SET telefono = ? WHERE id_cotizacion_temporal = ?", array($telefono, $id_cotizacion_temporal));
		$obj['resultado'] = $this->db->affected_rows() >= 0;
		return $obj;
	}

	public function guardar_correo($id_cotizacion_temporal, $correo)
	{
		$query = $this->db->query("UPDATE cotizaciones_temporales SET correo = ? WHERE id_cotizacion_temporal = ?", array($correo, $id_cotizacion_temporal));
		$obj['resultado'] = $this->db->affected_rows() >= 0;
		return $obj;
	}

	public function guardar_num_servicio($id_cotizacion_temporal, $num_servicio)
	{
		$query = $this->db->query("UPDATE cotizaciones_temporales SET numero_servicio = ? WHERE id_cotizacion_temporal = ?", array($num_servicio, $id_cotizacion_temporal));
		$obj['resultado'] = $this->db->affected_rows() >= 0;
		return $obj;
	}

	public function guardar_fecha($id_cotizacion_temporal, $fecha)
	{
		$query = $this->db->query("UPDATE cotizaciones_temporales SET fecha_cotizacion = ? WHERE id_cotizacion_temporal = ?", array($fecha, $id_cotizacion_temporal));
		$obj['resultado'] = $this->db->affected_rows() >= 0;
		return $obj;
	}

	public function guardar_mostrar_roi($id_cotizacion_temporal, $mostrar_roi)
	{
		$query = $this->db->query("UPDATE cotizaciones_temporales SET mostrar_roi = ? WHERE id_cotizacion_temporal = ?", array($mostrar_roi, $id_cotizacion_temporal));
		$obj['resultado'] = $this->db->affected_rows() >= 0;
		return $obj;
	}

	public function guardar_periodo($id_cotizacion_temporal, $periodo)
	{
		if ($periodo == "mensual") {
			$periodo_dias = 30;
		} else {
			$periodo_dias = 60;
		}
		$query = $this->db->query("UPDATE cotizaciones_temporales SET periodo_dias = ? WHERE id_cotizacion_temporal = ?", array($periodo_dias, $id_cotizacion_temporal));
		$obj['resultado'] = $this->db->affected_rows() >= 0;
		return $obj;
	}

	public function guardar_tipo_interconexion($id_cotizacion_temporal, $tipo_interconexion)
	{
		$query = $this->db->query("UPDATE cotizaciones_temporales SET tipo_interconexion = ? WHERE id_cotizacion_temporal = ?", array($tipo_interconexion, $id_cotizacion_temporal));
		$obj['resultado'] = $this->db->affected_rows() >= 0;
		return $obj;
	}

	public function guardar_precio_promedio($periodo, $tarifa, $forma_calculo, $consumo_promedio_pesos_final, $gasto_anual, $gasto_bimestral, $consumo_promedio_kwh, $datos_recibo, $suministro, $id_cotizacion_temporal)
	{
		$query = $this->db->query("UPDATE cotizaciones_temporales SET periodo = ?, tarifa = ?, forma_calculo = ?, consumo_promedio_precio = ?, gasto_anual_cfe = ?, gasto_bimestral_cfe = ?, consumo_promedio_kwh = ?, recibo_1 = ?, recibo_2 = ?, recibo_3 = ?, recibo_4 = ?, recibo_5 = ?, recibo_6 = ?, costo_suministro = ? WHERE id_cotizacion_temporal = ?", array($periodo, $tarifa, $forma_calculo, $consumo_promedio_pesos_final, $gasto_anual, $gasto_bimestral, $consumo_promedio_kwh, $datos_recibo[0], $datos_recibo[1], $datos_recibo[2], $datos_recibo[3], $datos_recibo[4], $datos_recibo[5], $suministro, $id_cotizacion_temporal));
		$obj = $this->db->affected_rows() >= 0;
		return $obj;
	}

	public function guardar_consumo_promedio($periodo, $tarifa, $forma_calculo, $consumo_promedio_pesos, $gasto_anual, $gasto_bimestral, $consumo_promedio_kwh, $suministro, $id_cotizacion_temporal)
	{
		$query = $this->db->query("UPDATE cotizaciones_temporales SET periodo = ?, tarifa = ?, forma_calculo = ?, consumo_promedio_precio = ?, gasto_anual_cfe = ?, gasto_bimestral_cfe = ?, consumo_promedio_kwh = ?, costo_suministro = ? WHERE id_cotizacion_temporal = ?", array($periodo, $tarifa, $forma_calculo, $consumo_promedio_pesos, $gasto_anual, $gasto_bimestral, $consumo_promedio_kwh, $suministro, $id_cotizacion_temporal));
		$obj = $this->db->affected_rows() >= 0;
		return $obj;
	}

	public function guardar_panel($id_cotizacion_temporal, $id_panel)
	{
		$query = $this->db->query("SELECT eficiencia, periodo_dias, tasa_cambio, tasa_iva, consumo_promedio_kwh, consumo_promedio_precio, indice_utilidad, hps, periodo, tarifa, dap, costo_suministro, gasto_anual_cfe FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

		if ($query->num_rows() > 0) {
			$datos_calculo = $query->row_array();
			$query = $this->db->query("SELECT * FROM paneles WHERE id_panel = ?", $id_panel);

			if ($query->num_rows() > 0) {
				$panel = $query->row_array();
				$indice_utilidad = (100 - ((float)$datos_calculo['indice_utilidad'])) / 100;
				$hps = (float)$datos_calculo['hps'];
				$eficiencia = (float)$datos_calculo['eficiencia'] / 100;
				$kw_panel = (float)$panel['watts_panel'] / 1000;
				$usd_watt = $panel['usd_watt'];
				$produccion_panel = round($hps * $kw_panel * $eficiencia * (int)$datos_calculo['periodo_dias'], 2);

				$num_paneles = floor((float)$datos_calculo['consumo_promedio_kwh'] / $produccion_panel);
				$cpu_usd = (float)$panel['usd_panel'];
				$cpu_mxn = round($cpu_usd * (float)$datos_calculo['tasa_cambio'], 2);
				$costo_total = round($num_paneles * $cpu_mxn, 2);
				$precio_unitario = round($cpu_mxn / $indice_utilidad, 2);
				$precio_final = round($precio_unitario * $num_paneles, 2);

				$produccion_promedio = round($produccion_panel * $num_paneles, 2);
				$porcentaje_produccion = round($produccion_promedio / (float)$datos_calculo['consumo_promedio_kwh'] * 100, 2);
				$potencia_total = round($kw_panel * $num_paneles, 2);
				if ($datos_calculo['periodo'] == "mensual") {
					$produccion_anual = round($produccion_promedio * 12, 2);
				} else {
					$produccion_anual = round($produccion_promedio * 6, 2);
				}

				$query = $this->db->query("SELECT id_producto_temporal FROM cotizaciones_productos_temporales WHERE id_cotizacion_temporal = ? AND principal = 1 AND tipo_producto LIKE 'panel_solar'", $id_cotizacion_temporal);

				$this->db->trans_begin();

				if ($query->num_rows() > 0) {
					$id_producto_temporal = $query->row_array()['id_producto_temporal'];
					$query = $this->db->query("UPDATE cotizaciones_productos_temporales SET cantidad = ?, cpu_usd = ?, cpu_mxn = ?, costo_total = ?, precio_unitario = ?, precio_final = ?, id_producto = ? WHERE id_producto_temporal = ?", array($num_paneles, $cpu_usd, $cpu_mxn, $costo_total, $precio_unitario, $precio_final, $id_panel, $id_producto_temporal));
				} else {
					$query = $this->db->query("INSERT INTO cotizaciones_productos_temporales (id_cotizacion_temporal, cantidad, cpu_usd, cpu_mxn, costo_total, precio_unitario, precio_final, principal, id_producto, tipo_producto) VALUES(?,?,?,?,?,?,?,1,?,'panel_solar')", array($id_cotizacion_temporal, $num_paneles, $cpu_usd, $cpu_mxn, $costo_total, $precio_unitario, $precio_final, $panel['id_panel']));
				}

				$query = $this->db->query("UPDATE cotizaciones_temporales SET num_paneles = ?, potencia_total = ?, produccion_periodo = ?, porcentaje_produccion = ?, produccion_anual = ?, costo_por_watt = ?, paneles_elegidos = 1 WHERE id_cotizacion_temporal = ?", array($num_paneles, $potencia_total, $produccion_promedio, $porcentaje_produccion, $produccion_anual, $usd_watt, $id_cotizacion_temporal));

				if ($this->db->trans_status() === FALSE) {
					$obj['resultado'] = false;
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();

					$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
					if ($calcular_totales['resultado']) {
						$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
						$obj['totales'] = $calcular_totales['totales'];
						$datos_calculo['paneles_elegidos'] = 1;
						$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, $produccion_promedio, $datos_calculo, $obj['totales']['total_final']);
					} else {
						$obj['productos_temporales'] = [];
					}

					$obj['resultado'] = true;
					$obj['potencia_total'] = $potencia_total;
					$obj['produccion_promedio'] = $produccion_promedio;
					$obj['produccion_anual'] = $produccion_anual;
					$obj['ahorro'] = $porcentaje_produccion;
					$obj['num_paneles'] = $num_paneles;
				}
			} else {
				$obj['resultado'] = false;
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function guardar_numero_paneles($id_cotizacion_temporal, $id_panel, $num_paneles)
	{
		$query = $this->db->query("SELECT eficiencia, periodo_dias, tasa_cambio, tasa_iva, consumo_promedio_kwh, consumo_promedio_precio, indice_utilidad, hps, periodo, tarifa, dap, costo_suministro, gasto_anual_cfe, paneles_elegidos FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

		if ($query->num_rows() > 0) {
			$datos_calculo = $query->row_array();
			$id_producto_temporal = $this->db->query("SELECT id_producto_temporal FROM cotizaciones_productos_temporales WHERE id_cotizacion_temporal = ? AND principal = 1 AND tipo_producto LIKE 'panel_solar'", $id_cotizacion_temporal)->row_array()['id_producto_temporal'];

			if ($id_producto_temporal != -1) {
				$query = $this->db->query("SELECT * FROM paneles WHERE id_panel = ?", $id_panel);
				$panel = $query->row_array();

				$indice_utilidad = (100 - ((float)$datos_calculo['indice_utilidad'])) / 100;
				$hps = (float)$datos_calculo['hps'];
				$eficiencia = (float)$datos_calculo['eficiencia'] / 100;
				$kw_panel = (float)$panel['watts_panel'] / 1000;
				$produccion_panel = round($hps * $kw_panel * $eficiencia * (int)$datos_calculo['periodo_dias'], 2);

				$cpu_usd = (float)$panel['usd_panel'];
				$cpu_mxn = round($cpu_usd * (float)$datos_calculo['tasa_cambio'], 2);
				$costo_total = round((int)$num_paneles * $cpu_mxn, 2);
				$precio_unitario = round($cpu_mxn / $indice_utilidad, 2);
				$precio_final = round($precio_unitario * (int)$num_paneles, 2);

				$produccion_promedio = round($produccion_panel * (int)$num_paneles, 2);
				$porcentaje_produccion = round($produccion_promedio / (float)$datos_calculo['consumo_promedio_kwh'] * 100, 2);
				$potencia_total = round($kw_panel * $num_paneles, 2);
				if ($datos_calculo['periodo'] == "mensual") {
					$produccion_anual = round($produccion_promedio * 12, 2);
				} else {
					$produccion_anual = round($produccion_promedio * 6, 2);
				}

				$this->db->trans_begin();

				$query = $this->db->query("UPDATE cotizaciones_temporales SET num_paneles = ?, potencia_total = ?, produccion_periodo = ?, porcentaje_produccion = ?, produccion_anual = ? WHERE id_cotizacion_temporal = ?", array($num_paneles, $potencia_total, $produccion_promedio, $porcentaje_produccion, $produccion_anual, $id_cotizacion_temporal));

				$query = $this->db->query("UPDATE cotizaciones_productos_temporales SET cantidad = ?, cpu_usd = ?, cpu_mxn = ?, costo_total = ?, precio_unitario = ?, precio_final = ? WHERE id_producto_temporal = ?", array($num_paneles, $cpu_usd, $cpu_mxn, $costo_total, $precio_unitario, $precio_final, $id_producto_temporal));

				if ($this->db->trans_status() === FALSE) {
					$obj['resultado'] = false;
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();

					$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
					if ($calcular_totales['resultado']) {
						$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
						$obj['totales'] = $calcular_totales['totales'];
						$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, $produccion_promedio, $datos_calculo, $obj['totales']['total_final']);
					} else {
						$obj['productos_temporales'] = [];
					}

					$obj['resultado'] = true;
					$obj['potencia_total'] = $potencia_total;
					$obj['produccion_promedio'] = $produccion_promedio;
					$obj['produccion_anual'] = $produccion_anual;
					$obj['ahorro'] = $porcentaje_produccion;
					$obj['num_paneles'] = $num_paneles;
				}
			} else {
				$obj['resultado'] = false;
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function calcular_ahorros($id_cotizacion_temporal, $produccion_promedio, $datos_calculo, $total_final)
	{
		$paneles_elegidos = (int)$datos_calculo['paneles_elegidos'];

		if ($paneles_elegidos == 1 && $total_final > 0) {
			$consumo_promedio_kwh = (float)$datos_calculo['consumo_promedio_kwh'];
			$dap = (float)$datos_calculo['dap'] / 100;
			$iva = (float)$datos_calculo['tasa_iva'] / 100;
			$suministro = (float)$datos_calculo['costo_suministro'];
			$periodo_dias = (float)$datos_calculo['periodo_dias'];

			$tarifa = $datos_calculo['tarifa'];
			$consumo_promedio_pesos = (float)$datos_calculo['consumo_promedio_precio'];
			$gasto_anual = (float)$datos_calculo['gasto_anual_cfe'];

			$consumo_precio = 0;
			$valor_dap = 0;
			$valor_iva = 0;
			$consumo_total_pesos = 0;
			$restante_kwh = round($consumo_promedio_kwh - $produccion_promedio, 3);
			$restante_pesos = 0;
			$restante_pesos_anual = 0;
			$restante_anios = array();
			$ahorro = 0;
			$ahorro_anios = array();
			$pagos_anuales_con_paneles = array();
			$pagos_anuales_sin_paneles = array();
			$datos_roi = array();

			if ($restante_kwh <= 0) {
				$restante_kwh = 0;
			}

			$tarifas_cfe = $this->db->query("SELECT * FROM tarifas_cfe")->row_array();

			switch ($tarifa) {
				case 'tarifa_dac':
					$consumo_precio = $restante_kwh * (float)$tarifas_cfe['dac'];
					break;
				case 'tarifa_pdbt':
					$consumo_precio = $restante_kwh * (float)$tarifas_cfe['pdbt'];
					break;
				case 'tarifa_01':
					$tarifa_limite_1 = 0;
					$tarifa_limite_2 = 0;
					$tarifa_limite_3 = 0;
					$consumo_aux = $restante_kwh;

					if ($consumo_aux >= (float)$tarifas_cfe['d1_limite_superior']) {
						$tarifa_limite_1 =  (float)$tarifas_cfe['d1_limite_superior'] * (float)$tarifas_cfe['d1'];
						$consumo_aux -= (float)$tarifas_cfe['d1_limite_superior'];
						if ($consumo_aux >= (float)$tarifas_cfe['d2_limite_superior']) {
							$tarifa_limite_2 =  (float)$tarifas_cfe['d2_limite_superior'] * (float)$tarifas_cfe['d2'];
							$consumo_aux -= (float)$tarifas_cfe['d2_limite_superior'];
							if ($consumo_aux > 0) {
								$tarifa_limite_3 =  $consumo_aux * (float)$tarifas_cfe['d3'];
							}
						} else {
							$tarifa_limite_2 =  $consumo_aux * (float)$tarifas_cfe['d2'];
						}
					} else {
						$tarifa_limite_1 =  $consumo_aux * (float)['tarifas_cfe.d1'];
					}

					$consumo_precio = $tarifa_limite_1 + $tarifa_limite_2 + $tarifa_limite_3;
					break;
			}

			$valor_dap = $consumo_precio * $dap;
			$valor_iva = $consumo_precio * $iva;
			$restante_pesos = round($suministro + $consumo_precio + $valor_dap + $valor_iva, 2);
			$ahorro = round($consumo_promedio_pesos - $restante_pesos, 2);

			if ($periodo_dias == 30) {
				$restante_pesos_anual = round($restante_pesos * 12, 2);
			} else {
				$restante_pesos_anual = round($restante_pesos * 6, 2);
			}

			for ($i = 1; $i <= 25; $i++) {
				$pagos_anuales_con_paneles[$i - 1] = round($restante_pesos_anual * $i, 2);
				$pagos_anuales_sin_paneles[$i - 1] = round($gasto_anual * $i, 2);
				$ahorro_anios[$i - 1] = round($pagos_anuales_sin_paneles[$i - 1] - $pagos_anuales_con_paneles[$i - 1], 2);
			}

			for ($i = 0; $i < 25; $i++) {
				$datos_roi[$i] = round(($pagos_anuales_sin_paneles[$i] - $pagos_anuales_con_paneles[$i]) - $total_final, 2);
			}

			$roi = round($total_final / $gasto_anual, 2);

			$this->db->query("DELETE FROM cotizaciones_temporales_ahorro WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

			if ($periodo_dias == 30) {
				$this->db->query("INSERT INTO cotizaciones_temporales_ahorro (id_cotizacion_temporal, periodo, actual, con_aamperia, ahorro) VALUES (?, ?, ?, ?, ?)", array($id_cotizacion_temporal, 'mensual', $consumo_promedio_pesos, $restante_pesos, $ahorro));
			} else {
				$this->db->query("INSERT INTO cotizaciones_temporales_ahorro (id_cotizacion_temporal, periodo, actual, con_aamperia, ahorro) VALUES (?, ?, ?, ?, ?)", array($id_cotizacion_temporal, 'bimestral', $consumo_promedio_pesos, $restante_pesos, $ahorro));
			}

			$this->db->query("INSERT INTO cotizaciones_temporales_ahorro (id_cotizacion_temporal, periodo, actual, con_aamperia, ahorro) VALUES (?, ?, ?, ?, ?)", array($id_cotizacion_temporal, '1_anio', $pagos_anuales_sin_paneles[0], $pagos_anuales_con_paneles[0], $ahorro_anios[0]));

			$this->db->query("INSERT INTO cotizaciones_temporales_ahorro (id_cotizacion_temporal, periodo, actual, con_aamperia, ahorro) VALUES (?, ?, ?, ?, ?)", array($id_cotizacion_temporal, '5_anios', $pagos_anuales_sin_paneles[4], $pagos_anuales_con_paneles[4], $ahorro_anios[4]));

			$this->db->query("INSERT INTO cotizaciones_temporales_ahorro (id_cotizacion_temporal, periodo, actual, con_aamperia, ahorro) VALUES (?, ?, ?, ?, ?)", array($id_cotizacion_temporal, '10_anios', $pagos_anuales_sin_paneles[9], $pagos_anuales_con_paneles[9], $ahorro_anios[9]));

			$this->db->query("INSERT INTO cotizaciones_temporales_ahorro (id_cotizacion_temporal, periodo, actual, con_aamperia, ahorro) VALUES (?, ?, ?, ?, ?)", array($id_cotizacion_temporal, '25_anios', $pagos_anuales_sin_paneles[24], $pagos_anuales_con_paneles[24], $ahorro_anios[24]));

			$this->db->query("UPDATE cotizaciones_temporales SET retorno_inversion = ? WHERE id_cotizacion_temporal = ?", array($roi, $id_cotizacion_temporal));

			$obj['retorno_inversion'] = $roi;
			$obj['datos_roi'] = $datos_roi;
			$obj['pagos_anuales_con_paneles'] = $pagos_anuales_con_paneles;
			$obj['pagos_anuales_sin_paneles'] = $pagos_anuales_sin_paneles;
			$obj['ahorro_anios'] = $ahorro_anios;
			$obj['ahorro'] = $ahorro;
			$obj['consumo_promedio_pesos'] = $consumo_promedio_pesos;
			$obj['restante_pesos'] = $restante_pesos;
		} else {
			$this->db->query("DELETE FROM cotizaciones_temporales_ahorro WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

			$obj['retorno_inversion'] = 0;
			$obj['datos_roi'] = array_fill(0, 25, 0);
			$obj['pagos_anuales_con_paneles'] = array_fill(0, 25, 0);
			$obj['pagos_anuales_sin_paneles'] = array_fill(0, 25, 0);
			$obj['ahorro_anios'] = array_fill(0, 25, 0);
			$obj['ahorro'] = 0;
			$obj['consumo_promedio_pesos'] = 0;
			$obj['restante_pesos'] = 0;
		}

		return $obj;
	}

	public function guardar_producto($id_cotizacion_temporal, $id_producto, $tipo_producto, $cantidad, $principal)
	{
		$query = $this->db->query("SELECT periodo_dias, tasa_cambio, tasa_iva, consumo_promedio_kwh, produccion_periodo, consumo_promedio_precio, indice_utilidad, tarifa, dap, costo_suministro, gasto_anual_cfe, paneles_elegidos FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

		if ($query->num_rows() > 0) {
			$datos_calculo = $query->row_array();
			$tasa_cambio = (float)$datos_calculo['tasa_cambio'];
			$indice_utilidad = (100 - ((float)$datos_calculo['indice_utilidad'])) / 100;
			$cantidad = (int)$cantidad;

			$query = $this->db->query("SELECT * FROM cotizaciones_productos_temporales WHERE id_producto = ? AND tipo_producto = ? AND id_cotizacion_temporal = ?", array($id_producto, $tipo_producto, $id_cotizacion_temporal));

			if ($query->num_rows() > 0) {
				$datos_producto_temporal = $query->row_array();
				$id_producto_temporal = $datos_producto_temporal['id_producto_temporal'];
				$cpu_mxn = (float)$datos_producto_temporal['cpu_mxn'];
				$cantidad_nueva = (int)$datos_producto_temporal['cantidad'] + $cantidad;
				$costo_total = round($cpu_mxn * (int)$cantidad_nueva, 2);
				$precio_unitario = round($cpu_mxn / $indice_utilidad, 2);
				$precio_final = round($precio_unitario * $cantidad_nueva, 2);

				$query = $this->db->query("UPDATE cotizaciones_productos_temporales SET costo_total = ?, precio_unitario = ?, precio_final = ?, cantidad = ? WHERE id_producto_temporal = ?", array($costo_total, $precio_unitario, $precio_final, $cantidad_nueva, $id_producto_temporal));

				if ($this->db->affected_rows() > 0) {
					$obj['resultado'] = true;
					$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
					if ($calcular_totales['resultado']) {
						$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
						$obj['totales'] = $calcular_totales['totales'];
						$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$datos_calculo['produccion_periodo'], $datos_calculo, $obj['totales']['total_final']);
					} else {
						$obj['productos_temporales'] = [];
					}
				} else {
					$obj['resultado'] = false;
				}
			} else {
				switch ($tipo_producto) {
					case 'estructura':
						$query = $this->db->query("SELECT costo, moneda FROM estructuras WHERE id_estructura = ?", $id_producto);
						$encontrado = $query->num_rows() > 0;
						break;
					case 'inversor':
						$query = $this->db->query("SELECT costo, moneda FROM inversores WHERE id_inversor = ?", $id_producto);
						$encontrado = $query->num_rows() > 0;
						break;
					case 'microinversor':
						$query = $this->db->query("SELECT costo, moneda FROM microinversores WHERE id_microinversor = ?", $id_producto);
						$encontrado = $query->num_rows() > 0;
						break;
					case 'optimizador':
						$query = $this->db->query("SELECT costo, moneda FROM optimizadores WHERE id_optimizador = ?", $id_producto);
						$encontrado = $query->num_rows() > 0;
						break;
					case 'sistema_monitoreo':
						$query = $this->db->query("SELECT costo, moneda FROM sistemas_monitoreo WHERE id_sistema_monitoreo = ?", $id_producto);
						$encontrado = $query->num_rows() > 0;
						break;
					case 'extra':
						$query = $this->db->query("SELECT costo, moneda FROM extras WHERE id_extra = ?", $id_producto);
						$encontrado = $query->num_rows() > 0;
						break;
					default:
						$encontrado = false;
						break;
				}

				if ($encontrado) {
					$datos = $query->row_array();
					$costo = (float)$datos['costo'];
					$moneda = $datos['moneda'];

					if ($moneda == "USD") {
						$cpu_usd = $costo;
						$cpu_mxn = $cpu_usd * $tasa_cambio;
						$costo_total = $cpu_mxn * $cantidad;
						$precio_unitario = $cpu_mxn / $indice_utilidad;
						$precio_final = $precio_unitario * $cantidad;
					} else {
						$cpu_usd = 0;
						$cpu_mxn = $costo;
						$costo_total = $cpu_mxn * $cantidad;
						$precio_unitario = $cpu_mxn / $indice_utilidad;
						$precio_final = $precio_unitario * $cantidad;
					}

					if ($principal == 1) {
						$query = $this->db->query("SELECT * FROM cotizaciones_productos_temporales WHERE id_cotizacion_temporal = ? AND tipo_producto = ? AND principal = 1", array($id_cotizacion_temporal, $tipo_producto));

						if ($query->num_rows() > 0) {
							$producto_existente = $query->row_array();
							$id_producto_temporal = $producto_existente['id_producto_temporal'];

							$query = $this->db->query("UPDATE cotizaciones_productos_temporales SET cantidad = ?, cpu_usd = ?, cpu_mxn = ?, costo_total = ?, precio_unitario = ?, precio_final = ?, id_producto = ?, tipo_producto = ? WHERE id_producto_temporal = ?", array($cantidad, $cpu_usd, $cpu_mxn, $costo_total, $precio_unitario, $precio_final, $id_producto, $tipo_producto, $id_producto_temporal));

							if ($this->db->affected_rows() > 0) {
								$obj['resultado'] = true;
								$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
								if ($calcular_totales['resultado']) {
									$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
									$obj['totales'] = $calcular_totales['totales'];
									$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$datos_calculo['produccion_periodo'], $datos_calculo, $obj['totales']['total_final']);
								} else {
									$obj['productos_temporales'] = [];
								}
							} else {
								$obj['resultado'] = false;
							}
						} else {
							$query = $this->db->query("INSERT INTO cotizaciones_productos_temporales (id_cotizacion_temporal, cantidad, cpu_usd, cpu_mxn, costo_total, precio_unitario, precio_final, principal, id_producto, tipo_producto) VALUES(?,?,?,?,?,?,?,?,?,?)", array($id_cotizacion_temporal, $cantidad, $cpu_usd, $cpu_mxn, $costo_total, $precio_unitario, $precio_final, $principal, $id_producto, $tipo_producto));

							if ($this->db->affected_rows() > 0) {
								$obj['resultado'] = true;
								$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
								if ($calcular_totales['resultado']) {
									$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
									$obj['totales'] = $calcular_totales['totales'];
									$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$datos_calculo['produccion_periodo'], $datos_calculo, $obj['totales']['total_final']);
								} else {
									$obj['productos_temporales'] = [];
								}
							} else {
								$obj['resultado'] = false;
							}
						}
					} else {
						$query = $this->db->query("INSERT INTO cotizaciones_productos_temporales (id_cotizacion_temporal, cantidad, cpu_usd, cpu_mxn, costo_total, precio_unitario, precio_final, principal, id_producto, tipo_producto) VALUES(?,?,?,?,?,?,?,?,?,?)", array($id_cotizacion_temporal, $cantidad, $cpu_usd, $cpu_mxn, $costo_total, $precio_unitario, $precio_final, $principal, $id_producto, $tipo_producto));

						if ($this->db->affected_rows() > 0) {
							$obj['resultado'] = true;
							$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
							if ($calcular_totales['resultado']) {
								$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
								$obj['totales'] = $calcular_totales['totales'];
								$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$datos_calculo['produccion_periodo'], $datos_calculo, $obj['totales']['total_final']);
							} else {
								$obj['productos_temporales'] = [];
							}
						} else {
							$obj['resultado'] = false;
						}
					}
				} else {
					$obj['resultado'] = false;
				}
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function guardar_instalacion_electrica($id_cotizacion_temporal, $metros, $instalacion)
	{
		$query = $this->db->query("SELECT costo_metro, periodo_dias, tasa_cambio, tasa_iva, consumo_promedio_kwh, produccion_periodo, consumo_promedio_precio, indice_utilidad, tarifa, dap, costo_suministro, gasto_anual_cfe, paneles_elegidos FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

		if ($query->num_rows() > 0) {
			$datos_calculo = $query->row_array();
			$indice_utilidad = (100 - ((float)$datos_calculo['indice_utilidad'])) / 100;
			$costo_metro = (float)$datos_calculo['costo_metro'];

			$query = $this->db->query("SELECT * FROM productos_fijos WHERE codigo = 'INGENIERIA_INSTALACION'");
			$datos_producto = $query->row_array();

			$query = $this->db->query("SELECT * FROM cotizaciones_productos_temporales WHERE id_cotizacion_temporal = ? AND id_producto = ? AND tipo_producto = 'producto_fijo'", array($id_cotizacion_temporal, $datos_producto['id_producto_fijo']));

			if ($query->num_rows() == 0) {
				$cpu_usd = 0;
				$cantidad = 1;
				$costo_total = round($costo_metro * $metros, 2);
				$costo_total_final = $costo_total + (int)$instalacion;
				$cpu_mxn = $costo_total_final;
				$precio_unitario = round($cpu_mxn / $indice_utilidad, 2);
				$precio_final = round($precio_unitario * $cantidad, 2);

				$query = $this->db->query("INSERT INTO cotizaciones_productos_temporales (id_cotizacion_temporal, cantidad, cpu_usd, cpu_mxn, costo_total, precio_unitario, precio_final, principal, id_producto, tipo_producto) VALUES(?,?,?,?,?,?,?,?,?,'producto_fijo')", array($id_cotizacion_temporal, $cantidad, $cpu_usd, $cpu_mxn, $costo_total_final, $precio_unitario, $precio_final, 1, $datos_producto['id_producto_fijo']));

				$this->db->query("UPDATE cotizaciones_temporales SET instalacion = ?, metros_instalacion = ?, tuberia_cableado = ? WHERE id_cotizacion_temporal = ?", array($instalacion, $metros, $costo_total, $id_cotizacion_temporal));

				if ($this->db->affected_rows() > 0) {
					$obj['resultado'] = true;
					$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
					if ($calcular_totales['resultado']) {
						$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
						$obj['totales'] = $calcular_totales['totales'];
						$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$datos_calculo['produccion_periodo'], $datos_calculo, $obj['totales']['total_final']);
					} else {
						$obj['productos_temporales'] = [];
					}
				} else {
					$obj['resultado'] = false;
				}
			} else {
				$datos_producto_temporal = $query->row_array();
				$id_producto_temporal = $datos_producto_temporal['id_producto_temporal'];
				$cpu_mxn = (float)$datos_producto_temporal['cpu_mxn'];

				$cpu_usd = 0;
				$cantidad = 1;
				$costo_total = round($costo_metro * $metros, 2);
				$costo_total_final = $costo_total + (int)$instalacion;
				$cpu_mxn = $costo_total_final;
				$precio_unitario = round($cpu_mxn / $indice_utilidad, 2);
				$precio_final = round($precio_unitario * $cantidad, 2);

				$query = $this->db->query("UPDATE cotizaciones_productos_temporales SET cantidad = ?, cpu_usd = ?, cpu_mxn = ?, costo_total = ?, precio_unitario = ?, precio_final = ? WHERE id_cotizacion_temporal = ? AND id_producto = ? AND tipo_producto = 'producto_fijo'", array($cantidad, $cpu_usd, $cpu_mxn, $costo_total_final, $precio_unitario, $precio_final, $id_cotizacion_temporal, $datos_producto['id_producto_fijo']));

				$this->db->query("UPDATE cotizaciones_temporales SET instalacion = ?, metros_instalacion = ?, tuberia_cableado = ? WHERE id_cotizacion_temporal = ?", array($instalacion, $metros, $costo_total, $id_cotizacion_temporal));

				if ($this->db->affected_rows() > 0) {
					$obj['resultado'] = true;
					$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
					if ($calcular_totales['resultado']) {
						$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
						$obj['totales'] = $calcular_totales['totales'];
						$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$datos_calculo['produccion_periodo'], $datos_calculo, $obj['totales']['total_final']);
					} else {
						$obj['productos_temporales'] = [];
					}
				} else {
					$obj['resultado'] = false;
				}
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function guardar_material_electrico($id_cotizacion_temporal, $material_electrico)
	{
		$query = $this->db->query("SELECT costo_metro, periodo_dias, tasa_cambio, tasa_iva, consumo_promedio_kwh, produccion_periodo, consumo_promedio_precio, indice_utilidad, tarifa, dap, costo_suministro, gasto_anual_cfe, paneles_elegidos FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

		if ($query->num_rows() > 0) {
			$datos_calculo = $query->row_array();
			$indice_utilidad = (100 - ((float)$datos_calculo['indice_utilidad'])) / 100;

			$query = $this->db->query("SELECT * FROM productos_fijos WHERE codigo = 'MATERIAL_ELECTRICO'");
			$datos_producto = $query->row_array();

			$query = $this->db->query("SELECT * FROM cotizaciones_productos_temporales WHERE id_cotizacion_temporal = ? AND id_producto = ? AND tipo_producto = 'producto_fijo'", array($id_cotizacion_temporal, $datos_producto['id_producto_fijo']));

			if ($query->num_rows() == 0) {
				$cpu_usd = 0;
				$cantidad = 1;
				$costo_total = (int)$material_electrico;
				$cpu_mxn = $costo_total;
				$precio_unitario = round($cpu_mxn / $indice_utilidad, 2);
				$precio_final = round($precio_unitario * $cantidad, 2);

				$query = $this->db->query("INSERT INTO cotizaciones_productos_temporales (id_cotizacion_temporal, cantidad, cpu_usd, cpu_mxn, costo_total, precio_unitario, precio_final, principal, id_producto, tipo_producto) VALUES(?,?,?,?,?,?,?,?,?,'producto_fijo')", array($id_cotizacion_temporal, $cantidad, $cpu_usd, $cpu_mxn, $costo_total, $precio_unitario, $precio_final, 1, $datos_producto['id_producto_fijo']));

				$this->db->query("UPDATE cotizaciones_temporales SET material_electrico = ? WHERE id_cotizacion_temporal = ?", array($material_electrico, $id_cotizacion_temporal));

				if ($this->db->affected_rows() > 0) {
					$obj['resultado'] = true;
					$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
					if ($calcular_totales['resultado']) {
						$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
						$obj['totales'] = $calcular_totales['totales'];
						$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$datos_calculo['produccion_periodo'], $datos_calculo, $obj['totales']['total_final']);
					} else {
						$obj['productos_temporales'] = [];
					}
				} else {
					$obj['resultado'] = false;
				}
			} else {
				$datos_producto_temporal = $query->row_array();
				$id_producto_temporal = $datos_producto_temporal['id_producto_temporal'];
				$cpu_mxn = (float)$datos_producto_temporal['cpu_mxn'];

				$cpu_usd = 0;
				$cantidad = 1;
				$costo_total = (int)$material_electrico;
				$cpu_mxn = $costo_total;
				$precio_unitario = round($cpu_mxn / $indice_utilidad, 2);
				$precio_final = round($precio_unitario * $cantidad, 2);

				$query = $this->db->query("UPDATE cotizaciones_productos_temporales SET cantidad = ?, cpu_usd = ?, cpu_mxn = ?, costo_total = ?, precio_unitario = ?, precio_final = ? WHERE id_cotizacion_temporal = ? AND id_producto = ? AND tipo_producto = 'producto_fijo'", array($cantidad, $cpu_usd, $cpu_mxn, $costo_total, $precio_unitario, $precio_final, $id_cotizacion_temporal, $datos_producto['id_producto_fijo']));

				$this->db->query("UPDATE cotizaciones_temporales SET material_electrico = ? WHERE id_cotizacion_temporal = ?", array($material_electrico, $id_cotizacion_temporal));

				if ($this->db->affected_rows() > 0) {
					$obj['resultado'] = true;
					$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
					if ($calcular_totales['resultado']) {
						$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
						$obj['totales'] = $calcular_totales['totales'];
						$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$datos_calculo['produccion_periodo'], $datos_calculo, $obj['totales']['total_final']);
					} else {
						$obj['productos_temporales'] = [];
					}
				} else {
					$obj['resultado'] = false;
				}
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function calcular_totales($id_cotizacion_temporal)
	{
		$query = $this->db->query("SELECT * FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

		if ($query->num_rows() > 0) {
			$datos_cotizacion = $query->row_array();
			$iva = (float)$datos_cotizacion['tasa_iva'] / 100;
			$paneles_elegidos = (int)$datos_cotizacion['paneles_elegidos'];
			$num_paneles = (int)$datos_cotizacion['num_paneles'];

			$query = $this->db->query("SELECT * FROM cotizaciones_productos_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);
			if ($query->num_rows() > 0) {
				$productos_temporales = $query->result_array();
				$subtotal = 0;
				$total_costos = 0;
				$subtotal_proveedores = 0;

				foreach ($productos_temporales as $key => $producto_temporal) {
					$id_producto = $producto_temporal['id_producto'];
					$prov = false;
					switch ($producto_temporal['tipo_producto']) {
						case 'panel_solar':
							$query = $this->db->query("SELECT * FROM paneles WHERE id_panel = ?", $id_producto);
							$prov = true;
							break;
						case 'estructura':
							$query = $this->db->query("SELECT * FROM estructuras WHERE id_estructura = ?", $id_producto);
							$prov = true;
							break;
						case 'inversor':
							$query = $this->db->query("SELECT * FROM inversores WHERE id_inversor = ?", $id_producto);
							$prov = true;
							break;
						case 'microinversor':
							$query = $this->db->query("SELECT * FROM microinversores WHERE id_microinversor = ?", $id_producto);
							$prov = true;
							break;
						case 'optimizador':
							$query = $this->db->query("SELECT * FROM optimizadores WHERE id_optimizador = ?", $id_producto);
							$prov = true;
							break;
						case 'sistema_monitoreo':
							$query = $this->db->query("SELECT * FROM sistemas_monitoreo WHERE id_sistema_monitoreo = ?", $id_producto);
							$prov = true;
							break;
						case 'extra':
							$query = $this->db->query("SELECT * FROM extras WHERE id_extra = ?", $id_producto);
							$prov = false;
							break;
						case 'producto_fijo':
							$query = $this->db->query("SELECT * FROM productos_fijos WHERE id_producto_fijo = ?", $id_producto);
							$prov = false;
							break;
					}

					$datos_producto = $query->row_array();
					$precio_final = (float)$producto_temporal['precio_final'];
					$costo = (float)$producto_temporal['costo_total'];
					$productos_temporales[$key]['datos_producto'] = $datos_producto;
					$subtotal += $precio_final;
					$total_costos += $costo;


					if ($prov) {
						$subtotal_proveedores += (float)$producto_temporal['costo_total'];
					}
				}

				// subtotal : costo de los insumos ya con utilidad (precio al cliente)
				// subtotal_proveedores : costo del proyecto con proveedores
				// subtotal_iva : iva del costo del proyecto con proveedores
				$subtotal = round($subtotal, 2);
				$subtotal_proveedores_iva = round($subtotal_proveedores * $iva, 2);

				// iva del costo del proyecto con proveedores 

				// iva final del precio final
				$subtotal_iva = round($subtotal * $iva, 2);

				// costo con los proveedores
				$total_proveedores = round($subtotal_proveedores + $subtotal_proveedores_iva, 2);

				// costo del proyecto con proveedores
				$costo_proyecto_proveedores = round($subtotal_proveedores, 2);

				// costo del proyecto + iva (pago mínimo del cliente)
				$costo_proyecto_iva = round($costo_proyecto_proveedores + $subtotal_proveedores_iva, 2);

				// utilidad del costo del proyecto
				$utilidad = round($subtotal - $costo_proyecto_proveedores, 2);

				// iva final del precio final 
				$iva_final = $subtotal_iva;

				// precio final al cliente
				$total_final = round($subtotal + $subtotal_iva, 2);

				if ($paneles_elegidos == 1) {
					// costo por panel
					$costo_panel = round($total_final / $num_paneles, 2);
				} else {
					$costo_panel = 0;
				}

				// porcentaje de pago mínimo 
				$porcentaje_minimo = ceil(($costo_proyecto_iva / $total_final) * 100);

				$query = $this->db->query("UPDATE cotizaciones_temporales SET costo_por_panel = ?, costo_proveedores = ?, iva_proveedores = ?, utilidad = ?, pago_minimo_cliente = ?, precio_al_cliente = ?, precio_final = ?, porcentaje_minimo = ?, subtotal = ?, iva = ?, total = ? WHERE id_cotizacion_temporal = ?", array($costo_panel, $costo_proyecto_proveedores, $subtotal_proveedores_iva, $utilidad, $costo_proyecto_iva, $subtotal, $total_final, $porcentaje_minimo, $subtotal, $subtotal_iva, $total_final, $id_cotizacion_temporal));

				if ($this->db->affected_rows() > 0) {
					$obj['resultado'] = true;

					$totales['total_costos'] = $total_costos;
					$totales['tuberia_cableado'] = $datos_cotizacion['tuberia_cableado'];
					$totales['metros_instalacion'] = $datos_cotizacion['metros_instalacion'];
					$totales['paneles_elegidos'] = $paneles_elegidos;
					$totales['subtotal'] = $subtotal;
					$totales['subtotal_iva'] = $subtotal_iva;
					$totales['total_final'] = $total_final;
					$totales['costo_por_watt'] = (float)$datos_cotizacion['costo_por_watt'];
					$totales['costo_por_panel'] = $costo_panel;
					$totales['costo_proveedores'] = $costo_proyecto_proveedores;
					$totales['iva_proveedores'] = $subtotal_proveedores_iva;
					$totales['utilidad'] = $utilidad;
					$totales['pago_minimo_cliente'] = $costo_proyecto_iva;
					$totales['precio_al_cliente'] = $subtotal;
					$totales['precio_final'] = $total_final;
					$totales['porcentaje_minimo'] = $porcentaje_minimo;

					$obj['totales'] = $totales;
					$obj['productos_temporales'] = $productos_temporales;
				} else {
					$obj['resultado'] = false;
				}
			} else {
				$query = $this->db->query("UPDATE cotizaciones_temporales SET costo_por_panel = 0, costo_proveedores = 0, iva_proveedores = 0, utilidad = 0, pago_minimo_cliente = 0, precio_al_cliente = 0, precio_final = 0, porcentaje_minimo = 0, subtotal = 0, iva = 0, total = 0, paneles_elegidos = 0, num_paneles = 0, material_electrico = 0, instalacion = 0, tuberia_cableado = 0, metros_instalacion = 0 WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

				if ($this->db->affected_rows() > 0) {
					$obj['resultado'] = true;

					$totales['total_costos'] = 0;
					$totales['tuberia_cableado'] = 0;
					$totales['metros_instalacion'] = 0;
					$totales['paneles_elegidos'] = 0;
					$totales['subtotal'] = 0;
					$totales['subtotal_iva'] = 0;
					$totales['total_final'] = 0;
					$totales['costo_por_watt'] = 0;
					$totales['costo_por_panel'] = 0;
					$totales['costo_proveedores'] = 0;
					$totales['iva_proveedores'] = 0;
					$totales['utilidad'] = 0;
					$totales['pago_minimo_cliente'] = 0;
					$totales['precio_al_cliente'] = 0;
					$totales['precio_final'] = 0;
					$totales['porcentaje_minimo'] = 0;

					$obj['totales'] = $totales;
					$obj['productos_temporales'] = [];
				} else {
					$obj['resultado'] = false;
				}
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function eliminar_producto($id_cotizacion_temporal, $id_producto, $tipo_producto)
	{
		$query = $this->db->query("SELECT periodo_dias, tasa_cambio, tasa_iva, consumo_promedio_kwh, produccion_periodo, consumo_promedio_precio, indice_utilidad, tarifa, dap, costo_suministro, gasto_anual_cfe, paneles_elegidos FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

		if ($query->num_rows() > 0) {
			$datos_calculo = $query->row_array();
			$query = $this->db->query("SELECT id_producto_temporal, principal FROM cotizaciones_productos_temporales WHERE id_cotizacion_temporal = ? AND id_producto = ? AND tipo_producto = ?", array($id_cotizacion_temporal, $id_producto, $tipo_producto));

			if ($query->num_rows() > 0) {
				$id_producto_temporal = $query->row_array()['id_producto_temporal'];
				$principal = $query->row_array()['principal'];

				$this->db->trans_begin();

				$query = $this->db->query("DELETE FROM cotizaciones_productos_temporales WHERE id_producto_temporal = ?", $id_producto_temporal);

				if ($tipo_producto == "panel_solar") {
					$query = $this->db->query("UPDATE cotizaciones_temporales SET paneles_elegidos = 0, num_paneles = 0, potencia_total = 0, porcentaje_produccion = 0, produccion_periodo = 0, produccion_anual = 0, costo_por_panel = 0, costo_por_watt = 0 WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);
				}

				if ($this->db->trans_status() === FALSE) {
					$obj['resultado'] = false;
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					$obj['resultado'] = true;
					$obj['principal'] = $principal;
					$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
					if ($calcular_totales['resultado']) {
						$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
						$obj['totales'] = $calcular_totales['totales'];
						$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$datos_calculo['produccion_periodo'], $datos_calculo, $obj['totales']['total_final']);
					} else {
						$obj['productos_temporales'] = false;
						$obj['totales'] = false;
					}
				}
			} else {
				$obj['resultado'] = false;
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function cambiar_cantidad_producto($id_cotizacion_temporal, $id_producto, $tipo_producto, $cantidad)
	{
		$query = $this->db->query("SELECT periodo_dias, tasa_cambio, tasa_iva, consumo_promedio_kwh, produccion_periodo, consumo_promedio_precio, indice_utilidad, tarifa, dap, costo_suministro, gasto_anual_cfe, paneles_elegidos FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

		if ($query->num_rows() > 0) {
			$datos_calculo = $query->row_array();
			$tasa_cambio = (float)$datos_calculo['tasa_cambio'];
			$indice_utilidad = (100 - ((float)$datos_calculo['indice_utilidad'])) / 100;

			$query = $this->db->query("SELECT * FROM cotizaciones_productos_temporales WHERE id_producto = ? AND tipo_producto = ? AND id_cotizacion_temporal = ?", array($id_producto, $tipo_producto, $id_cotizacion_temporal));

			if ($query->num_rows() > 0) {
				$datos_producto_temporal = $query->row_array();
				$id_producto_temporal = $datos_producto_temporal['id_producto_temporal'];
				$cpu_mxn = (float)$datos_producto_temporal['cpu_mxn'];
				$cantidad_nueva = (int)$cantidad;
				$costo_total = round($cpu_mxn * (int)$cantidad_nueva, 2);
				$precio_unitario = round($cpu_mxn / $indice_utilidad, 2);
				$precio_final = round($precio_unitario * $cantidad_nueva, 2);

				$query = $this->db->query("UPDATE cotizaciones_productos_temporales SET costo_total = ?, precio_unitario = ?, precio_final = ?, cantidad = ? WHERE id_producto_temporal = ?", array($costo_total, $precio_unitario, $precio_final, $cantidad_nueva, $id_producto_temporal));

				if ($this->db->affected_rows() > 0) {
					$obj['resultado'] = true;
					$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
					if ($calcular_totales['resultado']) {
						$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
						$obj['totales'] = $calcular_totales['totales'];
						$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$datos_calculo['produccion_periodo'], $datos_calculo, $obj['totales']['total_final']);
					} else {
						$obj['productos_temporales'] = [];
					}
				} else {
					$obj['resultado'] = false;
				}
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function guardar_cotizacion($id_cotizacion_temporal, $grafica_consumo, $grafica_roi, $tipo_cliente, $id_cliente, $id_usuario)
	{
		$query = $this->db->query("SELECT * FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

		if ($query->num_rows() > 0) {
			$datos_cotizacion = $query->row_array();

			$query = $this->db->query("SELECT * FROM cotizaciones_productos_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);
			$productos = $query->result_array();

			$query = $this->db->query("SELECT * FROM cotizaciones_temporales_ahorro WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);
			$datos_ahorro = $query->result_array();

			$this->db->trans_begin();

			/* 
				1.- Hacer en esta parte un array para insertar en la tabla de clientes 
				2.- Quitar los campos de la siguiente inserción. 

				Estatus tipo_cliente

				1.- El cliente es nuevo
				2.- El cliente ya existe
				*/
			// Si el tipo de cliente es nuevo, insertar cliente y obtener el id
			if ($tipo_cliente == 1) {
				// Crear el arreglo de cliente
				$datos_cliente = [
					'nombre' => $datos_cotizacion['nombre'],
					'ubicacion' => $datos_cotizacion['ubicacion'],
					'correo' => $datos_cotizacion['correo'],
					'numero_servicio' => $datos_cotizacion['numero_servicio'],
					'telefono' => $datos_cotizacion['telefono'],
					'id_usuario' => $this->session->usuario['id_usuario']
				];

				// Insertar el cliente en la base de datos y obtener el id_cliente
				$this->db->insert('clientes', $datos_cliente);
				$id_cliente = $this->db->insert_id();
			}
			$datos_cotizacion_insert = [
				'id_usuario' => $datos_cotizacion['id_usuario'],
				'estado_cotizacion' => 'Incompleto', // Valor estático 'Incompleto'
				'fecha_cotizacion' => $datos_cotizacion['fecha_cotizacion'],
				'tarifa' => $datos_cotizacion['tarifa'],
				'periodo' => $datos_cotizacion['periodo'],
				'forma_calculo' => $datos_cotizacion['forma_calculo'],
				'recibo_1' => $datos_cotizacion['recibo_1'],
				'recibo_2' => $datos_cotizacion['recibo_2'],
				'recibo_3' => $datos_cotizacion['recibo_3'],
				'recibo_4' => $datos_cotizacion['recibo_4'],
				'recibo_5' => $datos_cotizacion['recibo_5'],
				'recibo_6' => $datos_cotizacion['recibo_6'],
				'consumo_promedio_kwh' => $datos_cotizacion['consumo_promedio_kwh'],
				'consumo_promedio_precio' => $datos_cotizacion['consumo_promedio_precio'],
				'gasto_anual_cfe' => $datos_cotizacion['gasto_anual_cfe'],
				'gasto_bimestral_cfe' => $datos_cotizacion['gasto_bimestral_cfe'],
				'costo_suministro' => $datos_cotizacion['costo_suministro'],
				'dap' => $datos_cotizacion['dap'],
				'eficiencia' => $datos_cotizacion['eficiencia'],
				'hps' => $datos_cotizacion['hps'],
				'periodo_dias' => $datos_cotizacion['periodo_dias'],
				'indice_utilidad' => $datos_cotizacion['indice_utilidad'],
				'costo_metro' => $datos_cotizacion['costo_metro'],
				'tasa_cambio' => $datos_cotizacion['tasa_cambio'],
				'tasa_iva' => $datos_cotizacion['tasa_iva'],
				'fecha_tasa' => $datos_cotizacion['fecha_tasa'],
				'tipo_interconexion' => $datos_cotizacion['tipo_interconexion'],
				'paneles_elegidos' => $datos_cotizacion['paneles_elegidos'],
				'num_paneles' => $datos_cotizacion['num_paneles'],
				'material_electrico' => $datos_cotizacion['material_electrico'],
				'instalacion' => $datos_cotizacion['instalacion'],
				'tuberia_cableado' => $datos_cotizacion['tuberia_cableado'],
				'potencia_total' => $datos_cotizacion['potencia_total'],
				'porcentaje_produccion' => $datos_cotizacion['porcentaje_produccion'],
				'produccion_periodo' => $datos_cotizacion['produccion_periodo'],
				'produccion_anual' => $datos_cotizacion['produccion_anual'],
				'costo_por_panel' => $datos_cotizacion['costo_por_panel'],
				'costo_por_watt' => $datos_cotizacion['costo_por_watt'],
				'costo_proveedores' => $datos_cotizacion['costo_proveedores'],
				'iva_proveedores' => $datos_cotizacion['iva_proveedores'],
				'utilidad' => $datos_cotizacion['utilidad'],
				'pago_minimo_cliente' => $datos_cotizacion['pago_minimo_cliente'],
				'precio_al_cliente' => $datos_cotizacion['precio_al_cliente'],
				'precio_final' => $datos_cotizacion['precio_final'],
				'porcentaje_minimo' => $datos_cotizacion['porcentaje_minimo'],
				'subtotal' => $datos_cotizacion['subtotal'],
				'iva' => $datos_cotizacion['iva'],
				'total' => $datos_cotizacion['total'],
				'retorno_inversion' => $datos_cotizacion['retorno_inversion'],
				'mostrar_roi' => $datos_cotizacion['mostrar_roi'],
				'metros_instalacion' => $datos_cotizacion['metros_instalacion'],
				'grafica_consumo' => $grafica_consumo, // Suponiendo que $grafica_consumo es una variable
				'grafica_roi' => $grafica_roi, // Suponiendo que $grafica_roi es una variable
				'id_cliente' => $id_cliente
			];

			// Insertar los datos de cotización en la base de datos
			$this->db->insert('cotizaciones', $datos_cotizacion_insert);

			// Obtener el ID de la cotización insertada
			$id_cotizacion = $this->db->insert_id();

			foreach ($productos as $producto) {
				$this->db->query("INSERT INTO cotizaciones_productos (id_cotizacion, cantidad, cpu_usd, cpu_mxn, costo_total, precio_unitario, precio_final, principal, id_producto, tipo_producto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($id_cotizacion, $producto['cantidad'], $producto['cpu_usd'], $producto['cpu_mxn'], $producto['costo_total'], $producto['precio_unitario'], $producto['precio_final'], $producto['principal'], $producto['id_producto'], $producto['tipo_producto']));
			}

			foreach ($datos_ahorro as $dato_ahorro) {
				$this->db->query("INSERT INTO cotizaciones_ahorro (id_cotizacion, periodo, actual, con_aamperia, ahorro) VALUES (?, ?, ?, ?, ?)", array($id_cotizacion, $dato_ahorro['periodo'], $dato_ahorro['actual'], $dato_ahorro['con_aamperia'], $dato_ahorro['ahorro']));
			}

			$this->db->query("DELETE FROM cotizaciones_temporales_ahorro WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

			$this->db->query("DELETE FROM cotizaciones_productos_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

			$this->db->query("UPDATE usuarios SET id_cotizacion_temporal = NULL WHERE id_usuario = ?", $id_usuario);

			$this->db->query("DELETE FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

			if ($this->db->trans_status() === FALSE) {
				$obj['resultado'] = false;
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				$obj['resultado'] = true;
				$obj['id_cotizacion'] = $id_cotizacion;
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function finalizar_cotizacion($id_cotizacion, $condiciones_pago, $vigencia, $tiempo_entrega)
	{
		$this->db->trans_begin();

		$query = $this->db->query(
			"UPDATE cotizaciones SET 
				vigencia = DATE_ADD(fecha_cotizacion, INTERVAL ? DAY), 
				tiempo_entrega = ?,
				anticipo = ?,
				anticipo_porcentaje = ?,
				finalizar_instalacion = ?,
				finalizar_instalacion_porcentaje = ?,
				cambio_medidor_cfe = ?,
				cambio_medidor_cfe_porcentaje = ?,
				estado_cotizacion = 'Pendiente'
				WHERE id_cotizacion = ?",
			array($vigencia, $tiempo_entrega, $condiciones_pago['anticipo'], $condiciones_pago['anticipo_porcentaje'], $condiciones_pago['fin_instalacion'], $condiciones_pago['fin_instalacion_porcentaje'], $condiciones_pago['cambio_medidor'], $condiciones_pago['cambio_medidor_porcentaje'], $id_cotizacion)
		);

		if ($this->db->trans_status() === FALSE) {
			$obj['resultado'] = false;
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$obj['resultado'] = true;
		}

		return $obj;
	}

	public function guardar_pdf_cotizacion($id_cotizacion, $nombre_archivo)
	{
		$this->db->query("UPDATE cotizaciones SET nombre_archivo = ? WHERE id_cotizacion = ?", array($nombre_archivo, $id_cotizacion));
		if ($this->db->affected_rows() > 0) {
			$obj['resultado'] = false;
		} else {
			$obj['resultado'] = true;
		}

		return $obj;
	}

	public function guardar_indice_utilidad($id_cotizacion_temporal, $indice_utilidad)
	{
		$query = $this->db->query("SELECT periodo_dias, tasa_cambio, tasa_iva, consumo_promedio_kwh, produccion_periodo, consumo_promedio_precio, indice_utilidad, tarifa, dap, costo_suministro, gasto_anual_cfe, paneles_elegidos FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

		if ($query->num_rows() > 0) {
			$datos_calculo = $query->row_array();
			$this->db->query("UPDATE cotizaciones_temporales SET indice_utilidad = ? WHERE id_cotizacion_temporal = ?", array($indice_utilidad, $id_cotizacion_temporal));
			$indice_utilidad = (100 - ((float)$indice_utilidad)) / 100;

			if ($this->db->affected_rows() > 0) {
				$query = $this->db->query("SELECT * FROM cotizaciones_productos_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);
				if ($query->num_rows() > 0) {
					$productos_temporales = $query->result_array();

					foreach ($productos_temporales as $key => $producto_temporal) {
						$id_producto_temporal = $producto_temporal['id_producto_temporal'];
						$cpu_mxn = (float)$producto_temporal['cpu_mxn'];
						$costo_total = $producto_temporal['costo_total'];
						$cantidad = (int)$producto_temporal['cantidad'];
						$precio_unitario = round($cpu_mxn / $indice_utilidad, 2);
						$precio_final = round($precio_unitario * $cantidad, 2);

						$query = $this->db->query("UPDATE cotizaciones_productos_temporales SET precio_unitario = ?, precio_final = ? WHERE id_producto_temporal = ?", array($precio_unitario, $precio_final, $id_producto_temporal));
					}

					if ($this->db->affected_rows() > 0) {
						$obj['resultado'] = true;
						$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
						if ($calcular_totales['resultado']) {
							$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
							$obj['totales'] = $calcular_totales['totales'];
							$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$datos_calculo['produccion_periodo'], $datos_calculo, $obj['totales']['total_final']);
						} else {
							$obj['resultado'] = false;
							$obj['productos_temporales'] = [];
						}
					} else {
						$obj['resultado'] = false;
					}
				}
			} else {
				$obj['resultado'] = false;
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function guardar_tasa_cambio($id_cotizacion_temporal, $tasa_cambio_usd)
	{
		$query = $this->db->query("SELECT periodo_dias, tasa_iva, consumo_promedio_kwh, produccion_periodo, consumo_promedio_precio, indice_utilidad, tarifa, dap, costo_suministro, gasto_anual_cfe, paneles_elegidos FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);

		if ($query->num_rows() > 0) {
			$datos_calculo = $query->row_array();
			$this->db->query("UPDATE cotizaciones_temporales SET tasa_cambio = ?, fecha_tasa = NOW() WHERE id_cotizacion_temporal = ?", array($tasa_cambio_usd, $id_cotizacion_temporal));
			$tasa_cambio = (float)$tasa_cambio_usd;
			$indice_utilidad = (100 - ((float)$datos_calculo['indice_utilidad'])) / 100;

			if ($this->db->affected_rows() > 0) {
				$query = $this->db->query("SELECT * FROM cotizaciones_productos_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);
				if ($query->num_rows() > 0) {
					$productos_temporales = $query->result_array();

					foreach ($productos_temporales as $key => $producto_temporal) {
						if ($producto_temporal['cpu_usd'] != "0") {
							$id_producto_temporal = $producto_temporal['id_producto_temporal'];

							$cpu_usd = (float)$producto_temporal['cpu_usd'];
							$cantidad = (int)$producto_temporal['cantidad'];
							$cpu_mxn = round($cpu_usd * $tasa_cambio, 2);
							$costo_total = round($cpu_mxn * $cantidad, 2);
							$precio_unitario = round($cpu_mxn / $indice_utilidad, 2);
							$precio_final = round($precio_unitario * $cantidad, 2);

							$query = $this->db->query("UPDATE cotizaciones_productos_temporales SET cpu_mxn = ?, costo_total = ?, precio_unitario = ?, precio_final = ? WHERE id_producto_temporal = ?", array($cpu_mxn, $costo_total, $precio_unitario, $precio_final, $id_producto_temporal));
						}
					}

					$query = $this->db->query("SELECT fecha_tasa FROM cotizaciones_temporales WHERE id_cotizacion_temporal = ?", $id_cotizacion_temporal);
					$fecha_tasa = $query->row_array()['fecha_tasa'];

					if ($this->db->affected_rows() > 0) {
						$obj['resultado'] = true;
						$calcular_totales = $this->calcular_totales($id_cotizacion_temporal);
						if ($calcular_totales['resultado']) {
							$obj['productos_temporales'] = $calcular_totales['productos_temporales'];
							$obj['totales'] = $calcular_totales['totales'];
							$obj['fecha_tasa'] = $fecha_tasa;
							$obj['datos_ahorro'] = $this->calcular_ahorros($id_cotizacion_temporal, (float)$datos_calculo['produccion_periodo'], $datos_calculo, $obj['totales']['total_final']);
						} else {
							$obj['resultado'] = false;
							$obj['productos_temporales'] = [];
						}
					} else {
						$obj['resultado'] = false;
					}
				}
			} else {
				$obj['resultado'] = false;
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function cargar_clientes()
	{
		$query = $this->db->get('clientes');
		return $query->result();
	}

	/* Actualización de funciones 18 de febrero 2025 */

	public function comparar_datos($datos_usuario)
	{
		$id_usuario = $datos_usuario['id_usuario'];

		// Obtener datos en una sola consulta
		$query = $this->db->query("
				SELECT 
					u.id_cotizacion_temporal, 
					c.hps AS c_hps, c.eficiencia AS c_eficiencia, c.periodo AS c_periodo,
					d.hps AS d_hps, d.eficiencia AS d_eficiencia, d.periodo AS d_periodo
				FROM usuarios u
				LEFT JOIN cotizaciones_temporales c ON u.id_cotizacion_temporal = c.id_cotizacion_temporal
				LEFT JOIN datos_generales d ON 1 = 1
				WHERE u.id_usuario = ?", [$id_usuario]);

		if ($query->num_rows() > 0) {
			$data = $query->row_array();

			// Comparaciones
			$filtro_hps = $data['c_hps'] == $data['d_hps'];
			$filtro_eficiencia = $data['c_eficiencia'] == $data['d_eficiencia'];
			$filtro_periodo = $data['c_periodo'] == $data['d_periodo'];

			return [
				"filtro_hps" => $filtro_hps,
				"filtro_eficiencia" => $filtro_eficiencia,
				"filtro_periodo" => $filtro_periodo,
				"datos" => $data
			];
		}

		return null; // Si no hay datos
	}

	public function actualizar_cotizacion_temporal($datos_usuario)
	{
		$query = $this->db->get('datos_generales');
		$datos_generales = $query->row_array();
		// Preparar datos para la actualización
		$data = [
			'hps' => $datos_generales['hps'],
			'eficiencia' => $datos_generales['eficiencia'],
			'periodo' => $datos_generales['periodo']
		];

		// Actualizar la cotización temporal con los nuevos valores
		$this->db->where('id_cotizacion_temporal', $datos_usuario['id_cotizacion_temporal']);
		$this->db->update('cotizaciones_temporales', $data);

		// Verificar si la actualización fue exitosa
		if ($this->db->affected_rows() > 0) {
			return true;
		}

		return false;
	}
}
