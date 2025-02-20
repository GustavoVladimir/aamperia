<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cotizacion extends MY_Controller
{
	private $data = array();

	private function limpiar_cadena($cadena)
	{
		//Reemplazamos la A y a
		$cadena = str_replace(
			array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
			array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
			$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
			array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
			array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
			$cadena
		);

		//Reemplazamos la I y i
		$cadena = str_replace(
			array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
			array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
			$cadena
		);

		//Reemplazamos la O y o
		$cadena = str_replace(
			array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
			array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
			$cadena
		);

		//Reemplazamos la U y u
		$cadena = str_replace(
			array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
			array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
			$cadena
		);

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
			array('Ñ', 'ñ', 'Ç', 'ç'),
			array('N', 'n', 'C', 'c'),
			$cadena
		);

		$cadena = preg_replace('/[^a-z0-9]+/', '_', strtolower($cadena));

		$cadena = str_replace(' ', '_', $cadena);

		return $cadena;
	}

	public function __construct()
	{
		parent::__construct();
		$this->load->model('CotizacionModel');
		$this->load->model('ConfiguracionModel');
		$this->load->model('HistorialCotizacionesModel');
		$this->data['datos_pagina']['seccion'] = "cotizador";
		$this->data['datos_pagina']['subseccion'] = "";
	}

	public function index()
	{
		$this->data['datos_pagina']['titulo_pagina'] = "Cotizador";
		if ($this->checar_admin()) {
			$this->load->view('cotizador/cotizador_view', $this->data);
		} else {
			$this->load->view('cotizador/cotizador_empleado_view', $this->data);
		}
	}

	public function cotizador_empleado()
	{
		$this->data['datos_pagina']['titulo_pagina'] = "Cotizador";
		$this->load->view('cotizador/cotizador_empleado_view', $this->data);
	}

	public function obtener_datos_iniciales()
	{
		$obj['actualizar_dolar'] = $this->ConfiguracionModel->actualizar_dolar();
		$obj['datos_iniciales'] = $this->CotizacionModel->obtener_datos_iniciales();
		$obj['inventario'] = $this->CotizacionModel->obtener_elementos_cotizacion();
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	/* PARA SACAR EL CONSUMO PESOS SABIENDO LOS KWH */
	public function calcular_precio_promedio()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$tarifa = $this->input->post('tarifa');
		$consumo_promedio_kwh = (float) $this->input->post('consumo_promedio_kwh');
		$periodo = $this->input->post('periodo');
		$forma_calculo = $this->input->post('forma_calculo');
		$datos_recibo = $this->input->post('datos_recibo');

		$tarifa_cfe = $this->CotizacionModel->cargar_tarifa($tarifa);
		$costos_generales = $this->CotizacionModel->costos_generales();
		$iva = ((float) $costos_generales->iva) / 100;
		$dap = ((float) $costos_generales->dap) / 100;

		$consumo_promedio_pesos = 0;
		$suministro = 0;

		if (!is_null($tarifa) && $consumo_promedio_kwh > 0) {
			switch ($tarifa) {
				case 'tarifa_dac':
					$suministro = ($periodo == 'mensual') ? (float) $tarifa_cfe->suministro_residencial / 2 : (float) $tarifa_cfe->suministro_residencial;
					$consumo_promedio_pesos = $consumo_promedio_kwh * (float)$tarifa_cfe->dac;
					break;
				case 'tarifa_pdbt':
					$suministro = ($periodo == 'mensual') ? (float) $tarifa_cfe->suministro_comercial : (float) $tarifa_cfe->suministro_comercial * 2;
					$consumo_promedio_pesos = $consumo_promedio_kwh * (float)$tarifa_cfe->pdbt;
					break;
				case 'tarifa_01':
					$tarifa_limite_1 = 0;
					$tarifa_limite_2 = 0;
					$tarifa_limite_3 = 0;
					$consumo_aux = $consumo_promedio_kwh;
					$suministro = ($periodo == 'mensual') ? (float) $tarifa_cfe->suministro_residencial / 2 : (float) $tarifa_cfe->suministro_residencial;

					if ($consumo_aux >= (float) $tarifa_cfe->d1_limite_superior) {
						$tarifa_limite_1 =  ((float) $tarifa_cfe->d1_limite_superior) * ((float) $tarifa_cfe->d1);
						$consumo_aux -= (float) $tarifa_cfe->d1_limite_superior;
						if ($consumo_aux >= (float) $tarifa_cfe->d2_limite_superior) {
							$tarifa_limite_2 =  ((float) $tarifa_cfe->d2_limite_superior) * ((float) $tarifa_cfe->d2);
							$consumo_aux -= (float) $tarifa_cfe->d2_limite_superior;
							if ($consumo_aux > 0) {
								$tarifa_limite_3 =  $consumo_aux * ((float) $tarifa_cfe->d3);
							}
						} else {
							$tarifa_limite_2 =  $consumo_aux * ((float) $tarifa_cfe->d2);
						}
					} else {
						$tarifa_limite_1 =  $consumo_aux * ((float) $tarifa_cfe->d1);
					}

					$consumo_promedio_pesos = $tarifa_limite_1 + $tarifa_limite_2 + $tarifa_limite_3;
					break;
			}
			$valor_dap = $consumo_promedio_pesos * $dap;
			$valor_iva = $consumo_promedio_pesos * $iva;
			$consumo_promedio_pesos_final = round($suministro + $consumo_promedio_pesos + $valor_dap + $valor_iva, 2);

			if ($periodo == 'mensual') {
				$gasto_anual = round($consumo_promedio_pesos_final * 12, 2);
				$gasto_bimestral = $consumo_promedio_pesos_final * 2;
			} else {
				$gasto_anual = round($consumo_promedio_pesos_final * 6, 2);
				$gasto_bimestral = $consumo_promedio_pesos_final;
			}

			$obj['consumo_promedio_pesos'] = $consumo_promedio_pesos_final;
			$obj['gasto_anual'] = $gasto_anual;
			$obj['gasto_bimestral'] = $gasto_bimestral;
			$obj['suministro'] = $suministro;

			$obj['resultado'] = $this->CotizacionModel->guardar_precio_promedio($periodo, $tarifa, $forma_calculo, $consumo_promedio_pesos_final, $gasto_anual, $gasto_bimestral, $consumo_promedio_kwh, $datos_recibo, $suministro, $id_cotizacion_temporal);
		} else {
			$obj['resultado'] = false;
		}

		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	/* PARA SACAR EL CONSUMO KWH SABIENDO EL PRECIO */
	public function calcular_consumo_promedio()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$tarifa = $this->input->post('tarifa');
		$consumo_promedio_pesos = (float) $this->input->post('consumo_promedio_pesos');
		$periodo = $this->input->post('periodo');
		$forma_calculo = $this->input->post('forma_calculo');

		$tarifa_cfe = $this->CotizacionModel->cargar_tarifa($tarifa);
		$costos_generales = $this->CotizacionModel->costos_generales();
		$iva = ((float) $costos_generales->iva) / 100;
		$dap = ((float) $costos_generales->dap) / 100;
		$porcentaje_real = 1 - $iva - $dap;

		$consumo_promedio_kwh = 0;
		$suministro = 0;

		if (!is_null($tarifa) && $consumo_promedio_pesos > 0) {
			switch ($tarifa) {
				case 'tarifa_dac':
					$suministro = ($periodo == 'mensual') ? (float) $tarifa_cfe->suministro_residencial / 2 : (float) $tarifa_cfe->suministro_residencial;
					$consumo_promedio_kwh = round($consumo_promedio_pesos * $porcentaje_real / ((float) $tarifa_cfe->dac), 2);
					break;
				case 'tarifa_pdbt':
					$suministro = ($periodo == 'mensual') ? (float) $tarifa_cfe->suministro_comercial : (float) $tarifa_cfe->suministro_comercial * 2;
					$consumo_promedio_kwh = round($consumo_promedio_pesos * $porcentaje_real / ((float) $tarifa_cfe->pdbt), 2);
					break;
				case 'tarifa_01':
					$suministro = ($periodo == 'mensual') ? (float) $tarifa_cfe->suministro_residencial / 2 : (float) $tarifa_cfe->suministro_residencial;
					$consumo_limite_1 = 0;
					$consumo_limite_2 = 0;
					$consumo_limite_3 = 0;
					$total_aux = $consumo_promedio_pesos * $porcentaje_real;

					$tarifa_limite_1 = ((float) $tarifa_cfe->d1_limite_superior) * ((float) $tarifa_cfe->d1);
					$tarifa_limite_2 = ((float) $tarifa_cfe->d2_limite_superior) * ((float) $tarifa_cfe->d2);

					if ($total_aux >= $tarifa_limite_1) {
						$consumo_limite_1 = (float) $tarifa_cfe->d1_limite_superior;
						$total_aux -= $tarifa_limite_1;

						if ($total_aux > 0) {
							if ($total_aux >= $tarifa_limite_2) {
								$consumo_limite_2 = (float) $tarifa_cfe->d2_limite_superior;
								$total_aux -= $tarifa_limite_2;

								if ($total_aux > 0) {
									$consumo_limite_3 = $total_aux / ((float) $tarifa_cfe->d3);
								}
							} else {
								$consumo_limite_2 = $total_aux / ((float) $tarifa_cfe->d2);
							}
						}
					} else {
						$consumo_limite_1 = $total_aux / ((float) $tarifa_cfe->d1);
					}

					$consumo_promedio_kwh = round($consumo_limite_1 + $consumo_limite_2 + $consumo_limite_3, 2);
					break;
			}

			if ($periodo == 'mensual') {
				$gasto_anual = round($consumo_promedio_pesos * 12, 2);
				$gasto_bimestral = $consumo_promedio_pesos * 2;
			} else {
				$gasto_anual = round($consumo_promedio_pesos * 6, 2);
				$gasto_bimestral = $consumo_promedio_pesos;
			}

			$obj['consumo_promedio_kwh'] = $consumo_promedio_kwh;
			$obj['gasto_anual'] = $gasto_anual;
			$obj['gasto_bimestral'] = $gasto_bimestral;
			$obj['suministro'] = $suministro;

			$obj['resultado'] = $this->CotizacionModel->guardar_consumo_promedio($periodo, $tarifa, $forma_calculo, $consumo_promedio_pesos, $gasto_anual, $gasto_bimestral, $consumo_promedio_kwh, $suministro, $id_cotizacion_temporal);
		} else {
			$obj['resultado'] = false;
		}

		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function calcular_panel()
	{
		$id_panel = $this->input->post('id_panel');
		$consumo_promedio = (float) $this->input->post('consumo_promedio');
		$periodo = $this->input->post('periodo');

		$panel = $this->PanelesModel->cargar_panel($id_panel);
		$datos_generales = $this->CotizacionModel->datos_generales();
		$tasa_cambio = $this->CotizacionModel->tasa_cambio();

		if (!is_null($panel) && $consumo_promedio > 0) {
			$hps = (float) $datos_generales->hps;
			$eficiencia = ((float) $datos_generales->eficiencia) / 100;

			$costo_usd = (float) $panel->usd_panel;
			$costo_mxn = round($costo_usd * ((float)$tasa_cambio->tasa_cambio), 2);
			$kw_panel = ((float) $panel->watts_panel) / 1000;

			if ($periodo == "mensual") {
				$produccion_panel = round($hps * $kw_panel * $eficiencia * 30, 3);
			} else {
				$produccion_panel = round($hps * $kw_panel * $eficiencia * 60, 3);
			}

			$num_paneles = floor($consumo_promedio / $produccion_panel);

			$obj['resultado'] = true;
			$obj['panel'] = $panel;
			$obj['num_paneles'] = $num_paneles;
		} else {
			$obj['resultado'] = false;
		}

		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function cambio_numero_paneles()
	{
		$id_panel = $this->input->post('id_panel');
		$consumo_promedio = (float) $this->input->post('consumo_promedio');
		$num_paneles = (int) $this->input->post('num_paneles');
		$periodo = $this->input->post('periodo');

		$panel = $this->PanelesModel->cargar_panel($id_panel);
		$datos_generales = $this->CotizacionModel->datos_generales();
		$tasa_cambio = $this->CotizacionModel->tasa_cambio();

		if (!is_null($panel) && $consumo_promedio > 0 && $num_paneles > 0) {
			$hps = (float) $datos_generales->hps;
			$eficiencia = ((float) $datos_generales->eficiencia) / 100;

			$kw_panel = ((float) $panel->watts_panel) / 1000;
			$potencia_total = round($kw_panel * $num_paneles, 3);

			if ($periodo == "mensual") {
				$produccion_panel = round($hps * $kw_panel * $eficiencia * 30, 3);
				$produccion_promedio = round($produccion_panel * $num_paneles, 3);
				$produccion_anual = round($produccion_promedio * 12, 3);
			} else {
				$produccion_panel = round($hps * $kw_panel * $eficiencia * 60, 3);
				$produccion_promedio = round($produccion_panel * $num_paneles, 3);
				$produccion_anual = round($produccion_promedio * 6, 3);
			}

			$ahorro = round(($produccion_promedio / $consumo_promedio) * 100, 2);

			$costo_usd = (float) $panel->usd_panel;
			$costo_mxn = round($costo_usd * ((float)$tasa_cambio->tasa_cambio), 2);
			$costo_total = round($costo_usd * ((float)$tasa_cambio->tasa_cambio) * $num_paneles, 2);

			$obj['resultado'] = true;
			$obj['panel'] = $panel;
			$obj['ahorro'] = $ahorro;
			$obj['costo_mxn'] = $costo_mxn;
			$obj['costo_total'] = $costo_total;
			$obj['potencia_total'] = $potencia_total;
			$obj['produccion_promedio'] = $produccion_promedio;
			$obj['produccion_anual'] = $produccion_anual;
			$obj['kw_panel'] = $kw_panel;
			$obj['produccion_panel'] = $produccion_panel;
			$obj['num_paneles'] = $num_paneles;
		} else {
			$obj['resultado'] = false;
		}

		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function agregar_estructura()
	{
		$id_estructura = $this->input->post('id_estructura');
		$cantidad = $this->input->post('cantidad');
		$tasa_cambio = $this->CotizacionModel->tasa_cambio();
		$estructura = $this->EstructurasModel->cargar_estructura($id_estructura);

		if (!is_null($estructura) && $cantidad > 0) {
			$costo_usd = (float) $estructura->usd_panel;
			$costo_mxn = round($costo_usd * ((float)$tasa_cambio->tasa_cambio), 2);
			$costo_total = round($costo_mxn * $cantidad, 2);

			$obj['resultado'] = true;
		}
	}

	public function guardar_cotizacion()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$grafica_consumo = $this->input->post('grafica_consumo');
		$grafica_roi = $this->input->post('grafica_roi');
		$id_usuario = $this->input->post('id_usuario');
		$tipo_cliente = $this->input->post('tipo_cliente');
		$id_cliente = $this->input->post('id_cliente');

		$obj = $this->CotizacionModel->guardar_cotizacion($id_cotizacion_temporal, $grafica_consumo, $grafica_roi, $tipo_cliente, $id_cliente, $id_usuario);

		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function previsualizar_cotizacion($id_cotizacion = null)
	{
		$obj = $this->HistorialCotizacionesModel->descargar_cotizacion($id_cotizacion);
		if ($obj['resultado']) {
			if ($obj['estado_cotizacion'] != "Incompleto") {
				redirect("historial_cotizaciones");
			} else {
				if ($this->checar_admin()) {
					$this->load->view('reporte/reporte_view', $obj);
				} else {
					$this->load->view('reporte/reporte_empleado_view', $obj);
				}
			}
		} else {
			redirect("historial_cotizaciones");
		}
	}

	public function prueba_descarga($id_cotizacion)
	{
		$obj = $this->HistorialCotizacionesModel->descargar_cotizacion($id_cotizacion);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function finalizar_cotizacion()
	{
		$id_cotizacion = $this->input->post('id_cotizacion');
		$condiciones_pago = $this->input->post('condiciones_pago');
		$vigencia = $this->input->post('vigencia');
		$tiempo_entrega = $this->input->post('tiempo_entrega');

		$obj = $this->CotizacionModel->finalizar_cotizacion($id_cotizacion, $condiciones_pago, $vigencia, $tiempo_entrega);

		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_pdf_cotizacion()
	{
		$id_cotizacion = $this->input->post('id_cotizacion');
		$obj = $this->HistorialCotizacionesModel->descargar_cotizacion($id_cotizacion);
		if ($obj['resultado']) {
			$nombre_limpio = $this->limpiar_cadena($obj['cotizacion']->nombre);
			$this->load->library('wkhtmltopdf');
			$html = $this->load->view('reporte/plantilla_reporte', $obj, true);
			$ruta = './cotizaciones_pdf/';
			$nombre_archivo = 'cotizacion_' . $id_cotizacion . '_' . $nombre_limpio . '.pdf';
			$this->wkhtmltopdf->crear_pdf($html, $nombre_archivo, 3, $ruta);
			$obj = $this->CotizacionModel->guardar_pdf_cotizacion($id_cotizacion, $nombre_archivo);
			$obj['nombre_archivo'] = $nombre_archivo;
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		} else {
			redirect("historial_cotizaciones");
		}
	}

	public function cargar_cotizacion_temporal()
	{
		$datos_usuario = $this->session->userdata('usuario');
		$obj = $this->CotizacionModel->cargar_cotizacion_temporal($datos_usuario);

		if ($obj['tipo_cotizacion'] == 'nueva' || $obj['tipo_cotizacion'] == 'existente') {
			$this->session->set_userdata("usuario", $obj['usuario']);
		}

		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function cargar_productos_temporales()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$obj = $this->CotizacionModel->cargar_productos_temporales($id_cotizacion_temporal);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function reiniciar_cotizacion_temporal()
	{
		$datos_usuario = $this->session->userdata('usuario');
		$obj = $this->CotizacionModel->reiniciar_cotizacion_temporal($datos_usuario);

		if ($obj['resultado']) {
			$this->session->set_userdata("usuario", $obj['usuario']);
			redirect('cotizacion');
		} else {
			redirect('cotizacion');
		}
	}

	public function guardar_tasa_cambio()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$tasa_cambio_usd = $this->input->post('tasa_cambio_usd');
		$obj = $this->CotizacionModel->guardar_tasa_cambio($id_cotizacion_temporal, $tasa_cambio_usd);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_indice_utilidad()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$indice_utilidad = $this->input->post('indice_utilidad');
		$obj = $this->CotizacionModel->guardar_indice_utilidad($id_cotizacion_temporal, $indice_utilidad);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_nombre()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$nombre = $this->input->post('nombre');
		$obj = $this->CotizacionModel->guardar_nombre($id_cotizacion_temporal, $nombre);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_ubicacion()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$ubicacion = $this->input->post('ubicacion');
		$obj = $this->CotizacionModel->guardar_ubicacion($id_cotizacion_temporal, $ubicacion);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_telefono()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$telefono = $this->input->post('telefono');
		$obj = $this->CotizacionModel->guardar_telefono($id_cotizacion_temporal, $telefono);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_correo()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$correo = $this->input->post('correo');
		$obj = $this->CotizacionModel->guardar_correo($id_cotizacion_temporal, $correo);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_num_servicio()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$num_servicio = $this->input->post('num_servicio');
		$obj = $this->CotizacionModel->guardar_num_servicio($id_cotizacion_temporal, $num_servicio);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_fecha()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$fecha = $this->input->post('fecha');
		$obj = $this->CotizacionModel->guardar_fecha($id_cotizacion_temporal, $fecha);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_periodo()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$periodo = $this->input->post('periodo');
		$obj = $this->CotizacionModel->guardar_periodo($id_cotizacion_temporal, $periodo);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_mostrar_roi()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$mostrar_roi = $this->input->post('mostrar_roi');
		$obj = $this->CotizacionModel->guardar_mostrar_roi($id_cotizacion_temporal, $mostrar_roi);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_tipo_interconexion()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$tipo_interconexion = $this->input->post('tipo_interconexion');
		$obj = $this->CotizacionModel->guardar_tipo_interconexion($id_cotizacion_temporal, $tipo_interconexion);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_panel()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$id_panel = $this->input->post('id_panel');
		$obj = $this->CotizacionModel->guardar_panel($id_cotizacion_temporal, $id_panel);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_numero_paneles()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$id_panel = $this->input->post('id_panel');
		$num_paneles = $this->input->post('num_paneles');
		$obj = $this->CotizacionModel->guardar_numero_paneles($id_cotizacion_temporal, $id_panel, $num_paneles);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_instalacion_electrica()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$metros = $this->input->post('metros');
		$instalacion = $this->input->post('instalacion');
		$obj = $this->CotizacionModel->guardar_instalacion_electrica($id_cotizacion_temporal, $metros, $instalacion);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_material_electrico()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$material_electrico = $this->input->post('material_electrico');
		$obj = $this->CotizacionModel->guardar_material_electrico($id_cotizacion_temporal, $material_electrico);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function guardar_producto()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$id_producto = $this->input->post('id_producto');
		$tipo_producto = $this->input->post('tipo_producto');
		$cantidad = $this->input->post('cantidad');
		$principal = $this->input->post('principal');
		$obj = $this->CotizacionModel->guardar_producto($id_cotizacion_temporal, $id_producto, $tipo_producto, $cantidad, $principal);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function eliminar_producto()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$id_producto = $this->input->post('id_producto');
		$tipo_producto = $this->input->post('tipo_producto');
		$obj = $this->CotizacionModel->eliminar_producto($id_cotizacion_temporal, $id_producto, $tipo_producto);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function cambiar_cantidad_producto()
	{
		$id_cotizacion_temporal = $this->input->post('id_cotizacion_temporal');
		$id_producto = $this->input->post('id_producto');
		$tipo_producto = $this->input->post('tipo_producto');
		$cantidad = $this->input->post('cantidad');
		$obj = $this->CotizacionModel->cambiar_cantidad_producto($id_cotizacion_temporal, $id_producto, $tipo_producto, $cantidad);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function cargar_clientes()
	{
		$obj = $this->CotizacionModel->cargar_clientes();
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}
}
