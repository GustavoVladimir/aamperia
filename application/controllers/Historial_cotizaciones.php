<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Historial_cotizaciones extends MY_Controller{
		private $data = array();
		
		public function __construct(){
			parent::__construct();
			$this->load->model('HistorialCotizacionesModel');
			$this->data['datos_pagina']['seccion'] = "historial_cotizaciones";
			$this->data['datos_pagina']['subseccion'] = "";
			$this->actualizar_vigencias();
		}
		
		private function actualizar_vigencias(){
			$this->HistorialCotizacionesModel->actualizar_vigencias();
		}
		
		public function index(){
			$this->data['datos_pagina']['titulo_pagina'] = "Cotizaciones realizadas";
			if($this->checar_admin()) {
				$this->load->view('historial_cotizaciones/historial_view',$this->data);
			}
			else {
				$this->load->view('historial_cotizaciones/historial_empleado_view',$this->data);
			}
		}
		
		public function cargar_cotizaciones() {
			$obj = $this->HistorialCotizacionesModel->cargar_cotizaciones();
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_cotizaciones_empleado() {
			$id_usuario = $this->datos_sesion['id_usuario'];
			$obj = $this->HistorialCotizacionesModel->cargar_cotizaciones_empleado($id_usuario);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_cotizacion() {
			$id_cotizacion = $this->input->post('id_cotizacion');
			$obj = $this->HistorialCotizacionesModel->cargar_cotizacion($id_cotizacion);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}
		
		public function modificar_cotizacion() {
			$id_cotizacion = $this->input->post('id_cotizacion');
			$estado = $this->input->post('estado');
			$obj = $this->HistorialCotizacionesModel->modificar_cotizacion($id_cotizacion, $estado);
			$this->output->set_content_type("application/json");
			$this->output->set_output(json_encode($obj));
		}

		public function eliminar_cotizacion(){
			$id_cotizacion = $this->input->post('id_cotizacion');
			$obj = $this->HistorialCotizacionesModel->eliminar_cotizacion($id_cotizacion);
			if($obj['resultado']) {
				if (file_exists("./cotizaciones_pdf/".$obj['nombre_archivo'])) {
					unlink("./cotizaciones_pdf/".$obj['nombre_archivo']);
				}
			}
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function descargar_cotizacion($id_cotizacion = null) {
			$obj = $this->HistorialCotizacionesModel->descargar_cotizacion($id_cotizacion);
			if($obj['resultado']) {
				$nombre_limpio = str_replace(' ', '_', $obj['cotizacion']->nombre);
				$this->load->library('wkhtmltopdf');
				$html = $this->load->view('reporte/plantilla_reporte',$obj, true);
				$this->wkhtmltopdf->crear_pdf($html, 'cotizacion_'.$nombre_limpio);
			}
			else {
				redirect("historial_cotizaciones");
			}
		}
		
		public function ver_cotizacion($id_cotizacion = null) {
			$obj = $this->HistorialCotizacionesModel->descargar_cotizacion($id_cotizacion);
			if($obj['resultado']) {
				$nombre_limpio = str_replace(' ', '_', $obj['cotizacion']->nombre);
				$this->load->library('wkhtmltopdf');
				$html = $this->load->view('reporte/plantilla_reporte',$obj, true);
				$this->wkhtmltopdf->crear_pdf($html, 'cotizacion_'.$nombre_limpio, 2);
			}
			else {
				redirect("historial_cotizaciones");
			}
		}
		
		public function guardar_pdf_cotizacion($id_cotizacion = null) {
			$obj = $this->HistorialCotizacionesModel->descargar_cotizacion($id_cotizacion);
			if($obj['resultado']) {
				$nombre_limpio = str_replace(' ', '_', $obj['cotizacion']->nombre);
				$this->load->library('wkhtmltopdf');
				$html = $this->load->view('reporte/plantilla_reporte',$obj, true);
				$ruta = './cotizaciones_pdf/';
				$nombre_archivo = 'cotizacion_'.$id_cotizacion.'_'.$nombre_limpio;
				$this->wkhtmltopdf->crear_pdf($html, $nombre_archivo, 3, $ruta);
				
				$obj['nombre_archivo'] = $nombre_archivo;
				$this->output->set_content_type("application/json");
				$this->output->set_output(json_encode($obj));
			}
			else {
				redirect("historial_cotizaciones");
			}
		}
		
		public function cotizacion_html($id_cotizacion = null) {
			$obj = $this->HistorialCotizacionesModel->descargar_cotizacion($id_cotizacion);
			if($obj['resultado']) {
				$this->load->view('reporte/plantilla_reporte',$obj);
			}
			else {
				redirect("historial_cotizaciones");
			}
		}
	}