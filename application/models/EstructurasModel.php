<?php
	class EstructurasModel extends CI_Model{
		public function obtener_datos(){
			$query = $this->db->query("SELECT estructuras.*, tipos_estructura.codigo as tipo_codigo FROM estructuras LEFT JOIN tipos_estructura ON estructuras.id_tipo_estructura = tipos_estructura.id_tipo_estructura");
			$obj['estructuras'] = $query->result();
			return $obj;
		}
		
		public function cargar_tipos_estructura() {
			$query = $this->db->query("SELECT * from tipos_estructura");
			$obj['tipos'] = $query->result();	
			return $obj;
		}
		
		public function cargar_estructuras() {
			$query = $this->db->query("SELECT * from estructuras");
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['estructuras'] = $query->result();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function cargar_estructura($id_estructura){
			$query = $this->db->query("SELECT estructuras.*, tipos_estructura.codigo as tipo_codigo FROM estructuras LEFT JOIN tipos_estructura ON estructuras.id_tipo_estructura = tipos_estructura.id_tipo_estructura WHERE id_estructura = ?", $id_estructura);
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['estructura'] = $query->row();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function cargar_tipo_estructura($id_tipo_estructura){
			$query = $this->db->query("SELECT * from tipos_estructura WHERE id_tipo_estructura = ?", $id_tipo_estructura);
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['tipo'] = $query->row();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function obtener_estructuras_tipo($id_tipo_estructura) {
			$query = $this->db->query("SELECT id_estructura, codigo from estructuras WHERE id_tipo_estructura = ?", $id_tipo_estructura);
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['estructuras'] = $query->result();
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function editar_estructura($id_estructura, $codigo, $producto, $marca, $modulos, $celdas, $angulo, $costo, $moneda, $id_tipo_estructura) {
			$query = $this->db->query("UPDATE estructuras SET codigo = ?, producto = ?, marca = ?, modulos = ?, celdas = ?, angulo = ?, costo = ?, moneda = ?, id_tipo_estructura = ? WHERE id_estructura = ?", array($codigo, $producto, $marca, $modulos, $celdas, $angulo, $costo, $moneda, $id_tipo_estructura, $id_estructura));
			if($this->db->affected_rows() > 0) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function agregar_estructura($codigo, $producto, $marca, $modulos, $celdas, $angulo, $costo, $moneda, $id_tipo_estructura) {
			$query = $this->db->query("INSERT INTO estructuras (codigo, producto, marca, modulos, celdas, angulo, costo, moneda, id_tipo_estructura) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)", array($codigo, $producto, $marca, $modulos, $celdas, $angulo, $costo, $moneda, $id_tipo_estructura));
			if($this->db->affected_rows() == 1) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function borrar_estructura($id_estructura) {
			$query = $this->db->query("DELETE FROM estructuras WHERE id_estructura = ?", $id_estructura);
			if($this->db->affected_rows() == 1) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function agregar_tipo_estructura($codigo, $tipo) {
			$query = $this->db->query("INSERT INTO tipos_estructura (codigo, tipo) VALUES(?, ?)", array($codigo, $tipo));
			if($this->db->affected_rows() == 1) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function editar_tipo_estructura($id_tipo_estructura, $codigo, $tipo) {
			$query = $this->db->query("UPDATE tipos_estructura SET codigo = ?, tipo = ? WHERE id_tipo_estructura = ?", array($codigo, $tipo, $id_tipo_estructura));
			if($this->db->affected_rows() > 0) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function borrar_tipo_estructura($id_tipo_estructura) {
			$query = $this->db->query("SELECT * FROM estructuras WHERE id_tipo_estructura = ?",  $id_tipo_estructura);
			if($query->num_rows() > 0) {
				$obj['resultado'] = false;
			}
			else {
				$query = $this->db->query("DELETE FROM tipos_estructura WHERE id_tipo_estructura = ?", $id_tipo_estructura);
				if($this->db->affected_rows() == 1) {
					$obj['resultado'] = true;
				}
				else {
					$obj['resultado'] = false;
				}	
			}	
			
			return $obj;
		}
	}
	