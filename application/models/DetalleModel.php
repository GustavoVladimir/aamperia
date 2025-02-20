<?php
class DetalleModel extends CI_Model
{
	public function obtener_datos()
	{
		$query = $this->db->get('clientes');
		return $query->result();
	}

	public function cargar_recibos($id_cliente)
	{
		$query = $this->db->get_where('recibos', array('id_cliente' => $id_cliente));
		return $query->result();
	}

	public function agregar_comentario($data)
	{
		if ($this->db->insert('comentarios', $data)) {
			return [
				'status' => 'success',
				'insert_id' => $this->db->insert_id(), // Retorna el ID generado, si es una tabla con auto-increment
				'message' => 'Comentario agregado correctamente.'
			];
		} else {
			return [
				'status' => 'error',
				'error_message' => $this->db->_error_message() // Error específico de la base de datos
			];
		}
	}

	public function cargar_comentarios($id_cliente)
	{
		$this->db->select('comentarios.*, usuarios.nombre AS nombre_usuario, usuarios.apellido_paterno, usuarios.apellido_materno');
		$this->db->from('comentarios');
		$this->db->join('usuarios', 'usuarios.id_usuario = comentarios.id_usuario', 'inner');
		$this->db->where('comentarios.id_cliente', $id_cliente);
		$query = $this->db->get();
		return $query->result(); // Devuelve múltiples filas
	}

	public function agregar_recibo($data)
	{
		if ($this->db->insert('recibos', $data)) {
			return [
				'status' => 'success',
				'insert_id' => $this->db->insert_id(), // Retorna el ID generado, si es una tabla con auto-increment
				'message' => 'Recibo agregado correctamente.'
			];
		} else {
			return [
				'status' => 'error',
				'error_message' => $this->db->_error_message() // Error específico de la base de datos
			];
		}
	}

	public function borrar_cliente($id_cliente)
	{
		// Validar que el id_cliente no sea vacío o nulo
		if (!empty($id_cliente)) {
			// Ejecutar la eliminación del registro
			$this->db->where('id_cliente', $id_cliente);
			$result = $this->db->delete('clientes');

			// Verificar si se realizó la eliminación
			if ($result) {
				return true;  // Eliminación exitosa
			} else {
				return false; // Error en la eliminación
			}
		} else {
			return false; // ID no válido
		}
	}

	public function agregar_cliente($data)
	{
		if ($this->db->insert('clientes', $data)) {
			return [
				'status' => true,
				'message' => 'Cliente agregado con éxito.',
				'id_cliente' => $this->db->insert_id()
			];
		} else {
			return [
				'status' => false,
				'message' => 'Error al agregar el cliente.',
				'error' => $this->db->error() // Incluye detalles del error si es necesario
			];
		}
	}

	public function editar_cliente($data)
	{
		// Verificar que el ID del cliente esté definido y no sea nulo
		if (!empty($data['id_cliente'])) {
			// Establecer la condición para el cliente específico
			$this->db->where('id_cliente', $data['id_cliente']);
			// Intentar actualizar el registro
			$result = $this->db->update('clientes', $data);

			if ($result) {
				return [
					'status' => true,
					'message' => 'Cliente actualizado con éxito.'
				];
			} else {
				return [
					'status' => false,
					'message' => 'Error al actualizar el cliente.',
					'error' => $this->db->error() // Detalles del error
				];
			}
		} else {
			return [
				'status' => false,
				'message' => 'El ID del cliente no es válido o no se proporcionó.'
			];
		}
	}
}
