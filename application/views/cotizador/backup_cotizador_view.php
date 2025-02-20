<!doctype html>
<html lang="en">
	<head>
		<?php $this->load->view('include/header', $datos_pagina); ?>
		<script src="<?= base_url() ?>/static/js/cotizador/cotizador.js"></script>
	</head>
	<body>
		<div class="wrapper d-flex align-items-stretch">
			<?php $this->load->view('include/menu_lateral', $datos_pagina);  ?>
			<div id="content" class="main">
				<?php $this->load->view('include/barra_superior', $datos_pagina);  ?>

				<div id="contenido" class="container-fluid mb-4">
					<div class="row mt-4 mb-2">
						<div class="col">
							<h2>Cotizador</h2>
						</div>
					</div>
					
					<nav>
						<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
							<a class="nav-item nav-link active" id="nav_vista_cliente" data-toggle="tab" href="#vista_cliente" role="tab" aria-controls="vista_cliente" aria-selected="true">Vista cliente</a>
							<a class="nav-item nav-link" id="nav_vista_admin" data-toggle="tab" href="#vista_admin" role="tab" aria-controls="vista_admin" aria-selected="false">Vista administrador</a>
						</div>
					</nav>

					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active" id="vista_cliente" role="tabpanel" aria-labelledby="nav_vista_cliente">
							<div class="row mt-2">
								<div class="col-sm-3">
									<label for="tipoProveedor">Asesor</label>
									<select class="form-control" id="tipoProveedor">
										<option>Ing. Sergio Araiza</option>
										<option>Ing. María de la Cruz Mejía</option>
										<option>Ing. Santiago Quijano</option>
									</select>
								</div>
								<div class="col-sm-3">
									<label for="nombre_usuario">Nombre del usuario</label>
									<input class="form-control" type="text" id="nombre_usuario">
								</div>
								<div class="col-sm-3">
									<label for="ubicacion">Ubicación</label>
									<input class="form-control" type="text" id="ubicacion">
								</div>
								<div class="col-sm-3">
									<label for="num_servicio">Número de servicio</label>
									<input class="form-control" type="text" id="num_servicio">
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-sm-2">
									<label for="calcular_con">Calcular con</label>
									<select class="form-control" id="calcular_con">
										<option>Consumo</option>
										<option>Precio</option>
									</select>
								</div>
								<div class="col-sm-2">
									<label for="tarifa">Tarifa</label>
									<select class="form-control" id="tarifa">
										<option>Tarifa 01</option>
										<option>Tarifa DAC</option>
										<option>PDBY</option>
									</select>
								</div>
								<div class="col-sm-2">
									<label for="periodo">Periodo</label>
									<select class="form-control" id="periodo">
										<option>Mensual</option>
										<option selected>Bimestral</option>
									</select>
								</div>
								<div class="col-sm-3">
									<label for="promedio_bimestral">Promedio bimestral</label>
									<div class="input-group">
										<input id="promedio_bimestral" type="text" class="form-control" aria-label="Introducir promedio bimestral">
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<label for="consumo_promedio">Consumo promedio bimestral</label>
									<div class="input-group">
										<input id="consumo_promedio" type="text" class="form-control" aria-label="Consumo promedio bimestral" disabled>
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row mt-4">
								<div class="col">
									<h3>Datos del sistema</h3>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-sm-6">
									<label for="tipo_panel">Tipo de panel</label>
									<select class="form-control" id="tipo_panel">
										<option>Modulo Seraphim 385 W  (Precio por watt)</option>
										<option>Módulo Seraphim bifacial sin marco 400W  DECORATIVO (Precio por watt)</option>
										<option>Módulo Refacsol 50W</option>
										<option>Módulo Refacsol 100W</option>
										<option>Módulo Refacsol 150W</option>
									</select>
								</div>
								<div class="col-sm-6">
									<label for="tipo_conexion">Tipo de interconexión</label>
									<select class="form-control" id="tipo_conexion">
										<option>Inversor central (austero)</option>
										<option>Inversor central con optimizadores</option>
										<option>Microinversores</option>
									</select>
								</div>
							</div>	
							<div class="row mt-2">
								<div class="col-sm-3">
									<label for="num_paneles">Número de paneles</label>
									<input class="form-control" type="text" id="num_paneles" disabled>
								</div>
								<div class="col-sm-3">
									<label for="potencia_total">Potencia total</label>
									<div class="input-group">
										<input id="potencia_total" type="text" class="form-control" disabled>
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<label for="produccion_bimestral">Producción bimestral</label>
									<div class="input-group">
										<input id="produccion_bimestral" type="text" class="form-control" disabled>
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<label for="produccion_anual">Producción anual</label>
									<div class="input-group">
										<input id="produccion_anual" type="text" class="form-control" disabled>
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-sm-5">
									<label for="modelo_inversor">Modelo del inversor</label>
									<select class="form-control" id="modelo_inversor">
										<option>ABB TRIO-27.6-TL-OUTD-S1A-US-480-A</option>
										<option>Fronius Primo 5.0-1 208/240</option>
										<option>Inversor Goodwe 2.0 kW GW2000-NS-Bifásico (1 MPPT)</option>
									</select>
								</div>
								<div class="col-sm-5">
									<label for="sistema_monitoreo">Sistema de monitoreo</label>
									<select class="form-control" id="sistema_monitoreo">
										<option>Sistema de Monitoreo Envoy IQ ENV-IQ-AM1-240 M</option>
										<option>Sistema de Monitoreo Envoy IQ ENV–IQ–AMP3-3P</option>
									</select>
								</div>
								<div class="col-sm-2">
									<label for="optimizadores">Optimizadores</label>
									<select class="form-control" id="optimizadores">
										<option>OPTI p 400</option>
									</select>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col">
									<h3>Estructura</h3>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-sm-3">
									<label for="cantidad_estructura">Cantidad</label>
									<input class="form-control" type="number" id="cantidad_estructura" name="cantidad_estructura" min="1" max="20">
								</div>
								<div class="col-sm-7">
									<label for="tipo_estructura">Tipo de estructura</label>
									<select class="form-control" id="tipo_estructura">
										<option>ESTRUCTURA SENCILLA  72 CELDAS</option>
										<option>ESTRUCTURA SENCILLA 60 CELDAS</option>
										<option>ESTRUCTURA COPLANAR 72 CELDAS</option>
									</select>
								</div>
								<div class="col-sm-2">
									<label for="uvie">UVIE</label>
									<select class="form-control" id="uvie">
										<option>SÍ</option>
										<option>NO</option>
									</select>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col text-center">
									<div class="row">
										<div class="col-2">
											
										</div>
										<div class="col">
											Sencilla
										</div>
										<div class="col">
											Doble
										</div>
										<div class="col">
											Coplanar
										</div>
									</div>
									<div class="row">
										<div class="col-2">
											<h4># módulos</h4>
										</div>
										<div class="col">
											<select class="form-control" id="estructura_sencilla">
												<option>Estructura riel P6-P6. 11 módulos</option>
												<option>Estructura riel P6-P6. 12 módulos</option>
												<option>Estructura riel P6-P6. 13 módulos</option>
											</select>
										</div>
										<div class="col">
											<select class="form-control" id="estructura_doble">
												<option>Estructura riel P6-P6. 24 módulos</option>
												<option>Estructura riel P6-P6. 26 módulos</option>
												<option>Estructura riel P6-P6. 28 módulos</option>
											</select>
										</div>
										<div class="col">
											<select class="form-control" id="estructura_coplanar">
												<option>Estructura riel P6. 6 módulos</option>
												<option>Estructura riel P6. 7 módulos</option>
												<option>Estructura riel P6. 8 módulos</option>
											</select>
										</div>
									</div>
									<div class="row mt-1">
										<div class="col-2">
											12
										</div>
										<div class="col">
											<select class="form-control" id="estructura_sencilla2">
												<option>Estructura riel P6-P4. 5 módulos</option>
												<option>Estructura riel P6-P4. 6 módulos</option>
												<option>Estructura riel P6-P4. 7 módulos</option>
											</select>
										</div>
										<div class="col">
											<select class="form-control" id="estructura_doble2">
												<option>Estructura riel P6-P8. 2 módulos</option>
												<option>Estructura riel P6-P8. 3 módulos</option>
												<option>Estructura riel P6-P6. 4 módulos</option>
											</select>
										</div>
										<div class="col">
										</div>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-sm-4">
									<label for="metros_totales">Metros totales tubería y cableado</label>
									<select class="form-control" id="metros_totales">
										<option>25</option>
										<option>30</option>
										<option>35</option>
									</select>
								</div>
								<div class="col-sm-2">
									<label for="costo_metros">Costo</label>
									<input type="text" class="form-control" id="costo_metros" disabled>
								</div>
								<div class="col-sm-6">
									<label for="instaladores">Instaladores</label>
									<select class="form-control" id="instaladores">
										<option>Trini DreamTeam</option>
										<option>Uri Team </option>
										<option>Mane Team</option>
									</select>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="vista_admin" role="tabpanel" aria-labelledby="nav_vista_admin">
							<h3>Vista admin</h3>
						</div>
					</div>
					
					<div class="row mt-4">
						<div class="col-6">
							<button class="btn btn-success form-control">Guardar</button>
						</div>
						<div class="col-6">
							<button class="btn btn-danger form-control">Cancelar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('include/scripts');  ?>
	</body>
</html>