<?php	
	class LoginModel extends CI_Model{
		function random_string($length = 10) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
		
		public function iniciar_sesion($usuario, $contrasenia){
			$query = $this->db->query("SELECT id_usuario, correo, contrasenia, nombre, apellido_paterno, apellido_materno, usuario, nivel, telefono, fecha_registro, id_cotizacion_temporal FROM usuarios WHERE usuario = ? || correo = ?", array($usuario, $usuario));
			if($query->num_rows() > 0) {
				$result = $query->row();
				$obj['usuario'] = true;
				if($result->nivel == "Inactivo") {
					$obj['activo'] = false;
				}
				else {
					$obj['activo'] = true;
					if(md5($contrasenia) == $result->contrasenia){
						$obj['contrasenia'] = true;
						$obj['usuario'] = array();
						$obj['usuario']['id_usuario'] = $result->id_usuario;
						$obj['usuario']['correo'] = $result->correo;
						$obj['usuario']['nombre'] = $result->nombre;
						$obj['usuario']['telefono'] = $result->telefono;
						$obj['usuario']['fecha_registro'] = $result->fecha_registro;
						$obj['usuario']['apellido_paterno'] = $result->apellido_paterno;
						$obj['usuario']['apellido_materno'] = $result->apellido_materno;
						$obj['usuario']['usuario'] = $result->usuario;
						$obj['usuario']['nivel'] = $result->nivel; 
						$obj['usuario']['id_cotizacion_temporal'] = $result->id_cotizacion_temporal; 
					}else{
						$obj['contrasenia'] = false;
					}
				}
			}
			else {
				$obj['usuario'] = false;
			}
			
			return $obj;
		}
		
		public function enviar_correo($correo){
			$query = $this->db->query("SELECT * FROM usuarios WHERE correo = ?", array($correo));
			$result = $query->row();
			if($query->num_rows() > 0){
				$obj['correo'] = true;
				if($result->token == null){   
					$cadena = random_string();
					$sql = $this->db->query("UPDATE usuarios SET token = sha(?), vigencia_token = adddate(now(),INTERVAL 1 day) WHERE correo = ?", array($cadena,$correo));
					if($this->db->affected_rows() > 0){
						$obj['update'] = true;
						$query = $this->db->query("SELECT * FROM usuarios WHERE correo = ?", array($correo));
						$result = $query->row();
						$obj['token'] = $result->token;
						$obj['vigencia_token'] = $result->vigencia_token;
					}else{
						$obj['update'] = false;
					}
				}else{
					$obj['token'] = $result->token;
					$obj['vigencia_token'] = $result->vigencia_token;
				}
				
			}else{
				$obj['correo'] = false;
			}
			
			return $obj;
		}
		
		public function valida_token($token){
			$query = $this->db->query("SELECT *, if(vigencia_token > now(),'si','no') as vigente from usuarios where token = ?", array($token));
			$result = $query->row();
			//$obj['id_usuario'] = $result->id_usuario;
			$obj['hola'] = $result;
			if($query->num_rows() > 0){
				$obj['token'] = true;
				if($result->vigente == 'si'){
					$obj['vigencia'] = true;
				}else{
					$obj['vigencia'] = false;
					$sql = $this->db->query("UPDATE usuarios set token = null, vigencia_token = null where id_usuario = ?",array($obj['id_usuario']));
				}
			}else{
				$obj['token'] = false;
				$obj['vigencia'] = false;
			}
			return $obj;
		}
		
		public function reiniciar_token($id_usuario){
			
			return $obj;
		}
		
		public function cambiar_pass($password,$id_usuario){
			$query = $this->db->query("UPDATE usuarios set contrasenia = md5(?) where id_usuario = ?",array($password,$id_usuario));
			if($this->db->affected_rows()){
				$obj['cambio'] = true;
			}else{
				$obj['cambio'] = false;
			}
			
			return $obj;
		}
	}
		
		