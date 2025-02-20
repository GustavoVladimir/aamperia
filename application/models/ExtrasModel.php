<?php
	class ExtrasModel extends CI_Model{
		public function cargar_extras() {
			$query = $this->db->query("SELECT * FROM extras");
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['extras'] = $query->result();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function cargar_extra($id_extra) {
			$query = $this->db->query("SELECT * FROM extras WHERE id_extra = ?", $id_extra);
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['extras'] = $query->row();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function agregar_extra($marca, $codigo, $producto, $costo, $moneda){
			$query = $this->db->query("INSERT INTO extras(marca, codigo, producto, costo, moneda) VALUES(?, ?, ?, ?, ?)", array($marca, $codigo, $producto, $costo, $moneda));
			if($this->db->affected_rows() > 0){
				$obj['resultado'] = true;
				$obj['id_extra'] = $this->db->insert_id();
			}else{
				$obj['resultado'] = false;
			}
			return $obj;
		}
		
		public function modificar_extra($id_extra, $marca, $codigo, $producto, $costo, $moneda){
			$query = $this->db->query("UPDATE extras set marca = ?, codigo = ?, producto = ?, costo = ?, moneda = ? WHERE id_extra = ?", array($marca, $codigo, $producto, $costo, $moneda, $id_extra));
			if($this->db->affected_rows() > 0){
				$obj['resultado'] = true;
			}else{
				$obj['resultado'] = false;
			}
			return $obj;
		}
		
		public function eliminar_extra($id_extra){
			$query = $this->db->query("DELETE FROM extras WHERE id_extra = ?", $id_extra);
			if($this->db->affected_rows() > 0){
				$obj['resultado'] = true;
			}else{
				$obj['resultado'] = false;
			}
			return $obj;
		}
	}