<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Errores extends CI_Controller {
		public function __construct(){
			parent::__construct();
		}
	
		public function error_404() {
			$this->load->view('errores/404_view');
		}
	}