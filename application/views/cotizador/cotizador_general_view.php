<!doctype html>
<?= json_encode($userdata) ?>
<!--<html lang="en">
	<head>
		<?php $this->load->view('include/header', $datos_pagina); ?>
	</head>
	<body>
		<div class="wrapper d-flex align-items-stretch">
			<?php $this->load->view('include/menu_lateral', $datos_pagina);  ?>
			<div id="content" class="main">
				<?php $this->load->view('include/barra_superior', $datos_pagina);  ?>

				<div id="contenido" class="container-fluid mb-4">
					<div class="row mt-4 mb-2">
						<div class="col-6">
							<h2>Cotizador</h2>
						</div>
					</div>
					<nav>
						<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
							<a class="nav-item nav-link active" id="nav_vista_cliente" data-toggle="tab" href="#vista_cliente" role="tab" aria-controls="vista_cliente" aria-selected="true">Vista cliente</a>
						</div>
					</nav>
					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active" id="vista_cliente" role="tabpanel" aria-labelledby="nav_vista_cliente">
							<div class="form-row mt-2">
								<div class="col-sm-4 col-12 form-group">
									<label for="asesor">Asesor</label>
									<select class="custom-select" id="asesor" name="asesor">
										<option disabled selected>Selecciona un asesor...</option>
									</select>
								</div>
								<div class="col-sm-4 col-12 form-group">
									<label for="nombre_usuario">Nombre del cliente</label>
									<input class="form-control" type="text" id="nombre_usuario" name="nombre_usuario">
								</div>
								<div class="col-sm-4 col-12 form-group">
									<label for="ubicacion">Ubicación</label>
									<input class="form-control" type="text" id="ubicacion" name="ubicacion">
								</div>
								<div class="col-sm-3 col-12 form-group">
									<label for="telefono">Teléfono</label>
									<input class="form-control" type="tel" id="telefono" name="telefono">
								</div>
								<div class="col-sm-3 col-12 form-group">
									<label for="correo">Correo</label>
									<input class="form-control" type="email" id="correo" name="correo">
								</div>
								<div class="col-sm-3 col-12 form-group">
									<label for="num_servicio">Número de servicio</label>
									<input class="form-control" type="number" id="num_servicio" name="num_servicio">
								</div>
								<div class="col-sm-3 col-12 form-group">
									<label for="fecha">Fecha de cotización</label>
									<input class="form-control" type="date" id="fecha" name="fecha">
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-4 col-12 form-group">
									<label for="forma_calculo">Calcular con</label>
									<select class="custom-select" id="forma_calculo" name="forma_calculo">
										<option disabled selected>Selecciona una forma de cálculo...</option>
										<option value="consumo">Consumo</option>
										<option value="precio">Precio</option>
										<option value="recibo">Datos de recibo</option>
									</select>
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="tarifa">Tarifa</label>
									<select class="custom-select" id="tarifa">
										<option disabled selected>Selecciona una tarifa...</option>
										<option value="tarifa_01">Tarifa 01</option>
										<option value="tarifa_dac">Tarifa DAC</option>
										<option value="tarifa_pdbt">PDBT</option>
									</select>
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="periodo">Periodo</label>
									<select class="custom-select" id="periodo">
										<option value="mensual">Mensual</option>
										<option selected value="bimestral">Bimestral</option>
									</select>
								</div>
							</div>
							<div class="form-row d-none" id="periodos">
								<div class="col-sm-2 col-6 form-group">
									<label for="periodo_1">Periodo 1</label>
									<div class="input-group">
										<input class="form-control" type="number" id="periodo_1" name="periodo_1" readonly>
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
								<div class="col-sm-2 col-6 form-group">
									<label for="periodo_2">Periodo 2</label>
									<div class="input-group">
										<input class="form-control" type="number" id="periodo_2" name="periodo_2" readonly>
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
								<div class="col-sm-2 col-6 form-group">
									<label for="periodo_3">Periodo 3</label>
									<div class="input-group">
										<input class="form-control" type="number" id="periodo_3"  name="periodo_3" readonly>
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
								<div class="col-sm-2 col-6 form-group">
									<label for="periodo_4">Periodo 4</label>
									<div class="input-group">
										<input class="form-control" type="number" id="periodo_4"  name="periodo_4" readonly>
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
								<div class="col-sm-2 col-6 form-group">
									<label for="periodo_5">Periodo 5</label>
									<div class="input-group">
										<input class="form-control" type="number" id="periodo_5"  name="periodo_5" readonly>
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
								<div class="col-sm-2 col-6 form-group">
									<label for="periodo_6">Periodo 6</label>
									<div class="input-group">
										<input class="form-control" type="number" id="periodo_6"  name="periodo_6" readonly>
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-6 col-12 form-group">
									<label for="consumo_promedio_kwh">Consumo promedio bimestral (kWh)</label>
									<div class="input-group">
										<input id="consumo_promedio_kwh" name="consumo_promedio_kwh" type="number" class="form-control" readonly>
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
								<div class="col-sm-6 col-12 form-group">
									<label for="consumo_promedio_precio">Consumo promedio bimestral ($)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="consumo_promedio_precio" name="consumo_promedio_precio" type="number" class="form-control" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<div class="chart-container d-none" id="contenedor_grafica" style="position: relative; width:90%; margin:auto; height:500px">
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
									<select class="custom-select" id="tipo_interconexion" name="tipo_interconexion" disabled>
										<option disabled selected>Selecciona un tipo de interconexión...</option>
										<option value="inversor_central_austero">Inversor central (austero)</option>
										<option value="inversor_central_optimizadores">Inversor central con optimizadores</option>
										<option value="microinversores">Microinversores</option>
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
									<input class="form-control" type="number" id="num_paneles" name="num_paneles" min="1" max="999" disabled>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="potencia_total">Potencia total</label>
									<div class="input-group">
										<input id="potencia_total" name="potencia_total" type="number" class="form-control" readonly>
										<div class="input-group-append">
											<span class="input-group-text">kW</span>
										</div>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="produccion_promedio">Producción bimestral</label>
									<div class="input-group">
										<input id="produccion_promedio" name="produccion_promedio" type="number" class="form-control" readonly>
										<div class="input-group-append">
											<span class="input-group-text">kWh</span>
										</div>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="produccion_anual">Producción anual</label>
									<div class="input-group">
										<input id="produccion_anual" name="produccion_anual" type="number" class="form-control" readonly>
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
							<div class="form-row fila_estructura" id="fila_estructura_1">
								<div class="col-sm-4 col-6 form-group">
									<label for="tipo_estructura_1">Tipo de estructura</label>
									<select class="custom-select tipo_estructura" id="tipo_estructura_1" name="tipo_estructura_1" disabled>
										<option selected disabled>Selecciona un tipo de estructura...</option>
									</select>
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="estructura_1">Estructura</label>
									<select class="custom-select seleccionar_estructura" id="estructura_1" name="estructura_1" disabled>
										<option selected disabled>Selecciona una estructura...</option>
									</select>
								</div>
								<div class="col-sm-2 col-6 form-group">
									<label for="cantidad_estructura_1">Cantidad</label>
									<input class="form-control cantidad_estructura" type="number" id="cantidad_estructura_1" name="cantidad_estructura_1" value="1" min="1" max="999" disabled>
								</div>
								<div class="col-sm-1 col-3 form-group align-self-end">
									<button class="btn btn-success btn-block agregar_estructura" disabled>Agregar</button>
								</div>
								<div class="col-sm-1 col-3 form-group align-self-end">
									<button class="btn btn-secondary btn-block eliminar_estructura" disabled>Eliminar</button>
								</div>
							</div>
							<div class="form-row d-none" id="datos_inversor_central">
								<div class="col-12 form-group">
									<label for="inversor_central">Inversor central</label>
									<select class="custom-select" id="inversor_central" name="inversor_central" disabled>
										<option selected disabled>Selecciona un inversor...</option>
									</select>
								</div>
							</div>
							<div class="form-row d-none"  id="datos_microinversor">
								<div class="col-sm-8 col-6 form-group">
									<label for="microinversor">Microinversor</label>
									<select class="custom-select" id="microinversor" name="microinversor" disabled>
										<option selected disabled>Selecciona un microinversor...</option>
									</select>
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="cantidad_microinversor">Cantidad</label>
									<input class="form-control" type="number" id="cantidad_microinversor" name="cantidad_microinversor" value="1" min="1" max="999" disabled>
								</div>
							</div>
							<div class="form-row d-none"  id="datos_optimizador">
								<div class="col-sm-8 col-6 form-group">
									<label for="optimizador">Optimizador</label>
									<select class="custom-select" id="optimizador" name="optimizador" disabled>
										<option selected disabled>Selecciona un optimizador...</option>
									</select>
								</div>
								<div class="col-sm-4 col-6 form-group">
									<label for="cantidad_optimizador">Cantidad</label>
									<input class="form-control" type="number" id="cantidad_optimizador" name="cantidad_optimizador" value="1" min="1" max="999" disabled>
								</div>
							</div>
							<div class="form-row">
								<div class="col-6 form-group">
									<label for="sistema_monitoreo">Sistema de monitoreo</label>
									<select class="custom-select" id="sistema_monitoreo" name="sistema_monitoreo" disabled>
										<option selected disabled>Selecciona un sistema...</option>
									</select>
								</div>
								<div class="col-6 form-group">
									<label for="instalacion_electrica">Instalación eléctrica</label>
									<select class="custom-select" id="instalacion_electrica" name="instalacion_electrica" disabled>
										<option selected disabled>Selecciona una cantidad...</option>
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
							<div class="row">
								<div class="col-12">
									<div class="chart-container" style="position: relative; height:400px; width:90%; margin:auto">
										<canvas id="grafica_roi" class="d-none"></canvas>
									</div>
								</div>
							</div>
							<div class="row justify-content-center">
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
													<th style="width:10%">Cantidad</th>
													<th style="width:35%">Descripción</th>
													<th style="width:35%">Producto</th>
													<th style="width:20%">Precio</th>
												</tr>
											</thead>
											<tbody>
												<tr id="celda_paneles" class="d-none">
													<td></td>
													<td>Panel solar</td>
													<td></td>
													<td></td>
												</tr>
												<tr id="celda_microinversor" class="d-none">
													<td></td>
													<td>Microinversor</td>
													<td></td>
													<td></td>
												</tr>
												<tr id="celda_inversor" class="d-none">
													<td></td>
													<td>Inversor</td>
													<td></td>
													<td></td>
												</tr>
												<tr id="celda_optimizador" class="d-none">
													<td></td>
													<td>Optimizador</td>
													<td></td>
													<td></td>
												</tr>
												<tr id="celda_sistema" class="d-none">
													<td></td>
													<td>Sistema de monitoreo</td>
													<td></td>
													<td></td>
												</tr>
												<tr id="celda_estructura_1" class="d-none">
													<td></td>
													<td>Estructura</td>
													<td></td>
													<td></td>
												</tr>
												<tr id="celda_material" class="d-none">
													<td>1</td>
													<td colspan="2">Material eléctrico e instalación</td>
													<td></td>
												</tr>
												<tr id="celda_subtotal">
													<th colspan="3">SUBTOTAL</th>
													<td></td>
												</tr>
												<tr id="celda_iva">
													<th colspan="3">IVA</th>
													<td></td>
												</tr>
												<tr id="celda_total">
													<th colspan="3">TOTAL</th>
													<td></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="vista_admin" role="tabpanel" aria-labelledby="nav_vista_admin">
							<div class="row mt-2">
								<div class="col">
									<h3>Tasa de cambio</h3>
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-6 col-6 form-group">
									<label for="admin_tasa_cambio">Tasa de cambio</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_tasa_cambio" name="admin_tasa_cambio" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="admin_fecha_tasa_cambio">Fecha</label>
									<input id="admin_fecha_tasa_cambio" name="admin_fecha_tasa_cambio" type="text" class="form-control" readonly>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col">
									<h3>Índice de utilidad</h3>
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-6 col-12 form-group">
									<label for="admin_indice_utilidad">Índice de utilidad para esta cotización</label>
									<div class="input-group">
										<input id="admin_indice_utilidad" name="admin_indice_utilidad" type="number" class="form-control" min="1" max="100" step="0.01" readonly>
										<div class="input-group-append">
											<span class="input-group-text">%</span>
											<button class="btn btn-primary" type="button" id="cambiar_indice">Cambiar</button>
										</div>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col">
									<h3>Costos de CFE</h3>
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-6 col-6 form-group">
									<label for="admin_tarifa">Tarifa</label>
									<input id="admin_tarifa" name="admin_tarifa" type="text" class="form-control" readonly>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="admin_suministro">Costo suministro</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_suministro" name="admin_suministro" type="number" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="admin_gasto_bimestral">Gasto bimestral (CFE)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_gasto_bimestral" name="admin_gasto_bimestral" type="number" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-6 col-6 form-group">
									<label for="admin_gasto_anual">Gasto anual (CFE)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_gasto_anual" name="admin_gasto_anual" type="number" class="form-control" readonly>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col">
									<h3>Costos de componentes</h3>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col">
									<h4>Paneles</h4>
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-6 col-12 form-group">
									<label for="admin_panel_elegido">Panel elegido</label>
									<input id="admin_panel_elegido" name="admin_panel_elegido" type="text" class="form-control" readonly>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_usd_watt">USD/watt</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_usd_watt" name="admin_usd_watt" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_watt_panel">Watt/panel</label>
									<div class="input-group">
										<input id="admin_watt_panel" name="admin_watt_panel" type="text" class="form-control" readonly>
										<div class="input-group-append">
											<span class="input-group-text">W</span>
										</div>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_usd_panel">Costo por unidad (USD)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_usd_panel" name="admin_costo_usd_panel" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_mxn_panel">Costo por unidad (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_mxn_panel" name="admin_costo_mxn_panel" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_cantidad_panel">Cantidad</label>
									<input id="admin_cantidad_panel" name="admin_cantidad_panel" type="text" class="form-control" readonly>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_total_panel">Costo total (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_total_panel" name="admin_costo_total_panel" type="text" class="form-control" readonly>
									</div>
								</div>
							</div>
							<div class="form-row mt-2 d-none" id="fila_inversor">
								<div class="col-12 form-group">
									<h4>Inversor</h4>
								</div>
								<div class="col-sm-12 col-12 form-group">
									<label for="admin_inversor_elegido">Inversor elegido</label>
									<input id="admin_inversor_elegido" name="admin_inversor_elegido" type="text" class="form-control" readonly>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_usd_inversor">Costo por unidad (USD)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_usd_inversor" name="admin_costo_usd_inversor" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_mxn_inversor">Costo por unidad (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_mxn_inversor" name="admin_costo_mxn_inversor" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_cantidad_inversor">Cantidad</label>
									<input id="admin_cantidad_inversor" name="admin_cantidad_inversor" type="text" class="form-control" value="1" readonly>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_total_inversor">Costo total (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_total_inversor" name="admin_costo_total_inversor" type="text" class="form-control" readonly>
									</div>
								</div>
							</div>
							<div class="form-row mt-2 d-none" id="fila_optimizador">
								<div class="col-12 form-group">
									<h4>Optimizadores</h4>
								</div>
								<div class="col-sm-12 col-12 form-group">
									<label for="admin_optimizador_elegido">Optimizador elegido</label>
									<input id="admin_optimizador_elegido" name="admin_optimizador_elegido" type="text" class="form-control" readonly>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_usd_optimizador">Costo por unidad (USD)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_usd_optimizador" name="admin_costo_usd_optimizador" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_mxn_optimizador">Costo por unidad (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_mxn_optimizador" name="admin_costo_mxn_optimizador" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_cantidad_optimizador">Cantidad</label>
									<input id="admin_cantidad_optimizador" name="admin_cantidad_optimizador" type="text" class="form-control" readonly>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_total_optimizador">Costo total (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_total_optimizador" name="admin_costo_total_optimizador" type="text" class="form-control" readonly>
									</div>
								</div>
							</div>
							<div class="form-row d-none mt-2" id="fila_microinversor">
								<div class="col-12 form-group">
									<h4>Microinversores</h4>
								</div>
								<div class="col-sm-12 col-12 form-group">
									<label for="admin_microinversor_elegido">Microinversor elegido</label>
									<input id="admin_microinversor_elegido" name="admin_microinversor_elegido" type="text" class="form-control" readonly>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_usd_microinversor">Costo por unidad (USD)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_usd_microinversor" name="admin_costo_usd_microinversor" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_mxn_microinversor">Costo por unidad (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_mxn_microinversor" name="admin_costo_mxn_microinversor" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_cantidad_microinversor">Cantidad</label>
									<input id="admin_cantidad_microinversor" name="admin_cantidad_microinversor" type="text" class="form-control" readonly>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_total_microinversor">Costo total (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_total_microinversor" name="admin_costo_total_microinversor" type="text" class="form-control" readonly>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col">
									<h4>Sistema de monitoreo</h4>
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-12 col-12 form-group">
									<label for="admin_sistema_monitoreo_elegido">Sistema de monitoreo elegido</label>
									<input id="admin_sistema_monitoreo_elegido" name="admin_sistema_monitoreo_elegido" type="text" class="form-control" readonly>
								</div>
							</div>
							<div class="form-row">
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_usd_sistema_monitoreo">Costo por unidad (USD)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_usd_sistema_monitoreo" name="admin_costo_usd_sistema_monitoreo" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_mxn_sistema_monitoreo">Costo por unidad (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_mxn_sistema_monitoreo" name="admin_costo_mxn_sistema_monitoreo" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_cantidad_sistema_monitoreo">Cantidad</label>
									<input id="admin_cantidad_sistema_monitoreo" name="admin_cantidad_sistema_monitoreo" type="text" class="form-control" value="1" readonly>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_total_sistema_monitoreo">Costo total (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_total_sistema_monitoreo" name="admin_costo_total_sistema_monitoreo" type="text" class="form-control" readonly>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col">
									<h4 id="titulo_estructuras">Estructuras (1)</h4>
								</div>
							</div>
							<div class="form-row" id="admin_fila_estructura_1">
								<div class="col-sm-6 col-12 form-group">
									<label for="admin_estructura_elegida_1">Estructura elegida (1)</label>
									<input id="admin_estructura_elegida_1" name="admin_estructura_elegida_1" type="text" class="form-control" readonly>
								</div>
								<div class="col-sm-6 col-12 form-group">
									<label for="admin_tipo_estructura_1">Tipo de estructura</label>
									<input id="admin_tipo_estructura_1" name="admin_tipo_estructura_1" type="text" class="form-control" readonly>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_usd_estructura_1">Costo por unidad (USD)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_usd_estructura_1" name="admin_costo_usd_estructura_1" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_mxn_estructura_1">Costo por unidad (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_mxn_estructura_1" name="admin_costo_mxn_estructura_1" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_cantidad_estructura_1">Cantidad</label>
									<input id="admin_cantidad_estructura_1" name="admin_cantidad_estructura_1" type="text" class="form-control" readonly>
								</div>
								<div class="col-sm-3 col-6 form-group">
									<label for="admin_costo_total_estructura_1">Costo total (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_total_estructura_1" name="admin_costo_total_estructura_1" type="text" class="form-control" readonly>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col">
									<h3>Costos de instalación</h3>
								</div>
							</div>
							<div class="form-row">
								<div class="col-lg-2 col-6 form-group">
									<label for="admin_costo_por_metro">Costo por metro</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_por_metro" name="admin_costo_por_metro" type="number" class="form-control" value="0" min="1">
									</div>
								</div>
								<div class="col-lg-2 col-6 form-group">
									<label for="admin_costo_tuberia">Tubería y cableado</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_tuberia" name="admin_costo_tuberia" type="number" class="form-control" value="0" min="1">
									</div>
								</div>
								<div class="col-lg-2 col-6 form-group">
									<label for="admin_costo_material_electrico">Material eléctrico</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<select id="admin_costo_material_electrico" class="form-control">
											<option value="500">500</option>
											<option value="1000">1,000</option>
											<option value="1500">1,500</option>
											<option value="2000">2,000</option>
											<option value="2500">2,500</option>
											<option value="3000">3,000</option>
											<option value="3500">3,500</option>
											<option value="4000">4,000</option>
											<option value="4500">4,500</option>
											<option value="5000">5,000</option>
											<option value="5500">5,500</option>
											<option value="6000">6,000</option>
											<option value="6500">6,500</option>
											<option value="7000">7,000</option>
											<option value="7500">7,500</option>
											<option value="8000">8,000</option>
											<option value="8500">8,500</option>
											<option value="9000">9,000</option>
											<option value="9500">9,500</option>
											<option value="10000">10,000</option>
											<option value="10500">10,500</option>
											<option value="11000">11,000</option>
											<option value="11500">11,500</option>
											<option value="12000">12,000</option>
											<option value="12500">12,500</option>
											<option value="13000">13,000</option>
											<option value="13500">13,500</option>
											<option value="14000">14,000</option>
											<option value="14500">14,500</option>
											<option value="15000">15,000</option>
											<option value="15500">15,500</option>
											<option value="16000">16,000</option>
											<option value="16500">16,500</option>
											<option value="17000">17,000</option>
											<option value="17500">17,500</option>
											<option value="18000">18,000</option>
											<option value="18500">18,500</option>
											<option value="19000">19,000</option>
											<option value="19500">19,500</option>
											<option value="20000">20,000</option>
										</select>
									</div>
								</div>
								<div class="col-lg-2 col-6 form-group">
									<label for="admin_costo_instalacion">Instalación</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<select id="admin_costo_instalacion" class="form-control">
											<option value="500">500</option>
											<option value="1000">1,000</option>
											<option value="1500">1,500</option>
											<option value="2000">2,000</option>
											<option value="2500">2,500</option>
											<option value="3000">3,000</option>
											<option value="3500">3,500</option>
											<option value="4000">4,000</option>
											<option value="4500">4,500</option>
											<option value="5000">5,000</option>
											<option value="5500">5,500</option>
											<option value="6000">6,000</option>
											<option value="6500">6,500</option>
											<option value="7000">7,000</option>
											<option value="7500">7,500</option>
											<option value="8000">8,000</option>
											<option value="8500">8,500</option>
											<option value="9000">9,000</option>
											<option value="9500">9,500</option>
											<option value="10000">10,000</option>
											<option value="10500">10,500</option>
											<option value="11000">11,000</option>
											<option value="11500">11,500</option>
											<option value="12000">12,000</option>
											<option value="12500">12,500</option>
											<option value="13000">13,000</option>
											<option value="13500">13,500</option>
											<option value="14000">14,000</option>
											<option value="14500">14,500</option>
											<option value="15000">15,000</option>
											<option value="15500">15,500</option>
											<option value="16000">16,000</option>
											<option value="16500">16,500</option>
											<option value="17000">17,000</option>
											<option value="17500">17,500</option>
											<option value="18000">18,000</option>
											<option value="18500">18,500</option>
											<option value="19000">19,000</option>
											<option value="19500">19,500</option>
											<option value="20000">20,000</option>
										</select>
									</div>
								</div>
								<div class="col-lg-4 col-12 form-group">
									<label for="admin_costo_total_instalacion">Costo total (MXN)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_total_instalacion" name="admin_costo_total_instalacion" type="text" class="form-control">
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col">
									<h3>Financiamiento del proyecto</h3>
								</div>
							</div>
							<div class="form-row">
								<div class="col-lg-6 col-6 form-group">
									<label for="admin_costo_panel_instalado">Costo por panel instalado</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_panel_instalado" name="admin_costo_panel_instalado" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-lg-6 col-6 form-group">
									<label for="admin_costo_watt_instalado">Costo por watt instalado</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_watt_instalado" name="admin_costo_watt_instalado" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-lg-4 col-6 form-group">
									<label for="admin_costo_proyecto">Costo del proyecto con proveedores</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_proyecto" name="admin_costo_proyecto" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-lg-4 col-6 form-group">
									<label for="admin_proyecto_iva">IVA</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_proyecto_iva" name="admin_proyecto_iva" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-lg-4 col-6 form-group">
									<label for="admin_proyecto_utilidad">Utilidad</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_proyecto_utilidad" name="admin_proyecto_utilidad" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-lg-6 col-12 form-group">
									<label for="admin_costo_proyecto_iva">Costo del proyecto + IVA (pago min. del cliente)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_proyecto_iva" name="admin_costo_proyecto_iva" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-lg-6 col-12 form-group">
									<label for="admin_costo_proyecto_utilidad">Precio al cliente (proyecto + utilidad)</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_proyecto_utilidad" name="admin_costo_proyecto_utilidad" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-lg-6 col-6 form-group">
									<label for="admin_costo_proyecto_final">Precio final del proyecto con IVA</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input id="admin_costo_proyecto_final" name="admin_costo_proyecto_final" type="text" class="form-control" readonly>
									</div>
								</div>
								<div class="col-lg-6 col-6 form-group">
									<label for="admin_porcentaje_minimo">Porcentaje mínimo para iniciar</label>
									<div class="input-group">
										<input id="admin_porcentaje_minimo" name="admin_porcentaje_minimo" type="text" class="form-control" readonly>
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
							<button class="btn btn-success form-control" id="generar_cotizacion">Generar cotización</button>
						</div>
						<div class="col-sm-6 form-group">
							<button class="btn btn-danger form-control" id="reiniciar_cotizacion">Reiniciar cotización</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('include/scripts');  ?>
		<script src="<?= base_url() ?>static/js/cotizador/cotizador.js"></script>
	</body>
</html>