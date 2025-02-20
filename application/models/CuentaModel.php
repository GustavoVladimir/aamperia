<?php
	class CuentaModel extends CI_Model{
		public function cambiar_contra($contrasenia, $id_usuario) {
			$query = $this->db->query("UPDATE usuarios SET contrasenia = MD5(?) WHERE id_usuario = ?", array($contrasenia, $id_usuario));
			
			if($this->db->affected_rows() >= 0) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
	
	}