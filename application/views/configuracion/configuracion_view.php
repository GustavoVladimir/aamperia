<!doctype html>
<html lang="en">
	<head>
		<!-- HEADER (links de CSS y título) -->
		<?php $this->load->view('include/header', $datos_pagina); ?>
		<link rel="stylesheet" href="<?= base_url() ?>/static/css/summernote-bs4.min.css">
	</head>
	<body>
		<div class="wrapper d-flex align-items-stretch">
			<!-- MENU LATERAL -->
			<?php $this->load->view('include/menu_lateral', $datos_pagina);  ?>
			
			<div id="content" class="main mb-4">
				<!-- BARRA SUPERIOR DE USUARIO -->
				<?php $this->load->view('include/barra_superior', $datos_pagina);  ?>

				<div id="contenido" class="container-fluid">
					<div class="row mt-2">
						<div class="col">
							<h2>Configuración general</h2>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col">
							<h4>Datos generales</h4>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<span>
								Estos datos se toman en cuenta para el cálculo de los paneles.
							</span>
						</div>
					</div>
					<form method="post" id="form_datos_generales">
						<div class="form-row">
							<div class="col-sm-3 col-12 form-group">
								<label class="font-weight-bold" for="hps">HPS</label>
								<input type="number" class="form-control" min="0" max="24" step="0.01" id="hps" name="hps" required>
							</div>
							<div class="col-sm-3 col-12 form-group">
								<label class="font-weight-bold" for="eficiencia">Eficiencia</label>
								<div class="input-group mb-2">
									<input type="number" class="form-control" min="0" max="100" step="0.01" id="eficiencia" name="eficiencia" required>
									<div class="input-group-append">
										<div class="input-group-text">%</div>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-12 form-group">
								<label class="font-weight-bold" for="periodo">Periodo (días)</label>
								<!--<input type="number" class="form-control" id="periodo" name="periodo" required>-->
								<select class="form-control" id="periodo" name="periodo" required>
									<option selected disabled>Selecciona una opción</option>
									<option>30</option>
									<option>60</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-3 col-12 form-group">
								<button type="submit" class="btn btn-block btn-success">Guardar</button>
							</div>
						</div>
					</form>
					<div class="row mt-4">
						<div class="col">
							<h4>Costos generales</h4>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<span>
								Estos datos se toman en cuenta para las cotizaciones
							</span>
						</div>
					</div>
					<form method="post" id="form_costos_generales">
						<div class="form-row">
							<div class="col-sm-3 col-6 form-group">
								<label class="font-weight-bold" for="iva">IVA</label>
								<div class="input-group mb-2">
									<input type="number" class="form-control" min="0" max="100" step="0.01" id="iva" name="iva">
									<div class="input-group-append">
										<div class="input-group-text">%</div>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-6 form-group">
								<label class="font-weight-bold" for="dap">DAP</label>
								<div class="input-group mb-2">
									<input type="number" class="form-control" min="0" max="100" step="0.01" id="dap" name="dap">
									<div class="input-group-append">
										<div class="input-group-text">%</div>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-6 form-group">
								<label class="font-weight-bold" for="indice_utilidad">Índice de utilidad</label>
								<div class="input-group mb-2">
									<input type="number" class="form-control" min="0" max="100" step="0.01" id="indice_utilidad" name="indice_utilidad">
									<div class="input-group-append">
										<div class="input-group-text">%</div>
									</div>
								 </div>
							</div>
							<div class="w-100 d-none d-sm-block"></div>
							<div class="col-sm-3 col-6 form-group">
								<label class="font-weight-bold" for="costo_metro">Costo de tubería y cableado</label>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">$/m</div>
									</div>
									<input type="number" class="form-control" min="0" max="10000" id="costo_metro" name="costo_metro">
								 </div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-3 col-12 form-group">
								<button type="submit" class="btn btn-block btn-success">Guardar</button>
							</div>
						</div>
					</form>
					<div class="row mt-4">
						<div class="col">
							<h4>Obtención de tasa de cambio</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-9 col-12">
							<span>
								Puedes cambiar la tasa de cambio del dólar (USD) que se toma en cuenta para todas las cotizaciones.
							</span>
							<br>
						</div>
					</div>
					<form method="post" id="form_dolar">
						<div class="form-row">
							<div class="col-sm-3 col-12 form-group">
								<div class="form-row">
									<div class="col form-group">
										<label for="tasa_cambio" class="font-weight-bold">Tasa de cambio</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">$</div>
											</div>
											<input type="text" class="form-control" id="tasa_cambio" name="tasa_cambio">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-3 col-12 form-group">
								<button type="submit" class="btn btn-block btn-success">Guardar</button>
							</div>
						</div>
					</form>
					<div class="row mt-4">
						<div class="col">
							<h4>Obtención de tarifas de CFE</h4>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-sm-9 col-12">
							<span>
								Se pueden obtener las tarifas de CFE de manera manual en los siguientes sitios:
							</span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-9 col-12">
							<a class="btn btn-primary" href="https://app.cfe.mx/Aplicaciones/CCFE/Tarifas/TarifasCRECasa/Tarifas/Tarifa1.aspx" role="button" target="_blank">Tarifas 01</a>
							<a class="btn btn-primary" href="https://app.cfe.mx/Aplicaciones/CCFE/Tarifas/TarifasCRECasa/Tarifas/TarifaDAC.aspx" role="button" target="_blank">Tarifas DAC</a>
							<a class="btn btn-primary" href="https://app.cfe.mx/Aplicaciones/CCFE/Tarifas/TarifasCRENegocio/Tarifas/PequenaDemandaBT.aspx" role="button" target="_blank">Tarifas PDBT</a>
						</div>
					</div>
					<form method="post" id="form_tarifas_cfe">
						<div class="form-row mt-2">
							<div class="col">
								<h5>Tarifas 01</h5>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-3 col-12">
								<label class="font-weight-bold" for="tarifa_d1">Tarifa D1</label>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">$</div>
									</div>
									<input type="number" class="form-control" min="0" max="100" step="0.001" id="tarifa_d1" name="d1">
								</div>
							</div>
							<div class="col-sm-3 col-6">
								<label class="font-weight-bold" for="limite_inf_d1">Limite inferior</label>
								<div class="input-group mb-2">
									<input type="text" class="form-control" id="limite_inf_d1" name="d1_limite_inferior">
									<div class="input-group-append">
										<div class="input-group-text">kWh</div>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-6">
								<label class="font-weight-bold" for="limite_sup_d1">Limite superior</label>
								<div class="input-group mb-2">
									<input type="text" class="form-control" id="limite_sup_d1" name="d1_limite_superior">
									<div class="input-group-append">
										<div class="input-group-text">kWh</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-3 col-12">
								<label class="font-weight-bold" for="tarifa_d2">Tarifa D2</label>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">$</div>
									</div>
									<input type="number" class="form-control" min="0" max="100" step="0.001" id="tarifa_d2" name="d2">
								</div>
							</div>
							<div class="col-sm-3 col-6">
								<label class="font-weight-bold" for="limite_inf_d2">Limite inferior</label>
								<div class="input-group mb-2">
									<input type="number" class="form-control" id="limite_inf_d2" name="d2_limite_inferior">
									<div class="input-group-append">
										<div class="input-group-text">kWh</div>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-6">
								<label class="font-weight-bold" for="limite_sup_d2">Limite superior</label>
								<div class="input-group mb-2">
									<input type="text" class="form-control" id="limite_sup_d2" name="d2_limite_superior">
									<div class="input-group-append">
										<div class="input-group-text">kWh</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-3 col-12">
								<label class="font-weight-bold" for="tarifa_d3">Tarifa D3</label>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">$</div>
									</div>
									<input type="text" class="form-control" min="0" max="100" step="0.001" id="tarifa_d3" name="d3">
								</div>
							</div>
							<div class="col-sm-3 col-6">
								<label class="font-weight-bold" for="limite_inf_d3">Limite inferior</label>
								<div class="input-group mb-2">
									<input type="number" class="form-control" id="limite_inf_d3" min="0" max="10000" name="d3_limite_inferior">
									<div class="input-group-append">
										<div class="input-group-text">kWh</div>
									</div>
								 </div>
							</div>
							<div class="col-sm-3 col-6">
								<label class="font-weight-bold" for="limite_sup_d3">Limite superior</label>
								<div class="input-group mb-2">
									<input type="text" class="form-control" id="limite_sup_d3" min="0" max="10000" name="d3_limite_superior">
									<div class="input-group-append">
										<div class="input-group-text">kWh</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="col">
								<h5>Tarifas DAC y PDBT</h5>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-3 col-6">
								<label class="font-weight-bold" for="tarifa_dac">Tarifa DAC</label>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">$</div>
									</div>
									<input type="number" class="form-control" min="0" max="100" step="0.001" id="tarifa_dac" name="dac">
								</div>
							</div>
							<div class="col-sm-3 col-6">
								<label class="font-weight-bold" for="tarifa_pdbt">Tarifa PDBT</label>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">$</div>
									</div>
									<input type="number" class="form-control" min="0" max="100" step="0.001" id="tarifa_pdbt" name="pdbt">
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="col">
								<h5>Costo de suministro</h5>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-3 col-6">
								<label class="font-weight-bold" for="suministro_residencial">Suministro residencial</label>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">$</div>
									</div>
									<input type="number" class="form-control" id="suministro_residencial" min="0" max="500" step="0.001" name="suministro_residencial">
								</div>
							</div>
							<div class="col-sm-3 col-6">
								<label class="font-weight-bold" for="suministro_comercial">Suministro comercial</label>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">$</div>
									</div>
									<input type="text" class="form-control" id="suministro_comercial" min="0" max="500" step="0.001" name="suministro_comercial">
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="col-sm-3 col-12 form-group">
								<button type="submit" class="btn btn-success btn-block">Guardar</button>
							</div>
						</div>
					</form>
					<div class="row mt-4">
						<div class="col">
							<h4>Términos y condiciones de las cotizaciones</h4>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-sm-9 col-12">
							<span>
								Aquí se pueden ingresar los términos y condiciones que aplicarán a todas las cotizaciones generadas.
							</span>					
						</div>
					</div>
					<form method="post" id="form_terminos">
						<div class="form-row">
							<div class="col-sm-9 col-12">
								<div id="terminos"></div>				
							</div>
						</div>
						<div class="form-row mt-3 mb-4">
							<div class="col-sm-3 col-12 form-group">
								<button type="submit" class="btn btn-success btn-block">Guardar términos</button>
							</div>
						</div>
					</form>
					<div class="row mt-4">
						<div class="col">
							<h4>Pie de página de cotizaciones</h4>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-sm-9 col-12">
							<span>
								Elige la imagen de contacto que aparecerá en todas las cotizaciones generadas.<br>
								<b>El tamaño de la imagen de preferencia debe ser de 1200x200 pixeles en formato PNG.</b>
							</span>
						</div>
					</div>
					<form method="post" enctype="multipart/form-data" id="form_pie_pagina">
						<div class="form-row mb-2">
							<div class="col-sm-9 col-12">
								<div class="form-check">
									<input type="checkbox" class="form-check-input" id="pie_pagina_opcion" name="pie_pagina_opcion">
									<label class="form-check-label" for="pie_pagina_opcion">Habilitar pie de página</label>
								</div>
							</div>
						</div>
						<div class="custom-file col-sm-9 col-12">
							<input type="file" class="subir-imagen custom-file-input" name="pie_pagina" id="pie_pagina" aria-describedby="fileHelp" accept="image/x-png">
							<label class="subir-imagen-label custom-file-label" for="pie_pagina">
								Imagen de pie de página
							</label>
						</div>
						<div class="form-row mt-3 mb-4" id="pie_pagina_preview_div">
							<div class="col-12">
								<img id="pie_pagina_preview" class="img-fluid"></img>
							</div>
						</div>
						<div class="form-row mt-3 mb-4">
							<div class="col-sm-3 col-12 form-group">
								<button type="submit" class="btn btn-success btn-block">Guardar pie de página</button>
							</div>
							<div class="col-sm-3 col-12 form-group">
								<button id="remover_pie_pagina" class="btn btn-danger btn-block" disabled>Remover imagen</button>
							</div>
							<div class="col-sm-3 col-12 form-group">
								<a id="descargar_pie_pagina" class="btn btn-primary btn-block disabled" href="" role="button" disabled download>Descargar imagen</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<!-- SCRIPTS DE JS -->
		<?php $this->load->view('include/scripts');  ?>
		<script src="<?= base_url() ?>/static/js/summernote-bs4.min.js"></script>
		<script src="<?= base_url() ?>/static/js/configuracion/configuracion.js"></script>
	</body>
</html>