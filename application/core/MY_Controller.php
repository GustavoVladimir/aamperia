<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	protected $datos_sesion;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ZonaHorariaModel');
		if ($this->session->userdata('usuario')) {
			$this->datos_sesion = $this->session->userdata('usuario');
		} else {
			redirect('login');
		}
	}

	public function checar_acceso_privilegiado($allowed = null)
	{
		$nivel = $this->datos_sesion['nivel'];

		if (is_null($allowed)) {
			if ($nivel == "Administrador" || $nivel == "Propietario") {
				return;
			} elseif ($nivel == "Tercero") {
				// Redirigir al controlador cliente
				redirect('clientes');
			} else {
				show_404();
			}
		} else {
			if ($nivel != "Administrador" && $nivel != "Propietario") {
				if (!in_array($this->router->fetch_method(), $allowed)) {
					show_404();
				}
			}
		}
	}


	public function checar_admin()
	{
		$nivel = $this->datos_sesion['nivel'];
		if ($nivel == "Administrador" || $nivel == "Propietario") {
			return true;
		} else {
			return false;
		}
	}
}
