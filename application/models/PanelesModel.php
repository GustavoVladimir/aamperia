<?php
class PanelesModel extends CI_Model{
	public function traer_paneles($marca = null, $id_panel = null){
		if($marca == null && $id_panel == null){
			$query = $this->db->query("SELECT * FROM paneles order by id_panel desc");
			if($query->num_rows() >= 1) {
				$obj['resultado'] = true;
				$obj['paneles'] = $query->result();
			}
			else {
				$obj['resultado'] = false;
			}
		}
		else {
			if($id_panel == null){
				$query = $this->db->query("SELECT * FROM paneles where marca like '%$marca%' order by id_panel desc");
				if($query->num_rows() >= 1) {
					$obj['resultado'] = true;
					$obj['paneles'] = $query->result();
				}
				else {
					$obj['resultado'] = false;
				}
			}
			else {
				if($marca == null){
					$query = $this->db->query("SELECT * FROM paneles where id_panel = $id_panel");
					if($query->num_rows() >= 1) {
						$obj['resultado'] = true;
						$obj['paneles'] = $query->row();
					}
					else {
						$obj['resultado'] = false;
					}
				}
			}
		}
		
		return $obj;
	}
	
	public function cargar_panel($id_panel) {
		$query = $this->db->query("SELECT * FROM paneles WHERE id_panel = ?", $id_panel);
		if($query->num_rows() >= 1) {
			$obj['resultado'] = true;
			$obj['panel'] = $query->row();
		}
		else {
			$obj['resultado'] = false;
		}
		return $obj;
	}
		
	public function traer_marca_panel(){
		$query = $this->db->query("SELECT id_panel,marca FROM paneles GROUP BY marca");
		if($query->num_rows() >= 1) {
			$obj['resultado'] = true;
			$obj['marcas'] = $query->result();
		}
		else {
			$obj['resultado'] = false;
		}
		return $obj;
 	}
	
	public function cargar_paneles() {
		$query = $this->db->query("SELECT id_panel, codigo, marca, producto FROM paneles");
		$obj['paneles'] = $query->result();
		return $obj;
	}
	
	public function agregar_panel($codigo, $marca, $producto, $watts_panel, $usd_panel, $usd_watt){
		$query = $this->db->query("INSERT INTO paneles(codigo, marca, producto, watts_panel, usd_panel, usd_watt) VALUES(?, ?, ?, ?, ?, ?)", array($codigo, $marca, $producto, $watts_panel, $usd_panel, $usd_watt));
		if($this->db->affected_rows() > 0){
			$obj['resultado'] = true;
		}else{
			$obj['resultado'] = false;
		}
		return $obj;
	}
	
	public function eliminar_panel($id_panel){
		$query = $this->db->query("DELETE FROM paneles WHERE id_panel = $id_panel");
		if($this->db->affected_rows() > 0){
			$obj['resultado'] = true;
		}else{
			$obj['resultado'] = false;
		}
		return $obj;
	}
	
	public function modificar_panel($codigo, $marca, $watts_panel, $usd_panel, $usd_watt, $id_panel){
		$query = $this->db->query("UPDATE paneles set codigo = '$codigo', marca = '$marca', watts_panel = $watts_panel, USD_panel = $usd_panel, USD_watt = $usd_watt where id_panel = $id_panel");
		if($this->db->affected_rows() > 0){
			$obj['resultado'] = true;
		}else{
			$obj['resultado'] = false;
		}
		return $obj;
	}
}