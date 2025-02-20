$(document).ready(function() {
	$('#terminos').summernote({
		tabsize: 4,
		height: 200,
		minHeight: 200
	});
	  
	cargarDatosGenerales();
	cargarCostosGenerales();
	cargarTasaCambio();
	cargarTarifas();
	cargarTerminos();
	cargarConfiguracionPiepagina();
	
	$('#imagenfooter').on('change', function() { 
	   let fileName = $(this).val().split('\\').pop(); 
	   if(fileName == "") {
		   fileName = "Imagen de pie de página";
		   $("#remover_imagen").attr('disabled', true);
	   }
	   else {
		   $("#remover_imagen").attr('disabled', false);
	   }
	   $(this).next('.custom-file-label').addClass("selected").html(fileName);
	});
	
	$('#remover_imagen').click(function() {
		$("#imagenfooter").val(null);
		$('#imagenfooter_preview').addClass("d-none");
		$('#imagenfooter').next('.custom-file-label').removeClass("selected").html("Imagen de pie de página"); 
		$(this).attr('disabled', true);
	});
	
	$('#form_datos_generales').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'configuracion/guardar_datos_generales',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'Los datos se guardaron correctamente',
						confirmButtonText: 'Aceptar'
					});
					cargarDatosGenerales();
				}
				else{
					swal.fire({
						'icon' : 'error',
						'title' : 'Los datos no se guardaron correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
			}
		});
	});
	
	$('#form_costos_generales').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'configuracion/guardar_costos_generales',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'Los costos se guardaron correctamente',
						confirmButtonText: 'Aceptar'
					});
					cargarDatosGenerales();
				}
				else{
					swal.fire({
						'icon' : 'error',
						'title' : 'Los costos no se guardaron correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
			}
		});
	});
	
	$('#form_dolar').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'configuracion/guardar_tasa_cambio',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'La tasa de cambio se guardó correctamente',
						confirmButtonText: 'Aceptar'
					});
					cargarTasaCambio();
				}
				else{
					swal.fire({
						'icon' : 'error',
						'title' : 'La tasa de cambio no se guardó correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
			}
		});
	});
	
	$('#form_obt_dolar').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'configuracion/guardar_forma_obtencion',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'El tipo de obtención se guardó correctamente',
						confirmButtonText: 'Aceptar'
					});
					cargarTasaCambio();
				}
				else{
					swal.fire({
						'icon' : 'error',
						'title' : 'El tipo de obtención se guardó no se guardó correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
			}
		});
	});
	
	$('#actualizar_dolar').click(function() {
		$.ajax({
			'url' : base_url + 'configuracion/obtener_tasa_dof',
			'type' : 'post',
			'success' : function(obj){
				if(obj['response'] == "OK"){
					var indicadores_dolar = obj['ListaIndicadores'][0];
					if(indicadores_dolar.codIndicador == 31523) {
						var dolar = parseFloat(indicadores_dolar.valor);
						$('#tasa_cambio').val(round(dolar,2));
						swal.fire({
							'icon' : 'success',
							'title' : 'La tasa de cambio se obtuvo correctamente',
							confirmButtonText: 'Aceptar'
						});
					}
					else {
						swal.fire({
							'icon' : 'error',
							'title' : 'El servicio del DOF no está en funcionamiento en este horario',
							confirmButtonText: 'Aceptar'
						});
					}
				}
				else{
					swal.fire({
						'icon' : 'error',
						'title' : 'El servicio del DOF no se encuentra disponible en este momento',
						confirmButtonText: 'Aceptar'
					});
				}
			}
		});
		
		
	});
	
	$('#form_tarifas_cfe').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'configuracion/guardar_tarifas_cfe',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'Las tarifas CFE se guardaron correctamente',
						confirmButtonText: 'Aceptar'
					});
					cargarDatosGenerales();
				}
				else{
					swal.fire({
						'icon' : 'error',
						'title' : 'Las tarifas CFE no se guardaron correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
			}
		});
	});
	
	$('#form_terminos').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'configuracion/guardar_terminos',
			'type' : 'post',
			'data' : {
				'terminos' : $('#terminos').summernote('code')
			},
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'Los términos y condiciones se guardaron correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
				else{
					swal.fire({
						'icon' : 'error',
						'title' : 'Los términos y condiciones no se guardaron correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
			}
		});
	});
	
	$('#form_pie_pagina').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'configuracion/guardar_pie_pagina',
			'type' : 'post',
			'data': new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'Las opciones del pie de página se han guardado correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
				else{
					swal.fire({
						'icon' : 'error',
						'title' : 'No se ha podido guardar la imagen',
						confirmButtonText: 'Aceptar'
					});
				}
			}
		});
	});
	
	$('#pie_pagina').on('change', function() { 
	   verPiepagina(this);
	});
	
	function verPiepagina(input) {
		var id = input.id;
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#pie_pagina_preview').attr('src', e.target.result);
			};

			reader.readAsDataURL(input.files[0]);
		}
	}
	
	function cargarDatosGenerales() {
		$.ajax({
			'url' : base_url + 'configuracion/obtener_datos_generales',
			'type': 'post',
			'datatype' : 'json',
			'success' : function(obj){
				if(obj['resultado'] == true) {
					var datosGenerales = obj['datos_generales'];
					
					$('#hps').val(datosGenerales.hps);
					$('#eficiencia').val(datosGenerales.eficiencia);
					$('#periodo').val(datosGenerales.periodo);
				}
				else {
					Swal.fire('Error al cargar', 'No se pudieron cargar los datos generales.', 'error');
				}
			}
		});
	}

	function cargarCostosGenerales() {
		$.ajax({
			'url' : base_url + 'configuracion/obtener_costos_generales',
			'type': 'post',
			'datatype' : 'json',
			'success' : function(obj){
				if(obj['resultado'] == true) {
					var costosGenerales = obj['costos_generales'];
				
					$('#iva').val(costosGenerales.iva);
					$('#dap').val(costosGenerales.dap);
					$('#indice_utilidad').val(costosGenerales.indice_utilidad);
					$('#costo_referido').val(costosGenerales.costo_referido);
					$('#costo_metro').val(costosGenerales.costo_metro);
				}
				else {
					Swal.fire('Error al cargar', 'No se pudieron cargar los costos generales.', 'error');
				}
			}
		});
	}

	function cargarTasaCambio() {
		$.ajax({
			'url' : base_url + 'configuracion/obtener_tasa_cambio',
			'type': 'post',
			'datatype' : 'json',
			'success' : function(obj){
				if(obj['resultado'] == true) {
					var tasaCambio = obj['tasa_cambio'];
				
					if(tasaCambio.tipo_obtencion == "automatica") {
						$('#tasa_automatica').prop("checked", true);
					}
					else {
						if(tasaCambio.tipo_obtencion == "manual") {
							$('#tasa_manual').prop("checked", true);
						}
					}
					$('#tasa_cambio').val(tasaCambio.tasa_cambio);
					var aviso = "Actualizado el " + tasaCambio.solo_fecha_tasa + " a las " + tasaCambio.solo_hora_tasa;
					$('#aviso_tasa').html(aviso);
				}
				else {
					Swal.fire('Error al cargar', 'No se pudieron cargar los costos generales.', 'error');
				}
			}
		});
	}

	function cargarTarifas() {
		$.ajax({
			'url' : base_url + 'configuracion/obtener_tarifas_cfe',
			'type': 'post',
			'datatype' : 'json',
			'success' : function(obj){
				if(obj['resultado'] == true) {
					var tarifas = obj['tarifas_cfe'];
				
					$('#tarifa_d1').val(tarifas.d1);
					$('#limite_inf_d1').val(tarifas.d1_limite_inferior);
					$('#limite_sup_d1').val(tarifas.d1_limite_superior);
					$('#tarifa_d2').val(tarifas.d2);
					$('#limite_inf_d2').val(tarifas.d2_limite_inferior);
					$('#limite_sup_d2').val(tarifas.d2_limite_superior);
					$('#tarifa_d3').val(tarifas.d3);
					$('#limite_inf_d3').val(tarifas.d3_limite_inferior);
					$('#limite_sup_d3').val(tarifas.d3_limite_superior);
					$('#tarifa_dac').val(tarifas.dac);
					$('#tarifa_pdbt').val(tarifas.pdbt);
					$('#suministro_residencial').val(tarifas.suministro_residencial);
					$('#suministro_comercial').val(tarifas.suministro_comercial);
					if(tarifas.obtencion_cfe == "auto") {
						$('#cfe_automatico').prop("checked", true);
					}
					else {
						if(tarifas.obtencion_cfe == "manual") {
							$('#cfe_manual').prop("checked", true);
						}
					}
					var aviso = "Actualizado el " + tarifas.solo_fecha_cfe + " a las " + tarifas.solo_hora_cfe;
					$('#aviso_cfe').html(aviso);
				}
				else {
					Swal.fire('Error al cargar', 'No se pudieron cargar los costos generales.', 'error');
				}
			}
		});
	}
	
	function cargarTerminos() {
		$.ajax({
			'url' : base_url + 'configuracion/obtener_terminos',
			'type': 'post',
			'datatype' : 'json',
			'success' : function(obj){
				if(obj['resultado'] == true) {
					$('#terminos').summernote('code', obj['terminos']);
				}
				else {
					Swal.fire('Error al cargar', 'No se pudieron cargar los términos.', 'error');
				}
			}
		});
	}
	
	function cargarConfiguracionPiepagina() {
		$.ajax({
			'url' : base_url + 'configuracion/obtener_config_piepagina',
			'type': 'post',
			'datatype' : 'json',
			'success' : function(obj){
				if(obj['resultado'] == true) {
					$('#pie_pagina_opcion').prop('checked', true);
					$('#pie_pagina_preview').attr('src', base_url + 'img/pie_pagina.png');
					$('#descargar_pie_pagina').attr('href', base_url + 'img/pie_pagina.png');
					$('#descargar_pie_pagina').removeClass('disabled');
				}
				else {
					$('#pie_pagina_opcion').prop('checked', false);
					$('#pie_pagina_preview_div').addClass('d-none');
				}
			}
		});
	}
});

