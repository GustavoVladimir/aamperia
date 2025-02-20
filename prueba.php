<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="<?= base_url() ?>static/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>static/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>static/css/reporte.css">
	<title>Reporte</title>
</head>
<body>
	<div class="container-fluid">
		<img src="<?= base_url() ?>/img/logoazul.png" width="115" height="100">
		<nav style="background:#087E88;">
			<span class="navbar-text" style="color:#FFFFFF">
				"Aquí va la variable del nombre"<br>
				<center><img src="<?= base_url() ?>/img/Imagen_1.png" width="196" height="165"></center>
				<center>Juntos somos energía</center>
			</span>
		</nav>
		<nav style="background:#EBF2FA">
				<div class="row">
					<div class="col-10">
						<span class="navbar-text" style="color:#05405F">
						Propuesta personalizada<br>
						Ubicada en "Aquí va la variable de locación"<br>
						Asesor comercial: "Aquí va el ingeniero"
						</span>
					</div>
					<div class="col-2">
						<span>
						vigencia de:
						</span>
						<span style="background: #FEDE2F">
						15 días
						</span>
					</div>
				</div>
		</nav>
		<nav style="background:#EAEAEA">
			<div class="row">
				<div class="col-4">
					<span>
						<b>Propuesta & análisis</b>
					</span>
				</div>
				<div class="col-2">
					<span>
						Diagnóstico
					</span>
				</div>
				<div class="col-2">
					<span style="color:#FEDE2F">
						Propuesta
					</span>
				</div>
				<div class="col-2">
					<span>
						Cotización
					</span>
				</div>
				<div class="col-2">
					<span>
						Pago
					</span>
				</div>
			</div>
		</nav>
		<div class="container">
			<br>
			<h3>Información del sistema</h3>
			<hr style="background:#FEDE2F">
			<div class="row">
				<div class="col-3">
					<nav style="background:#05405F">
						<font size="5" style="color:#FFFFFF">Número de paneles</font>
					</nav>
				</div>
				<div class="col-3">
					<nav style="background:#EBF2FA">
						<font size="5">8</font>
					</nav>
				</div>
				<div class="col-3">
					<nav style="background:#05405F">
						<font size="5" style="color:#FFFFFF">Producción anual<br></font>
					</nav>
				</div>
				<div class="col-3">
					<nav style="background:#EBF2FA">
						<font size="5">4632.01<br></font>
					</nav>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-3">
					<nav style="background:#05405F">
						<font size="5" style="color:#FFFFFF">Tipo de sistema<br></font>
					</nav>
				</div>
				<div class="col-3">
					<nav style="background:#EBF2FA">
						<font size="5">(Austero)<br> Inversor central</font>
					</nav>
				</div>
				<div class="col-3">
					<nav style="background:#05405F">
						<font size="5" style="color:#FFFFFF">Producción bimestral<br></font>
					</nav>
				</div>
				<div class="col-3">
					<nav style="background:#EBF2FA">
						<font size="5">772.00<br></font>
					</nav>
				</div>
			</div>
			<br>
			<h3>Ahorros estimados</h3>
			<hr style="background:#FEDE2F">
			<table class="table table-hover">
				<thead>
					<th>Periodo</th>
					<th>Actual</th>
					<th>Con Aamperia</th>
					<th>Ahorro</th>
				</thead>
				<tbody>
					<tr>
						<td class="tabla-head"><label style="color:#FFFFFF">Bimestral</label></td>
						<td class="tabla-body">$4,415.56 </td>
						<td class="tabla-body">$52.00</td>
						<td class="tabla-body">$4,363.56</td>
					</tr>
					<tr>
						<td class="tabla-head"><label style="color:#FFFFFF">1er Año</label></td>
						<td class="tabla-body">$26,493.36</td>
						<td class="tabla-body">$312.00</td>
						<td class="tabla-body">$26,181.36</td>
					</tr>
					<tr>
						<td class="tabla-head"><label style="color:#FFFFFF">5 años</label></td>
						<td class="tabla-body">$138,447.03 </td>
						<td class="tabla-body">$1,560.00</td>
						<td class="tabla-body">$136,887.03</td>
					</tr>
					<tr>
						<td class="tabla-head"><label style="color:#FFFFFF">10 años</label></td>
						<td class="tabla-body">$306,795.24</td>
						<td class="tabla-body">$3,120.00</td>
						<td class="tabla-body">$303,675.24</td>
					</tr>
					<tr>
						<td class="tabla-head"><label style="color:#FFFFFF">25 años</label></td>
						<td class="tabla-body">$991,246.87</td>
						<td class="tabla-body">$7,800.00</td>
						<td class="tabla-body">$983,446.87</td>
					</tr>
				</tbody>
			</table>
		</div>
		<nav style="background:#EAEAEA">
			<div class="row">
				<div class="col-4">
					<span>
						<b>Propuesta & análisis</b>
					</span>
				</div>
				<div class="col-2">
					<span>
						Diagnóstico
					</span>
				</div>
				<div class="col-2">
					<span>
						Propuesta
					</span>
				</div>
				<div class="col-2">
					<span style="color:#FEDE2F">
						Cotización
					</span>
				</div>
				<div class="col-2">
					<span>
						Pago
					</span>
				</div>
			</div>
		</nav>
		<div class="container">
			<table class="table table-hover">
				<thead>
					<th>Sistema</th>
					<th>Cantidad</th>
					<th>P. Unitario</th>
					<th>Importe</th>
				</thead>
				<tbody>
					<tr>
						<td class="tabla-head"><label style="color:#FFFFFF">Modulo Seraphim 385 W  (Precio por watt)</label></td>
						<td class="tabla-body">8</td>
						<td class="tabla-body">$3,109.04</td>
						<td class="tabla-body">$24,872.36</td>
					</tr>
					<tr>
						<td class="tabla-head"><label style="color:#FFFFFF">Sistema de Monitoreo Envoy IQ ENV-IQ-AM1-240 M</label></td>
						<td class="tabla-body">1</td>
						<td class="tabla-body">$7,851.81</td>
						<td class="tabla-body">$7,851.81</td>
					</tr>
					<tr>
						<td class="tabla-head"><label style="color:#FFFFFF">Fronius Primo 10.0-1 208/240</label></td>
						<td class="tabla-body">1</td>
						<td class="tabla-body">$64,815.03</td>
						<td class="tabla-body">$64,815.03</td>
					</tr>
					<tr>
						<td class="tabla-head"><label style="color:#FFFFFF">-</label></td>
						<td class="tabla-body">1</td>
						<td class="tabla-body">-</td>
						<td class="tabla-body">-</td>
					</tr>
					<tr>
						<td class="tabla-head"><label style="color:#FFFFFF">Material E instalación</label></td>
						<td class="tabla-body">1</td>
						<td class="tabla-body">$16,170.00</td>
						<td class="tabla-body">$16,170.00</td>
					</tr>
					<tr>
						<td class="tabla-head"><label style="color:#FFFFFF">ESTRUCTURA SENCILLA  72 CELDAS</label></td>
						<td class="tabla-body">1</td>
						<td class="tabla-body">$5,236.61</td>
						<td class="tabla-body">$5,236.61</td>
					</tr>
					<tr>
						<td class="tabla-head"><label style="color:#FFFFFF">Medidor de CFE</label></td>
						<td class="tabla-body">1</td>
						<td class="tabla-body">-</td>
						<td class="tabla-body">-</td>
					</tr>
				</tbody>
			</table>
			<div class="row">
				<div class="col-6"><br>
					<nav style="background:#05405F">
						<font size="5" style="color:#FFFFFF">Retorno de inversión<br></font>
					</nav>
					<h1>4 años</h1>
				</div>
				<div class="col-6">
					<nav style="background:#EAEAEA">
						<div class="row">
							<div class="col-6">
								<font size="5">Subtotal<br></font>
							</div>
							<div class="col-6">
								<font size="5">$118,945.81<br></font>
							</div>
						</div>
					</nav>
					<nav style="background:#EAEAEA">
						<div class="row">
							<div class="col-6">
								<font size="5">IVA<br></font>
							</div>
							<div class="col-6">
								<font size="5">$19,031.33<br></font>
							</div>
						</div>
					</nav>
					<nav style="background:#EAEAEA">
						<div class="row">
							<div class="col-6">
								<font size="5">Total<br></font>
							</div>
							<div class="col-6">
								<font size="5">$137,977.14<br></font>
							</div>
						</div>
					</nav>
				</div>
			</div>
		</div>
		<nav style="background:#EAEAEA">
			<div class="row">
				<div class="col-4">
					<span>
						<b>Propuesta & análisis</b>
					</span>
				</div>
				<div class="col-2">
					<span>
						Diagnóstico
					</span>
				</div>
				<div class="col-2">
					<span>
						Propuesta
					</span>
				</div>
				<div class="col-2">
					<span>
						Cotización
					</span>
				</div>
				<div class="col-2">
					<span style="color:#FEDE2F">
						Pago
					</span>	
				</div>
			</div>
		</nav>
		<br>
		<h3>Condiciones de pago</h3>
		<hr style="background:#FEDE2F">
		<div class="container">
			<div class="row">
				<div class="col-6">
					<nav style="background:#05405F">
						<font size="5" style="color:#FFFFFF">Anticipo<br></font>
					</nav>
				</div>
				<div class="col-3">
					<nav style="background:#EBF2FA;">
						<font size="5">65%<br></font>
					</nav>
				</div>
				<div class="col-3">
					<nav style="background:#EBF2FA;">
						<font size="5">$ - <br></font>
					</nav>
				</div>
			</div><br>
			<div class="row">
				<div class="col-6">
					<nav style="background:#05405F">
						<font size="5" style="color:#FFFFFF">Finalizar la Instalación<br></font>
					</nav>
				</div>
				<div class="col-3">
					<nav style="background:#EBF2FA;">
						<font size="5">30%<br></font>
					</nav>
				</div>
				<div class="col-3">
					<nav style="background:#EBF2FA;">
						<font size="5">$ - <br></font>
					</nav>
				</div>
			</div><br>
			<div class="row">
				<div class="col-6">
					<nav style="background:#05405F">
						<font size="5" style="color:#FFFFFF">Cambio de medidor CFE<br></font>
					</nav>
				</div>
				<div class="col-3">
					<nav style="background:#EBF2FA;">
						<font size="5">5%<br></font>
					</nav>
				</div>
				<div class="col-3">
					<nav style="background:#EBF2FA;">
						<font size="5">$ - <br></font>
					</nav>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="chart-container" id="contenedor_grafica" style="position: relative;  width:90%; margin:auto">
					<canvas id="grafica_tarifa"></canvas>
				</div>
			</div>
		</div>
		<p>
			Términos<br>
			*Precio en MXN<br>
			*Tipo de cambio 	20.1227<br>
			*Vigencia de cotización <br>					
			*No Incluye obra civil en caso de ser requerido en la instalación<br>					
			*Aammperia no se hace responsable de variaciones de voltaje existentes 	<br>				
			*Tiempo de entrega máximo<br>
		</p>
		<script src="<?= base_url() ?>static/js/jquery.min.js"></script>
		<script src="<?= base_url() ?>static/js/chart.min.js"></script>
		<script src="<?= base_url() ?>static/js/chartjs-plugin-annotation.min.js"></script>
		<script src="<?= base_url() ?>static/js/bootstrap.bundle.min.js"></script>
		<script src="<?= base_url() ?>static/js/pdf.js"></script>
	</div>
</body>
</html>