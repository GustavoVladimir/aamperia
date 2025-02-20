<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Optimizadores extends MY_Controller {
		private $data = array();
		
		public function __construct(){
			parent::__construct();
			$allowed = array(
				'cargar_optimizador'
			);
			$this->checar_acceso_privilegiado($allowed);
			$this->load->model('OptimizadoresModel');
			$this->data['datos_pagina']['seccion'] = "gestion_especifica";
			$this->data['datos_pagina']['subseccion'] = "optimizadores";
		}
	
		public function index() {
			$this->data['datos_pagina']['titulo_pagina'] = "Optimizadores";
			$this->load->view('optimizadores/optimizadores_view', $this->data);
		}
		
		public function obtener_datos() {
			$obj = $this->OptimizadoresModel->obtener_datos();
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_optimizador() {
			$id_optimizador = $this->input->post('id_optimizador');
			$obj = $this->OptimizadoresModel->cargar_optimizador($id_optimizador);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_optimizadores() {
			$obj = $this->OptimizadoresModel->cargar_optimizadores();
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function editar_optimizador() {
			$id_optimizador = $this->input->post('id_optimizador');
			$codigo = $this->input->post('codigo');
			$producto = $this->input->post('producto');
			$marca = $this->input->post('marca');
			$costo = $this->input->post('costo');
			$moneda = $this->input->post('moneda');
			$obj = $this->OptimizadoresModel->editar_optimizador($id_optimizador, $codigo, $producto, $marca, $costo, $moneda);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function agregar_optimizador() {
			$codigo = $this->input->post('codigo');
			$producto = $this->input->post('producto');
			$marca = $this->input->post('marca');
			$costo = $this->input->post('costo');
			$moneda = $this->input->post('moneda');
			$obj = $this->OptimizadoresModel->agregar_optimizador($codigo, $producto, $marca, $costo, $moneda);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function borrar_optimizador() {
			$id_optimizador = $this->input->post('id_optimizador');
			$obj = $this->OptimizadoresModel->borrar_optimizador($id_optimizador);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
	
	}
	