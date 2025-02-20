<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	use mikehaertl\wkhtmlto\Pdf;
	
	class Reporte extends MY_Controller {
		
		public function __construct(){
			parent::__construct();
			$this->load->model('ReporteModel');
		}

		public function generar_pdf(){
			$codigo_html = $this->input->post('codigo_html');
			
			date_default_timezone_set('America/Mexico_City');
	    	$date = date('d-M-Y-H-i-s');
	    	$filePath = 'reporte_pdf_'.$date.'.pdf';
	    	$mpdf = new \Mpdf\Mpdf();
	    	$mpdf->WriteHTML($codigo_html);
	    	$mpdf->Output($filePath,'D');
		}
		
		public function prueba() {
			$this->load->view('reporte/prueba_reporte');
		}
		
		public function prueba_dompdf() {
			$this->load->library('pdf');
			$html = $this->load->view('reporte/prueba_reporte', [], true);
			$this->pdf->generate($html, 'mypdf', true);
		}
		
		// LA MEJOR
		public function prueba_mpdf(){
			$codigo_html = $this->load->view('reporte/prueba_reporte', [], true);
			
			date_default_timezone_set('America/Mexico_City');
	    	$date = date('d-M-Y-H-i-s');
	    	$filePath = 'reporte_pdf_'.$date.'.pdf';
	    	$mpdf = new \Mpdf\Mpdf();
	    	$mpdf->WriteHTML($codigo_html);
	    	$mpdf->Output($filePath,'D');
		}
		
		public function bs3() {
			$this->load->view('reporte/prueba_bs3');
		}
		
		// LA MEJOR
		public function pdf_bs3(){
			$this->load->library('pdf');
			$html = $this->load->view('reporte/prueba_bs3', [], true);
			$this->pdf->generate($html, 'mypdf', true);
		}
		
		// LA MEJOR
		public function pdf_bs3_mdpf(){
			$codigo_html = $this->load->view('reporte/prueba_bs3', [], true);
			date_default_timezone_set('America/Mexico_City');
	    	$date = date('d-M-Y-H-i-s');
	    	$filePath = 'reporte_pdf_'.$date.'.pdf';
	    	$mpdf = new \Mpdf\Mpdf();
	    	$mpdf->WriteHTML($codigo_html);
	    	$mpdf->Output($filePath,'D');
		}
		
		public function traer_terminos(){
			$obj = $this->ReporteModel->traer_terminos();
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function prueba_bs3() {
			$this->load->view('reporte/reporte_dompdf');
		}
		
		// LA MEJOR
		public function prueba_bs3_pdf(){
			$this->load->library('pdf');
			$html = $this->load->view('reporte/reporte_dompdf', [], true);
			$this->pdf->generate($html, 'mypdf', true);
		}
		
		public function casi_final(){
			$this->load->view('reporte/reporte_view_dompdf');
		}
		
		public function wkhtml() {
			//$mpdf = new mikehaertl\wkhtmlto\Pdf();

			// You can pass a filename, a HTML string, an URL or an options array to the constructor
			$pdf = new Pdf($this->load->view('reporte/reporte_dompdf', [], true));

			// On some systems you may have to set the path to the wkhtmltopdf executable
			$pdf->binary = '/kunden/homepages/45/d866696072/htdocs/usr/local/bin/./wkhtmltopdf';

			if (!$pdf->send('reporte_prueba.pdf')) {
				$error = $pdf->getError();
				echo $error;
				// ... handle error here
			}
		}
		
		public function cancelar_cotizacion(){
			$id_cotizacion = $this->input->post('id_cotizacion');
			$obj = $this->ReporteModel->cancelar_cotizacion($id_cotizacion);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function ver_reporte($file_name = null){
			if (preg_match('^[A-Za-z0-9_]{2,32}+[.]{1}[A-Za-z]{3,4}$^', $file_name)) {
				$file = './cotizaciones_pdf/'.$file_name;
				if (file_exists($file)) {
					header("Content-type:application/pdf");
					readfile($file);
				}
				else {
					show_404();
				}
			}
			else {
				show_404();
			}
		}
		
		public function descargar_reporte($file_name = null){
			if (preg_match('^[A-Za-z0-9_]{2,32}+[.]{1}[A-Za-z]{3,4}$^', $file_name)) {
				$file = './cotizaciones_pdf/'.$file_name;
				if (file_exists($file)) {
					header("Content-type:application/pdf");
					header("Content-Disposition:attachment;filename=".$file_name);
					readfile($file);
                }
				else {
					show_404();
				}
			}
			else {
				show_404();
			}
		}
	}
	
	