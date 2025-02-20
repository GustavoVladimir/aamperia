<?php
class ReporteModel extends CI_Model{
	function traer_terminos(){
		$query = $this->db->query("SELECT terminos FROM datos_generales");
		$obj = $query->row();
		return $obj;
	}
	
	public function cancelar_cotizacion($id_cotizacion){
		$this->db->trans_begin();
		$query = $this->db->query("DELETE FROM cotizaciones_ahorro WHERE id_cotizacion = ?", $id_cotizacion);
		$query = $this->db->query("DELETE FROM cotizaciones_productos WHERE id_cotizacion = ?", $id_cotizacion);
		$query = $this->db->query("DELETE FROM cotizaciones WHERE id_cotizacion = ?", $id_cotizacion);
		
		if ($this->db->trans_status() === FALSE) {
			$obj['resultado'] = false;
			$this->db->trans_rollback();
		}
		else {
			$this->db->trans_commit();
			$obj['resultado'] = true;
		}
		
		return $obj;
	}
}