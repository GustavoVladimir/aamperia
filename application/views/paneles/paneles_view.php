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
					<div class="botones_crud mt-4">
						<div class="row">
							<div class="col">
								<h2>Gestión de paneles</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 d-flex justify-content-center align-items-end">
								<button class="btn btn-success btn-block" type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregar">Agregar nuevo panel</button>
							</div>
							<div class="col-sm-6">
								<label for="marca_panel">Mostrar marca</label>
								<select class="form-control" id="marca_panel">
									<option selected disabled>Seleccione una opción</option>
									<option value="">Todas las marcas</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col">
							<table id="tabla_crud" class="table-striped table-bordered tabla-responsiva">
								<thead>
									<tr>
										<th scope="col">Marca</th>
										<th scope="col">Código</th>
										<th scope="col">Producto</th>
										<th scope="col">Watts por panel</th>
										<th scope="col">USD/WATT</th>
										<th scope="col">USD/PANEL</th>
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
				
		<div class="modal fade" id="agregar" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Agregar panel</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" id="formulario_agregar" name="formulario_agregar">
							<div class="form-row">
								<div class="col-sm-12 col-12 form-group">
									<label for="codigo_panel">Código del panel</label>
									<input class="form-control" type="text" id="codigo_panel" name="codigo_panel" required>
								</div>
								<div class="col-sm-12 col-12 form-group">
									<label for="producto_panel">Producto</label>
									<input class="form-control" type="text" id="producto_panel" name="producto_panel" required>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="marca_panel">Marca del panel</label>
									<input class="form-control" type="text" id="marca_panel" name="marca_panel" required>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="watts_panel">Watts</label>
									<div class="input-group">
										<input class="form-control" type="number" id="watts_panel" name="watts_panel" required>
										<div class="input-group-append">
											<span class="input-group-text">W</span>
										</div>
									</div>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="usd_watt">Costo (USD/watt)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control" type="number" id="usd_watt" name="usd_watt" step="0.001" required>
									</div>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="usd_panel">Costo (USD/panel)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control" type="number" id="usd_panel" name="usd_panel" step="0.01" required>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-success form-control" type="submit" form="formulario_agregar">Guardar</button>
						<button class="btn btn-danger form-control" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="editar" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Modificar panel</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" id="formulario_modificar">
							<div class="form-row">
								<div class="col-sm-2 col-2 form-group">
									<label for="id_panel">ID</label>
									<input class="form-control" type="text" id="id_panel" name="id_panel" readonly>
								</div>
								<div class="col-sm-10 col-10 form-group">
									<label for="modificar_codigo">Código del panel</label>
									<input class="form-control" type="text" id="modificar_codigo" name="modificar_codigo" required>
								</div>
								<div class="col-sm-12 form-group">
									<label for="modificar_producto">Producto</label>
									<input class="form-control" type="text" id="modificar_producto" name="modificar_producto" required>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="modificar_marca">Marca del panel</label>
									<input class="form-control" type="text" id="modificar_marca" name="modificar_marca" required>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="modificar_watts_panel">Watts</label>
									<div class="input-group">
										<input class="form-control" type="number" id="modificar_watts_panel" name="modificar_watts_panel" required>
										<div class="input-group-append">
											<span class="input-group-text">W</span>
										</div>
									</div>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="modificar_usd_watt">Costo (USD/watt)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control" type="number" id="modificar_usd_watt" name="modificar_usd_watt" step="0.001" required>
									</div>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="modificar_usd_panel">Costo (USD/panel)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control" type="number" id="modificar_usd_panel" name="modificar_usd_panel" step="0.01" required>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-success form-control" type="submit" form="formulario_modificar">Guardar</button>
						<button class="btn btn-danger form-control" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
			
		<div class="modal fade" id="ver" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Ver panel</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" id="formulario">
							<div class="row mt-2">
								<div class="col-3">
									<h5>ID</h5>
									<p id="ver_id"></p>
								</div>
								<div class="col-9">
									<h5>Código</h5>
									<p id="ver_codigo"></p>
								</div>
								<div class="col-12">
									<h5>Producto</h5>
									<p id="ver_producto"></p>
								</div>
								<div class="col-6">
									<h5>Marca</h5>
									<p id="ver_marca"></p>
								</div>
								<div class="col-6">
									<h5>Watts</h5>
									<p id="ver_watts_panel"></p>
								</div>
								<div class="col-6">
									<h5>Costo (USD/watt)</h5>
									<p id="ver_usd_watt"></p>
								</div>
								<div class="col-6">
									<h5>Costo (USD/panel)</h5>
									<p id="ver_usd_panel"></p>
								</div>
								<div class="col-6">
									<h5>Fecha de agregación</h5>
									<p id="ver_fecha_agregacion"></p>
								</div>
								<div class="col-6">
									<h5>Fecha de actualización</h5>
									<p id="ver_fecha_actualizacion"></p>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<div class="col-6">
							<button class="btn btn-danger form-control" data-dismiss="modal">Cancelar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- SCRIPTS DE JS -->
		<?php $this->load->view('include/scripts');  ?>
		<script src="<?= base_url() ?>static/js/paneles/paneles.js"></script>
	</body>
</html>