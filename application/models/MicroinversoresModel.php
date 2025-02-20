<?php
	class MicroinversoresModel extends CI_Model{
		public function obtener_datos(){
			$query = $this->db->query("SELECT * from microinversores");
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['microinversores'] = $query->result();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function cargar_microinversor($id_microinversor){
			$query = $this->db->query("SELECT * from microinversores WHERE id_microinversor = ?", $id_microinversor);
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['microinversor'] = $query->row();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function cargar_microinversores(){
			$query = $this->db->query("SELECT id_microinversor, codigo, marca, producto from microinversores");
			$obj['microinversores'] = $query->result();
			return $obj;
		}
		
		public function editar_microinversor($id_microinversor, $codigo, $producto, $marca, $potencia, $costo, $moneda) {
			$query = $this->db->query("UPDATE microinversores SET codigo = ?, producto = ?, marca = ?, potencia = ?, costo = ?, moneda = ? WHERE id_microinversor = ?", array($codigo, $producto, $marca, $potencia, $costo, $moneda, $id_microinversor));
			if($this->db->affected_rows() > 0) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function agregar_microinversor($codigo, $producto, $marca, $potencia, $costo, $moneda) {
			$query = $this->db->query("INSERT INTO microinversores (codigo, producto, marca, potencia, costo, moneda) VALUES(?, ?, ?, ?, ?, ?)", array($codigo, $producto, $marca, $potencia, $costo, $moneda));
			if($this->db->affected_rows() == 1) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function borrar_microinversor($id_microinversor) {
			$query = $this->db->query("DELETE FROM microinversores WHERE id_microinversor = ?", $id_microinversor);
			if($this->db->affected_rows() == 1) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
	}
	