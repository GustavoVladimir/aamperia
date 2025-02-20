<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Monitoreo extends CI_Controller{
		private $data = array();
		public function __construct(){
			parent::__construct();
			$this->load->model('MonitoreoModel');
			$this->data['datos_pagina']['seccion'] = "gestion_especifica";
			$this->data['datos_pagina']['subseccion'] = "monitoreo";
		}
		
		public function index(){
			$this->data['datos_pagina']['titulo_pagina'] = "Monitoreo";
			$this->load->view('monitoreo/monitoreo_view',$this->data);
		}
	}