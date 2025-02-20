<!DOCTYPE HTML>
<html lang="en">
	<head>
		<?php $this->load->view('include/header', $datos_pagina); ?>
		<style>
			/*th, td { white-space: nowrap; }*/
		</style>
	</head>
	<body>
		<div id="overlay" class="">
			<div id="spinner"></div>
		</div>
		<div class="wrapper d-flex align-items-stretch">
			<?php $this->load->view('include/menu_lateral', $datos_pagina);  ?>
			<div id="content" class="main">
				<?php $this->load->view('include/barra_superior', $datos_pagina);  ?>
				
				<div id="contenido" class="container-fluid">
					<div class="botones_crud mt-4">
						<div class="row">
							<div class="col">
								<h2>Cotizaciones realizadas</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 d-flex justify-content-center align-items-end">
								<a href="<?= base_url() ?>cotizacion" class="btn btn-success btn-block" type="button" class="btn btn-primary">Nueva cotización</a>
							</div>
							<div class="col-sm-4">
								<label for="asesor_cotizacion">Asesor de la cotización</label>
								<select class="custom-select" id="asesor_cotizacion">
									<option value="Todos" selected>Todos</option>
								</select>
							</div>
							<div class="col-sm-4">
								<label for="estado_cotizacion">Estado de la cotización</label>
								<select class="custom-select" id="estado_cotizacion">
									<option value="Todos" selected>Todos</option>
									<option value="Pendiente">Pendiente</option>
									<option value="Aceptado">Aceptado</option>
									<option value="Rechazado">Rechazado</option>
									<option value="Cancelado">Cancelado</option>
									<option value="Vencido">Vencido</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col">
								<table id="tabla_crud" class="table-striped table-bordered tabla-responsiva" style="width:100%">
									<thead>
										<tr>
											<th scope="col">Nombre</th>
											<th scope="col">Teléfono</th>
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
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="editar" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Modificar estado de cotizacion</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" id="formulario_modificar">
							<div class="form-row">
								<div class="col-sm-2 col-2 form-group">
									<label for="id_cotizacion">ID</label>
									<input class="form-control" type="text" id="id_cotizacion" name="id_cotizacion" readonly>
								</div>
								<div class="col-sm-10 col-10 form-group">
									<label for="nombre">Nombre del cliente</label>
									<input class="form-control" type="text" id="nombre" name="nombre" disabled>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="telefono">Teléfono</label>
									<input class="form-control" type="text" id="telefono" name="telefono" disabled>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="tipo">Tipo de sistema</label>
									<input class="form-control" type="text" id="tipo" name="tipo" disabled>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="precio">Precio</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control" type="text" id="precio" name="precio" disabled>
									</div>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="paneles">Paneles</label>
									<input class="form-control" type="text" id="paneles" name="paneles" disabled>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="fecha">Fecha</label>
									<input class="form-control" type="text" id="fecha" name="fecha" disabled>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="vigencia">Vigencia</label>
									<input class="form-control" type="text" id="vigencia" name="vigencia" disabled>
								</div>
								<div class="col-sm-12 form-group">
									<label for="asesor">Asesor</label>
									<input class="form-control" type="text" id="asesor" name="asesor" disabled>
								</div>
								<div class="col-sm-12 col-12 form-group">
									<label for="estado">Estado de la cotización</label>
									<select class="custom-select" id="estado" name="estado">
										<option value="Pendiente">Pendiente</option>
										<option value="Aceptado">Aceptado</option>
										<option value="Rechazado">Rechazado</option>
										<option value="Cancelado">Cancelado</option>
										<option value="Vencido">Vencido</option>
									</select>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-success form-control" type="submit" form="formulario_modificar">Guardar</button>
						<button id="boton_modificar" class="btn btn-primary form-control">Modificar</button>
						<button class="btn btn-danger form-control" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		
		<!-- SCRIPTS DE JS -->
		<?php $this->load->view('include/scripts');  ?>
		<script src="<?= base_url() ?>static/js/historial_cotizaciones/historial_cotizaciones.js"></script>
	</body>
</html>