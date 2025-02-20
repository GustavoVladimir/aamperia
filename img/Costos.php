<?php 
	class Costos extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model('CostosModel');
			$this->load->library('pdf');
		}
		
		public function index(){
			$this->load->view('costos/costos_view');
		}
		
		public function vista_agregar(){
			$this->load->view('costos/agregar_costos_view');
		}
		
		public function traer_tipo_articulo(){
			$obj = $this->CostosModel->traer_tipo_articulo();
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function agregar_articulo(){
			$nombre_articulo = $this->input->post('nombre_articulo');
			$costo_MXN = $this->input->post('costo_MXN');
			$costo_USD = $this->input->post('costo_USD');
			$id_tipo_articulo = $this->input->post('id_tipo_articulo');
			$obj = $this->CostosModel->agregar_articulo($nombre_articulo,$costo_MXN,$costo_USD,$id_tipo_articulo);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function traer_costos(){
			$id_tipo_articulo = $this->input->post('id_tipo_articulo');
			$id_costo = $this->input->post('id_costo');
			$obj = $this->CostosModel->traer_costos($id_costo,$id_tipo_articulo);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function vista_editar(){
			$obj['id_costo'] = $this->uri->segment(3);
			$this->load->view('costos/editar_costos',$obj);
		}
		
		public function vista_visualizar(){
			$obj['id_costo'] = $this->uri->segment(3);
			$this->load->view('costos/visualizar_costos',$obj);
		}
		
		public function editar_articulo(){
			$id_costo = $this->input->post('id_costo');
			$nombre_articulo = $this->input->post('nombre_articulo');
			$costo_MXN = $this->input->post('costo_MXN');
			$costo_USD = $this->input->post('costo_USD');
			$id_tipo_articulo = $this->input->post('id_tipo_articulo');
			$obj = $this->CostosModel->editar_articulo($id_costo,$nombre_articulo,$costo_MXN,$costo_USD,$id_tipo_articulo);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function eliminar_costo(){
			$id_costo = $this->input->post('id_costo');
			$obj = $this->CostosModel->eliminar_costo($id_costo);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function DetallePdf(){
			// $prueba = $this->input->post('prueba');
			// if($prueba == null){
				// $prueba = "prueba 1";
			// }
	    	$var =
			'<link rel="stylesheet" href="'.base_url().'static/css/bootstrap.min.css">'.
	    	'<img src="./img/logoazul.png" width="115" height="100">'.
			'<nav style="background:#087E88;">'.
			'<span class="navbar-text" style="color:#FFFFFF">'.
			'"Aquí va la variable del nombre"<br>'.
			'<img src="./img/logoblanco.png" width="115" height="100">'.
			'<center>Juntos somos energía</center>'.
			'</span>'.
			'</nav>';
	    	$this->pdf->loadHtml($var);
			$this->pdf->render();
			$this->pdf->stream("".'PrimerPrueba'.".pdf", array("Attachment"=>0));
	    }
	}