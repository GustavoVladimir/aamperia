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
						<h2>Gestión de clientes</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 d-flex justify-content-center align-items-end">
						<button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#agregar">Agregar nuevo cliente</button>
					</div>
				</div>
				<!-- Tabla -->
				<div class="row mt-4">
					<div class="col">
						<table id="tabla_crud" class="table-striped table-bordered tabla-responsiva">
							<thead>
								<tr>
									<th scope="col">ID</th>
									<th scope="col">Nombre</th>
									<th scope="col">Ubicación</th>
									<th scope="col">Correo</th>
									<th scope="col">Teléfono</th>
									<th scope="col">Número servicio</th>
									<th scope="col">Status</th>
									<th scope="col">Asesor</th>
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

	<!-- Modal -->
	<div class="modal fade" id="agregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="formulario_agregar">
						<div class="form-group">
							<label for="nombre">Nombre</label>
							<input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre">
						</div>
						<div class="form-group">
							<label for="ubicacion">Ubicación</label>
							<input type="text" class="form-control" name="ubicacion" placeholder="Ingrese la ubicación">
						</div>
						<div class="form-group">
							<label for="correo">Correo</label>
							<input type="email" class="form-control" name="correo" placeholder="Ingrese el correo">
						</div>
						<div class="form-group">
							<label for="numero_servicio">Número de Servicio</label>
							<input type="text" class="form-control" name="numero_servicio" placeholder="Ingrese el número de servicio">
						</div>
						<div class="form-group">
							<label for="telefono">Teléfono</label>
							<input type="text" class="form-control" name="telefono" placeholder="Ingrese el teléfono">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary" form="formulario_agregar">Guardar cambios</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal for Editing Client -->
	<div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- Edit Client Form -->
					<form id="formulario_editar">
						<input type="hidden" id="id_cliente" name="id_cliente">

						<div class="form-group">
							<label for="nombre">Nombre</label>
							<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre" required>
						</div>

						<div class="form-group">
							<label for="ubicacion">Ubicación</label>
							<input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ingrese la ubicación" required>
						</div>

						<div class="form-group">
							<label for="correo">Correo</label>
							<input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese el correo" required>
						</div>

						<div class="form-group">
							<label for="numero_servicio">Número de Servicio</label>
							<input type="text" class="form-control" id="numero_servicio" name="numero_servicio" placeholder="Ingrese el número de servicio" required>
						</div>

						<div class="form-group">
							<label for="telefono">Teléfono</label>
							<input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese el teléfono" required>
						</div>
						<div class="form-group">
							<label for="status">Status</label>
							<select name="status" id="status" class="form-control">
								<option value="En Proceso">En Proceso</option>
								<option value="Vendido">Vendido</option>
								<option value="Cobrado">Cobrado</option>
								<option value="Listo para pago">Listo para pago</option>
							</select>
						</div>

					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary" form="formulario_editar">Guardar cambios</button>
				</div>
			</div>
		</div>
	</div>




	<!-- SCRIPTS DE JS -->
	<?php $this->load->view('include/scripts');  ?>
	<script src="<?= base_url() ?>static/js/cliente/cliente.js"></script>
	<script>

	</script>


</body>

</html>
