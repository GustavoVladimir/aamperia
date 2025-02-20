<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Paneles extends MY_Controller{
		private $data = array();
		public function __construct(){
			parent::__construct();
			$allowed = array(
				'cargar_panel'
			);
			$this->checar_acceso_privilegiado($allowed);
			$this->load->model('PanelesModel');
			$this->data['datos_pagina']['seccion'] = "gestion_especifica";
			$this->data['datos_pagina']['subseccion'] = "paneles";
		}

		public function index(){
			$this->data['datos_pagina']['titulo_pagina'] = "Paneles";
			$this->load->view('paneles/paneles_view',$this->data);
		}
		
		public function traer_paneles(){
			$id_panel = $this->input->post('id_panel');
			$marca = $this->input->post('marca');
			$obj = $this->PanelesModel->traer_paneles($marca,$id_panel);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_paneles() {
			$obj = $this->PanelesModel->cargar_paneles();
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_panel() {
			$id_panel = $this->input->post('id_panel');
			$obj = $this->PanelesModel->cargar_panel($id_panel);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function traer_marca_panel(){
			$obj = $this->PanelesModel->traer_marca_panel();
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function agregar_panel(){
			$codigo = $this->input->post('codigo_panel');
			$marca = $this->input->post('marca_panel');
			$producto = $this->input->post('producto_panel');
			$watts_panel = $this->input->post('watts_panel');
			$usd_panel = $this->input->post('usd_panel');
			$usd_watt = $this->input->post('usd_watt');
			$obj = $this->PanelesModel->agregar_panel($codigo, $marca, $producto, $watts_panel, $usd_panel, $usd_watt);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function eliminar_panel(){
			$id_panel = $this->input->post('id_panel');
			$obj = $this->PanelesModel->eliminar_panel($id_panel);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function modificar_panel(){
			$id_panel = $this->input->post('id_panel');
			$codigo = $this->input->post('modificar_codigo');
			$marca = $this->input->post('modificar_marca');
			$watts_panel = $this->input->post('modificar_watts_panel');
			$usd_panel = $this->input->post('modificar_usd_panel');
			$usd_watt = $this->input->post('modificar_usd_watt');
			$obj = $this->PanelesModel->modificar_panel($codigo, $marca, $watts_panel, $usd_panel, $usd_watt, $id_panel);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
	}