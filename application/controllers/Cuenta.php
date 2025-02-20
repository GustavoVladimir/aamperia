<?php 
	class Cuenta extends MY_Controller{
		private $data = array();
		
		public function __construct(){
			parent::__construct();
			$this->load->model('CuentaModel');
			$this->data['datos_pagina']['seccion'] = "";
			$this->data['datos_pagina']['subseccion'] = "";
		}
		
		public function index(){
			$this->data['datos_pagina']['titulo_pagina'] = "Cuenta";
			$this->load->view('cuenta/cuenta_view', $this->data);
		}
	
		public function cambiar_contra() {
			$contrasenia = $this->input->post("contrasenia");
			$id_usuario = $this->session->usuario['id_usuario'];
			$obj = $this->CuentaModel->cambiar_contra($contrasenia, $id_usuario);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
	}