<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Estructuras extends MY_Controller {
		private $data = array();
		
		public function __construct(){
			parent::__construct();
			$allowed = array(
				'obtener_estructuras_tipo',
				'cargar_estructura'
			);
			$this->checar_acceso_privilegiado($allowed);
			$this->load->model('EstructurasModel');
			$this->data['datos_pagina']['seccion'] = "gestion_especifica";
			$this->data['datos_pagina']['subseccion'] = "estructuras";
		}
	
		public function index() {
			$this->data['datos_pagina']['titulo_pagina'] = "Estructuras";
			$this->load->view('estructuras/estructuras_view', $this->data);
		}
		
		public function obtener_datos() {
			$obj = $this->EstructurasModel->obtener_datos();
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_estructuras() {
			$obj = $this->EstructurasModel->cargar_estructuras();
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_tipos_estructura() {
			$obj = $this->EstructurasModel->cargar_tipos_estructura();
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_estructura() {
			$id_estructura = $this->input->post('id_estructura');
			$obj = $this->EstructurasModel->cargar_estructura($id_estructura);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_tipo_estructura() {
			$id_tipo_estructura = $this->input->post('id_tipo_estructura');
			$obj = $this->EstructurasModel->cargar_tipo_estructura($id_tipo_estructura);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function obtener_estructuras_tipo() {
			$id_tipo_estructura = $this->input->post('id_tipo_estructura');
			$obj = $this->EstructurasModel->obtener_estructuras_tipo($id_tipo_estructura);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function editar_estructura() {
			$id_estructura = $this->input->post('id_estructura');
			$codigo = $this->input->post('codigo');
			$producto = $this->input->post('producto');
			$marca = $this->input->post('marca');
			$modulos = $this->input->post('modulos');
			$celdas = $this->input->post('celdas');
			$angulo = $this->input->post('angulo');
			$costo = $this->input->post('costo');
			$moneda = $this->input->post('moneda');
			$id_tipo_estructura = $this->input->post('tipo_estructura');
			$obj = $this->EstructurasModel->editar_estructura($id_estructura, $codigo, $producto, $marca, $modulos, $celdas, $angulo, $costo, $moneda, $id_tipo_estructura);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function agregar_estructura() {
			$codigo = $this->input->post('codigo');
			$producto = $this->input->post('producto');
			$marca = $this->input->post('marca');
			$modulos = $this->input->post('modulos');
			$celdas = $this->input->post('celdas');
			$angulo = $this->input->post('angulo');
			$costo = $this->input->post('costo');
			$moneda = $this->input->post('moneda');
			$id_tipo_estructura = $this->input->post('tipo_estructura');
			$obj = $this->EstructurasModel->agregar_estructura($codigo, $producto, $marca, $modulos, $celdas, $angulo, $costo, $moneda, $id_tipo_estructura);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function borrar_estructura() {
			$id_estructura = $this->input->post('id_estructura');
			$obj = $this->EstructurasModel->borrar_estructura($id_estructura);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
	
		public function agregar_tipo_estructura() {
			$codigo = $this->input->post('codigo');
			$tipo = $this->input->post('tipo');
			$obj = $this->EstructurasModel->agregar_tipo_estructura($codigo, $tipo);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function editar_tipo_estructura() {
			$id_tipo_estructura = $this->input->post('id_tipo_estructura');
			$codigo = $this->input->post('codigo');
			$tipo = $this->input->post('tipo');
			$obj = $this->EstructurasModel->editar_tipo_estructura($id_tipo_estructura, $codigo, $tipo);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function borrar_tipo_estructura() {
			$id_tipo_estructura = $this->input->post('id_tipo_estructura');
			$obj = $this->EstructurasModel->borrar_tipo_estructura($id_tipo_estructura);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
	}
	