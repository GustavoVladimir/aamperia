<!doctype html>
<html lang="en">

<head>
	<?php $this->load->view('include/header', $datos_pagina); ?>
	<script>
		var nivel = "<?= $this->session->usuario['nivel'] ?>";
	</script>
</head>

<body>
	<div class="wrapper d-flex align-items-stretch">
		<?php $this->load->view('include/menu_lateral', $datos_pagina);  ?>

		<div id="content" class="main">
			<?php $this->load->view('include/barra_superior', $datos_pagina);  ?>
			<div id="contenido" class="container-fluid">
				<div class="botones_crud mt-4">
					<div class="row">
						<div class="col">
							<h2>Gestión de usuarios</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 col-12 d-flex justify-content-center align-items-end">
							<button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#agregar-usuario">Agregar nuevo usuario</button>
						</div>
					</div>
				</div>
				<div class="row mt-4">
					<div class="col">
						<table id="tabla-usuarios" class="table-striped table-bordered tabla-responsiva">
							<thead>
								<tr>
									<th scope="col">Nombre</th>
									<th scope="col">Correo</th>
									<th scope="col">Usuario</th>
									<th scope="col">Teléfono</th>
									<th scope="col">Nivel</th>
									<th scope="col">Acción</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="agregar-usuario" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Agregar usuario</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" id="formulario_agregar">
						<div class="form-row">
							<div class="col-6 form-group">
								<label for="usuario_nuevo">Usuario</label>
								<input class="form-control" type="text" id="usuario_nuevo" name="usuario" required>
							</div>
							<div class="col-6 form-group">
								<label for="contrasenia_nuevo">Contraseña</label>
								<input class="form-control" type="password" id="contrasenia_nuevo" name="contrasenia" required>
							</div>
						</div>
						<div class="form-row">
							<div class="col-12 form-group">
								<label for="correo_nuevo">Correo electrónico</label>
								<input class="form-control" type="email" id="correo_nuevo" name="correo" required>
							</div>
						</div>
						<div class="form-row">
							<div class="col-12 form-group">
								<label for="nombre_nuevo">Nombre(s)</label>
								<input class="form-control" type="text" id="nombre_nuevo" name="nombre" required>
							</div>
							<div class="col-6 form-group">
								<label for="apellido_paterno_nuevo">Apellido paterno</label>
								<input class="form-control" type="text" id="apellido_paterno_nuevo" name="apellido_paterno" required>
							</div>
							<div class="col-6 form-group">
								<label for="apellido_materno_nuevo">Apellido materno</label>
								<input class="form-control" type="text" id="apellido_materno_nuevo" name="apellido_materno" required>
							</div>
						</div>
						<div class="form-row">
							<div class="col-6 form-group">
								<label for="telefono_nuevo">Teléfono</label>
								<input class="form-control" type="text" id="telefono_nuevo" name="telefono" required>
							</div>
							<div class="col-6 form-group">
								<label>Nivel de usuario</label>
								<select class="form-control" id="nivel" name="nivel" required>
									<option value="" disabled selected>Selecciona una opción</option>
									<?php if ($this->session->usuario['nivel'] == "Propietario") {  ?>
										<option value="Propietario">Propietario</option>
										<option value="Administrador">Administrador</option>
										<option value="Empleado">Empleado</option>
										<option value="Tercero">Tercero</option>
										<option value="Inactivo">Inactivo</option>
									<?php } elseif ($this->session->usuario['nivel'] == "Administrador") { ?>
										<option value="Tercero">Tercero</option>
										<option value="Inactivo">Inactivo</option>
									<?php } ?>
								</select>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" form="formulario_agregar">Agregar</button>
					<button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="editar-usuario" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Editar usuario</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" id="formulario_editar">
						<div class="form-row">
							<div class="col-2 form-group">
								<label for="id_usuario_editar">ID</label>
								<input class="form-control" type="text" id="id_usuario_editar" name="id_usuario" readonly>
							</div>
							<div class="col-10 form-group">
								<label for="usuario_editar">Usuario</label>
								<input class="form-control" type="text" id="usuario_editar" name="usuario" required>
							</div>
						</div>
						<div class="form-row">
							<div class="col-12 form-group">
								<label for="correo_editar">Correo electrónico</label>
								<input class="form-control" type="email" id="correo_editar" name="correo" required>
							</div>
						</div>
						<div class="form-row">
							<div class="col-12 form-group">
								<label for="nombre_editar">Nombre(s)</label>
								<input class="form-control" type="text" id="nombre_editar" name="nombre" required>
							</div>
							<div class="col-6 form-group">
								<label for="apellido_paterno_editar">Apellido paterno</label>
								<input class="form-control" type="text" id="apellido_paterno_editar" name="apellido_paterno" required>
							</div>
							<div class="col-6 form-group">
								<label for="apellido_materno_editar">Apellido materno</label>
								<input class="form-control" type="text" id="apellido_materno_editar" name="apellido_materno" required>
							</div>
						</div>
						<div class="form-row">
							<div class="col-6 form-group">
								<label for="telefono_editar">Teléfono</label>
								<input class="form-control" type="text" id="telefono_editar" name="telefono" required>
							</div>
							<div class="col-6 form-group">
								<label for="nivel_editar">Nivel de usuario</label>
								<select class="form-control" name="nivel" id="nivel_editar" required>
								</select>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button id="enviar_edit" type="submit" class="btn btn-success" form="formulario_editar">Guardar</button>
					<button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="ver" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Ver usuario</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-2">
							<h5>ID</h5>
							<p id="ver_id_usuario"></p>
						</div>
						<div class="col-10">
							<h5>Usuario</h5>
							<p id="ver_usuario"></p>
						</div>
						<div class="col-12">
							<h5>Correo electrónico</h5>
							<p id="ver_correo"></p>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<h5>Nombre(s)</h5>
							<p id="ver_nombre"></p>
						</div>
						<div class="col-6">
							<h5>Apellido paterno</h5>
							<p id="ver_apellido_paterno"></p>
						</div>
						<div class="col-6">
							<h5>Apellido materno</h5>
							<p id="ver_apellido_materno"></p>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<h5>Teléfono</h5>
							<p id="ver_telefono"></p>
						</div>
						<div class="col-6">
							<h5>Nivel</h5>
							<p id="ver_nivel"></p>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<h5>Fecha de registro</h5>
							<p id="ver_fecha_registro"></p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-danger">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('include/scripts');  ?>
	<script src="<?= base_url() ?>static/js/usuarios/usuarios.js"></script>
	<script>
		$('[data-toggle="tooltip"]').tooltip();
	</script>
</body>

</html>
