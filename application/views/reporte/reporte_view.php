<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=1024">
		<link rel="stylesheet" href="<?= base_url() ?>static/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?= base_url() ?>static/css/reporte.css">
		<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>/img/favicon.png">
		<title>Cotización generada</title>
		<style type="text/css">
			@media print { body { -webkit-print-color-adjust: exact; } }
		</style>
		<script>
			var base_url = "<?= base_url() ?>";
			var total = <?=$cotizacion->total?>;
			var id_cotizacion = <?=$cotizacion->id_cotizacion?>;
			var fecha_cotizacion = "<?=$cotizacion->fecha_cotizacion?>";
		</script>
	</head>
	<body>
		<div id="overlay" class="d-none">
			<div id="spinner"></div>
		</div>
		<div class="container pb-2">
			<div class="row mb-2 mt-2">
				<div class="col-6">
					<img src="<?= base_url() ?>/img/logoazul.png" width="115" height="100">
				</div>
				<div class="col-6 text-right">
					<span class="font-weight-bold texto-azul">Energía solar</span>
				</div>
			</div>
			<nav class="p-2" style="background:#003749;">
				<span class="navbar-text" style="color:#FFFFFF">
					<h2><?=$cotizacion->nombre?></h2>
					<center>Juntos somos energía</center>
				</span>
			</nav>
			<nav class="fondo-azul">
				<div class="row h-100 p-2 no-gutters" style="color:#05405F">
					<div class="col-5">
						Propuesta personalizada<br>
						<b>Ubicada en</b> <?=$cotizacion->ubicacion?><br>
						<b>Asesor comercial:</b> <?=$cotizacion->nombre_asesor?>
					</div>
					<div class="col-4">
						<b>Correo:</b> <?=$cotizacion->correo?><br>
						<b>No. de servicio:</b> <?=$cotizacion->numero_servicio?><br>
						<b>Teléfono:</b> <?=$cotizacion->telefono?>
					</div>
					<div class="col-3 my-auto">
						<div class="w-100 text-right">
							<label for="vigencia">
								Vigencia de cotización: 
							</label>
							<select class="ml-1 custom-select" style="width:auto" id="dias_vigencia">
								<option value="1">1 días</option>
								<option value="2">2 días</option>
								<option value="3">3 días</option>
								<option value="4">4 días</option>
								<option value="5">5 días</option>
								<option value="6">6 días</option>
								<option value="7">7 días</option>
								<option value="8">8 días</option>
								<option value="9">9 días</option>
								<option value="10">10 días</option>
								<option value="11">11 días</option>
								<option value="12">12 días</option>
								<option value="13">13 días</option>
								<option value="14">14 días</option>
								<option value="15">15 días</option>
							</select>
							
						</div>
						<div class="w-100 text-right" id="vigencia_1"></div>
					</div>
				</div>
			</nav>
			<div class="row no-gutters p-2 fondo-gris mb-2 text-center">
				<div class="col-4 text-left">
					<h3>Diagnóstico</h3>
				</div>
				<div class="col-2 my-auto">
					<span class="text-amarillo">
						Diagnóstico
					</span>
				</div>
				<div class="col-2 my-auto">
					<span>
						Propuesta
					</span>
				</div>
				<div class="col-2 my-auto">
					<span>
						Cotización
					</span>
				</div>
				<div class="col-2 my-auto">
					<span>
						Pago
					</span>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<h4>Diagnóstico de servicio</h4>
					<hr style="background:#FEDE2F">
				</div>
			</div>
			<div class="row no-gutters text-center mb-4">
				<div class="col-3 text-white fondo-azul-oscuro d-flex justify-content-center align-items-center">
					<div style="font-size: large">Consumo <br>promedio (kWh)</div>
				</div>
				<div class="col-3 fondo-azul text-dark d-flex justify-content-center align-items-center pr-md-1">
					<div style="font-size: large"><?=number_format($cotizacion->consumo_promedio_kwh, 2)?> (kWh)</div>
				</div>
				<div class="col-3 text-white fondo-azul-oscuro d-flex justify-content-center align-items-center pl-md-1">
					<div style="font-size: large">Consumo <br>promedio ($)</div>
				</div>
				<div class="col-3 fondo-azul text-dark d-flex justify-content-center align-items-center">
					<div style="font-size: large">$ <?=number_format($cotizacion->consumo_promedio_precio, 2)?></div>
				</div>
			</div>
			<?php 
				if($cotizacion->forma_calculo == "recibo") { ?>
					<div class="row" style="margin-top:10px">
						<div class="col-xs-12">
							<div style="margin-left:auto margin-right:auto">
								<center><img width="80%" src="<?=$cotizacion->grafica_consumo?>"></center>
							</div>
						</div>
					</div>
			<?
				}
			?>
			<div class="row no-gutters p-2 fondo-gris mb-2 text-center mt-4">
				<div class="col-4 text-left">
					<h3>Propuesta y análisis</h3>
				</div>
				<div class="col-2 my-auto">
					<span>
						Diagnóstico
					</span>
				</div>
				<div class="col-2 my-auto">
					<span class="text-amarillo">
						Propuesta
					</span>
				</div>
				<div class="col-2 my-auto">
					<span>
						Cotización
					</span>
				</div>
				<div class="col-2 my-auto">
					<span>
						Pago
					</span>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<h4>Información del sistema</h4>
					<hr style="background:#FEDE2F">
				</div>
			</div>
			<div class="row no-gutters text-center mb-2">
				<div class="col-3 text-white fondo-azul-oscuro d-flex justify-content-center align-items-center">
					<div style="font-size: large">Número de <br>paneles</div>
				</div>
				<div class="col-3 fondo-azul text-dark d-flex justify-content-center align-items-center pr-md-1">
					<div style="font-size: large"><?=$cotizacion->num_paneles?></div>
				</div>
				<div class="col-3 text-white fondo-azul-oscuro d-flex justify-content-center align-items-center pl-md-1">
					<div style="font-size: large">Producción <br>anual</div>
				</div>
				<div class="col-3 fondo-azul text-dark d-flex justify-content-center align-items-center">
					<div style="font-size: large"><?=$cotizacion->produccion_anual?> kWh</div>
				</div>
			</div>
			<div class="row no-gutters text-center mb-4">
				<div class="col-3 text-white fondo-azul-oscuro d-flex justify-content-center align-items-center">
					<div style="font-size: large">Porcentaje <br>de ahorro</div>
				</div>
				<div class="col-3 fondo-azul text-dark d-flex justify-content-center align-items-center pr-md-1">
					<div style="font-size: large"><?=$cotizacion->porcentaje_produccion?> %</div>
				</div>
				<div class="col-3 text-white fondo-azul-oscuro d-flex justify-content-center align-items-center pl-md-1">
					<div style="font-size: large">Producción <br><?=$cotizacion->periodo?></div>
				</div>
				<div class="col-3 fondo-azul text-dark d-flex justify-content-center align-items-center">
					<div style="font-size: large"><?=$cotizacion->produccion_periodo?> kWh</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<h4>Ahorros estimados</h4>
					<hr style="background:#FEDE2F">
				</div>
			</div>
			<table class="table text-center tabla-azul">
				<thead>
					<th>Periodo</th>
					<th>Pago actual sin paneles</th>
					<th class="text-amarillo">Cargo fijo CFE</th>
					<th>Ahorro con AAMPERIA</th>
				</thead>
				<tbody>
					<tr>
						<th>Bimestral</th>
						<td>$ <?=number_format($ahorro[0]->actual,2)?></td>
						<td>$ <?=number_format($ahorro[0]->con_aamperia,2)?></td>
						<td>$ <?=number_format($ahorro[0]->ahorro,2)?></td>
					</tr>
					<tr>
						<th>1 año</th>
						<td>$ <?=number_format($ahorro[1]->actual,2)?></td>
						<td>$ <?=number_format($ahorro[1]->con_aamperia,2)?></td>
						<td>$ <?=number_format($ahorro[1]->ahorro,2)?></td>
					</tr>
					<tr>
						<th>5 años</th>
						<td>$ <?=number_format($ahorro[2]->actual,2)?></td>
						<td>$ <?=number_format($ahorro[2]->con_aamperia,2)?></td>
						<td>$ <?=number_format($ahorro[2]->ahorro,2)?></td>
					</tr>
					<tr>
						<th>10 años</th>
						<td>$ <?=number_format($ahorro[3]->actual,2)?></td>
						<td>$ <?=number_format($ahorro[3]->con_aamperia,2)?></td>
						<td>$ <?=number_format($ahorro[3]->ahorro,2)?></td>
					</tr>
					<tr>
						<th>25 años</th>
						<td>$ <?=number_format($ahorro[4]->actual,2)?></td>
						<td>$ <?=number_format($ahorro[4]->con_aamperia,2)?></td>
						<td>$ <?=number_format($ahorro[4]->ahorro,2)?></td>
					</tr>
				</tbody>
			</table>
			<?php if($cotizacion->mostrar_roi == "si") { ?>
				<div class="row" style="margin-top:10px">
					<div class="col-xs-12">
						<div style="margin-left:auto margin-right:auto">
							<center><img width="80%" src="<?=$cotizacion->grafica_roi?>"></center>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="row no-gutters p-2 fondo-gris mb-4 text-center mt-4">
				<div class="col-4 text-left">
					<h3>Cotización</h3>
				</div>
				<div class="col-2 my-auto">
					<span>
						Diagnóstico
					</span>
				</div>
				<div class="col-2 my-auto">
					<span>
						Propuesta
					</span>
				</div>
				<div class="col-2 my-auto">
					<span class="text-amarillo">
						Cotización
					</span>
				</div>
				<div class="col-2 my-auto">
					<span>
						Pago
					</span>
				</div>
			</div>
			<table class="table text-center tabla-azul">
				<thead>
					<th>Sistema</th>
					<th>Cantidad</th>
					<th>P. Unitario</th>
					<th>Importe</th>
				</thead>
				<tbody>
					<? 
					foreach($productos as $producto) {
					?>
						<tr>
							<th><?=$producto['datos_producto']['producto']?></th>
							<td><?=$producto['cantidad']?></td>
							<td>$ <?=number_format($producto['precio_unitario'],2)?></td>
							<td>$ <?=number_format($producto['precio_final'],2)?></td>
						</tr>
					<?
						}
					?>
				</tbody>
			</table>
			<div class="row text-center">
				<div class="col-6 my-auto">
					<div class="fondo-azul-oscuro text-white">
						<h2><?php echo ($cotizacion->mostrar_roi == "si") ? "Retorno de inversión" : "" ?></h2>
					</div>
					<h1><?php echo ($cotizacion->mostrar_roi == "si") ? $cotizacion->retorno_inversion." años" : "" ?></h1>
				</div>
				<div class="col-6">
					<table class="table table-borderless tabla-totales font-weight-bold">
						<tbody>
							<tr>
								<td>SUBTOTAL</td>
								<td>$ <?=number_format($cotizacion->subtotal,2)?></td>
							</tr>
							<tr>
								<td>IVA</td>
								<td>$ <?=number_format($cotizacion->iva,2)?></td>
							</tr>
							<tr>
								<td>TOTAL</td>
								<td>$ <?=number_format($cotizacion->total,2)?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row no-gutters p-2 fondo-gris mb-4 text-center mt-4">
				<div class="col-4 text-left">
					<h3>Pago</h3>
				</div>
				<div class="col-2 my-auto">
					<span>
						Diagnóstico
					</span>
				</div>
				<div class="col-2 my-auto">
					<span>
						Propuesta
					</span>
				</div>
				<div class="col-2 my-auto">
					<span>
						Cotización
					</span>
				</div>
				<div class="col-2 my-auto">
					<span class="text-amarillo">
						Pago
					</span>
				</div>
			</div>
			<div class="pr-5 pl-5">
				<div class="row">
					<div class="col">
						<h4>Condiciones de pago</h4>
						<hr style="background:#FEDE2F">
					</div>
				</div>
				<div class="row text-center condiciones-pago mb-2">
					<div class="col-6 fondo-azul-oscuro text-white">
						Anticipo
					</div>
					<div class="col-3">
						<div class="input-group">
							<input type="number" class="form-control" id="anticipo" value="70" max="100" min="<?=$cotizacion->anticipo_porcentaje?>">
							<div class="input-group-append">
								<span class="input-group-text">%</span>
							</div>
						</div>
					</div>
					<div class="col-3 borde-amarillo" id="anticipo-result">
						
					</div>
				</div>
				<div class="row text-center condiciones-pago mb-2">
					<div class="col-6 fondo-azul-oscuro text-white">
						Finalizar la instalación
					</div>
					<div class="col-3">
						<div class="input-group">
							<input type="number" class="form-control" id="fin-instalacion" value="20" max="100" min="0">
							<div class="input-group-append">
								<span class="input-group-text">%</span>
							</div>
						</div>
					</div>
					<div class="col-3 borde-amarillo" id="fin-instalacion-result">
						
					</div>
				</div>
				<div class="row text-center condiciones-pago">
					<div class="col-6 fondo-azul-oscuro text-white">
						Cambio de medidor CFE
					</div>
					<div class="col-3">
						<div class="input-group">
							<input type="number" class="form-control" id="cambio-medidor" value="10" max="100" min="0">
							<div class="input-group-append">
								<span class="input-group-text">%</span>
							</div>
						</div>
					</div>
					<div class="col-3 borde-amarillo" id="cambio-medidor-result">
						
					</div>
				</div>
			</div>
			<div class="row mt-4">
				<div class="col">
					<h3>Términos y condiciones</h3>
					<ul class="mb-0">
						<li>Precios en MXN.</li>
						<li>Tipo de cambio: $ <?=number_format($cotizacion->tasa_cambio,2)?></li>
						<li>Vigencia de cotización: <span id="vigencia_2"></span></li>	
						<li>Tiempo de entrega máximo: 
							<select class="custom-select" style="width:auto;" id="tiempo_entrega">
								<option value="1">1 semana</option>
								<option value="2">2 semanas</option>
								<option value="3">3 semanas</option>
								<option value="4" selected>4 semanas</option>
								<option value="5">5 semanas</option>
								<option value="6">6 semanas</option>
								<option value="7">7 semanas</option>
								<option value="8">8 semanas</option>
							</select>
						</li>				
					</ul>
					<div><?=$terminos?></div>
				</div>
			</div>
			<div class="row mt-2 mb-2 d-print-none">
				<div class="col-sm-6">
					<button class="btn btn-success btn-block" id="descargar_cotizacion">Descargar cotización</button>
				</div>
				<div class="col-sm-6">
					<button class="btn btn-danger btn-block" id="cancelar_cotizacion" onclick="cancelar_cotizacion(<?=$cotizacion->id_cotizacion?>)">Cancelar cotización</button>
				</div>
			</div>
		</div>
		<script src="<?= base_url() ?>static/js/jquery.min.js"></script>
		<script src="<?= base_url() ?>static/js/bootstrap.bundle.min.js"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
		<script src="<?= base_url() ?>static/js/utilidades.js"></script>
		<script src="<?= base_url() ?>static/js/reporte/reporte.js"></script>
	</body>
</html>