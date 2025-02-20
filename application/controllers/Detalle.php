<?php
class Detalle extends MY_Controller
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('DetalleModel');
		// Cargar el helper para manejar archivos
		$this->load->helper(array('url', 'form', 'file'));
		// Cargar la librería para manejar formularios
		$this->load->library('form_validation');
	}

	public function cargar_recibos()
	{
		$id_cliente = $this->input->post('id_cliente');
		$obj = $this->DetalleModel->cargar_recibos($id_cliente);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function upload_file()
	{
		$data = $this->input->post();

		// Configuración para la carga de archivos
		$config['upload_path'] = './uploads'; // Asegúrate de que la ruta sea accesible
		$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf'; // Tipos permitidos
		$config['max_size'] = 2048; // Tamaño máximo del archivo (2MB)
		$config['file_name'] = uniqid(); // Nombre único para el archivo

		// Cargar la librería de carga de archivos
		$this->load->library('upload', $config);

		// Cambiar 'file' por 'reciboArchivo' en el método do_upload
		if (!$this->upload->do_upload('reciboArchivo')) {  // Cambiar 'file' a 'reciboArchivo'
			// Si ocurre un error durante la carga
			$response = [
				'status' => 'error',
				'message' => $this->upload->display_errors()  // Mostrar los errores de carga
			];
		} else {
			// Archivo subido correctamente
			$file_data = $this->upload->data();

			$data['url'] = base_url('uploads/' . $file_data['file_name']);
			$response = [
				'status' => 'success',
				'message' => 'Archivo subido con éxito',
				'file_path' => base_url('uploads/' . $file_data['file_name']),
				'data' => $data
			];
			unset($data['reciboTipo']);
			$obj = $this->DetalleModel->agregar_recibo($data);
		}

		// Devolver la respuesta en formato JSON
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function agregar_comentario()
	{
		$data = $this->input->post();
		$data['id_usuario'] = $this->session->usuario['id_usuario'];
		$data['fecha_registro'] = date('Y-m-d H:i:s');
		$obj = $this->DetalleModel->agregar_comentario($data);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function cargar_comentarios()
	{
		$id_cliente = $this->input->post("id_cliente");
		$obj = $this->DetalleModel->cargar_comentarios($id_cliente);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function borrar_cliente()
	{
		$id_cliente = $this->input->post("id_cliente");
		$obj = $this->DetalleModel->borrar_cliente($id_cliente);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function agregar_cliente()
	{
		$data = $this->input->post();
		$obj = $this->DetalleModel->agregar_cliente($data);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}

	public function editar_cliente()
	{
		$data = $this->input->post();
		$obj = $this->DetalleModel->editar_cliente($data);
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($obj));
	}
}
