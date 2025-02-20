<!DOCTYPE html>
<html lang="es">

<head>
	<!-- HEADER (links de CSS y título) -->
	<?php $this->load->view('include/header', $datos_pagina); ?>
</head>


<body>
	<script>
		let id_cliente = <?= $id_cliente ?>;
	</script>
	<div class="container my-4">
		<!-- Barra superior -->
		<?php $this->load->view('include/barra_superior', $datos_pagina); ?>
		<br>

		<!-- Breadcrumb de Bootstrap 4 -->
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Inicio</a></li>
				<li class="breadcrumb-item"><a href="<?= base_url() ?>clientes">Clientes</a></li>
				<li class="breadcrumb-item active" aria-current="page">Detalle del Cliente</li>
			</ol>
		</nav>
		<h1 class="mb-4">Detalle del Cliente</h1>

		<!-- SECCIÓN: Detalle del cliente -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

		<div class="card mb-4">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0">Información del Cliente</h5>
			</div>
			<div class="card-body">
				<div class="row mb-2">
					<div class="col-md-6">
						<strong>Nombre cliente:</strong> <span id="nombreCliente"></span>
					</div>
					<div class="col-md-6">
						<strong>Email:</strong> <span id="emailCliente"></span>
					</div>

				</div>
				<div class="row mb-2">
					<div class="col-md-6">
						<strong>Teléfono:</strong> <span id="telefonoCliente"></span>
					</div>
					<div class="col-md-6">
						<strong>Dirección:</strong> <span id="direccionCliente"></span>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-md-6">
						<strong>Número de servicio:</strong> <span id="numServ"></span>
					</div>
					<div class="col-md-6">
						<strong>Fecha de Registro:</strong> <span id="fechaRegistro"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<strong>Nombre asesor:</strong> <span id="nombreAsesor"></span>
					</div>
				</div>
			</div>
		</div>


		<!-- SECCIÓN: Recibos de Luz -->
		<section class="mb-4">
			<h2>Recibos de Luz</h2>
			<!-- Botón para agregar un nuevo recibo -->
			<button class="btn btn-success" id="agregarReciboBtn">Agregar Recibo</button>
			<div id="recibosContainer" class="d-flex flex-wrap gap-3 mt-3">
				<!-- Aquí se cargarán los recibos como PDF o imágenes -->
			</div>
		</section>

		<!-- SECCIÓN: Cotizaciones Relacionadas -->
		<!-- INICIO IF DE PERMISOS -->
		<?php if ($_SESSION['usuario']['nivel'] !== "Tercero"): ?>
			<section>
				<h2>Cotizaciones</h2>
				<div class="col">
					<table id="tabla_crud" class="table-striped table-bordered tabla-responsiva" style="width:100%">
						<thead>
							<tr>
								<th scope="col">Tipo</th>
								<th scope="col">Precio</th>
								<th scope="col">Paneles</th>
								<th scope="col">Fecha</th>
								<th scope="col">Asesor</th>
								<th scope="col">Vigencia</th>
								<th scope="col">Estado</th>
								<th scope="col">Acción</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</section>
		<?php endif; ?>
		<!-- FIN IF DE PERMISOS -->

		<!-- SECCIÓN: Comentarios -->
		<section class="mt-4">
			<h2>Comentarios</h2>
			<div id="comentariosContainer" class="mb-4">
				<!-- Comentarios cargados dinámicamente -->
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Agregar Comentario</h5>
					<form method="post" id="agregar_comentario">
						<div class="form-group">
							<textarea id="comentarioInput" name="texto" class="form-control" rows="3" placeholder="Escribe tu comentario..."></textarea>
						</div>
						<div class="text-right mt-2">
							<button type="submit" class="btn btn-primary">Agregar Comentario</button>
						</div>
					</form>
				</div>
			</div>
	</div>
	</section>
	</div>

	<!-- Modal para agregar un recibo -->
	<div class="modal fade" id="modalRecibo" tabindex="-1" role="dialog" aria-labelledby="modalReciboLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalReciboLabel">Subir Nuevo Recibo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- Formulario para agregar un recibo -->
					<form id="reciboForm" enctype="multipart/form-data" method="post">
						<div class="form-group">
							<label for="reciboTipo">Tipo de Recibo</label>
							<select id="reciboTipo" name="reciboTipo" class="form-control">
								<option value="pdf">PDF</option>
								<option value="imagen">Imagen</option>
							</select>
						</div>

						<div class="form-group mt-2">
							<label for="reciboArchivo">Archivo</label>
							<input type="file" id="reciboArchivo" name="reciboArchivo" class="form-control" required>
						</div>

						<!-- Contenedor para previsualización -->
						<div id="previsualizacionRecibo" class="mt-3">
							<!-- Aquí se mostrará la previsualización -->
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					<button type="submit" form="reciboForm" class="btn btn-primary">Subir Recibo</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<?php $this->load->view('include/scripts'); ?>
	<script src="<?= base_url() ?>static/js/historial_cotizaciones/historial_cotizaciones.js"></script>
	<script src="<?= base_url() ?>static/js/cliente/detalle.js"></script>
</body>

</html>
