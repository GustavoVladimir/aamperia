<!doctype html>
<html lang="en">
	<head>
		<?php $this->load->view('include/header', $datos_pagina); ?>
		<script>
			var id_usuario = "<?=$this->session->usuario['id_usuario']?>";
		</script>
	</head>
	<body>
		<div id="overlay" class="d-none">
			<div id="spinner"></div>
		</div>
		<div class="wrapper d-flex align-items-stretch">
			<?php $this->load->view('include/menu_lateral', $datos_pagina);  ?>
			<div id="content" class="main">
				<?php $this->load->view('include/barra_superior', $datos_pagina);  ?>

				<div id="contenido" class="container-fluid mb-4">
					<div class="row mt-4 mb-2">
						<div class="col">
							<h2>Cotizador</h2>
							<div class="alert alert-dismissible fade show mb-0 d-none" role="alert" id="alerta">
								<strong>La tasa de cambio puede estar desactualizada: </strong><span></span>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="col-sm-4 col-12 form-group">
							<label for="asesor">Asesor</label>
							<input class="form-control" type="text" id="asesor" name="asesor" value="<?=$this->session->usuario['nombre'].' '.$this->session->usuario['apellido_paterno'].' '.$this->session->usuario['apellido_materno']?>" disabled>
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
								<input class="form-control" type="number" id="periodo_1" name="periodo_1" min="1" readonly>
								<div class="input-group-append">
									<span class="input-group-text">kWh</span>
								</div>
							</div>
						</div>
						<div class="col-sm-2 col-6 form-group">
							<label for="periodo_2">Periodo 2</label>
							<div class="input-group">
								<input class="form-control" type="number" id="periodo_2" name="periodo_2" min="1" readonly>
								<div class="input-group-append">
									<span class="input-group-text">kWh</span>
								</div>
							</div>
						</div>
						<div class="col-sm-2 col-6 form-group">
							<label for="periodo_3">Periodo 3</label>
							<div class="input-group">
								<input class="form-control" type="number" id="periodo_3"  name="periodo_3" min="1" readonly>
								<div class="input-group-append">
									<span class="input-group-text">kWh</span>
								</div>
							</div>
						</div>
						<div class="col-sm-2 col-6 form-group">
							<label for="periodo_4">Periodo 4</label>
							<div class="input-group">
								<input class="form-control" type="number" id="periodo_4"  name="periodo_4" min="1" readonly>
								<div class="input-group-append">
									<span class="input-group-text">kWh</span>
								</div>
							</div>
						</div>
						<div class="col-sm-2 col-6 form-group">
							<label for="periodo_5">Periodo 5</label>
							<div class="input-group">
								<input class="form-control" type="number" id="periodo_5"  name="periodo_5" min="1" readonly>
								<div class="input-group-append">
									<span class="input-group-text">kWh</span>
								</div>
							</div>
						</div>
						<div class="col-sm-2 col-6 form-group">
							<label for="periodo_6">Periodo 6</label>
							<div class="input-group">
								<input class="form-control" type="number" id="periodo_6"  name="periodo_6" min="1" readonly>
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
						<div class="col-lg-3 col-6 form-group">
							<label for="sistema_monitoreo">Sistema de monitoreo</label>
							<select class="custom-select" id="sistema_monitoreo" name="sistema_monitoreo" disabled>
								<option selected disabled>Selecciona un sistema...</option>
							</select>
						</div>
						<div class="col-lg-3 col-6 form-group">
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
						<div class="col-lg-3 col-6 form-group">
							<label for="material_electrico">Material eléctrico</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">$</span>
								</div>
								<select id="material_electrico" class="form-control" disabled>
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
							<label for="instalacion">Instalación</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">$</span>
								</div>
								<select id="instalacion" class="form-control" disabled>
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
							<div class="chart-container d-none" id="contenedor_roi" style="position: relative; height:400px; width:90%; margin:auto">
								<canvas id="grafica_roi"></canvas>
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
					<div class="form-row mt-4">
						<div class="col-sm-6 form-group">
							<button class="btn btn-success btn-block" id="generar_cotizacion">Generar cotización</button>
						</div>
						<div class="col-sm-6 form-group">
							<button class="btn btn-danger btn-block" id="reiniciar_cotizacion">Reiniciar cotización</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('include/scripts');  ?>
		<script src="<?= base_url() ?>static/js/cotizador/cotizador_empleado.js"></script>
	</body>
</html>