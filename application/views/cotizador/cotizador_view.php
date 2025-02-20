<!doctype html>
<html lang="en">

<head>
	<?php $this->load->view('include/header', $datos_pagina); ?>
	<script>
		var id_usuario = "<?= $this->session->usuario['id_usuario'] ?>";
		var id_cotizacion_temporal = "<?= $this->session->usuario['id_cotizacion_temporal'] ?>";
	</script>
</head>
<style>
	a.text-decoration-underline {
		text-decoration: underline;
	}
</style>

<!-- Cargar jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Cargar Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">





<body>
	<div id="overlay" class="">
		<div id="spinner"></div>
	</div>
	<div class="wrapper d-flex align-items-stretch">
		<?php $this->load->view('include/menu_lateral', $datos_pagina); ?>
		<div id="content" class="main">
			<?php $this->load->view('include/barra_superior', $datos_pagina); ?>

			<div id="contenido" class="container-fluid mb-4">
				<div class="row mt-4 mb-2">
					<div class="col-12">
						<h2>Cotizador</h2>
					</div>
				</div>
				<div class="row mt-2 mb-2">
					<div class="col-12">
						<div class="alert fade show mb-0 alert-success d-none" role="alert"
							id="alerta_cotizacion_nueva">
							<strong>Iniciaste una cotización nueva.</strong> Ésta se guardará cada vez que hagas un
							cambio.
						</div>
						<div class="alert fade show mb-0 alert-info d-none" role="alert"
							id="alerta_cotizacion_guardada">
							<strong>Estás editando una cotización autoguardada en <span
									id="fecha_cotizacion_guardada"></span>: </strong><a
								href="<?= base_url() ?>cotizacion/reiniciar_cotizacion_temporal">¿Deseas empezar una
								cotización nueva?</a>
						</div>
					</div>
				</div>
				<nav>
					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" id="nav_vista_cliente" data-toggle="tab"
							href="#vista_cliente" role="tab" aria-controls="vista_cliente" aria-selected="true">Vista
							cliente</a>
						<a class="nav-item nav-link" id="nav_vista_admin" data-toggle="tab" href="#vista_admin"
							role="tab" aria-controls="vista_admin" aria-selected="false">Vista administrador</a>
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="vista_cliente" role="tabpanel"
						aria-labelledby="nav_vista_cliente">
						<!-- Inicio alerta -->
						<div class="form-row mt-2">
							<div class="col-sm-12 col-12 form-group">
								<div class="alert alert-warning alert-dismissible fade show" role="alert">
									<strong>Atención:</strong> ¿Es un cliente nuevo o un cliente existente? <a href="javascript:void(0)" onclick="nuevo_cliente()" class="text-decoration-underline">Nuevo Cliente</a> o <a href="javascript:void(0)" onclick="cliente_existente()" class="text-decoration-underline">Cliente Existente</a>
								</div>
							</div>
						</div>
						<!-- Fin alerta -->
						<!-- Select de nuevo cliente -->
						<input type="text" id="tipo_cliente" class="d-none">
						<div class="form-row mt-2 d-none" id="cliente_existente">
							<div class="col-12">
								<label for="clienteExistente">Seleccionar Cliente</label>
								<select class="form-control select2" id="clienteExistente" name="id_cliente">
									<option value="" selected disabled>Selecciona un cliente</option>
									<option value="1">Cliente 1</option>
									<option value="2">Cliente 2</option>
									<option value="3">Cliente 3</option>
								</select>
							</div>
						</div>
						<!-- Fin de select nuevo cliente -->
						<!-- Formulario de cliente -->
						<div class="form-row mt-2 d-none" id="nuevo_cliente">
							<div class="col-12">
								<h5>Datos de cliente</h5>
							</div>
							<div class="col-sm-4 col-12 form-group">
								<label for="nombre_usuario">Nombre del cliente</label>
								<span class="ml-1 badge badge-success" style="display: none">Guardado</span>
								<input class="form-control" type="text" id="nombre_usuario" name="nombre_usuario"
									autocomplete="on">
							</div>
							<div class="col-sm-4 col-12 form-group">
								<label for="ubicacion">Ubicación</label>
								<span class="ml-1 badge badge-success" style="display: none">Guardado</span>
								<input class="form-control" type="text" id="ubicacion" name="ubicacion">
							</div>
							<div class="col-sm-4 col-12 form-group">
								<label for="telefono">Teléfono</label>
								<span class="ml-1 badge badge-success" style="display: none">Guardado</span>
								<span class="ml-1 badge badge-success" style="display: none">Guardado</span>
								<input class="form-control" type="tel" id="telefono" name="telefono">
							</div>

							<div class="col-sm-6 col-12 form-group">
								<label for="correo">Correo</label>
								<span class="ml-1 badge badge-success" style="display: none">Guardado</span>
								<input class="form-control" type="email" id="correo" name="correo">
							</div>
							<div class="col-sm-6 col-12 form-group">
								<label for="num_servicio">Número de servicio</label>
								<span class="ml-1 badge badge-success" style="display: none">Guardado</span>
								<input class="form-control" type="text" id="num_servicio" name="num_servicio">

							</div>
							<div class="col-12">
								<hr>
							</div>
						</div>
						<!-- Fin datos de cliente -->

						<div class="form-row mt-2">

							<div class="col-sm-2 col-3 form-group">
								<label for="folio_cotizacion">Folio</label>
								<input class="form-control" type="text" id="folio_cotizacion" name="folio_cotizacion"
									value="<?= $this->session->usuario['id_cotizacion_temporal'] ?>" disabled>
							</div>
							<div class="col-sm-5 col-9 form-group">
								<label for="asesor">Asesor</label>
								<input class="form-control" type="text" id="asesor" name="asesor"
									value="<?= $this->session->usuario['nombre'] . ' ' . $this->session->usuario['apellido_paterno'] . ' ' . $this->session->usuario['apellido_materno'] ?>"
									disabled>
							</div>
							<div class="col-sm-5 col-12 form-group">
								<label for="fecha">Fecha de cotización</label>
								<span class="ml-1 badge badge-success" style="display: none">Guardado</span>
								<input class="form-control" type="date" id="fecha" name="fecha">
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-3 col-12 form-group">
								<label for="forma_calculo">Calcular con</label>
								<select class="custom-select" id="forma_calculo" name="forma_calculo">
									<option disabled selected>Selecciona una forma de cálculo...</option>
									<option value="consumo">Consumo</option>
									<option value="precio">Precio</option>
									<option value="recibo">Datos de recibo</option>
								</select>
							</div>
							<div class="col-sm-3 col-12 form-group">
								<label for="tarifa">Tarifa</label>
								<select class="custom-select" id="tarifa">
									<option disabled selected>Selecciona una tarifa...</option>
									<option value="tarifa_01">Tarifa 01</option>
									<option value="tarifa_dac">Tarifa DAC</option>
									<option value="tarifa_pdbt">PDBT</option>
								</select>
							</div>
							<div class="col-sm-3 col-6 form-group">
								<label for="periodo">Periodo</label>
								<select class="custom-select" id="periodo">
									<option value="mensual">Mensual</option>
									<option selected value="bimestral">Bimestral</option>
								</select>
							</div>
							<div class="col-sm-3 col-6 form-group">
								<label for="mostrar_roi">Mostrar ROI</label>
								<select class="custom-select" id="mostrar_roi">
									<option value="si">Sí</option>
									<option value="no">No</option>
								</select>
							</div>
						</div>
						<div class="form-row d-none" id="periodos">
							<div class="col-sm-2 col-6 form-group">
								<label for="periodo_1">Periodo 1</label>
								<div class="input-group">
									<input class="form-control" type="number" id="periodo_1" name="periodo_1" min="1"
										readonly>
									<div class="input-group-append">
										<span class="input-group-text">kWh</span>
									</div>
								</div>
							</div>
							<div class="col-sm-2 col-6 form-group">
								<label for="periodo_2">Periodo 2</label>
								<div class="input-group">
									<input class="form-control" type="number" id="periodo_2" name="periodo_2" min="1"
										readonly>
									<div class="input-group-append">
										<span class="input-group-text">kWh</span>
									</div>
								</div>
							</div>
							<div class="col-sm-2 col-6 form-group">
								<label for="periodo_3">Periodo 3</label>
								<div class="input-group">
									<input class="form-control" type="number" id="periodo_3" name="periodo_3" min="1"
										readonly>
									<div class="input-group-append">
										<span class="input-group-text">kWh</span>
									</div>
								</div>
							</div>
							<div class="col-sm-2 col-6 form-group">
								<label for="periodo_4">Periodo 4</label>
								<div class="input-group">
									<input class="form-control" type="number" id="periodo_4" name="periodo_4" min="1"
										readonly>
									<div class="input-group-append">
										<span class="input-group-text">kWh</span>
									</div>
								</div>
							</div>
							<div class="col-sm-2 col-6 form-group">
								<label for="periodo_5">Periodo 5</label>
								<div class="input-group">
									<input class="form-control" type="number" id="periodo_5" name="periodo_5" min="1"
										readonly>
									<div class="input-group-append">
										<span class="input-group-text">kWh</span>
									</div>
								</div>
							</div>
							<div class="col-sm-2 col-6 form-group">
								<label for="periodo_6">Periodo 6</label>
								<div class="input-group">
									<input class="form-control" type="number" id="periodo_6" name="periodo_6" min="1"
										readonly>
									<div class="input-group-append">
										<span class="input-group-text">kWh</span>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-4 col-12 form-group">
								<label for="consumo_promedio_kwh">Consumo promedio bimestral (kWh)</label>
								<div class="input-group">
									<input id="consumo_promedio_kwh" name="consumo_promedio_kwh" type="number"
										class="form-control" readonly>
									<div class="input-group-append">
										<span class="input-group-text">kWh</span>
									</div>
								</div>
							</div>
							<div class="col-sm-4 col-12 form-group">
								<label for="consumo_promedio_pesos">Consumo promedio bimestral ($)</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="consumo_promedio_pesos" name="consumo_promedio_pesos" type="number"
										class="form-control" readonly>
								</div>
							</div>
							<div class="col-sm-4 col-12 form-group align-self-end">
								<button type="button" class="btn btn-block btn-success" id="calcular_consumos">Calcular
									consumos</button>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-12">
								<div class="chart-container d-none" id="contenedor_grafica"
									style="position: relative; width:90%; margin:auto; height:500px">
									<canvas id="grafica_consumo"></canvas>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col">
								<h3>Datos del sistema</h3>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="col-sm-12 col-12 form-group">
								<label for="tipo_interconexion">Tipo de interconexión</label>
								<select class="custom-select" id="tipo_interconexion" name="tipo_interconexion"
									disabled>
									<option disabled selected>Selecciona un tipo de interconexión...</option>
									<option value="inversor_central_austero">Inversor central</option>
									<option value="inversor_central_optimizadores">Inversor central con optimizadores
									</option>
									<option value="microinversores">Microinversores</option>
									<option value="personalizado">Personalizado</option>
								</select>
							</div>
							<div class="col-sm-9 col-12 form-group">
								<label for="tipo_panel">Tipo de panel</label>
								<select class="custom-select" id="tipo_panel" name="tipo_panel" disabled>
									<option disabled selected>Selecciona un panel...</option>
								</select>
							</div>
							<div class="col-sm-3 col-6 form-group">
								<label for="num_paneles">Número de paneles</label>
								<input class="form-control" type="number" id="num_paneles" name="num_paneles" min="1"
									max="999" disabled>
							</div>
							<div class="col-sm-3 col-6 form-group">
								<label for="potencia_total">Potencia total</label>
								<div class="input-group">
									<input id="potencia_total" name="potencia_total" type="number" class="form-control"
										readonly>
									<div class="input-group-append">
										<span class="input-group-text">kW</span>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-6 form-group">
								<label for="produccion_promedio">Producción bimestral</label>
								<div class="input-group">
									<input id="produccion_promedio" name="produccion_promedio" type="number"
										class="form-control" readonly>
									<div class="input-group-append">
										<span class="input-group-text">kWh</span>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-6 form-group">
								<label for="produccion_anual">Producción anual</label>
								<div class="input-group">
									<input id="produccion_anual" name="produccion_anual" type="number"
										class="form-control" readonly>
									<div class="input-group-append">
										<span class="input-group-text">kWh</span>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-12 form-group">
								<label for="ahorro">Ahorro</label>
								<div class="input-group">
									<input id="ahorro" name="ahorro" type="text" class="form-control" readonly>
									<div class="input-group-append">
										<span class="input-group-text">%</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col">
								<h3>Componentes fotovoltaicos y eléctricos</h3>
							</div>
						</div>
						<div class="form-row" id="datos_estructura">
							<div class="col-sm-4 col-6 form-group">
								<label for="tipo_estructura">Tipo de estructura</label>
								<select class="custom-select" id="tipo_estructura" name="tipo_estructura" disabled>
									<option selected disabled>Selecciona un tipo de estructura...</option>
								</select>
							</div>
							<div class="col-sm-4 col-6 form-group">
								<label for="estructura">Estructura</label>
								<select class="custom-select" id="estructura" name="estructura" disabled>
									<option selected disabled>Selecciona una estructura...</option>
								</select>
							</div>
							<div class="col-sm-2 col-6 form-group">
								<label for="cantidad_estructura">Cantidad de estructuras</label>
								<input class="form-control cantidad_estructura" type="number" id="cantidad_estructura"
									name="cantidad_estructura" value="1" min="1" max="999" disabled>
							</div>
							<div class="col-sm-2 col-6 form-group align-self-end">
								<button class="btn btn-success btn-block" id="agregar_estructura"
									disabled>Agregar</button>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-6 col-12 form-group">
								<label for="inversor_central">Inversor central</label>
								<select class="custom-select" id="inversor_central" name="inversor_central" disabled>
									<option selected disabled>Selecciona un inversor...</option>
								</select>
							</div>
							<div class="col-sm-6 col-12 form-group">
								<label for="microinversor">Microinversor</label>
								<select class="custom-select" id="microinversor" name="microinversor" disabled>
									<option selected disabled>Selecciona un microinversor...</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-4 col-12 form-group">
								<label for="optimizador">Optimizador</label>
								<select class="custom-select" id="optimizador" name="optimizador" disabled>
									<option selected disabled>Selecciona un optimizador...</option>
								</select>
							</div>
							<div class="col-sm-4 col-12 form-group">
								<label for="sistema_monitoreo">Sistema de monitoreo</label>
								<select class="custom-select" id="sistema_monitoreo" name="sistema_monitoreo" disabled>
									<option selected disabled>Selecciona un sistema...</option>
								</select>
							</div>
							<div class="col-sm-4 col-12 form-group">
								<label for="instalacion_electrica">Instalación eléctrica</label>
								<select class="custom-select" id="instalacion_electrica" name="instalacion_electrica"
									disabled>
									<option value="0">0 metros</option>
									<option value="5">5 metros</option>
									<option value="10">10 metros</option>
									<option value="15">15 metros</option>
									<option value="20">20 metros</option>
									<option value="25">25 metros</option>
									<option value="30">30 metros</option>
									<option value="35">35 metros</option>
									<option value="40">40 metros</option>
									<option value="45">45 metros</option>
									<option value="50">50 metros</option>
									<option value="55">55 metros</option>
									<option value="60">60 metros</option>
									<option value="65">65 metros</option>
									<option value="70">70 metros</option>
									<option value="75">75 metros</option>
									<option value="80">80 metros</option>
									<option value="85">85 metros</option>
									<option value="90">90 metros</option>
									<option value="95">95 metros</option>
									<option value="100">100 metros</option>
								</select>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-12 col-sm-9">
								<h3>Resumen de cotización</h3>
							</div>
							<div class="col-12 col-sm-3">
								<button class="btn btn-success btn-block" type="button" data-toggle="modal"
									data-target="#modal_agregar_producto">Añadir otro producto</button>
							</div>
						</div>
						<div class="row mt-2 justify-content-center">
							<div class="col-12">
								<div class="table-responsive">
									<table id="tabla_productos" class="table text-center mb-0 tabla-responsiva">
										<thead>
											<tr>
												<th style="width:20%">Código</th>
												<th style="width:25%">Producto</th>
												<th style="width:10%">Marca</th>
												<th style="width:15%">Cantidad</th>
												<th style="width:20%">Acciones</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col">
								<h3>Ahorros estimados</h3>
							</div>
						</div>
						<div class="row justify-content-center">
							<div class="col-sm-10">
								<div class="table-responsive">
									<table id="tabla_ahorro" class="table text-center mb-0">
										<thead>
											<tr>
												<th style="width:5%">Periodo</th>
												<th style="width:30%">Actual</th>
												<th style="width:30%">Con AAMPERIA</th>
												<th style="width:30%">Ahorro</th>
											</tr>
										</thead>
										<tbody>
											<tr id="periodo_tabla">
												<th>Bimestral</th>
												<td>$ 0</td>
												<td>$ 0</td>
												<td>$ 0</td>
											</tr>
											<tr id="1_anio">
												<th>1 año</th>
												<td>$ 0</td>
												<td>$ 0</td>
												<td>$ 0</td>
											</tr>
											<tr id="5_anios">
												<th>5 años</th>
												<td>$ 0</td>
												<td>$ 0</td>
												<td>$ 0</td>
											</tr>
											<tr id="10_anios">
												<th>10 años</th>
												<td>$ 0</td>
												<td>$ 0</td>
												<td>$ 0</td>
											</tr>
											<tr id="25_anios">
												<th>25 años</th>
												<td>$ 0</td>
												<td>$ 0</td>
												<td>$ 0</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="row" id="row_roi">
							<div class="col-12">
								<div class="chart-container" id="contenedor_roi"
									style="position: relative; height:400px; width:90%; margin:auto">
									<canvas id="grafica_roi"></canvas>
								</div>
							</div>
						</div>
						<div class="row justify-content-center" id="roi_texto">
							<div class="col-sm-9">
								<table class="table text-center mb-0">
									<tbody>
										<tr id="retorno_inversion">
											<th>Retorno de inversión:</th>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col">
								<h3>Precios finales de cotización</h3>
							</div>
						</div>
						<div class="row mt-2 mb-4 justify-content-center">
							<div class="col-12">
								<div class="table-responsive">
									<table id="tabla_totales" class="table text-center mb-0" style="min-width:600px">
										<thead>
											<tr>
												<th style="width:25%">Código</th>
												<th style="width:40%">Producto</th>
												<th style="width:15%">Cantidad</th>
												<th style="width:20%">Precio</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										<tfoot>
											<tr>
												<th colspan="2"></th>
												<th colspan="1">SUBTOTAL</th>
												<td id="subtotal"></td>
											</tr>
											<tr>
												<th colspan="2"></th>
												<th colspan="1">IVA</th>
												<td id="iva"></td>
											</tr>
											<tr>
												<th colspan="2"></th>
												<th colspan="1">TOTAL</th>
												<td id="total"></td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="vista_admin" role="tabpanel" aria-labelledby="nav_vista_admin">
						<div class="form-row mt-2">
							<div class="col-sm-6 col-12 form-group">
								<div class="row mt-2">
									<div class="col">
										<h3>Tasa de cambio</h3>
									</div>
								</div>
								<div class="form-row">
									<div class="col-6 form-group">
										<label for="admin_tasa_cambio">Precio USD</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">$</span>
											</div>
											<input id="admin_tasa_cambio" name="admin_tasa_cambio" type="number"
												class="form-control" min="0.01" step="0.01" readonly>
											<div class="input-group-append">
												<button class="btn btn-primary" type="button"
													id="cambiar_tasa_usd">Cambiar</button>
											</div>
										</div>
									</div>
									<div class="col-sm-6 col-6 form-group">
										<label for="admin_fecha_tasa_cambio">Fecha de tasa USD</label>
										<input id="admin_fecha_tasa_cambio" name="admin_fecha_tasa_cambio" type="text"
											class="form-control" readonly>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-12 form-group">
								<div class="row mt-2">
									<div class="col">
										<h3>Índice de utilidad</h3>
									</div>
								</div>
								<div class="form-row">
									<div class="col-12 form-group">
										<label for="admin_indice_utilidad">Índice de utilidad para esta
											cotización</label>
										<div class="input-group">
											<input id="admin_indice_utilidad" name="admin_indice_utilidad" type="number"
												class="form-control" min="1" max="100" step="0.01" readonly>
											<div class="input-group-append">
												<span class="input-group-text">%</span>
												<button class="btn btn-primary" type="button"
													id="cambiar_indice">Cambiar</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col">
								<h3>Costos de instalación</h3>
							</div>
						</div>
						<div class="form-row">
							<div class="col-lg-3 col-6 form-group">
								<label for="admin_costo_por_metro">Costo por metro</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_costo_por_metro" name="admin_costo_por_metro" type="text"
										class="form-control" readonly>
								</div>
							</div>
							<div class="col-lg-3 col-6 form-group">
								<label for="admin_costo_tuberia">Tubería y cableado</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_costo_tuberia" name="admin_costo_tuberia" type="text"
										class="form-control" value="0.00" readonly>
								</div>
							</div>
							<div class="col-lg-3 col-6 form-group">
								<label for="admin_costo_instalacion">Instalación</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<select id="admin_costo_instalacion" class="form-control">
										<option selected value="0">0</option>
										<option value="1000">1,000</option>
										<option value="2000">2,000</option>
										<option value="3000">3,000</option>
										<option value="4000">4,000</option>
										<option value="5000">5,000</option>
										<option value="6000">6,000</option>
										<option value="7000">7,000</option>
										<option value="8000">8,000</option>
										<option value="9000">9,000</option>
										<option value="10000">10,000</option>
										<option value="11000">11,000</option>
										<option value="12000">12,000</option>
										<option value="13000">13,000</option>
										<option value="14000">14,000</option>
										<option value="15000">15,000</option>
										<option value="16000">16,000</option>
										<option value="17000">17,000</option>
										<option value="18000">18,000</option>
										<option value="19000">19,000</option>
										<option value="20000">20,000</option>
										<option value="21000">21,000</option>
										<option value="22000">22,000</option>
										<option value="23000">23,000</option>
										<option value="24000">24,000</option>
										<option value="25000">25,000</option>
										<option value="26000">26,000</option>
										<option value="27000">27,000</option>
										<option value="28000">28,000</option>
										<option value="29000">29,000</option>
										<option value="30000">30,000</option>
										<option value="31000">31,000</option>
										<option value="32000">32,000</option>
										<option value="33000">33,000</option>
										<option value="34000">34,000</option>
										<option value="35000">35,000</option>
										<option value="36000">36,000</option>
										<option value="37000">37,000</option>
										<option value="38000">38,000</option>
										<option value="39000">39,000</option>
										<option value="40000">40,000</option>
										<option value="41000">41,000</option>
										<option value="42000">42,000</option>
										<option value="43000">43,000</option>
										<option value="44000">44,000</option>
										<option value="45000">45,000</option>
										<option value="46000">46,000</option>
										<option value="47000">47,000</option>
										<option value="48000">48,000</option>
										<option value="49000">49,000</option>
										<option value="50000">50,000</option>
										<option value="51000">51,000</option>
										<option value="52000">52,000</option>
										<option value="53000">53,000</option>
										<option value="54000">54,000</option>
										<option value="55000">55,000</option>
										<option value="56000">56,000</option>
										<option value="57000">57,000</option>
										<option value="58000">58,000</option>
										<option value="59000">59,000</option>
										<option value="60000">60,000</option>
										<option value="61000">61,000</option>
										<option value="62000">62,000</option>
										<option value="63000">63,000</option>
										<option value="64000">64,000</option>
										<option value="65000">65,000</option>
										<option value="66000">66,000</option>
										<option value="67000">67,000</option>
										<option value="68000">68,000</option>
										<option value="69000">69,000</option>
										<option value="70000">70,000</option>
										<option value="71000">71,000</option>
										<option value="72000">72,000</option>
										<option value="73000">73,000</option>
										<option value="74000">74,000</option>
										<option value="75000">75,000</option>
										<option value="76000">76,000</option>
										<option value="77000">77,000</option>
										<option value="78000">78,000</option>
										<option value="79000">79,000</option>
										<option value="80000">80,000</option>
										<option value="81000">81,000</option>
										<option value="82000">82,000</option>
										<option value="83000">83,000</option>
										<option value="84000">84,000</option>
										<option value="85000">85,000</option>
										<option value="86000">86,000</option>
										<option value="87000">87,000</option>
										<option value="88000">88,000</option>
										<option value="89000">89,000</option>
										<option value="90000">90,000</option>
										<option value="91000">91,000</option>
										<option value="92000">92,000</option>
										<option value="93000">93,000</option>
										<option value="94000">94,000</option>
										<option value="95000">95,000</option>
										<option value="96000">96,000</option>
										<option value="97000">97,000</option>
										<option value="98000">98,000</option>
										<option value="99000">99,000</option>
										<option value="100000">100,000</option>
									</select>
								</div>
							</div>
							<div class="col-lg-3 col-6 form-group">
								<label for="admin_costo_material_electrico">Material eléctrico</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<select id="admin_costo_material_electrico" class="form-control">
										<option selected value="0">0</option>
										<option value="1000">1,000</option>
										<option value="2000">2,000</option>
										<option value="3000">3,000</option>
										<option value="4000">4,000</option>
										<option value="5000">5,000</option>
										<option value="6000">6,000</option>
										<option value="7000">7,000</option>
										<option value="8000">8,000</option>
										<option value="9000">9,000</option>
										<option value="10000">10,000</option>
										<option value="11000">11,000</option>
										<option value="12000">12,000</option>
										<option value="13000">13,000</option>
										<option value="14000">14,000</option>
										<option value="15000">15,000</option>
										<option value="16000">16,000</option>
										<option value="17000">17,000</option>
										<option value="18000">18,000</option>
										<option value="19000">19,000</option>
										<option value="20000">20,000</option>
										<option value="21000">21,000</option>
										<option value="22000">22,000</option>
										<option value="23000">23,000</option>
										<option value="24000">24,000</option>
										<option value="25000">25,000</option>
										<option value="26000">26,000</option>
										<option value="27000">27,000</option>
										<option value="28000">28,000</option>
										<option value="29000">29,000</option>
										<option value="30000">30,000</option>
										<option value="31000">31,000</option>
										<option value="32000">32,000</option>
										<option value="33000">33,000</option>
										<option value="34000">34,000</option>
										<option value="35000">35,000</option>
										<option value="36000">36,000</option>
										<option value="37000">37,000</option>
										<option value="38000">38,000</option>
										<option value="39000">39,000</option>
										<option value="40000">40,000</option>
										<option value="41000">41,000</option>
										<option value="42000">42,000</option>
										<option value="43000">43,000</option>
										<option value="44000">44,000</option>
										<option value="45000">45,000</option>
										<option value="46000">46,000</option>
										<option value="47000">47,000</option>
										<option value="48000">48,000</option>
										<option value="49000">49,000</option>
										<option value="50000">50,000</option>
										<option value="51000">51,000</option>
										<option value="52000">52,000</option>
										<option value="53000">53,000</option>
										<option value="54000">54,000</option>
										<option value="55000">55,000</option>
										<option value="56000">56,000</option>
										<option value="57000">57,000</option>
										<option value="58000">58,000</option>
										<option value="59000">59,000</option>
										<option value="60000">60,000</option>
										<option value="61000">61,000</option>
										<option value="62000">62,000</option>
										<option value="63000">63,000</option>
										<option value="64000">64,000</option>
										<option value="65000">65,000</option>
										<option value="66000">66,000</option>
										<option value="67000">67,000</option>
										<option value="68000">68,000</option>
										<option value="69000">69,000</option>
										<option value="70000">70,000</option>
										<option value="71000">71,000</option>
										<option value="72000">72,000</option>
										<option value="73000">73,000</option>
										<option value="74000">74,000</option>
										<option value="75000">75,000</option>
										<option value="76000">76,000</option>
										<option value="77000">77,000</option>
										<option value="78000">78,000</option>
										<option value="79000">79,000</option>
										<option value="80000">80,000</option>
										<option value="81000">81,000</option>
										<option value="82000">82,000</option>
										<option value="83000">83,000</option>
										<option value="84000">84,000</option>
										<option value="85000">85,000</option>
										<option value="86000">86,000</option>
										<option value="87000">87,000</option>
										<option value="88000">88,000</option>
										<option value="89000">89,000</option>
										<option value="90000">90,000</option>
										<option value="91000">91,000</option>
										<option value="92000">92,000</option>
										<option value="93000">93,000</option>
										<option value="94000">94,000</option>
										<option value="95000">95,000</option>
										<option value="96000">96,000</option>
										<option value="97000">97,000</option>
										<option value="98000">98,000</option>
										<option value="99000">99,000</option>
										<option value="100000">100,000</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col">
								<h3>Costos de CFE</h3>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-3 col-6 form-group">
								<label for="admin_tarifa">Tarifa del cliente</label>
								<input id="admin_tarifa" name="admin_tarifa" type="text" class="form-control" readonly>
							</div>
							<div class="col-sm-3 col-6 form-group">
								<label for="admin_suministro">Costo suministro</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_suministro" name="admin_suministro" type="text"
										class="form-control" readonly>
								</div>
							</div>
							<div class="col-sm-3 col-6 form-group">
								<label for="admin_gasto_bimestral">Gasto bimestral (CFE)</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_gasto_bimestral" name="admin_gasto_bimestral" type="text"
										class="form-control" readonly>
								</div>
							</div>
							<div class="col-sm-3 col-6 form-group">
								<label for="admin_gasto_anual">Gasto anual (CFE)</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_gasto_anual" name="admin_gasto_anual" type="text"
										class="form-control" readonly>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col">
								<h3>Costos de componentes</h3>
							</div>
						</div>
						<div class="row mt-2 justify-content-center">
							<div class="col-12">
								<div class="table-responsive">
									<table id="tabla_costos" class="table text-center mb-0 table-striped">
										<thead>
											<tr>
												<th>Código</th>
												<th>Producto</th>
												<th>Marca</th>
												<th>Cantidad</th>
												<th>Costo por unidad (USD)</th>
												<th>Costo por unidad (MXN)</th>
												<th>Costo total (MXN)</th>
												<th>Precio final sin IVA (MXN)</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										<tfoot>
											<tr>
												<th colspan="5"></th>
												<th>SUBTOTAL</th>
												<th id="total_costos"></th>
												<th id="total_precios_finales"></th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col">
								<h3>Financiamiento del proyecto</h3>
							</div>
						</div>
						<div class="form-row">
							<div class="col-lg-6 col-12 form-group">
								<label for="admin_costo_panel_instalado">Costo por panel instalado</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_costo_panel_instalado" name="admin_costo_panel_instalado"
										type="text" class="form-control" readonly>
								</div>
							</div>
							<div class="col-lg-6 col-12 form-group">
								<label for="admin_costo_watt_instalado">Costo por watt instalado (USD)</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_costo_watt_instalado" name="admin_costo_watt_instalado" type="text"
										class="form-control" readonly>
								</div>
							</div>
							<div class="col-lg-4 col-12 form-group">
								<label for="admin_costo_proyecto">Costo del proyecto con proveedores</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_costo_proyecto" name="admin_costo_proyecto" type="text"
										class="form-control" readonly>
								</div>
							</div>
							<div class="col-lg-4 col-6 form-group">
								<label for="admin_proyecto_iva">IVA</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_proyecto_iva" name="admin_proyecto_iva" type="text"
										class="form-control" readonly>
								</div>
							</div>
							<div class="col-lg-4 col-6 form-group">
								<label for="admin_proyecto_utilidad">Utilidad</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_proyecto_utilidad" name="admin_proyecto_utilidad" type="text"
										class="form-control" readonly>
								</div>
							</div>
							<div class="col-lg-6 col-12 form-group">
								<label for="admin_costo_proyecto_iva">Costo del proyecto + IVA (pago min. del
									cliente)</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_costo_proyecto_iva" name="admin_costo_proyecto_iva" type="text"
										class="form-control" readonly>
								</div>
							</div>
							<div class="col-lg-6 col-12 form-group">
								<label for="admin_costo_proyecto_utilidad">Precio al cliente (proyecto +
									utilidad)</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_costo_proyecto_utilidad" name="admin_costo_proyecto_utilidad"
										type="text" class="form-control" readonly>
								</div>
							</div>
							<div class="col-lg-6 col-6 form-group">
								<label for="admin_costo_proyecto_final">Precio final del proyecto con IVA</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input id="admin_costo_proyecto_final" name="admin_costo_proyecto_final" type="text"
										class="form-control" readonly>
								</div>
							</div>
							<div class="col-lg-6 col-6 form-group">
								<label for="admin_porcentaje_minimo">Porcentaje mínimo para iniciar</label>
								<div class="input-group">
									<input id="admin_porcentaje_minimo" name="admin_porcentaje_minimo" type="text"
										class="form-control" readonly>
									<div class="input-group-append">
										<span class="input-group-text">%</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-row mt-4">
					<div class="col-sm-6 form-group">
						<button class="btn btn-success btn-block" id="generar_cotizacion">Generar cotización</button>
					</div>
					<div class="col-sm-6 form-group">
						<a class="btn btn-danger btn-block"
							href="<?= base_url() ?>cotizacion/reiniciar_cotizacion_temporal">Reiniciar cotización</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_agregar_producto" tabindex="-1" role="dialog"
		aria-labelledby="modal_agregar_producto_label" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal_agregar_producto_label">Agregar producto o servicio</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-row">
						<div class="col-12 form-group">
							<label for="modal_tipo_producto">Tipo de producto</label>
							<select class="custom-select" id="modal_tipo_producto">
								<option disabled selected>Selecciona un tipo de producto...</option>
								<option value="paneles_solares">Paneles solares</option>
								<option value="optimizadores">Optimizadores</option>
								<option value="inversores_centrales">Inversores centrales</option>
								<option value="estructuras">Estructuras</option>
								<option value="microinversores">Microinversores</option>
								<option value="sistemas_monitoreo">Sistemas de monitoreo</option>
								<option value="extras">Extras</option>
							</select>
						</div>
					</div>
					<div class="row mt-2 justify-content-center">
						<div class="col-12">
							<div class="table-responsive">
								<table id="tabla_agregar" class="table text-center mb-0 tabla-responsiva">
									<thead>
										<tr>
											<th style="width:5%">Código</th>
											<th style="width:40%">Producto</th>
											<th style="width:20%">Marca</th>
											<th style="width:20%">Cantidad</th>
											<th style="width:15%">Acciones</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="col-12">
							<div class="" id="accordionExample">
								<div class="card">
									<div class="card-header collapsed" data-toggle="collapse" data-target="#collapseOne"
										aria-expanded="true">
										<span class="title">Agregar producto extra</span>
										<span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
									</div>
									<div id="collapseOne" class="collapse" data-parent="#accordionExample">
										<div class="card-body">
											<form id="nuevo_extra" name="nuevo_extra" method="post">
												<div class="form-row">
													<div class="col-sm-4 col-6 form-group">
														<label for="extra_codigo">Código</label>
														<input id="extra_codigo" name="codigo" type="text"
															class="form-control" required>
													</div>
													<div class="col-sm-4 col-6 form-group">
														<label for="extra_producto">Producto</label>
														<input id="extra_producto" name="producto" type="text"
															class="form-control" required>
													</div>
													<div class="col-sm-4 col-6 form-group">
														<label for="extra_marca">Marca</label>
														<input id="extra_marca" name="marca" type="text"
															class="form-control" required>
													</div>
													<div class="col-sm-4 col-6 form-group">
														<label for="extra_costo">Costo</label>
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text">$</span>
															</div>
															<input class="form-control" type="number" id="costo_nuevo"
																name="costo" value="0" step="0.01" required>
														</div>
													</div>
													<div class="col-sm-4 col-6 form-group">
														<label for="extra_moneda">Moneda</label>
														<select id="extra_moneda" class="form-control" name="moneda"
															required>
															<option selected disabled>Selecciona una moneda...</option>
															<option value="USD">USD</option>
															<option value="MXN">MXN</option>
														</select>
													</div>
													<div class="col-sm-4 col-12 form-group align-self-end">
														<button type="submit" class="btn btn-success btn-block">Agregar
															extra</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>

			</div>
		</div>
	</div>
	<?php $this->load->view('include/scripts'); ?>
	<!--<script src="<?= base_url() ?>static/js/cotizador/cotizador.js"></script>-->
	<script src="<?= base_url() ?>static/js/cotizador/cotizador_nuevo.js"></script>
	<!-- Cargar Select2 JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
	<script src="<?= base_url() ?>static/js/cotizador/scripts.js"></script>
</body>

</html>