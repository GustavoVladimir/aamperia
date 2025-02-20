<!doctype html>
<html lang="en">
	<head>
		<!-- HEADER (links de CSS y título) -->
		<?php $this->load->view('include/header', $datos_pagina); ?>
	</head>
	<body>
		<div class="wrapper d-flex align-items-stretch">
			<!-- MENU LATERAL -->
			<?php $this->load->view('include/menu_lateral', $datos_pagina);  ?>
			<div id="content" class="main">
				<!-- BARRA SUPERIOR DE USUARIO -->
				<?php $this->load->view('include/barra_superior', $datos_pagina);  ?>
				
				<div id="contenido" class="container-fluid">
					<div class="row mt-4">
						<div class="col">
							<h2>Datos de cuenta</h2>
						</div>
					</div>
					<div class="form-row">
						<div class="col-sm-4 col-12 form-group">
							<label for="nombre">Nombre (s)</label>
							<input class="form-control" type="text" id="nombre" value="<?=$this->session->usuario['nombre']?>" disabled>
						</div>
						<div class="col-sm-4 col-6 form-group">
							<label for="apellido_paterno">Apellido paterno</label>
							<input class="form-control" type="text" id="apellido_paterno" value="<?=$this->session->usuario['apellido_paterno']?>" disabled>
						</div>
						<div class="col-sm-4 col-6 form-group">
							<label for="apellido_materno">Apellido materno</label>
							<input class="form-control" type="text" id="apellido_materno" value="<?=$this->session->usuario['apellido_materno']?>" disabled>
						</div>
					</div>
					<div class="form-row">
						<div class="col-sm-4 col-12 form-group">
							<label for="usuario">Usuario</label>
							<input class="form-control" type="text" id="usuario" value="<?=$this->session->usuario['usuario']?>" disabled>
						</div>
						<div class="col-sm-4 col-6 form-group">
							<label for="correo">Correo electrónico</label>
							<input class="form-control" type="text" id="correo" name="correo" value="<?=$this->session->usuario['correo']?>" disabled>
						</div>
						<div class="col-sm-4 col-6 form-group">
							<label for="telefono">Teléfono</label>
							<input class="form-control" type="text" id="telefono" value="<?=$this->session->usuario['telefono']?>" disabled>
						</div>
					</div>
					<div class="form-row">
						<div class="col-sm-6 col-12 form-group">
							<label for="nivel">Nivel</label>
							<input class="form-control" type="text" id="nivel" value="<?=$this->session->usuario['nivel']?>" disabled>
						</div>
						<div class="col-sm-6 col-12 form-group">
							<label for="fecha_registro">Fecha de registro</label>
							<input class="form-control" type="text" id="fecha_registro" value="<?=$this->session->usuario['fecha_registro']?>" disabled>
						</div>
					</div>
					<form id="cambiar_contra" method="post">
						<div class="form-row">
							<div class="col-sm-4 col-6 form-group">
								<label for="contrasenia" class="mr-2">Contraseña</label><span class="text-danger" id="aviso_contra"></span>
								<input class="form-control" type="password" id="contrasenia" name="contrasenia" value="***********" disabled required>
							</div>
							<div class="col-sm-4 col-6 form-group">
								<label for="contrasenia_confirmar" class="mr-2">Confirmar contraseña</label><span class="text-danger" id="aviso_contra2"></span>
								<input class="form-control" type="password" id="contrasenia_confirmar" name="contrasenia_confirmar" value="***********" disabled required>
							</div>
							<div class="col-sm-2 col-6 form-group align-self-end">
								<button class="btn btn-success btn-block" id="cambiar_contrasenia" type="button">Cambiar contraseña</button>
							</div>
							<div class="col-sm-2 col-6 form-group align-self-end">
								<button class="btn btn-danger btn-block" id="cancelar_cambio" type="button" disabled>Cancelar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- SCRIPTS DE JS -->
		<?php $this->load->view('include/scripts');  ?>
		<script src="<?= base_url() ?>static/js/cuenta/cuenta.js"></script>
	</body>
</html>