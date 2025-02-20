<?php 
	class SistemasMonitoreoModel extends CI_Model{
		public function obtener_datos(){
			$query = $this->db->query("SELECT * from sistemas_monitoreo");
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['sistemas'] = $query->result();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function cargar_sistemas(){
			$query = $this->db->query("SELECT id_sistema_monitoreo, codigo, marca, producto from sistemas_monitoreo");
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['sistemas'] = $query->result();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function cargar_sistema($id_sistema_monitoreo){
			$query = $this->db->query("SELECT * from sistemas_monitoreo WHERE id_sistema_monitoreo = ?", $id_sistema_monitoreo);
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['sistema'] = $query->row();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function agregar_sistema($codigo, $producto, $marca, $costo, $moneda) {
			$query = $this->db->query("INSERT INTO sistemas_monitoreo (codigo, producto, marca, costo, moneda) VALUES(?, ?, ?, ?, ?)", array($codigo, $producto, $marca, $costo, $moneda));
			if($this->db->affected_rows() == 1) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function editar_sistema($id_sistema_monitoreo, $codigo, $producto, $marca, $costo, $moneda) {
			$query = $this->db->query("UPDATE sistemas_monitoreo SET codigo = ?, producto = ?, marca = ?, costo = ?, moneda = ? WHERE id_sistema_monitoreo = ?", array($codigo, $producto, $marca, $costo, $moneda, $id_sistema_monitoreo));
			if($this->db->affected_rows() == 1) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function borrar_sistema($id_sistema_monitoreo) {
			$query = $this->db->query("DELETE FROM sistemas_monitoreo WHERE id_sistema_monitoreo = ?", $id_sistema_monitoreo);
			if($this->db->affected_rows() == 1) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
	}