<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Sistemas_monitoreo extends MY_Controller {
		private $data = array();
		
		public function __construct(){
			parent::__construct();
			$allowed = array(
				'cargar_sistema'
			);
			$this->checar_acceso_privilegiado($allowed);
			$this->load->model('SistemasMonitoreoModel');
			$this->data['datos_pagina']['seccion'] = "gestion_especifica";
			$this->data['datos_pagina']['subseccion'] = "sistemas_monitoreo";
		}
	
		public function index() {
			$this->data['datos_pagina']['titulo_pagina'] = "Sistemas de monitoreo";
			$this->load->view('sistemas_monitoreo/sistemas_monitoreo_view', $this->data);
		}
		
		public function obtener_datos() {
			$obj = $this->SistemasMonitoreoModel->obtener_datos();
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_sistema() {
			$id_sistema_monitoreo = $this->input->post('id_sistema_monitoreo');
			$obj = $this->SistemasMonitoreoModel->cargar_sistema($id_sistema_monitoreo);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_sistemas() {
			$obj = $this->SistemasMonitoreoModel->cargar_sistemas();
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}

		public function agregar_sistema() {
			$codigo = $this->input->post('codigo');
			$producto = $this->input->post('producto');
			$marca = $this->input->post('marca');
			$costo = $this->input->post('costo');
			$moneda = $this->input->post('moneda');
			$obj = $this->SistemasMonitoreoModel->agregar_sistema($codigo, $producto, $marca, $costo, $moneda);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function editar_sistema() {
			$id_sistema_monitoreo = $this->input->post('id_sistema_monitoreo');
			$codigo = $this->input->post('codigo');
			$producto = $this->input->post('producto');
			$marca = $this->input->post('marca');
			$costo = $this->input->post('costo');
			$moneda = $this->input->post('moneda');
			$obj = $this->SistemasMonitoreoModel->editar_sistema($id_sistema_monitoreo, $codigo, $producto, $marca, $costo, $moneda);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function borrar_sistema() {
			$id_sistema_monitoreo = $this->input->post('id_sistema_monitoreo');
			$obj = $this->SistemasMonitoreoModel->borrar_sistema($id_sistema_monitoreo);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
	
	}
	