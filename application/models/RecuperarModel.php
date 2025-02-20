<?php	
	class RecuperarModel extends CI_Model{
		function random_string($length = 10) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
		
		public function enviar_correo($correo){
			$query = $this->db->query("SELECT id_usuario, correo, nivel, token, if(vigencia_token > now(),'si','no') as vigente FROM usuarios WHERE correo = ?", array($correo));
			if($query->num_rows() > 0){
				$result = $query->row();
				$obj['correo'] = true;
				if($result->nivel != 'Inactivo') {
					$obj['activo'] = true;
					if($result->token == null || $result->vigente == "no"){   
						$cadena = $this->random_string();
						$sql = $this->db->query("UPDATE usuarios SET token = sha(?), vigencia_token = adddate(now(),INTERVAL 30 minute) WHERE correo = ?", array($cadena,$correo));
						if($this->db->affected_rows() > 0){
							$query = $this->db->query("SELECT vigencia_token, token FROM usuarios WHERE correo = ?", array($correo));
							$result = $query->row();
							$obj['token'] = $result->token;
						}
					} else {
						$obj['token'] = $result->token;
					}
				}
				else {
					$obj['activo'] = false;
				}
			}else{
				$obj['correo'] = false;
			}
			
			return $obj;
		}
		
		public function valida_token($token){
			$query = $this->db->query("SELECT id_usuario, if(vigencia_token > now(),'si','no') as vigente from usuarios where token = ?", array($token));
			if($query->num_rows() > 0){
				$result = $query->row();
				$obj['id_usuario'] = $result->id_usuario;
				$obj['token'] = true;
				if($result->vigente == 'si'){
					$obj['vigencia'] = true;
				}else{
					$obj['vigencia'] = false;
					$sql = $this->db->query("UPDATE usuarios set token = null, vigencia_token = null where id_usuario = ?",array($obj['id_usuario']));
				}
			}else{
				$obj['token'] = false;
			}
			
			return $obj;
		}
		
		public function cambiar_pass($token, $password){
			$query = $this->db->query("SELECT id_usuario, if(vigencia_token > now(),'si','no') as vigente from usuarios where token = ?", array($token));
			if($query->num_rows() > 0) {
				$result = $query->row();
				if($result->vigente == 'si'){
					$this->db->query("UPDATE usuarios SET contrasenia = md5(?), token  = null, vigencia_token = null WHERE id_usuario = ?", array($password,$result->id_usuario));
					if($this->db->affected_rows() > 0){
						$obj['cambiado'] = true;
					}
					else {
						$obj['cambiado'] = false;
					}
				}
				else{
					$obj['cambiado'] = false;
				}
			}
			else {
				$obj['cambiado'] = false;
			}
			
			return $obj;
		}
	}
		
		