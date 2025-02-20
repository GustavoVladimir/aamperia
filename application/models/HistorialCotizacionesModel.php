<?php
class HistorialCotizacionesModel extends CI_Model
{
	public function cargar_cotizaciones()
	{
		$query = $this->db->query("SELECT CONCAT(usuarios.nombre, ' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno) as nombre_asesor, id_cotizacion, cotizaciones.nombre, cotizaciones.telefono, tipo_interconexion, num_paneles, total, DATE_FORMAT(fecha_cotizacion,'%d/%m/%Y') as fecha_cotizacion, DATE_FORMAT(vigencia,'%d/%m/%Y') as vigencia, estado_cotizacion, estado_cotizacion, nombre_archivo, id_cliente FROM cotizaciones INNER JOIN usuarios ON (cotizaciones.id_usuario = usuarios.id_usuario) ORDER BY id_cotizacion DESC");
		if ($query->num_rows() >= 0) {
			$obj['resultado'] = true;
			$obj['cotizaciones'] = $query->result();
		} else {
			$obj['resultado'] = false;
		}
		return $obj;
	}

	public function cargar_cotizaciones_empleado($id_usuario)
	{
		$query = $this->db->query("SELECT CONCAT(usuarios.nombre, ' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno) as nombre_asesor, id_cotizacion, cotizaciones.nombre, cotizaciones.telefono, tipo_interconexion, num_paneles, total, DATE_FORMAT(fecha_cotizacion,'%d/%m/%Y') as fecha_cotizacion, DATE_FORMAT(vigencia,'%d/%m/%Y') as vigencia, estado_cotizacion, estado_cotizacion FROM cotizaciones INNER JOIN usuarios ON (cotizaciones.id_usuario = usuarios.id_usuario) WHERE cotizaciones.id_usuario = ? ORDER BY id_cotizacion DESC", $id_usuario);
		if ($query->num_rows() >= 0) {
			$obj['resultado'] = true;
			$obj['cotizaciones'] = $query->result();
		} else {
			$obj['resultado'] = false;
		}
		return $obj;
	}

	public function cargar_cotizacion($id_cotizacion)
	{
		$query = $this->db->query("SELECT CONCAT(usuarios.nombre, ' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno) as nombre_asesor, id_cotizacion, cotizaciones.nombre, cotizaciones.telefono, tipo_interconexion, num_paneles, total, DATE_FORMAT(fecha_cotizacion,'%d/%m/%Y') as fecha_cotizacion, DATE_FORMAT(vigencia,'%d/%m/%Y') as vigencia, estado_cotizacion, estado_cotizacion FROM cotizaciones INNER JOIN usuarios ON (cotizaciones.id_usuario = usuarios.id_usuario) WHERE id_cotizacion = ?", $id_cotizacion);
		if ($query->num_rows() > 0) {
			$obj['resultado'] = true;
			$obj['cotizacion'] = $query->row();
		} else {
			$obj['resultado'] = false;
		}
		return $obj;
	}

	public function modificar_cotizacion($id_cotizacion, $estado)
	{
		$query = $this->db->query("UPDATE cotizaciones SET estado_cotizacion = ? WHERE id_cotizacion = ?", array($estado, $id_cotizacion));
		if ($this->db->affected_rows() >= 0) {
			$obj['resultado'] = true;
		} else {
			$obj['resultado'] = false;
		}
		return $obj;
	}

	public function descargar_cotizacion($id_cotizacion)
	{
		$query = $this->db->query("SELECT CONCAT(usuarios.nombre, ' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno) nombre_asesor, usuarios.telefono as telefono_asesor, cotizaciones.* FROM cotizaciones INNER JOIN usuarios ON (cotizaciones.id_usuario = usuarios.id_usuario) WHERE id_cotizacion = ?", $id_cotizacion);
		if ($query->num_rows() > 0) {
			$obj['cotizacion'] = $query->row();
			$obj['estado_cotizacion'] = $query->row()->estado_cotizacion;
			$query = $this->db->query("SELECT * FROM cotizaciones_productos WHERE id_cotizacion = ?", $id_cotizacion);
			if ($query->num_rows() > 0) {
				$productos = $query->result_array();

				foreach ($productos as $key => $producto) {
					$id_producto = $producto['id_producto'];
					$prov = false;
					switch ($producto['tipo_producto']) {
						case 'panel_solar':
							$query = $this->db->query("SELECT producto, codigo FROM paneles WHERE id_panel = ?", $id_producto);
							break;
						case 'estructura':
							$query = $this->db->query("SELECT producto, codigo FROM estructuras WHERE id_estructura = ?", $id_producto);
							break;
						case 'inversor':
							$query = $this->db->query("SELECT producto, codigo FROM inversores WHERE id_inversor = ?", $id_producto);
							break;
						case 'microinversor':
							$query = $this->db->query("SELECT producto, codigo FROM microinversores WHERE id_microinversor = ?", $id_producto);
							break;
						case 'optimizador':
							$query = $this->db->query("SELECT producto, codigo FROM optimizadores WHERE id_optimizador = ?", $id_producto);
							break;
						case 'sistema_monitoreo':
							$query = $this->db->query("SELECT producto, codigo FROM sistemas_monitoreo WHERE id_sistema_monitoreo = ?", $id_producto);
							break;
						case 'extra':
							$query = $this->db->query("SELECT producto, codigo FROM extras WHERE id_extra = ?", $id_producto);
							break;
						case 'producto_fijo':
							$query = $this->db->query("SELECT producto, codigo FROM productos_fijos WHERE id_producto_fijo = ?", $id_producto);
							break;
					}

					$datos_producto = $query->row_array();
					$productos[$key]['datos_producto'] = $datos_producto;
				}

				$obj['productos'] = $productos;

				$query = $this->db->query("SELECT * FROM cotizaciones_ahorro WHERE id_cotizacion = ?", $id_cotizacion);

				if ($query->num_rows() > 0) {
					$obj['ahorro'] = $query->result();
					$query = $this->db->query("SELECT terminos FROM datos_generales");
					$obj['terminos'] = $query->row()->terminos;
					$obj['resultado'] = true;
				} else {
					$obj['resultado'] = false;
				}
			} else {
				$obj['resultado'] = false;
			}
		} else {
			$obj['resultado'] = false;
		}

		return $obj;
	}

	public function eliminar_cotizacion($id_cotizacion)
	{
		$query = $this->db->query("SELECT nombre_archivo FROM cotizaciones WHERE id_cotizacion = ?", $id_cotizacion);
		$row = $query->row_array();

		$this->db->trans_begin();
		$query = $this->db->query("DELETE FROM cotizaciones_ahorro WHERE id_cotizacion = ?", $id_cotizacion);
		$query = $this->db->query("DELETE FROM cotizaciones_productos WHERE id_cotizacion = ?", $id_cotizacion);
		$query = $this->db->query("DELETE FROM cotizaciones WHERE id_cotizacion = ?", $id_cotizacion);

		if ($this->db->trans_status() === FALSE) {
			$obj['resultado'] = false;
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$obj['resultado'] = true;
			$obj['nombre_archivo'] = $row['nombre_archivo'];
		}

		return $obj;
	}

	public function actualizar_vigencias()
	{
		$this->db->query("UPDATE cotizaciones SET estado_cotizacion = 'Vencido' WHERE (NOW() > vigencia) AND estado_cotizacion like 'Pendiente'");
	}
}
