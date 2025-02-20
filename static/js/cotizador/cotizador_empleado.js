$(document).ready( function() {		
	$(window).on('beforeunload', function() {
		$(window).scrollTop(0);
	});
	
	$.ajaxSetup({
		'error' : function(xhr){
			Swal.fire({
				'icon' : 'error',
				'title' : 'Error en el servidor',
				'html' : '<b>Mensaje técnico:</b><br>' +
						 '<p>' + xhr.status + ' ' + xhr.statusText + '</p>',
				confirmButtonText: 'Aceptar'
			});
			$('#overlay').addClass('d-none');
		}
	});

	/** VARIABLES DE AYUDA **/
	const fecha = new Date();
	var grafica_consumo;
	var grafica_roi;
	var grafica_consumo_fija;
	var cambiando_indice = false;
	var indice_correcto = false;
	var indice_numerico;
	var signo_grafica = 1;

	/** VARIABLES DE DATOS PARA COTIZAR **/
	var tarifas_cfe;
	var tasa_cambio;
	var datos_generales;
	var tarifa_cambio = 0;
	var dap = 0.0;
	var indice_utilidad = 0;
	var iva = 0.0;
	var hps = 0;
	var eficiencia = 0;
	var periodo_dias = 60;
	
	/** VARIABLES DE OPERACION **/
	var periodo = "";
	var consumo_total_kwh = 0.0;
	var consumo_total_pesos = 0.0;
	var tipo_interconexion = "";
	var pagos_anuales_con_paneles = new Array(25);
	var pagos_anuales_sin_paneles = new Array(25);
	var productos_cotizacion = new Array();
	
	for(var d=0; d<25; d++) {
		pagos_anuales_con_paneles[d] = 0;
		pagos_anuales_sin_paneles[d] = 0;
	}
	
	var datos_cotizacion = {
		asesor : "",
		id_asesor : id_usuario,
		nombre_usuario : "",
		ubicacion : "",
		telefono : "",
		correo: "",
		num_servicio : "",
		fecha_cotizacion : "",
		tasa_cambio : 0
	};

	var datos_consumo = {
		suministro : 0,
		tarifa : "",
		forma_calculo: "",
		periodo : "bimestral",
		consumo_promedio_kwh :  0,
		consumo_promedio_pesos : 0,
		gasto_bimestral : 0,
		gasto_anual : 0
	};
	
	var datos_sistema = {
		tipo_interconexion : "",
		num_paneles : 0,
		ahorro : 0,
		produccion_promedio : 0,
		produccion_anual : 0
	};
	
	var paneles = {
		estado : false,
		producto : "",
		codigo : "",
		costo_mxn : 0,
		usd_watt : 0,
		watt_panel : 0,
		kw_panel : 0,
		produccion_panel : 0,
		potencia_total : 0,
		num_paneles : 0,
		costo_total : 0,
		precio_final : 0
	};
	
	var estructuras = new Array();
	
	var inversor = {
		estado : false,
		producto : "",
		codigo : "",
		cantidad: 1,
		costo_usd : 0,
		costo_mxn : 0,
		costo_total : 0,
		precio_final : 0
	};
	
	var microinversores = {
		estado : false,
		producto : "",
		codigo : "",
		cantidad : 0,
		costo_usd : 0,
		costo_mxn : 0,
		costo_total : 0,
		precio_final : 0
	};
	
	var optimizadores = {
		estado : false,
		producto : "",
		codigo : "",
		cantidad : 0,
		costo_usd : 0,
		costo_mxn : 0,
		costo_total : 0,
		precio_final : 0
	};
	
	var sistema_monitoreo = {
		estado : false,
		producto : "",
		codigo : "",
		cantidad : 1,
		costo_usd : 0,
		costo_mxn : 0,
		costo_total : 0,
		precio_final : 0
	};
	
	var instalacion_electrica = {
		estado : false,
		cantidad: 1,
		metros_tuberia : 0,
		costo_metro : 0,
		costo_tuberia : 0,
		material_eletrico : 0,
		instalacion : 0,
		costo_total : 0,
		precio_final : 0
	};
	
	var datos_ahorro = new Array();
	
	var totales_cotizacion = {
		costo_panel : 0,
		usd_watt : 0,
		costo_proyecto_proveedores : 0,
		iva_proveedores : 0,
		utilidad : 0,
		iva_final : 0,
		costo_proyecto_iva : 0,
		costo_proyecto_utilidad : 0,
		costo_final : 0,
		retorno_inversion : 0,
		porcentaje_minimo: 0
	};
	
	$('#fecha').val(fecha.getFullYear() + '-' + ('0' + (fecha.getMonth()+1)).slice(-2) + '-' + ('0' + fecha.getDate()).slice(-2));
	datos_cotizacion.fecha_cotizacion = $('#fecha').val();
	
	$("#num_paneles").inputSpinner();
	$("#cantidad_estructura_1").inputSpinner();
	$("#cantidad_microinversor").inputSpinner();
	$("#cantidad_optimizador").inputSpinner();
	
	grafica_consumo = new Chart($('#grafica_consumo'), {
		type: 'bar',
		data: {
			labels: ['1 periodo', '2 periodo', '3 periodo', '4 periodo', '5 periodo', '6 periodo'],
			datasets: [{
				data: [0, 0, 0, 0, 0, 0],
				backgroundColor: '#F0A202'
			}]
		},
		options: {
			maintainAspectRatio: false,
			scales: {
				y: {
					grace: '5%',
					beginAtZero: true,
					ticks: {
						font: {
							size: function(context) {
								var width = context.chart.width;
								
								if(width<=320) {
									size = 12;
								}
								else {
									if(width>320 && width<600) {
										size = 16;
									}
									else {
										size = 20;
									}
								}
								//var size = Math.round(width / 32);

								return size;
							},
							weight: "bold"
						}
					},
					grid: {
						display: false
					}
				},
				x: {
					beginAtZero: true,
					ticks: {
						font: {
							size: function(context) {
								var width = context.chart.width;
								
								if(width<=320) {
									size = 12;
								}
								else {
									if(width>320 && width<600) {
										size = 16;
									}
									else {
										size = 20;
									}
								}
								//var size = Math.round(width / 32);

								return size;
							},
							weight: "bold"
						}
					},
					grid: {
						display: false
					}
				}
			},
			plugins: {
				autocolors: false,
				annotation: {
					annotations: {
						line1: {
							display: false,
							type: 'line',
							yMin: 0,
							yMax: 0,
							borderColor: 'rgb(255, 0, 0)',
							borderWidth: 2,
							label: {
								content: "",
								enabled: true,
								yAdjust: function(context) {
									var width = context.chart.width;
									
									if(width<=320) {
										size = -10;
									}
									else {
										if(width>320 && width<600) {
											size = -15;
										}
										else {
											size = -20;
										}
									}
									//var size = Math.round(width / 32);

									return size*signo_grafica;
								},
								backgroundColor: 'rgba(0,0,0,0)',
								color: '#000000',
								font: function(context) {
									var width = context.chart.width;
									
									if(width<=320) {
										size= 12;
									}
									else {
										if(width>320 && width<600) {
											size = 16;
										}
										else {
											size = 20;
										}
									}
									//var size = Math.round(width / 32);

									return {
										size: size
									};
								}
							}
						},
						line2: {
							display: false,
							type: 'line',
							yMin: 0,
							yMax: 0,
							borderColor: 'rgb(146, 208, 80)',
							borderWidth: 2,
							label: {
								content:"",
								enabled: true,
								yAdjust: function(context) {
									var width = context.chart.width;
									
									if(width<=320) {
										size = 10;
									}
									else {
										if(width>320 && width<600) {
											size = 15;
										}
										else {
											size = 20;
										}
									}
									//var size = Math.round(width / 32);

									return size*signo_grafica;
								},
								backgroundColor: 'rgba(0,0,0,0)',
								color: '#000000',
								font: function(context) {
									var width = context.chart.width;
									
									if(width<=320) {
										size= 12;
									}
									else {
										if(width>320 && width<600) {
											size = 16;
										}
										else {
											size = 20;
										}
									}
									//var size = Math.round(width / 32);

									return {
										size: size
									};
								}
							}
						}
					}
				},
				legend: {
					display: false
				},
				tooltip: {
					enabled: false
				},
				title: {
					display: true,
					text: "Gráfica de kWh consumidos",
					font: {
						size: 20
					},
					padding: {
						bottom: 30
					}
				}
			}
		}
	});
	
	grafica_roi = new Chart($('#grafica_roi'), {
		type: 'bar',
		data: {
			labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25'],
			datasets: [{
				label: 'Beneficio obtenido',
				data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
				backgroundColor: '#F0A202'
			}]
		},
		options: {
			maintainAspectRatio: false,
			scales: {
				y: {
					beginAtZero: true,
					ticks: {
						font: {
							size:function(context) {
								var width = context.chart.width;
								
								if(width<=320) {
									size = 12;
								}
								else {
									if(width>320 && width<600) {
										size = 16;
									}
									else {
										size = 20;
									}
								}
								//var size = Math.round(width / 32);

								return size;
							},
							weight: "bold",
						},
						callback: function(value, index, values) {
							return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						}
					},
					grid: {
						display: false
					},
					title: {
						text: 'Ahorro',
						display: true,
						font: {
							size: 24
						}
					}
				},
				x: {
					beginAtZero: true,
					ticks: {
						font: {
							size:function(context) {
								var width = context.chart.width;
								
								if(width<=320) {
									size = 12;
								}
								else {
									if(width>320 && width<600) {
										size = 16;
									}
									else {
										size = 20;
									}
								}
								//var size = Math.round(width / 32);

								return size;
							},
							weight: "bold"
						}
					},
					grid: {
						display: false
					},
					title: {
						text: 'Años',
						display: true,
						font: {
							size: 24
						}
					}
				}
			},
			plugins: {
				autocolors: false,
				legend: {
					display: false
				},
				title: {
					display: true,
					text: "Retorno de inversión",
					font: {
						size: 20
					}
				}
			}
		}
	});
	
	/** LLAMADAS AJAX PARA DATOS INICIALES **/
	$.ajax({
		'url' : base_url + 'cotizacion/obtener_datos_iniciales',
		'type' : 'post',
		'success' : function(obj){
			var estado = true;
			
			if(obj['datos_iniciales'].resultado){
				datos_generales = obj['datos_iniciales'].datos_generales;
				costos_generales = obj['datos_iniciales'].costos_generales;
				tasa_cambio = obj['datos_iniciales'].tasa_cambio;
				tarifas_cfe = obj['datos_iniciales'].tarifas_cfe;
				
				hps = parseFloat(datos_generales.hps);
				eficiencia = parseFloat(datos_generales.eficiencia)/100;
				dap = parseFloat(costos_generales.dap)/100;
				iva = parseFloat(costos_generales.iva)/100;
				indice_utilidad = (100-(parseFloat(costos_generales.indice_utilidad)))/100;
				tarifa_cambio = parseFloat(tasa_cambio.tasa_cambio);
				datos_cotizacion.tasa_cambio = tarifa_cambio;
				instalacion_electrica.costo_metro = parseFloat(costos_generales.costo_metro);
			}
			else {
				Swal.fire('Ocurrió un error', 'No se pudieron cargar los datos iniciales de cotización', 'error');
			}
			
			if(obj['paneles'].resultado){
				$.each(obj['paneles'].paneles, function(i, elemento) {
					$('#tipo_panel').append('<option value=' + elemento.id_panel + '>' + elemento.codigo + '</option>');
				});
			}
			
			if(obj['sistemas_monitoreo'].resultado){
				$.each(obj['sistemas_monitoreo'].sistemas, function(i, elemento) {
					$('#sistema_monitoreo').append('<option value=' + elemento.id_sistema_monitoreo + '>' + elemento.codigo + '</option>');
				});
			}
			
			if(obj['inversores'].resultado){
				$.each(obj['inversores'].inversores, function(i, elemento) {
					$('#inversor_central').append('<option value=' + elemento.id_inversor + '>' + elemento.codigo + '</option>');
				});
			}
			
			if(obj['optimizadores'].resultado){
				$.each(obj['optimizadores'].optimizadores, function(i, elemento) {
					$('#optimizador').append('<option value=' + elemento.id_optimizador + '>' + elemento.codigo + '</option>');
				});
			}
			
			if(obj['microinversores'].resultado){
				$.each(obj['microinversores'].microinversores, function(i, elemento) {
					$('#microinversor').append('<option value=' + elemento.id_microinversor + '>' + elemento.codigo + '</option>');
				});
			}
			
			if(obj['tipos_estructura'].resultado){
				$.each(obj['tipos_estructura'].tipos, function(i, elemento) {
					$('#tipo_estructura_1').append('<option value=' + elemento.id_tipo_estructura + '>' + elemento.codigo + '</option>');
				});
			}
			
			if(!obj['actualizar_dolar'].resultado){
				if(obj['actualizar_dolar'].tipo_obtencion == 'automatica') {
					$('#alerta').addClass('alert-warning');
					$('#alerta span:first').html(obj['actualizar_dolar'].mensaje);
					$('#alerta').removeClass('d-none');
				}
				else {
					$('#alerta').addClass('alert-info');
					$('#alerta span:first').html(obj['actualizar_dolar'].mensaje);
					$('#alerta').removeClass('d-none');
				}
			}
		}
	});
	/** LLAMADAS AJAX PARA DATOS **/
	
	$('#nombre_usuario').on('input', function() {
		datos_cotizacion.nombre_usuario = $(this).val();
		if(!datos_cotizacion.nombre_usuario) {
			$(this).addClass('is-invalid');
		}
		else {	
			$(this).removeClass('is-invalid');
		}
	});
	
	$('#ubicacion').on('input', function() {
		datos_cotizacion.ubicacion = $(this).val();
	});
	
	$('#telefono').on('input', function() {
		datos_cotizacion.telefono = $(this).val();
		if(!datos_cotizacion.telefono) {
			$(this).addClass('is-invalid');
		}
		else {	
			$(this).removeClass('is-invalid');
		}
	});
	
	$('#correo').on('input', function() {
		datos_cotizacion.correo = $(this).val();
	});
	
	$('#num_servicio').on('input', function() {
		datos_cotizacion.num_servicio = $(this).val();
	});
	
	$('#fecha').on('input', function() {
		datos_cotizacion.fecha_cotizacion = $(this).val();
		if(!datos_cotizacion.fecha_cotizacion) {
			$(this).addClass('is-invalid');
		}
		else {	
			$(this).removeClass('is-invalid');
		}
	});

	$('#forma_calculo').change(function() {
		datos_consumo.forma_calculo = $(this).val();
		$(this).removeClass('is-invalid');
		
		if(datos_consumo.forma_calculo == "recibo") {
			$('#periodos').removeClass('d-none');
		}
		else {
			$('#periodos').addClass('d-none');
		}
		limpiar_inputs();
	});
	
	$('#periodo_1, #periodo_2, #periodo_3, #periodo_4, #periodo_5, #periodo_6').on('input', function() {
		var vacios = false;
		var suma_auxiliar = 0;
		var nuevos_datos = [];
		var promedio_consumo = 0;
		
		for(var i=1; i<=6; i++) {
			if($('#periodo_' + i).val() == "") {
				vacios = true;
			}
			else {
				suma_auxiliar += parseFloat($('#periodo_' + i).val());
				nuevos_datos.push(parseFloat($('#periodo_' + i).val()));
				$('#periodo_' + i).removeClass('is-invalid');
			}
		}
		
		if(nuevos_datos.length > 0) {
			if(!vacios) {
				promedio_consumo = round(suma_auxiliar/6, 2);
				$('#consumo_promedio_kwh').val(promedio_consumo).trigger("input");;
			}
			grafica_consumo.data.datasets[0].data = nuevos_datos;
			grafica_consumo.options.plugins.annotation.annotations.line1.yMin = promedio_consumo;
			grafica_consumo.options.plugins.annotation.annotations.line1.yMax = promedio_consumo;
			grafica_consumo.options.plugins.annotation.annotations.line1.display = true;
			grafica_consumo.options.plugins.annotation.annotations.line1.label.content = "Promedio de consumo: " + promedio_consumo + " kWh";
			grafica_consumo.update();
			grafica_consumo_fija = grafica_consumo;
		}
	});
	
	$('#tarifa').change(function() {
		datos_consumo.tarifa = $(this).val();
		$(this).removeClass('is-invalid');
		limpiar_inputs();
	});
	
	$('#periodo').change(function() {
		periodo = $(this).val();
		if(periodo == 'bimestral') {
			periodo_dias = 60;
			$("label[for='consumo_promedio_kwh']").text("Consumo promedio bimestral (kWh)");
			$("label[for='consumo_promedio_precio']").text("Consumo promedio bimestral ($)");
			$("label[for='produccion_promedio']").text("Producción bimestral");
			$('#periodo_tabla th').html("Bimestral");
			datos_consumo.periodo = "bimestral";
		}
		else {
			periodo_dias = 30;
			$("label[for='consumo_promedio_kwh']").text("Consumo promedio mensual (kWh)");
			$("label[for='consumo_promedio_precio']").text("Consumo promedio mensual ($)");
			$("label[for='produccion_promedio']").text("Producción mensual");
			$('#periodo_tabla th').html("Mensual");
			datos_consumo.periodo = "mensual";
		}
		limpiar_inputs();
	});

	function limpiar_inputs() {
		if(!$('#forma_calculo option:selected').prop("disabled") && !$('#tarifa option:selected').prop("disabled")) {
			$('#periodo_1, #periodo_2, #periodo_3, #periodo_4, #periodo_5, #periodo_6, #consumo_promedio_kwh, #consumo_promedio_precio').val('').prop("readonly", true);
			$('#contenedor_grafica').addClass('d-none');
			
			switch(datos_consumo.forma_calculo) {
				case 'consumo' :
					$('#consumo_promedio_kwh').prop("readonly", false);
					break;
				case 'precio' :
					$('#consumo_promedio_precio').prop("readonly", false);
					break;
				case 'recibo' :
					$('#contenedor_grafica').removeClass('d-none');
					$('#periodo_1, #periodo_2, #periodo_3, #periodo_4, #periodo_5, #periodo_6').prop("readonly", false);
					break;
			}
		}	
	}
	
	function habilitar_inputs() {
		$('#tipo_interconexion, #tipo_panel, #tipo_estructura_1, #sistema_monitoreo, #instalacion_electrica, #optimizador, #microinversor, #inversor_central, .agregar_estructura, #material_electrico, #instalacion').prop("disabled", false); 
	}

	$('#consumo_promedio_kwh').on('input', function() {
		consumo_total_kwh = parseFloat($(this).val());
		if(isNaN(consumo_total_kwh)) {
			return;
		}
		$(this).removeClass('is-invalid');
		var suministro = 0;
		var consumo_precio = 0;
		var valor_dap = 0;
		var valor_iva = 0;
		var consumo_total_pesos = 0;
		
		switch(datos_consumo.tarifa) {
			case 'tarifa_dac' : 
				suministro = (periodo_dias == 30) ? parseFloat(tarifas_cfe.suministro_residencial)/2 : parseFloat(tarifas_cfe.suministro_residencial);
				consumo_precio = consumo_total_kwh*parseFloat(tarifas_cfe.dac);
				break;
			case 'tarifa_pdbt' : 
				suministro = (periodo_dias == 30) ? parseFloat(tarifas_cfe.suministro_comercial) : parseFloat(tarifas_cfe.suministro_comercial)*2;
				consumo_precio = consumo_total_kwh*parseFloat(tarifas_cfe.pdbt);
				break;
			case 'tarifa_01' : 
				var tarifa_limite_1 = 0;
				var tarifa_limite_2 = 0;
				var tarifa_limite_3 = 0;
				var consumo_aux = consumo_total_kwh;
				suministro = (periodo_dias == 30) ? parseFloat(tarifas_cfe.suministro_residencial)/2 : parseFloat(tarifas_cfe.suministro_residencial);
				
				if(consumo_aux >= parseFloat(tarifas_cfe.d1_limite_superior)) {
					tarifa_limite_1 =  parseFloat(tarifas_cfe.d1_limite_superior)*parseFloat(tarifas_cfe.d1);
					consumo_aux -= parseFloat(tarifas_cfe.d1_limite_superior);
					if(consumo_aux >= parseFloat(tarifas_cfe.d2_limite_superior)) {
						tarifa_limite_2 =  parseFloat(tarifas_cfe.d2_limite_superior)*parseFloat(tarifas_cfe.d2);
						consumo_aux -= parseFloat(tarifas_cfe.d2_limite_superior);
						if(consumo_aux > 0) {
							tarifa_limite_3 =  consumo_aux*parseFloat(tarifas_cfe.d3);
						}
					}
					else {
						tarifa_limite_2 =  consumo_aux*parseFloat(tarifas_cfe.d2);
					}
				}
				else {
					tarifa_limite_1 =  consumo_aux*parseFloat(tarifas_cfe.d1);
				}
				
				consumo_precio = tarifa_limite_1 + tarifa_limite_2 + tarifa_limite_3;
				break;
		}
		
		valor_dap = consumo_precio*dap;
		valor_iva = consumo_precio*iva;
		consumo_total_pesos = round(suministro + consumo_precio + valor_dap + valor_iva, 2);
		
		datos_consumo.consumo_promedio_pesos = consumo_total_pesos;
		datos_consumo.consumo_promedio_kwh = consumo_total_kwh;
		datos_consumo.suministro = suministro;
		
		if(periodo_dias == 30) {
			datos_consumo.gasto_anual = round(consumo_total_pesos*12, 2);
			datos_consumo.gasto_bimestral = round(consumo_total_pesos*2, 2);
		} else {
			datos_consumo.gasto_anual = round(consumo_total_pesos*6, 2);
			datos_consumo.gasto_bimestral = consumo_total_pesos;
		}

		$('#consumo_promedio_precio').val(datos_consumo.consumo_promedio_pesos);
		habilitar_inputs();
		
		if(paneles.estado) {
			$('#tipo_panel').change();
		}
	});
	
	$('#consumo_promedio_precio').on('input', function() {
		consumo_total_pesos = parseFloat($(this).val());
		if(isNaN(consumo_total_pesos)) {
			return;
		}
		$(this).removeClass('is-invalid');
		var porcentaje_real = 1-dap-iva;
		var suministro = 0;
		
		switch(datos_consumo.tarifa) {
			case 'tarifa_dac' : 
				suministro = (periodo_dias == 30) ? parseFloat(tarifas_cfe.suministro_residencial)/2 : parseFloat(tarifas_cfe.suministro_residencial);
				consumo_total_kwh = round(consumo_total_pesos*porcentaje_real/parseFloat(tarifas_cfe.dac), 2);
				break;
			case 'tarifa_pdbt' : 
				suministro = (periodo_dias == 30) ? parseFloat(tarifas_cfe.suministro_comercial) : parseFloat(tarifas_cfe.suministro_comercial)*2;
				consumo_total_kwh = round(consumo_total_pesos*porcentaje_real/parseFloat(tarifas_cfe.pdbt), 2);
				break;
			case 'tarifa_01' : 
				var consumo_limite_1 = 0;
				var consumo_limite_2 = 0;
				var consumo_limite_3 = 0;
				var total_aux = consumo_total_pesos*porcentaje_real;
				suministro = (periodo_dias == 30) ? parseFloat(tarifas_cfe.suministro_residencial)/2 : parseFloat(tarifas_cfe.suministro_residencial);
				
				var tarifa_limite_1 = parseFloat(tarifas_cfe.d1_limite_superior)*parseFloat(tarifas_cfe.d1);
				var tarifa_limite_2 = parseFloat(tarifas_cfe.d2_limite_superior)*parseFloat(tarifas_cfe.d2);
				
				if(total_aux >= tarifa_limite_1) {
					consumo_limite_1 = parseFloat(tarifas_cfe.d1_limite_superior);
					total_aux -= tarifa_limite_1;
					
					if(total_aux > 0) {
						if(total_aux >= tarifa_limite_2) {
							consumo_limite_2 = parseFloat(tarifas_cfe.d2_limite_superior);
							total_aux -= tarifa_limite_2;
							
							if(total_aux > 0) {
								consumo_limite_3 = total_aux/parseFloat(tarifas_cfe.d3);
							}
						}
						else {
							consumo_limite_2 = total_aux/parseFloat(tarifas_cfe.d2);
						}
					}
				}
				else {
					consumo_limite_2 = total_aux/parseFloat(tarifas_cfe.d1);
				}
				
				consumo_total_kwh = round(consumo_limite_1+consumo_limite_2+consumo_limite_3, 2);
				break;
		}
		
		datos_consumo.consumo_promedio_pesos = consumo_total_pesos;
		datos_consumo.consumo_promedio_kwh = consumo_total_kwh;
		datos_consumo.suministro = suministro;

		if(periodo_dias == 30) {
			datos_consumo.gasto_anual = round(consumo_total_pesos*12, 2);
			datos_consumo.gasto_bimestral = round(consumo_total_pesos*2, 2);
		} else {
			datos_consumo.gasto_anual = round(consumo_total_pesos*6, 2);
			datos_consumo.gasto_bimestral = consumo_total_pesos;
		}
		
		$('#consumo_promedio_kwh').val(datos_consumo.consumo_promedio_kwh);
		habilitar_inputs();
		
		if(paneles.estado) {
			$('#tipo_panel').change();
		}
	});
	
	$('#tipo_panel').change(function() {
		$(this).removeClass('is-invalid');
		$.ajax({
			'url' : base_url + 'paneles/cargar_panel',
			'data' : {
				'id_panel' : $(this).val()
			},
			'type' : 'post',
			'success' : function(obj){
				console.log(obj);
				if(obj['resultado']){
					datos_panel = obj['panel'];
					
					paneles.estado = true;
					paneles.producto = datos_panel.producto;
					paneles.kw_panel = parseFloat(datos_panel.watts_panel)/1000;
					paneles.produccion_panel = round(hps*paneles.kw_panel*eficiencia*periodo_dias, 2);
					paneles.num_paneles = Math.floor(datos_consumo.consumo_promedio_kwh/paneles.produccion_panel);
					paneles.costo_mxn = round(parseFloat(datos_panel.usd_panel)*tarifa_cambio, 2);
					
					totales_cotizacion.usd_watt = datos_panel.usd_watt;
					
					$('#num_paneles').prop("disabled", false).val(paneles.num_paneles).change();
				}
				else {
					Swal.fire('Ocurrió un error', 'No se pudo cargar el panel elegido', 'error');
				}
			}
		});
	});
	
	$('#num_paneles').change(function() {
		paneles.num_paneles = parseInt($(this).val());
		datos_sistema.num_paneles = paneles.num_paneles;
		paneles.potencia_total = round(paneles.kw_panel*paneles.num_paneles, 2);
		datos_sistema.produccion_promedio = round(paneles.produccion_panel*paneles.num_paneles, 2);
		if(periodo == "mensual") {
			datos_sistema.produccion_anual = round(datos_sistema.produccion_promedio*12, 2);
		}
		else {
			datos_sistema.produccion_anual = round(datos_sistema.produccion_promedio*6, 2);
		}
		paneles.costo_total = round(paneles.costo_mxn*paneles.num_paneles, 2);
		paneles.precio_final = round(paneles.costo_total/indice_utilidad, 2);
		datos_sistema.ahorro = round((datos_sistema.produccion_promedio/datos_consumo.consumo_promedio_kwh)*100, 2);
		
		if(optimizadores.estado) {
			$('#cantidad_optimizador').val(paneles.num_paneles).change();
		}
		if(microinversores.estado) {
			$('#cantidad_microinversor').val(paneles.num_paneles).change();
		}
		
		$('#potencia_total').val(paneles.potencia_total);
		$('#produccion_promedio').val(datos_sistema.produccion_promedio);
		$('#produccion_anual').val(datos_sistema.produccion_anual);
		$('#ahorro').val(datos_sistema.ahorro);

		if(datos_consumo.forma_calculo == 'recibo') {
			if(datos_sistema.produccion_promedio > consumo_total_kwh) {
				signo_grafica = -1;
			}
			else {
				signo_grafica = 1;
			}
			grafica_consumo.options.plugins.annotation.annotations.line2.yMin = datos_sistema.produccion_promedio;
			grafica_consumo.options.plugins.annotation.annotations.line2.yMax = datos_sistema.produccion_promedio;
			grafica_consumo.options.plugins.annotation.annotations.line2.display = true;
			grafica_consumo.options.plugins.annotation.annotations.line2.label.content = "Generación por paneles: " + datos_sistema.produccion_promedio + " kWh";
			grafica_consumo.update();
		}
		
		calcular_ahorros();
		calcular_cotizacion();
		$('#contenedor_roi').removeClass('d-none');
	});
	
	
	$('#tipo_interconexion').change(function() {
		tipo_interconexion = $(this).val();
		$(this).removeClass('is-invalid');
		
		inversor.estado = false;
		microinversores.estado = false;
		optimizadores.estado = false;
		
		datos_sistema.tipo_interconexion = $('#tipo_interconexion option:selected').text();
		
		switch(tipo_interconexion) {
			case 'inversor_central_austero' :
				$('#datos_inversor_central, #fila_inversor').removeClass('d-none');
				$('#datos_microinversor, #fila_microinversor').addClass('d-none');
				$('#datos_optimizador, #fila_optimizador').addClass('d-none');
				break;
			case 'inversor_central_optimizadores' :
				$('#datos_inversor_central, #fila_inversor').removeClass('d-none');
				$('#datos_microinversor, #fila_microinversor').addClass('d-none');
				$('#datos_optimizador, #fila_optimizador').removeClass('d-none');
				break;
			case 'microinversores' :
				$('#datos_inversor_central, #fila_inversor').addClass('d-none');
				$('#datos_microinversor, #fila_microinversor').removeClass('d-none');
				$('#datos_optimizador, #fila_optimizador').addClass('d-none');
				break;
		}	
		
		calcular_cotizacion();
	});
	
	$(document).on('change', '.tipo_estructura', function() {
		var id_actual = parseInt($(this).prop("id").match(/\d+/g), 10);
		var id_tipo_estructura = $(this).val();
		$('#estructura_' + id_actual + ' option:not(:first)').remove();
		
		$.ajax({
			'url' : base_url + 'estructuras/obtener_estructuras_tipo',
			'data' : {
				'id_tipo_estructura' : id_tipo_estructura
			},
			'type' : 'post',
			'success' : function(obj){
				if(obj['resultado']){
					$('#estructura_' + id_actual).prop("disabled", false);
					
					$.each(obj['estructuras'], function(i, elemento) {
						$('#estructura_' + id_actual).append('<option value="' + elemento.id_estructura + '">' + elemento.codigo + '</option>');
					});
				}
				else {
					$('#estructura_' + id_actual).prop("disabled", false);
				}
			}
		});
	});
	
	$(document).on('click', '.agregar_estructura', function() {
		var id_fila = parseInt($(this).closest('.fila_estructura').prop('id').match(/\d+/g), 10);
		var id_siguiente = id_fila + 1;
		
		if(!$('#fila_estructura_' + id_siguiente).length) {
			console.log("entro al if");
			$('#cantidad_estructura_' + id_fila).inputSpinner("destroy");
			var fila_nueva = $('#fila_estructura_' + id_fila).clone();
			$('#cantidad_estructura_' + id_fila).inputSpinner();
			$(fila_nueva).prop("id", 'fila_estructura_' + id_siguiente);
			$(fila_nueva).find('#tipo_estructura_' + id_fila).prop("id", 'tipo_estructura_' + id_siguiente).prop("name", 'tipo_estructura_' + id_siguiente);
			$(fila_nueva).find('label[for="tipo_estructura_' + id_fila + '"]').prop('for', 'tipo_estructura_' + id_siguiente);
			$(fila_nueva).find('#estructura_' + id_fila).prop("id", 'estructura_' + id_siguiente).prop("name", 'estructura_' + id_siguiente).prop("disabled", true);
			$(fila_nueva).find('label[for="estructura_' + id_fila + '"]').prop('for', 'estructura_' + id_siguiente);
			$(fila_nueva).find('#cantidad_estructura_' + id_fila).prop("id", 'cantidad_estructura_' + id_siguiente).prop("name", 'cantidad_estructura_' + id_siguiente).prop("disabled", true).prop("value", "1");
			$(fila_nueva).find('label[for="cantidad_estructura_' + id_fila + '"]').prop('for', 'cantidad_estructura_' + id_siguiente);
			$(fila_nueva).find('.agregar_estructura').prop('disabled', false).addClass('btn-success').removeClass('btn-secondary');
			$(fila_nueva).find('.eliminar_estructura').prop('disabled', false).addClass('btn-danger').removeClass('btn-secondary');
			$('#fila_estructura_' + id_fila).after(fila_nueva);
			$('#fila_estructura_' + id_fila).find('.agregar_estructura').prop('disabled', true).removeClass('btn-success').addClass('btn-secondary');
			$('#fila_estructura_' + id_fila).find('.eliminar_estructura').prop('disabled', true).removeClass('btn-danger').addClass('btn-secondary');
			$('#cantidad_estructura_' + id_siguiente).inputSpinner();
			
			var celda_nueva = $('#celda_estructura_' + id_fila).clone();
			$(celda_nueva).prop("id", 'celda_estructura_' + id_siguiente);
			$('#celda_estructura_' + id_fila).after(celda_nueva);
		}
	});
	
	$(document).on('click', '.eliminar_estructura', function() {
		var id_fila = parseInt($(this).closest('.fila_estructura').prop('id').match(/\d+/g), 10);
		var id_anterior = id_fila - 1;
		
		if(id_fila > 1) {
			$(this).closest('.fila_estructura').remove();
			$('#celda_estructura_' + id_fila).remove();
			$('#titulo_estructuras').text("Estructuras (" + id_anterior + ")");
			$('#fila_estructura_' + id_anterior).find('.agregar_estructura').prop('disabled', false).addClass('btn-success').removeClass('btn-secondary');
			
			if(id_fila == 2) {
				$('#fila_estructura_' + id_anterior).find('.eliminar_estructura').prop('disabled', true).removeClass('btn-danger').addClass('btn-secondary');
			}
			else {
				$('#fila_estructura_' + id_anterior).find('.eliminar_estructura').prop('disabled', false).addClass('btn-danger').removeClass('btn-secondary');
			}
			
			estructuras.pop();
			calcular_cotizacion();
		}
	});
	
	$(document).on('change', '.seleccionar_estructura', function() {
		var id_fila = parseInt($(this).closest('.fila_estructura').prop('id').match(/\d+/g), 10);
		var cantidad = parseInt($('#cantidad_estructura_' + id_fila).val());
		var tipo_estructura = $('#tipo_estructura_' + id_fila + ' option:selected').text();
		
		$.ajax({
			'url' : base_url + 'estructuras/cargar_estructura',
			'data' : {
				'id_estructura' : $(this).val()
			},
			'type' : 'post',
			'success' : function(obj){
				if(obj['resultado']) {
					var estructura = {};
					
					datos_estructura = obj['estructura'];
					estructura.estado = true;
					
					if(datos_estructura.moneda == "USD") {
						estructura.costo_mxn = round(parseFloat(datos_estructura.costo)*tarifa_cambio, 2);
						estructura.costo_usd = parseFloat(datos_estructura.costo);
					}
					else {
						estructura.costo_mxn = parseFloat(datos_estructura.costo);
						estructura.costo_usd = 0;
					}
					
					estructura.cantidad = cantidad;
					estructura.producto = datos_estructura.producto;
					estructura.codigo = datos_estructura.codigo;
					estructura.costo_total = round(estructura.costo_mxn*cantidad, 2);
					estructura.precio_final = round(estructura.costo_total/indice_utilidad, 2);
					estructuras.push(estructura);

					$('#cantidad_estructura_' + id_fila).prop("disabled", false);
					
					calcular_cotizacion();
				}
				else {
					Swal.fire('Ocurrió un error', 'No se pudo cargar el panel elegido', 'error');
				}
			}
		});
	});
	
	$(document).on('change', '.cantidad_estructura', function() {
		var id_fila = parseInt($(this).closest('.fila_estructura').prop('id').match(/\d+/g), 10);
		var cantidad = parseInt($(this).val());
		
		console.dir(estructuras[id_fila-1]);
		console.dir(estructuras);
		estructuras[id_fila-1].cantidad = cantidad;
		estructuras[id_fila-1].costo_total = round(estructuras[id_fila-1].costo_mxn*cantidad, 2);
		estructuras[id_fila-1].precio_final = round(estructuras[id_fila-1].costo_total/indice_utilidad, 2);

		calcular_cotizacion();
	});
	
	$('#inversor_central').change(function() {
		$.ajax({
			'url' : base_url + 'inversores/cargar_inversor',
			'data' : {
				'id_inversor' : $(this).val()
			},
			'type' : 'post',
			'success' : function(obj){
				if(obj['resultado']) {
					datos_inversor = obj['inversor'];
					
					inversor.estado = true;
					
					if(datos_inversor.moneda == "USD") {
						inversor.costo_mxn = round(parseFloat(datos_inversor.costo)*tarifa_cambio, 2);
						inversor.costo_usd = parseFloat(datos_inversor.costo);
					}
					else {
						inversor.costo_mxn = parseFloat(datos_inversor.costo);
						inversor.costo_usd = 0;
					}
					
					inversor.codigo = datos_inversor.codigo;
					inversor.producto = datos_inversor.producto;
					inversor.costo_total = inversor.costo_mxn;
					inversor.precio_final = round(inversor.costo_total/indice_utilidad, 2);

					calcular_cotizacion();

				}
				else {
					Swal.fire('Ocurrió un error', 'No se pudo cargar el panel elegido', 'error');
				}
			}
		});
	});
	
	$('#optimizador').change(function() {
		$.ajax({
			'url' : base_url + 'optimizadores/cargar_optimizador',
			'data' : {
				'id_optimizador' : $(this).val()
			},
			'type' : 'post',
			'success' : function(obj){
				if(obj['resultado']) {
					datos_optimizador = obj['optimizador'];
					$('#cantidad_optimizador').prop("disabled", false);
					$('#cantidad_optimizador').val(paneles.num_paneles);
					var cantidad = parseInt($('#cantidad_optimizador').val());
					
					optimizadores.estado = true;
					
					if(datos_optimizador.moneda == "USD") {
						optimizadores.costo_mxn = round(parseFloat(datos_optimizador.costo)*tarifa_cambio, 2);
						optimizadores.costo_usd = parseFloat(datos_optimizador.costo);
					}
					else {
						optimizadores.costo_mxn = parseFloat(datos_optimizador.costo);
						optimizadores.costo_usd = 0;
					}
					
					optimizadores.codigo = datos_optimizador.codigo;
					optimizadores.producto = datos_optimizador.producto;
					optimizadores.cantidad = cantidad;
					optimizadores.costo_total = round(optimizadores.costo_mxn*cantidad, 2);
					optimizadores.precio_final = round(optimizadores.costo_total/indice_utilidad, 2); 
					
					calcular_cotizacion();
				}
				else {
					Swal.fire('Ocurrió un error', 'No se pudo cargar el optimizador elegido', 'error');
				}
			}
		});
	});
	
	$('#cantidad_optimizador').change(function() {
		var cantidad = parseInt($(this).val());
		optimizadores.cantidad = cantidad;
		optimizadores.costo_total = round(optimizadores.costo_mxn*cantidad, 2);
		optimizadores.precio_final = round(optimizadores.costo_total/indice_utilidad, 2); 
		calcular_cotizacion();
	});
	
	$('#microinversor').change(function() {
		$.ajax({
			'url' : base_url + 'microinversores/cargar_microinversor',
			'data' : {
				'id_microinversor' : $(this).val()
			},
			'type' : 'post',
			'success' : function(obj){
				if(obj['resultado']) {
					datos_microinversor = obj['microinversor'];
					$('#cantidad_microinversor').prop("disabled", false);
					$('#cantidad_microinversor').val(paneles.num_paneles);
					var cantidad = parseInt($('#cantidad_microinversor').val());
					
					microinversores.estado = true;
					
					if(datos_microinversor.moneda == "USD") {
						microinversores.costo_mxn = round(parseFloat(datos_microinversor.costo)*tarifa_cambio, 2);
						microinversores.costo_usd = parseFloat(datos_microinversor.costo);
					}
					else {
						microinversores.costo_mxn = parseFloat(datos_microinversor.costo);
						microinversores.costo_usd = 0;
					}
					
					microinversores.codigo = datos_microinversor.codigo;
					microinversores.producto = datos_microinversor.producto;
					microinversores.cantidad = cantidad;
					microinversores.costo_total = round(microinversores.costo_mxn*cantidad, 2);
					microinversores.precio_final = round(microinversores.costo_total/indice_utilidad, 2); 
					
					calcular_cotizacion();
				}
				else {
					Swal.fire('Ocurrió un error', 'No se pudo cargar el microinversor elegido', 'error');
				}
			}
		});
	});
	
	$('#cantidad_microinversor').change(function() {
		var cantidad = parseInt($(this).val());
		microinversores.cantidad = cantidad;
		microinversores.costo_total = round(microinversores.costo_mxn*cantidad, 2);
		microinversores.precio_final = round(microinversores.costo_total/indice_utilidad, 2); 

		calcular_cotizacion();
	});
	
	$('#sistema_monitoreo').change(function() {
		$.ajax({
			'url' : base_url + 'sistemas_monitoreo/cargar_sistema',
			'data' : {
				'id_sistema_monitoreo' : $(this).val()
			},
			'type' : 'post',
			'success' : function(obj){
				if(obj['resultado']) {
					datos_sistema_monitoreo = obj['sistema'];
					
					sistema_monitoreo.estado = true;
					
					if(datos_sistema_monitoreo.moneda == "USD") {
						sistema_monitoreo.costo_mxn = round(parseFloat(datos_sistema_monitoreo.costo)*tarifa_cambio, 2);
						sistema_monitoreo.costo_usd = parseFloat(datos_sistema_monitoreo.costo);
					}
					else {
						sistema_monitoreo.costo_mxn = parseFloat(datos_sistema_monitoreo.costo);
						sistema_monitoreo.costo_usd = 0;
					}
					
					sistema_monitoreo.costo_total = sistema_monitoreo.costo_mxn;
					sistema_monitoreo.precio_final = round(sistema_monitoreo.costo_total/indice_utilidad, 2); 
					sistema_monitoreo.codigo = datos_sistema_monitoreo.codigo;
					sistema_monitoreo.producto = datos_sistema_monitoreo.producto;

					calcular_cotizacion();
				}
				else {
					Swal.fire('Ocurrió un error', 'No se pudo cargar el datos_sistema de monitoreo elegido', 'error');
				}
			}
		});
	});
	
	$('#instalacion_electrica, #instalacion, #material_electrico').on('change input', function() {
		instalacion_electrica.estado = true;
		instalacion_electrica.metros_tuberia = isNaN(parseInt($('#instalacion_electrica').val())) ? 0 : parseInt($('#instalacion_electrica').val());
		instalacion_electrica.material_eletrico = parseInt($('#material_electrico').val());
		instalacion_electrica.instalacion = parseInt($('#instalacion').val());
		instalacion_electrica.costo_tuberia = round(instalacion_electrica.costo_metro*instalacion_electrica.metros_tuberia, 2);
		instalacion_electrica.costo_total = round(instalacion_electrica.costo_tuberia + instalacion_electrica.instalacion + instalacion_electrica.material_eletrico, 2);
		instalacion_electrica.precio_final = round(instalacion_electrica.costo_total/indice_utilidad, 2); 

		calcular_cotizacion();
	});

	function recalcular_costos() {
		if(paneles.estado) {
			paneles.precio_final = round(paneles.costo_total/indice_utilidad,2);
		}
		
		for(var i=0; i<estructuras.length; i++) {
			if(estructuras[i].estado) {
				estructuras[i].precio_final = round(estructuras[i].costo_total/indice_utilidad,2);
			}
		}
		
		if(inversor.estado) {
			inversor.precio_final = round(inversor.costo_total/indice_utilidad,2);
		}
		
		if(microinversores.estado) {
			microinversores.precio_final = round(microinversores.costo_total/indice_utilidad,2);
		}
		
		if(optimizadores.estado) {
			optimizadores.precio_final = round(optimizadores.costo_total/indice_utilidad,2);
		}
		
		if(sistema_monitoreo.estado) {
			sistema_monitoreo.precio_final = round(sistema_monitoreo.costo_total/indice_utilidad,2);
		}
		
		if(instalacion_electrica.estado) {
			instalacion_electrica.precio_final = round(instalacion_electrica.costo_total/indice_utilidad,2);
		}
		
		calcular_cotizacion();
	}
	
	function calcular_roi() {
		var datos_roi = new Array(25);
		
		for(var i=0; i<25; i++) {
			datos_roi[i] = round((pagos_anuales_sin_paneles[i]-pagos_anuales_con_paneles[i]) - totales_cotizacion.costo_final, 2);
		}
		
		totales_cotizacion.retorno_inversion = round((totales_cotizacion.costo_final)/datos_consumo.gasto_anual, 2);
		grafica_roi.data.datasets[0].data = datos_roi;
		grafica_roi.update();
		
		$('#retorno_inversion td:eq(0)').text(totales_cotizacion.retorno_inversion + " años");
	}

	function calcular_ahorros() {
		var consumo_precio = 0;
		var valor_dap = 0;
		var valor_iva = 0;
		var consumo_total_pesos = 0;
		var restante_kwh = round(datos_consumo.consumo_promedio_kwh - datos_sistema.produccion_promedio, 3);
		var restante_pesos = 0;
		var restante_pesos_anual = 0;
		var restante_anios = new Array(25);
		var ahorro = 0;
		var ahorro_anios = new Array(25);
		var dato_ahorro = {};
		
		if(restante_kwh <= 0) {
			restante_kwh = 0;
		}
		
		switch(datos_consumo.tarifa) {
			case 'tarifa_dac' : 
				consumo_precio = restante_kwh*parseFloat(tarifas_cfe.dac);
				break;
			case 'tarifa_pdbt' : 
				consumo_precio = restante_kwh*parseFloat(tarifas_cfe.pdbt);
				break;
			case 'tarifa_01' : 
				var tarifa_limite_1 = 0;
				var tarifa_limite_2 = 0;
				var tarifa_limite_3 = 0;
				var consumo_aux = restante_kwh;

				if(consumo_aux >= parseFloat(tarifas_cfe.d1_limite_superior)) {
					tarifa_limite_1 =  parseFloat(tarifas_cfe.d1_limite_superior)*parseFloat(tarifas_cfe.d1);
					consumo_aux -= parseFloat(tarifas_cfe.d1_limite_superior);
					if(consumo_aux >= parseFloat(tarifas_cfe.d2_limite_superior)) {
						tarifa_limite_2 =  parseFloat(tarifas_cfe.d2_limite_superior)*parseFloat(tarifas_cfe.d2);
						consumo_aux -= parseFloat(tarifas_cfe.d2_limite_superior);
						if(consumo_aux > 0) {
							tarifa_limite_3 =  consumo_aux*parseFloat(tarifas_cfe.d3);
						}
					}
					else {
						tarifa_limite_2 =  consumo_aux*parseFloat(tarifas_cfe.d2);
					}
				}
				else {
					tarifa_limite_1 =  consumo_aux*parseFloat(tarifas_cfe.d1);
				}
				
				consumo_precio = tarifa_limite_1 + tarifa_limite_2 + tarifa_limite_3;
				break;
		}
		
		valor_dap = consumo_precio*dap;
		valor_iva = consumo_precio*iva;
		restante_pesos = round(datos_consumo.suministro + consumo_precio + valor_dap + valor_iva, 2);
		ahorro = round(datos_consumo.consumo_promedio_pesos-restante_pesos, 2);
		
		if(periodo_dias == 30) {
			restante_pesos_anual = round(restante_pesos*12, 2);
		} else {
			restante_pesos_anual = round(restante_pesos*6, 2);
		}
		
		/*
		for(i=1; i<=25; i++) {
			pagos_anuales_sin_paneles[i-1] = round(restante_pesos_anual*i, 2);
			pagos_anuales_con_paneles[i-1] = round(datos_consumo.gasto_anual*i, 2);
			ahorro_anios[i-1] = round(pagos_anuales_con_paneles[i-1]-pagos_anuales_sin_paneles[i-1], 2);
		}
		*/
		
		for(i=1; i<=25; i++) {
			pagos_anuales_con_paneles[i-1] = round(restante_pesos_anual*i, 2);
			pagos_anuales_sin_paneles[i-1] = round(datos_consumo.gasto_anual*i, 2);
			ahorro_anios[i-1] = round(pagos_anuales_sin_paneles[i-1]-pagos_anuales_con_paneles[i-1], 2);
		}
		
		$('#periodo_tabla td:eq(0)').text(dinero(datos_consumo.consumo_promedio_pesos));
		$('#1_anio td:eq(0)').text(dinero(pagos_anuales_sin_paneles[0]));
		$('#5_anios td:eq(0)').text(dinero(pagos_anuales_sin_paneles[4]));
		$('#10_anios td:eq(0)').text(dinero(pagos_anuales_sin_paneles[9]));
		$('#25_anios td:eq(0)').text(dinero(pagos_anuales_sin_paneles[24]));
		
		$('#periodo_tabla td:eq(1)').text(dinero(restante_pesos));
		$('#1_anio td:eq(1)').text(dinero(pagos_anuales_con_paneles[0]));
		$('#5_anios td:eq(1)').text(dinero(pagos_anuales_con_paneles[4]));
		$('#10_anios td:eq(1)').text(dinero(pagos_anuales_con_paneles[9]));
		$('#25_anios td:eq(1)').text(dinero(pagos_anuales_con_paneles[24]));
		
		$('#periodo_tabla td:eq(2)').text(dinero(ahorro));
		$('#1_anio td:eq(2)').text(dinero(ahorro_anios[0]));
		$('#5_anios td:eq(2)').text(dinero(ahorro_anios[4]));
		$('#10_anios td:eq(2)').text(dinero(ahorro_anios[9]));
		$('#25_anios td:eq(2)').text(dinero(ahorro_anios[24]));
		
		datos_ahorro = [
			{
				periodo : "bimestral",
				actual : datos_consumo.consumo_promedio_pesos,
				con_aamperia : restante_pesos,
				ahorro : ahorro
			},
			{
				periodo : "1_anio",
				actual : pagos_anuales_sin_paneles[0],
				con_aamperia : pagos_anuales_con_paneles[0],
				ahorro : ahorro_anios[0]
			},
			{
				periodo : "5_anios",
				actual : pagos_anuales_sin_paneles[4],
				con_aamperia : pagos_anuales_con_paneles[4],
				ahorro : ahorro_anios[4]
			},
			{
				periodo : "10_anios",
				actual : pagos_anuales_sin_paneles[9],
				con_aamperia : pagos_anuales_con_paneles[9],
				ahorro : ahorro_anios[9]
			},
			{
				periodo : "25_anios",
				actual : pagos_anuales_sin_paneles[24],
				con_aamperia : pagos_anuales_con_paneles[24],
				ahorro : ahorro_anios[24]
			}
		]
	}
	
	function calcular_cotizacion() {
		var subtotal = 0;
		var subtotal_iva = 0;
		var total_final = 0;
		productos_cotizacion = new Array();
		var producto_auxiliar = {};
		
		if(paneles.estado) {
			$('#celda_paneles').removeClass("d-none");
			$('#celda_paneles td:eq(0)').text(paneles.num_paneles);
			$('#celda_paneles td:eq(2)').text(paneles.producto);
			$('#celda_paneles td:eq(3)').text(dinero(paneles.precio_final));
			
			producto_auxiliar = {};
			producto_auxiliar.nombre = paneles.producto;
			producto_auxiliar.cantidad = paneles.num_paneles;
			producto_auxiliar.p_unitario = round(paneles.precio_final/paneles.num_paneles, 2);
			producto_auxiliar.importe = paneles.precio_final;
			productos_cotizacion.push(producto_auxiliar);
			
			subtotal += paneles.precio_final;
		}
		else {
			$('#celda_paneles').addClass("d-none");
		}
		
		if(inversor.estado) {
			$('#celda_inversor').removeClass("d-none");
			$('#celda_inversor td:eq(0)').text(inversor.cantidad);
			$('#celda_inversor td:eq(2)').text(inversor.producto);
			$('#celda_inversor td:eq(3)').text(dinero(inversor.precio_final));
			
			producto_auxiliar = {};
			producto_auxiliar.nombre = inversor.producto;
			producto_auxiliar.cantidad = inversor.cantidad;
			producto_auxiliar.p_unitario = inversor.precio_final;
			producto_auxiliar.importe = inversor.precio_final;
			productos_cotizacion.push(producto_auxiliar);
			
			subtotal += inversor.precio_final;
		}
		else {
			$('#celda_inversor').addClass("d-none");
		}
		
		if(optimizadores.estado) {
			$('#celda_optimizador').removeClass("d-none");
			$('#celda_optimizador td:eq(0)').text(optimizadores.cantidad);
			$('#celda_optimizador td:eq(2)').text(optimizadores.producto);
			$('#celda_optimizador td:eq(3)').text(dinero(optimizadores.precio_final));
			
			producto_auxiliar = {};
			producto_auxiliar.nombre = optimizadores.producto;
			producto_auxiliar.cantidad = optimizadores.cantidad;
			producto_auxiliar.p_unitario = round(optimizadores.precio_final/optimizadores.cantidad, 2);
			producto_auxiliar.importe = optimizadores.precio_final;
			productos_cotizacion.push(producto_auxiliar);
			
			subtotal += optimizadores.precio_final;
		}
		else {
			$('#celda_optimizador').addClass("d-none");
		}
		
		if(microinversores.estado) {
			$('#celda_microinversor').removeClass("d-none");
			$('#celda_microinversor td:eq(0)').text(microinversores.cantidad);
			$('#celda_microinversor td:eq(2)').text(microinversores.producto);
			$('#celda_microinversor td:eq(3)').text(dinero(microinversores.precio_final));
			
			producto_auxiliar = {};
			producto_auxiliar.nombre = microinversores.producto;
			producto_auxiliar.cantidad = microinversores.cantidad;
			producto_auxiliar.p_unitario = round(microinversores.precio_final/microinversores.cantidad, 2);
			producto_auxiliar.importe = microinversores.precio_final;
			productos_cotizacion.push(producto_auxiliar);
			
			subtotal += microinversores.precio_final;
		}
		else {
			$('#celda_microinversor').addClass("d-none");
		}
		
		if(sistema_monitoreo.estado) {
			$('#celda_sistema').removeClass("d-none");
			$('#celda_sistema td:eq(0)').text(sistema_monitoreo.cantidad);
			$('#celda_sistema td:eq(2)').text(sistema_monitoreo.producto);
			$('#celda_sistema td:eq(3)').text(dinero(sistema_monitoreo.precio_final));
			
			producto_auxiliar = {};
			producto_auxiliar.nombre = sistema_monitoreo.producto;
			producto_auxiliar.cantidad = sistema_monitoreo.cantidad;
			producto_auxiliar.p_unitario = sistema_monitoreo.precio_final;
			producto_auxiliar.importe = sistema_monitoreo.precio_final;
			productos_cotizacion.push(producto_auxiliar);
			
			subtotal += sistema_monitoreo.precio_final;
		}
		else {
			$('#celda_sistema').addClass("d-none");
		}
		
		for(var i=0; i<estructuras.length; i++) {
			if(estructuras[i].estado) {
				$('#celda_estructura_' + (i+1)).removeClass("d-none");
				$('#celda_estructura_' + (i+1) + " td:eq(0)").text(estructuras[i].cantidad);
				$('#celda_estructura_' + (i+1) + " td:eq(2)").text(estructuras[i].producto);
				$('#celda_estructura_' + (i+1) + " td:eq(3)").text(dinero(estructuras[i].precio_final));
				
				producto_auxiliar = {};
				producto_auxiliar.nombre = "Estructura " + estructuras[i].codigo;
				producto_auxiliar.cantidad = estructuras[i].cantidad;
				producto_auxiliar.p_unitario = round(estructuras[i].precio_final/estructuras[i].cantidad, 2);
				producto_auxiliar.importe = estructuras[i].precio_final;
				productos_cotizacion.push(producto_auxiliar);
				
				subtotal += estructuras[i].precio_final;
			}
			else {
				$('#celda_estructura_' + (i+1)).addClass("d-none");
			}
		}
		
		if(instalacion_electrica.estado) {
			$('#celda_material').removeClass("d-none");
			$('#celda_material td:eq(2)').text(dinero(instalacion_electrica.precio_final));
			
			producto_auxiliar = {};
			producto_auxiliar.nombre = "Instalación";
			producto_auxiliar.cantidad = instalacion_electrica.cantidad;
			producto_auxiliar.p_unitario = instalacion_electrica.precio_final;
			producto_auxiliar.importe = instalacion_electrica.precio_final;
			productos_cotizacion.push(producto_auxiliar);
			
			subtotal += instalacion_electrica.precio_final;
		}
		else {
			$('#celda_material').addClass("d-none");
		}
		
		if(subtotal > 0 && paneles.num_paneles > 0) {
			// subtotal : costo de los insumos ya con utilidad
			subtotal = round(subtotal, 2);
			subtotal_iva = round(subtotal*iva, 2);
			total = round(subtotal + subtotal_iva, 2);
			
			// precio al cliente (proyecto + utilidad)
			totales_cotizacion.costo_proyecto_utilidad = subtotal;
			
			// iva final del precio final 
			totales_cotizacion.iva_final = subtotal_iva;
			
			// precio final al cliente con iva
			totales_cotizacion.costo_final = total;

			$('#celda_subtotal td:eq(0)').text(dinero(totales_cotizacion.costo_proyecto_utilidad));
			$('#celda_iva td:eq(0)').text(dinero(totales_cotizacion.iva_final));
			$('#celda_total td:eq(0)').text(dinero(totales_cotizacion.costo_final));
			
			calcular_roi();
		}
	}
	
	function checar_datos() {
		var llenos = true;

		if(!datos_cotizacion.nombre_usuario) {
			llenos = false;
			$('#nombre_usuario').addClass('is-invalid');
		}
		
		if(!datos_cotizacion.telefono) {
			llenos = false;
			$('#telefono').addClass('is-invalid');
		}

		if(!datos_cotizacion.fecha_cotizacion) {
			llenos = false;
			$('#fecha').addClass('is-invalid');
		}

		if(!datos_consumo.tarifa) {
			llenos = false;
			$('#tarifa').addClass('is-invalid');
		}
		
		if(!datos_consumo.forma_calculo) {
			llenos = false;
			$('#forma_calculo').addClass('is-invalid');
		}
		else {
			switch(datos_consumo.consumo_promedio_kwh) {
				case "consumo" :
					if(!datos_cotizacion.consumo_promedio_kwh) {
						llenos = false;
						$('#consumo_promedio_kwh').addClass('is-invalid');
					}
					break;
				case "precio" :
					if(!datos_cotizacion.consumo_promedio_pesos) {
						llenos = false;
						$('#consumo_promedio_precio').addClass('is-invalid');
					}
					break;
				case "recibo" :
					if(!datos_cotizacion.consumo_promedio_kwh) {
						llenos = false;
						$('#periodo_1, #periodo_2, #periodo_3, #periodo_4, #periodo_5, #periodo_6').addClass('is-invalid');
					}
			}
		}
		
		if(!datos_sistema.tipo_interconexion) {
			llenos = false;
			$('#tipo_interconexion').addClass('is-invalid');
		}
		
		if(!paneles.estado) {
			llenos = false;
			$('#tipo_panel').addClass('is-invalid');
		}
		
		return llenos;
	}
	
	$('#generar_cotizacion').click(function(e) {
		if(checar_datos()) {
			$('#overlay').removeClass('d-none');
			$('#contenedor_grafica').addClass('d-none');
			$('#contenedor_roi').addClass('d-none');
			grafica_consumo.resize(1300, 500);
			grafica_roi.resize(1300, 400);
			const canvas1 = document.getElementById('grafica_consumo');
			const canvas2 = document.getElementById('grafica_roi');
			cambiar_fondo_canvas(canvas1, 'rgb(255,255,255)');
			cambiar_fondo_canvas(canvas2, 'rgb(255,255,255)');
			$.ajax({
				'url' : base_url + 'cotizacion/guardar_cotizacion',
				'data' : {
					'datos_cotizacion' : datos_cotizacion,
					'datos_consumo' : datos_consumo,
					'datos_sistema' : datos_sistema,
					'datos_ahorro' : datos_ahorro,
					'productos_cotizacion' : productos_cotizacion,
					'totales_cotizacion' : totales_cotizacion,
					'grafica_consumo' : grafica_consumo.toBase64Image(),
					'grafica_roi' : grafica_roi.toBase64Image()
				},
				'type' : 'post',
				'success' : function(obj){
					if(obj['resultado']) {
						window.location.replace(base_url + 'cotizacion/previsualizar_cotizacion/' + obj['id_cotizacion']);
					}
					else {
						$('#overlay').addClass('d-none');
						Swal.fire('Ocurrió un error', 'Ha ocurrido un error al intentar generar la cotización', 'error');
						grafica_consumo.resize();
					}
				}
			});
		}
		else {
			e.preventDefault();
			Swal.fire({
				heightAuto: false,
				title: 'Faltan datos', 
				text: 'No has llenado todos los datos requeridos para generar la cotización', 
				icon: 'error',
				didClose: () => $("html, body").animate({scrollTop:0 },"fast")
			});
		}
		
	});
	
	$('#reiniciar_cotizacion').click(function() {
		location.reload(true);
	});
});