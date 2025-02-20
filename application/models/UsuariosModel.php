<?php
	class UsuariosModel extends CI_Model{
		
		public function agregar_usuario($nombre, $apellido_paterno, $apellido_materno, $usuario, $correo, $contrasenia, $telefono, $nivel){
			$query = $this->db->query("INSERT INTO usuarios(nombre, apellido_paterno, apellido_materno, usuario, correo, contrasenia, telefono, nivel) VALUES(?, ?, ?, ?, ?, MD5(?), ?, ?)", array($nombre, $apellido_paterno, $apellido_materno, $usuario, $correo, $contrasenia, $telefono, $nivel));
			if($this->db->affected_rows() > 0){
				$obj['resultado'] = true;
			} else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function cargar_usuarios(){
			$query = $this->db->query("SELECT id_usuario, nombre, apellido_paterno, apellido_materno, usuario, nivel, correo, telefono from usuarios");
			if($query->num_rows() > 0){
				$obj['resultado'] = true;
				$obj['usuarios'] = $query->result();
			}else{
				$obj['resultado'] = false;
				$obj['mensaje'] = "No se encontraron usuarios";
			}	
			return $obj;
		}
		
		public function visualizar_usuario($id_usuario){
			$query = $this->db->query("SELECT id_usuario, CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno) as nombre, usuario, nivel, telefono from usuarios WHERE id_usuario = '$id_usuario'");
			if($query->num_rows() > 0){
				$obj['resultado'] = true;
				$obj['datos_usuario'] = $query->row();
			}else{
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function cargar_usuario($id_usuario){
			$query = $this->db->query("SELECT id_usuario, nombre, apellido_paterno, apellido_materno, usuario, nivel, correo, telefono, fecha_registro from usuarios WHERE id_usuario = ?", $id_usuario);
			if($query->num_rows() > 0){
				$obj['resultado'] = true;
				$obj['datos_usuario'] = $query->row();
			}else{
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
		public function editar_usuario($id_usuario, $nombre, $apellido_paterno, $apellido_materno, $usuario, $correo, $telefono, $nivel){
			$query = $this->db->query("UPDATE usuarios set nombre = ?, apellido_paterno = ?, apellido_materno = ?, usuario = ?, correo = ?, telefono = ?, nivel = ? WHERE id_usuario = ?", array($nombre, $apellido_paterno, $apellido_materno, $usuario, $correo, $telefono, $nivel, $id_usuario));
			if($this->db->affected_rows() > 0){
				$obj['resultado'] = true;
			}else{
				$obj['resultado'] = false;
			}
			return $obj;
		}
		
		public function cargar_responsables() {
			$query = $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as responsable from usuarios");
			if($query->num_rows() > 0) {
				$obj['resultado'] = true;
				$obj['responsables'] = $query->result();
			} else {
				$obj['resultado'] = false;
			}	
			return $obj;
		}
		
	}