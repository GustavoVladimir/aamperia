<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Extras extends MY_Controller{
		private $data = array();
		
		public function __construct(){
			parent::__construct();
			$allowed = array(
				'cargar_extra'
			);
			$this->checar_acceso_privilegiado($allowed);
			$this->load->model('ExtrasModel');
			$this->data['datos_pagina']['seccion'] = "gestion_especifica";
			$this->data['datos_pagina']['subseccion'] = "extras";
		}
		
		public function index(){
			$this->data['datos_pagina']['titulo_pagina'] = "Extras";
			$this->load->view('extras/extras_view',$this->data);
		}
		
		public function cargar_extras() {
			$obj = $this->ExtrasModel->cargar_extras();
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_extra() {
			$id_extra = $this->input->post('id_extra');
			$obj = $this->ExtrasModel->cargar_extra($id_extra);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function agregar_extra(){
			$marca = $this->input->post('marca');
			$codigo = $this->input->post('codigo');
			$producto = $this->input->post('producto');
			$costo = $this->input->post('costo');
			$moneda = $this->input->post('moneda');
			$obj = $this->ExtrasModel->agregar_extra($marca, $codigo, $producto, $costo, $moneda);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function modificar_extra(){
			$id_extra = $this->input->post('id_extra');
			$marca = $this->input->post('marca');
			$codigo = $this->input->post('codigo');
			$producto = $this->input->post('producto');
			$costo = $this->input->post('costo');
			$moneda = $this->input->post('moneda');
			$obj = $this->ExtrasModel->modificar_extra($id_extra, $marca, $codigo, $producto, $costo, $moneda);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function eliminar_extra(){
			$id_extra = $this->input->post('id_extra');
			$obj = $this->ExtrasModel->eliminar_extra($id_extra);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
	}