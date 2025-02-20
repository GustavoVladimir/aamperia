<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Recuperar extends CI_Controller {
		public function __construct(){
			parent::__construct();
			$this->load->model('RecuperarModel');
		}
		
		public function index() {
			if($this->session->userdata('usuario')) {
				redirect('cotizacion');
			}
			else {
				$this->load->view('recuperar/recuperar_view');
			}
		}	
		
		public function vista_mail(){
			$this->load->view('plantillas/mail_view');
		}
		
		public function enviar_correo(){
			$correo = $this->input->post('correo');
			$obj = $this->RecuperarModel->enviar_correo($correo);  
			
			if($obj['correo']){
				if($obj['activo']) {
					$mail_view = $this->load->view('plantillas/mail_view',$obj,true);
					$this->load->library('email');
					$this->email->from('atencion@agctecnologias.com', 'Sistema AAMPERIA');
					$this->email->to($correo);
					$this->email->subject('Recuperación de contraseña');
					$this->email->message($mail_view);
					if($this->email->send()){
						$obj['mail_envio'] = true;
					}
					else{
						$obj['mail_envio'] = false;
					}
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function valida_token($token = null){
			$obj = $this->RecuperarModel->valida_token($token);
			
			if($obj['token']) {
				if($obj['vigencia']) {
					$obj['valor_token'] = $token;
					$this->load->view("recuperar/cambiar_pass",$obj);
				}
				else {
					$this->session->set_flashdata('mensaje_error', 'El token introducido ya no está vigente, vuelve a solicitar otro.');
					redirect('recuperar');
				}
			}
			else {
				$this->session->set_flashdata('mensaje_error', 'El token introducido no es correcto, vuelve a solicitar otro.');
				redirect('recuperar');
			}
		}
		
		public function cambiar_pass() {
			$token = $this->input->post('token');
			$password = $this->input->post('password');
			
			if(!is_null($token) && !is_null($password)) {
				$obj = $this->RecuperarModel->cambiar_pass($token, $password);
				if($obj['cambiado']) {
					$this->load->view("recuperar/contrasena_cambiada");
				}
				else {
					$this->session->set_flashdata('mensaje_error', 'El token introducido no es correcto, vuelve a solicitar otro.');
					redirect('recuperar');
				}
			}
			else {
				redirect('recuperar');
			}
		}
	}
	