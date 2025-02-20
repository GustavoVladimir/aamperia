<!doctype html>
<html lang="en">
	<head>
		<?php $this->load->view('include/header', $datos_pagina); ?>
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
								<h2>Gestión de extras</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 d-flex justify-content-center align-items-end">
								<button class="btn btn-success btn-block" type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregar">Agregar nuevo extra</button>
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
										<th scope="col">Costo</th>
										<th scope="col">Moneda</th>
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
						<h5 class="modal-title">Agregar extra</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" id="formulario_agregar" name="formulario_agregar">
							<div class="form-row">
								<div class="col-12 form-group">
									<label for="codigo">Código</label>
									<input class="form-control" type="text" id="codigo" name="codigo" required>
								</div>
								<div class="col-12 form-group">
									<label for="producto">Producto</label>
									<input class="form-control" type="text" id="producto" name="producto" required>
								</div>
								<div class="col-6 form-group">
									<label for="marca">Marca</label>
									<input class="form-control" type="text" id="marca" name="marca" required>
								</div>
								<div class="col-6 form-group">
									<label for="costo">Costo</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control" type="number" id="costo" name="costo" step="0.01" value="0" required>
									</div>
								</div>
								<div class="col-6 form-group">
									<label for="moneda">Moneda</label>
									<select id="moneda" class="form-control" name="moneda" required>
										<option value="USD">USD</option>
										<option value="MXN">MXN</option>
									</select>
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
						<h5 class="modal-title">Modificar extra</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" id="formulario_editar">
							<div class="form-row">
								<div class="col-2 form-group">
									<label for="id_extra">ID</label>
									<input class="form-control" type="text" id="id_extra" name="id_extra" readonly>
								</div>
								<div class="col-10 form-group">
									<label for="modificar_codigo">Código</label>
									<input class="form-control" type="text" id="modificar_codigo" name="codigo" required>
								</div>
								<div class="col-12 form-group">
									<label for="modificar_producto">Producto</label>
									<input class="form-control" type="text" id="modificar_producto" name="producto" required>
								</div>
								<div class="col-6 form-group">
									<label for="modificar_marca">Marca</label>
									<input class="form-control" type="text" id="modificar_marca" name="marca" required>
								</div>
								<div class="col-6 form-group">
									<label for="modificar_costo">Costo</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control" type="number" id="modificar_costo" name="costo" step="0.01" required>
									</div>
								</div>
								<div class="col-6 form-group">
									<label for="modificar_moneda">Moneda</label>
									<select id="modificar_moneda" class="form-control" name="moneda" required>
										<option value="USD">USD</option>
										<option value="MXN">MXN</option>
									</select>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-success form-control" type="submit" form="formulario_editar">Guardar</button>
						<button class="btn btn-danger form-control" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
			<!-- MODAL MODIFICAR CENTRADO VERTICALMENTE -->
		<div class="modal fade" id="ver" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Ver extra</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-2">
								<h5>ID</h5>
								<p id="ver_id"></p>
							</div>
							<div class="col-10">
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
								<h5>Costo</h5>
								<p id="ver_costo"></p>
							</div>
							<div class="col-6">
								<h5>Moneda</h5>
								<p id="ver_moneda"></p>
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
					</div>
					<div class="modal-footer">
						<button class="btn btn-danger form-control" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- SCRIPTS DE JS -->
		<?php $this->load->view('include/scripts');  ?>
		<script src="<?= base_url() ?>static/js/extras/extras.js"></script>
	</body>
</html>