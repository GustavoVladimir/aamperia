<?php
	class OptimizadoresModel extends CI_Model{
		public function obtener_datos(){
			$query = $this->db->query("SELECT * from optimizadores");
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['optimizadores'] = $query->result();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function cargar_optimizador($id_optimizador){
			$query = $this->db->query("SELECT * from optimizadores WHERE id_optimizador = ?", $id_optimizador);
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['optimizador'] = $query->row();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function cargar_optimizadores(){
			$query = $this->db->query("SELECT id_optimizador, codigo, marca, producto from optimizadores");
			$obj['optimizadores'] = $query->result();
			return $obj;
		}
		
		public function editar_optimizador($id_optimizador, $codigo, $producto, $marca, $costo, $moneda) {
			$query = $this->db->query("UPDATE optimizadores SET codigo = ?, producto = ?, marca = ?, costo = ?, moneda = ? WHERE id_optimizador = ?", array($codigo, $producto, $marca, $costo, $moneda, $id_optimizador));
			if($this->db->affected_rows() > 0) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function agregar_optimizador($codigo, $producto, $marca, $costo, $moneda) {
			$query = $this->db->query("INSERT INTO optimizadores (codigo, producto, marca, costo, moneda) VALUES(?, ?, ?, ?, ?)", array($codigo, $producto, $marca, $costo, $moneda));
			if($this->db->affected_rows() == 1) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function borrar_optimizador($id_optimizador) {
			$query = $this->db->query("DELETE FROM optimizadores WHERE id_optimizador = ?", $id_optimizador);
			if($this->db->affected_rows() == 1) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
	}
	