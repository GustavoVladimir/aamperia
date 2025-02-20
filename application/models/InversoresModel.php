<?php
	class InversoresModel extends CI_Model{
		public function traer_inversores($id_inversor,$marca){
			if($id_inversor == null && $marca == null){
				$query = $this->db->query("SELECT * FROM inversores");
				if($query->num_rows() > 0) {
					$obj['resultado'] = true;
					$obj['inversores'] = $query->result();
				}
				else {
					$obj['resultado'] = true;
				}
			}else if($marca == null){
				$query = $this->db->query("SELECT * FROM inversores where id_inversor = $id_inversor");
				if($query->num_rows() > 0) {
					$obj['resultado'] = true;
					$obj['inversores'] = $query->row();
				}
				else {
					$obj['resultado'] = true;
				}
			}else if($id_inversor == null){
				$query = $this->db->query("SELECT * FROM inversores where marca = '$marca'");
				if($query->num_rows() > 0) {
					$obj['resultado'] = true;
					$obj['inversores'] = $query->row();
				}
				else {
					$obj['resultado'] = true;
				}
			}
			
			return $obj;
		}
		
		public function traer_marca_inversor(){
			$query = $this->db->query("SELECT marca FROM inversores group by marca");
			$obj['resultado'] = $query->result();
			return $obj;
		}
		
		public function cargar_inversores() {
			$query = $this->db->query("SELECT id_inversor, codigo, marca, producto FROM inversores");
			$obj['inversores'] = $query->result();
			return $obj;
		}
		
		public function cargar_inversor($id_inversor) {
			$query = $this->db->query("SELECT * FROM inversores WHERE id_inversor = ?", $id_inversor);
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['inversor'] = $query->row();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function agregar_inversor($marca, $codigo, $producto, $potencia, $costo, $moneda){
			$query = $this->db->query("INSERT INTO inversores(marca, codigo, producto, potencia, costo, moneda) VALUES(?, ?, ?, ?, ?, ?)", array($marca, $codigo, $producto, $potencia, $costo, $moneda));
			if($this->db->affected_rows() > 0){
				$obj['resultado'] = true;
			}else{
				$obj['resultado'] = false;
			}
			return $obj;
		}
		
		public function modificar_inversor($id_inversor, $marca, $codigo, $producto, $potencia, $costo, $moneda){
			$query = $this->db->query("UPDATE inversores set marca = ?, codigo = ?, producto = ?, potencia = ?, costo = ?, moneda = ? WHERE id_inversor = ?", array($marca, $codigo, $producto, $potencia, $costo, $moneda, $id_inversor));
			if($this->db->affected_rows() > 0){
				$obj['resultado'] = true;
			}else{
				$obj['resultado'] = false;
			}
			return $obj;
		}
		
		public function eliminar_inversor($id_inversor){
			$query = $this->db->query("DELETE FROM inversores WHERE id_inversor = $id_inversor");
			if($this->db->affected_rows() > 0){
				$obj['resultado'] = true;
			}else{
				$obj['resultado'] = false;
			}
			return $obj;
		}
	}