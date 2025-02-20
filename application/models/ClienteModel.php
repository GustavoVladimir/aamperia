<?php
class ClienteModel extends CI_Model
{
	public function obtener_datos()
	{
		// Obtener el nivel de usuario desde la sesión
		$nivel_usuario = $_SESSION['usuario']['nivel'];

		// Seleccionar los campos que necesitas
		$this->db->select('clientes.*, usuarios.nombre AS nombre_usuario, usuarios.apellido_paterno, usuarios.apellido_materno');
		$this->db->from('clientes');
		$this->db->join('usuarios', 'usuarios.id_usuario = clientes.id_usuario', 'inner'); // Realizar el JOIN

		// Si el nivel de usuario es "Tercero", filtrar por el ID de usuario
		if ($nivel_usuario === 'Tercero') {
			$id_usuario = $_SESSION['usuario']['id_usuario']; // Obtener el ID del usuario actual
			$this->db->where('clientes.id_usuario', $id_usuario); // Filtrar por el usuario actual
		}

		// Ejecutar la consulta
		$query = $this->db->get();

		// Retornar los resultados de la consulta
		return $query->result();
	}


	public function cargar_cliente($id_cliente)
	{
		$this->db->select('clientes.*, usuarios.nombre AS nombre_usuario, usuarios.apellido_paterno, usuarios.apellido_materno');
		$this->db->from('clientes');
		$this->db->join('usuarios', 'usuarios.id_usuario = clientes.id_usuario', 'inner');
		$this->db->where('clientes.id_cliente', $id_cliente);
		$query = $this->db->get();
		return $query->row(); // Devuelve una sola fila
	}

	public function agregar_cliente($data)
	{
		$data['id_usuario'] = $_SESSION['usuario']['id_usuario'];
		// Insert data into the 'clientes' table
		$this->db->insert('clientes', $data);

		// Check if the insertion was successful
		if ($this->db->affected_rows() > 0) {
			return true; // Inserted successfully
		} else {
			return false; // Insertion failed
		}
	}

	// Method to delete a client from the 'clientes' table
	public function borrar_cliente($id_cliente)
	{
		// Check if the client exists
		$this->db->where('id_cliente', $id_cliente);
		$query = $this->db->get('clientes');

		if ($query->num_rows() > 0) {
			// Client exists, proceed to delete
			$this->db->where('id_cliente', $id_cliente);
			$this->db->delete('clientes');

			if ($this->db->affected_rows() > 0) {
				return array('status' => 'success', 'message' => 'Cliente borrado exitosamente');
			} else {
				return array('status' => 'error', 'message' => 'No se pudo borrar el cliente');
			}
		} else {
			return array('status' => 'error', 'message' => 'Cliente no encontrado');
		}
	}

	public function editar_cliente($data)
	{
		$this->db->update('clientes', $data, 'id_cliente = ' . $data['id_cliente']);
		// Check if the insertion was successful
		if ($this->db->affected_rows() > 0) {
			return true; // Inserted successfully
		} else {
			return false; // Insertion failed
		}
	}
}
