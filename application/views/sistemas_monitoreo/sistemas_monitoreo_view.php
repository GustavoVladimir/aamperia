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
							<div class="col-sm-6">
								<h2>Gestión de sistemas de monitoreo</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 d-flex justify-content-center align-items-end">
								<button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#agregar">Agregar nuevo sistema de monitoreo</button>
							</div>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col">
							<table id="tabla-crud" class="table-striped table-bordered tabla-responsiva">
								<thead>
									<tr>
										<th scope="col">Código</th>
										<th scope="col">Marca</th>
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
						<h5 class="modal-title">Agregar estructura</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" id="formulario-agregar">
							<div class="form-row">
								<div class="col-sm-8 col-7 form-group">
									<label for="codigo_nuevo">Código</label>
									<input class="form-control" type="text" id="codigo_nuevo" name="codigo" required>
								</div>
								<div class="col-sm-4 col-5 form-group">
									<label for="marca_nuevo">Marca</label>
									<input class="form-control" type="text" id="marca_nuevo" name="marca" required>
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-12 col-12 form-group">
									<label for="producto_nuevo">Producto</label>
									<input class="form-control" type="text" id="producto_nuevo" name="producto" required>
								</div>
							</div>
							<div class="form-row">
								<div class="col-6 form-group">
									<label for="costo_nuevo">Costo</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control" type="number" id="costo_nuevo" name="costo" value="0" step="0.01" required>
									</div>
								</div>
								<div class="col-6 form-group">
									<label for="moneda_nuevo">Moneda</label>
									<select id="moneda_nuevo" class="form-control" name="moneda" required>
										<option value="USD">USD</option>
										<option value="MXN">MXN</option>
									</select>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success" form="formulario-agregar">Agregar</button>
						<button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="modal fade" id="editar" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Editar sistema de monitoreo</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" id="formulario-editar">
							<div class="form-row">
								<div class="col-sm-2 col-2 form-group">
									<label for="id_sistema_monitoreo">ID</label>
									<input class="form-control" type="text" id="id_sistema_monitoreo" name="id_sistema_monitoreo" readonly>
								</div>
								<div class="col-sm-10 col-10 form-group">
									<label for="codigo">Código</label>
									<input class="form-control" type="text" id="codigo" name="codigo" required>
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-8 col-7 form-group">
									<label for="producto">Producto</label>
									<input class="form-control" type="text" id="producto" name="producto" required>
								</div>
								<div class="col-sm-4 col-5 form-group">
									<label for="marca">Marca</label>
									<input class="form-control" type="text" id="marca" name="marca" required>
								</div>
							</div>
							<div class="form-row">
								<div class="col-6 form-group">
									<label for="costo">Costo</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control" type="number" id="costo" name="costo" value="0" step="0.01" required>
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
						<button type="submit" class="btn btn-success" form="formulario-editar">Guardar</button>
						<button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="ver" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Ver sistema de monitoreo</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-2">
								<h5>ID</h5>
								<p id="ver_id_sistema"></p>
							</div>
							<div class="col-6">
								<h5>Código</h5>
								<p id="ver_codigo"></p>
							</div>
							<div class="col-4">
								<h5>Marca</h5>
								<p id="ver_marca"></p>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<h5>Producto</h5>
								<p id="ver_producto"></p>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<h5>Costo</h5>
								<p id="ver_costo"></p>
							</div>
							<div class="col-6">
								<h5>Moneda</h5>
								<p id="ver_moneda"></p>
							</div>
						</div>
						<div class="row">
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
						<button type="button" data-dismiss="modal" class="btn btn-danger">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		
		<!-- SCRIPTS DE JS -->
		<?php $this->load->view('include/scripts');  ?>
		<script src="<?= base_url() ?>/static/js/sistemas_monitoreo/sistemas_monitoreo.js"></script>
	</body>
</html>