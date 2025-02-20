<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Inversores extends MY_Controller{
		private $data = array();
		
		public function __construct(){
			parent::__construct();
			$allowed = array(
				'cargar_inversor'
			);
			$this->checar_acceso_privilegiado($allowed);
			$this->load->model('InversoresModel');
			$this->data['datos_pagina']['seccion'] = "gestion_especifica";
			$this->data['datos_pagina']['subseccion'] = "inversores";
		}
		
		public function index(){
			$this->data['datos_pagina']['titulo_pagina'] = "Inversores";
			$this->load->view('inversores/inversores_view',$this->data);
		}
		
		public function traer_inversores(){
			$marca = $this->input->post('marca');
			$id_inversor = $this->input->post('id_inversor');
			$obj = $this->InversoresModel->traer_inversores($id_inversor,$marca);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_inversores() {
			$obj = $this->InversoresModel->cargar_inversores();
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_inversor() {
			$id_inversor = $this->input->post('id_inversor');
			$obj = $this->InversoresModel->cargar_inversor($id_inversor);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function agregar_inversor(){
			$marca = $this->input->post('marca');
			$codigo = $this->input->post('codigo');
			$producto = $this->input->post('producto');
			$potencia = $this->input->post('potencia');
			$costo = $this->input->post('costo');
			$moneda = $this->input->post('moneda');
			$obj = $this->InversoresModel->agregar_inversor($marca, $codigo, $producto, $potencia, $costo, $moneda);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function traer_marca_inversor(){
			$obj = $this->InversoresModel->traer_marca_inversor();
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function modificar_inversor(){
			$id_inversor = $this->input->post('id_inversor');
			$marca = $this->input->post('marca');
			$codigo = $this->input->post('codigo');
			$producto = $this->input->post('producto');
			$potencia = $this->input->post('potencia');
			$costo = $this->input->post('costo');
			$moneda = $this->input->post('moneda');
			$obj = $this->InversoresModel->modificar_inversor($id_inversor, $marca, $codigo, $producto, $potencia, $costo, $moneda);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function eliminar_inversor(){
			$id_inversor = $this->input->post('id_inversor');
			$obj = $this->InversoresModel->eliminar_inversor($id_inversor);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
	}