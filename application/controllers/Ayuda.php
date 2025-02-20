<?php 
	class Ayuda extends MY_Controller {
		private $data = array();
		
		public function __construct(){
			parent::__construct();
			$this->load->model('AyudaModel');
			$this->data['datos_pagina']['seccion'] = "ayuda";
			$this->data['datos_pagina']['subseccion'] = "";
		}
		
		public function index(){
			$this->data['datos_pagina']['titulo_pagina'] = "Ayuda y documentación";
			$this->load->view('ayuda/ayuda_view', $this->data);
		}
		
	}