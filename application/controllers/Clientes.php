<?php
class Clientes extends MY_Controller
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ClienteModel');
		$this->data['datos_pagina']['seccion'] = "Clientes";
		$this->data['datos_pagina']['subseccion'] = "";
	}

	public function index()
	{
		$this->data['datos_pagina']['titulo_pagina'] = "Clientes";
		$this->load->view('cliente/cliente_view', $this->data);
	}

	public function obtener_datos()
	{
		$obj = $this->ClienteModel->obtener_datos();
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function detalle_cliente($id_cliente)
	{
		// Establecer el título de la página
		$this->data['datos_pagina']['titulo_pagina'] = "Clientes";

		// Puedes usar el $id_cliente para cargar los datos del cliente o hacer otras operaciones
		$this->data['id_cliente'] = $id_cliente;
		$this->load->view('cliente/detalle_cliente', $this->data);
	}

	public function cargar_cliente()
	{
		$id_cliente = $this->input->post('id_cliente');
		$obj = $this->ClienteModel->cargar_cliente($id_cliente);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function agregar_cliente()
	{
		$data = $this->input->post();
		$obj = $this->ClienteModel->agregar_cliente($data);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function borrar_cliente()
	{
		$id_cliente = $this->input->post("id_cliente");
		$obj = $this->ClienteModel->borrar_cliente($id_cliente);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function editar_cliente()
	{
		$data = $this->input->post();
		$obj = $this->ClienteModel->editar_cliente($data);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}
}
