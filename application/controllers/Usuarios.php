<?php 
	class Usuarios extends MY_Controller {
		private $data = array();
		public function __construct(){
			parent::__construct();
			$this->checar_acceso_privilegiado();
			$this->load->model('UsuariosModel');
			$this->data['datos_pagina']['seccion'] = "gestion_general";
			$this->data['datos_pagina']['subseccion'] = "usuarios";
		}
		
		public function index(){
			$this->data['datos_pagina']['titulo_pagina'] = "Usuarios";
			$this->load->view('usuarios/usuarios_view', $this->data);
		}
		
		public function vista_agregar(){
			$this->load->view('usuarios/agregar_usuarios');
		}
		
		public function agregar_usuario(){
			$nombre = $this->input->post('nombre');
			$apellido_paterno = $this->input->post('apellido_paterno');
			$apellido_materno = $this->input->post('apellido_materno');
			$usuario = $this->input->post('usuario');
			$correo = $this->input->post('correo');
			$contrasenia = $this->input->post('contrasenia');
			$telefono = $this->input->post('telefono');
			$nivel = $this->input->post('nivel');
			$obj = $this->UsuariosModel->agregar_usuario($nombre, $apellido_paterno, $apellido_materno, $usuario, $correo, $contrasenia, $telefono, $nivel);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function editar_usuario(){
			$id_usuario = $this->input->post('id_usuario');
			$nombre = $this->input->post('nombre');
			$apellido_paterno = $this->input->post('apellido_paterno');
			$apellido_materno = $this->input->post('apellido_materno');
			$usuario = $this->input->post('usuario');
			$correo = $this->input->post('correo');
			$telefono = $this->input->post('telefono');
			$nivel = $this->input->post('nivel');
			$obj = $this->UsuariosModel->editar_usuario($id_usuario, $nombre, $apellido_paterno, $apellido_materno, $usuario, $correo, $telefono, $nivel);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_usuarios(){
			$obj = $this->UsuariosModel->cargar_usuarios();
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function visualizar_usuario(){
			$id_usuario = $this->input->post('id_usuario');
			$obj = $this->UsuariosModel->visualizar_usuario($id_usuario);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_usuario(){
			$id_usuario = $this->input->post('id_usuario');
			$obj = $this->UsuariosModel->cargar_usuario($id_usuario);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function eliminar_usuario(){
			$id_usuario = $this->input->post('id_usuario');
			$obj = $this->UsuariosModel->eliminar_usuario($id_usuario);
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
		
		public function cargar_responsables() {
			$obj = $this->UsuariosModel->cargar_responsables();
			$this->output->set_content_type( "application/json" );
			$this->output->set_output(json_encode($obj));
		}
	}
	//Si  se va a poder modificar la password del usuario, se requiere verificación de contraseña anterior.