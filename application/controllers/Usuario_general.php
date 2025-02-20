<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_general extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('UsuarioGeneralModel');
		//$data['datos_pagina']['seccion'] = "cotizador";
		$data['datos_pagina']['seccion'] = "cotizador";
		$data['datos_pagina']['subseccion'] = "";
	}
	
	public function index(){
		$data['userdata'] = $this->session->userdata('userData');
		$data['datos_pagina']['titulo_pagina'] = "Usuario general";
		$this->load->view('cotizador/cotizador_general_view', $data);
	}
}