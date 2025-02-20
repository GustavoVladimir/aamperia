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
							<div class="col-sm-6">
								<h2>Gestión de estructuras</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 d-flex justify-content-center align-items-end">
								<button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#agregar">Agregar nueva estructura</button>
							</div>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col">
							<table id="tabla_crud" class="table-striped table-bordered tabla-responsiva">
								<thead>
									<tr>
										<th scope="col">Código</th>
										<th scope="col">Módulos</th>
										<th scope="col">Marca</th>
										<th scope="col">Tipo</th>
										<th scope="col">Celdas</th>
										<th scope="col">Ángulo</th>
										<th scope="col">Costo</th>
										<th scope="col">Moneda</th>
										<th scope="col">Acción</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
					<div class="mt-4">
						<div class="row">
							<div class="col-sm-6">
								<h2>Tipos de estructura</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 d-flex justify-content-center align-items-end">
								<button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#agregar_tipo">Agregar nuevo tipo</button>
							</div>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col">
							<table id="tabla_tipos" class="table-striped table-bordered tabla-responsiva">
								<thead>
									<tr>
										<th scope="col">Código</th>
										<th scope="col">Tipo</th>
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
						<form method="post" id="formulario_agregar">
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
									<input class="form-control" type="text" id="producto_nuevo" name="producto">
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-4 col-6 form-group">
									<label for="modulos_nuevo">Módulos</label>
									<input class="form-control" type="text" id="modulos_nuevo" name="modulos">
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="celdas_nuevo">Celdas</label>
									<input class="form-control" type="text" id="celdas_nuevo" name="celdas">
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="angulo_nuevo">Ángulo</label>
									<div class="input-group">
										<input class="form-control" type="text" id="angulo_nuevo" name="angulo">
										<div class="input-group-append">
											<span class="input-group-text">°</span>
										</div>
									</div>
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="tipo_nuevo">Tipo</label>
									<select class="form-control" id="tipo_nuevo" name="tipo_estructura" required>
										<option disabled selected>Selecciona un tipo...</option>
									</select>
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="costo_nuevo">Costo</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control" type="number" id="costo_nuevo" name="costo" value="0" step="0.01" required>
									</div>
								</div>
								<div class="col-sm-4 col-6 form-group">
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
						<button type="submit" class="btn btn-success form-control" form="formulario_agregar">Agregar</button>
						<button type="button" data-dismiss="modal" class="btn btn-danger form-control">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="modal fade" id="editar" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Editar estructura</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" id="formulario_editar">
							<div class="form-row">
								<div class="col-sm-2 col-2 form-group">
									<label for="id_estructura">ID</label>
									<input class="form-control" type="text" id="id_estructura" name="id_estructura" readonly>
								</div>
								<div class="col-sm-10 col-10 form-group">
									<label for="codigo">Código</label>
									<input class="form-control" type="text" id="codigo" name="codigo" required>
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-8 col-6 form-group">
									<label for="producto">Producto</label>
									<input class="form-control" type="text" id="producto" name="producto">
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="marca">Marca</label>
									<input class="form-control" type="text" id="marca" name="marca">
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-4 col-6 form-group">
									<label for="modulos">Módulos</label>
									<input class="form-control" type="text" id="modulos" name="modulos">
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="celdas">Celdas</label>
									<input class="form-control" type="text" id="celdas" name="celdas">
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="angulo">Ángulo</label>
									<div class="input-group">
										<input class="form-control" type="text" id="angulo" name="angulo">
										<div class="input-group-append">
											<span class="input-group-text">°</span>
										</div>
									</div>
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="tipo">Tipo</label>
									<select class="form-control" id="tipo" name="tipo_estructura">
										<option disabled selected>Selecciona un tipo...</option>
									</select>
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="costo">Costo</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control" type="number" id="costo" name="costo" value="0" step="0.01" required>
									</div>
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="moneda">Moneda</label>
									<select id="moneda" class="form-control"  name="moneda" required>
										<option value="USD">USD</option>
										<option value="MXN">MXN</option>
									</select>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success form-control" form="formulario_editar">Guardar</button>
						<button type="button" data-dismiss="modal" class="btn btn-danger form-control">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="ver" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Ver estructura</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-2">
								<h5>ID</h5>
								<p id="ver_id_estructura"></p>
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
								<h5>Tipo</h5>
								<p id="ver_tipo"></p>
							</div>
							<div class="col-4">
								<h5>Módulos</h5>
								<p id="ver_modulos"></p>
							</div>
							<div class="col-4">
								<h5>Celdas</h5>
								<p id="ver_celdas"celdas></p>
							</div>
							<div class="col-4">
								<h5>Ángulo</h5>
								<p id="ver_angulo"></p>
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
						<button type="button" data-dismiss="modal" class="btn btn-danger form-control">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="agregar_tipo" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Agregar tipo de estructura</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" id="formulario_agregar_tipo">
							<div class="form-row">
								<div class="col-6 form-group">
									<label for="tipo_codigo">Código</label>
									<input class="form-control" type="text" id="tipo_codigo" name="codigo" required>
								</div>
								<div class="col-6 form-group">
									<label for="tipo_tipo">Tipo</label>
									<input class="form-control" type="text" id="tipo_tipo" name="tipo">
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success form-control" form="formulario_agregar_tipo">Agregar</button>
						<button type="button" data-dismiss="modal" class="btn btn-danger form-control">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="editar_tipo" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Editar estructura</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" id="formulario_editar_tipo">
							<div class="form-row">
								<div class="col-2 form-group">
									<label for="tipo_id_tipo_estructura_editar">ID</label>
									<input class="form-control" type="text" id="tipo_id_tipo_estructura_editar" name="id_tipo_estructura" readonly>
								</div>
								<div class="col-5 form-group">
									<label for="tipo_codigo_editar">Código</label>
									<input class="form-control" type="text" id="tipo_codigo_editar" name="codigo" required>
								</div>
								<div class="col-5 form-group">
									<label for="tipo_tipo_editar">Tipo</label>
									<input class="form-control" type="text" id="tipo_tipo_editar" name="tipo">
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success form-control" form="formulario_editar_tipo">Guardar</button>
						<button type="button" data-dismiss="modal" class="btn btn-danger form-control">Cancelar</button>
					</div>
				</div>
			</div>
		</div>

		<?php $this->load->view('include/scripts');  ?>
		<script src="<?= base_url() ?>/static/js/estructuras/estructuras.js"></script>
	</body>
</html>