<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Microinversores extends MY_Controller {
		private $data = array();
		
		public function __construct(){
			parent::__construct();
			$allowed = array(
				'cargar_microinversor'
			);
			$this->checar_acceso_privilegiado($allowed);
			$this->load->model('MicroinversoresModel');
			$this->data['datos_pagina']['seccion'] = "gestion_especifica";
			$this->data['datos_pagina']['subseccion'] = "microinversores";
		}
	
		public function index() {
			$this->data['datos_pagina']['titulo_pagina'] = "Microinversores";
			$this->load->view('microinversores/microinversores_view', $this->data);
		}
		
		public function obtener_datos() {
			$obj = $this->MicroinversoresModel->obtener_datos();
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_microinversor() {
			$id_microinversor = $this->input->post('id_microinversor');
			$obj = $this->MicroinversoresModel->cargar_microinversor($id_microinversor);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_microinversores() {
			$obj = $this->MicroinversoresModel->cargar_microinversores();
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function editar_microinversor() {
			$id_microinversor = $this->input->post('id_microinversor');
			$codigo = $this->input->post('codigo');
			$producto = $this->input->post('producto');
			$marca = $this->input->post('marca');
			$potencia = $this->input->post('potencia');
			$costo = $this->input->post('costo');
			$moneda = $this->input->post('moneda');
			$obj = $this->MicroinversoresModel->editar_microinversor($id_microinversor, $codigo, $producto, $marca, $potencia, $costo, $moneda);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function agregar_microinversor() {
			$codigo = $this->input->post('codigo');
			$producto = $this->input->post('producto');
			$marca = $this->input->post('marca');
			$potencia = $this->input->post('potencia');
			$costo = $this->input->post('costo');
			$moneda = $this->input->post('moneda');
			$obj = $this->MicroinversoresModel->agregar_microinversor($codigo, $producto, $marca, $potencia, $costo, $moneda);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function borrar_microinversor() {
			$id_microinversor = $this->input->post('id_microinversor');
			$obj = $this->MicroinversoresModel->borrar_microinversor($id_microinversor);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
	
	}
	