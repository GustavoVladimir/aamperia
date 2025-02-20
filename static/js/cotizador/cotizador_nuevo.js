$(document).ready(function () {
	$.ajaxSetup({
		error: function (xhr) {
			Swal.fire({
				icon: "error",
				title: "Error en el servidor",
				html:
					"<b>Mensaje técnico:</b><br>" +
					"<p>" +
					xhr.status +
					" " +
					xhr.statusText +
					"</p>",
				confirmButtonText: "Aceptar",
			});
			console.log(xhr.responseText);
			$("#overlay").addClass("d-none");
		},
	});

	var tabla_agregar = $("#tabla_agregar").DataTable({
		responsive: true,
		ordering: false,
		columnDefs: [{ orderable: false, targets: [0, 1, 2, 3, 4] }],
		lengthChange: false,
		pageLength: 5,
		language: {
			url: base_url + "static/js/Spanish.json",
		},
	});

	var tabla_productos = $("#tabla_productos").DataTable({
		responsive: true,
		ordering: false,
		searching: false,
		paging: false,
		lengthChange: false,
		info: false,
		language: {
			url: base_url + "static/js/Spanish.json",
		},
	});

	var tabla_costos = $("#tabla_costos").DataTable({
		responsive: true,
		ordering: false,
		searching: false,
		paging: false,
		lengthChange: false,
		info: false,
		language: {
			url: base_url + "static/js/Spanish.json",
		},
	});

	/** VARIABLES DE AYUDA **/
	const fecha = new Date();
	var grafica_consumo;
	var grafica_roi;
	var grafica_consumo_fija;
	var cambiando_indice = false;
	var cambiando_tasa = false;
	var indice_correcto = false;
	var tasa_correcta = false;
	var indice_numerico;
	var signo_grafica = 1;
	var wto;
	var columnas_tabla_productos = [];
	var columnas_tabla_costos = [];

	var datos_ahorro = {};

	var datos_recibo = [0, 0, 0, 0, 0, 0];

	var elementos_cotizacion = new Array();

	var totales = {
		subtotal: 0,
		subtotal_iva: 0,
		total_final: 0,
	};

	$("#tabla_productos thead tr th").each(function () {
		columnas_tabla_productos.push($(this).html());
	});

	$("#tabla_costos thead tr th").each(function () {
		columnas_tabla_costos.push($(this).html());
	});

	$("#fecha").val(
		fecha.getFullYear() +
			"-" +
			("0" + (fecha.getMonth() + 1)).slice(-2) +
			"-" +
			("0" + fecha.getDate()).slice(-2)
	);

	grafica_consumo = new Chart($("#grafica_consumo"), {
		type: "bar",
		data: {
			labels: [
				"1 periodo",
				"2 periodo",
				"3 periodo",
				"4 periodo",
				"5 periodo",
				"6 periodo",
			],
			datasets: [
				{
					data: [0, 0, 0, 0, 0, 0],
					backgroundColor: "#F0A202",
				},
			],
		},
		options: {
			maintainAspectRatio: false,
			scales: {
				y: {
					grace: "5%",
					beginAtZero: true,
					ticks: {
						font: {
							size: function (context) {
								var width = context.chart.width;

								if (width <= 320) {
									size = 12;
								} else {
									if (width > 320 && width < 600) {
										size = 16;
									} else {
										size = 20;
									}
								}
								return size;
							},
							weight: "bold",
						},
					},
					grid: {
						display: false,
					},
				},
				x: {
					beginAtZero: true,
					ticks: {
						font: {
							size: function (context) {
								var width = context.chart.width;

								if (width <= 320) {
									size = 12;
								} else {
									if (width > 320 && width < 600) {
										size = 16;
									} else {
										size = 20;
									}
								}
								return size;
							},
							weight: "bold",
						},
					},
					grid: {
						display: false,
					},
				},
			},
			plugins: {
				autocolors: false,
				annotation: {
					annotations: {
						line1: {
							display: false,
							type: "line",
							yMin: 0,
							yMax: 0,
							borderColor: "rgb(255, 0, 0)",
							borderWidth: 2,
							label: {
								content: "",
								enabled: true,
								yAdjust: function (context) {
									var width = context.chart.width;

									if (width <= 320) {
										size = -10;
									} else {
										if (width > 320 && width < 600) {
											size = -15;
										} else {
											size = -20;
										}
									}
									return size * signo_grafica;
								},
								backgroundColor: "rgba(0,0,0,0)",
								color: "#000000",
								font: function (context) {
									var width = context.chart.width;

									if (width <= 320) {
										size = 12;
									} else {
										if (width > 320 && width < 600) {
											size = 16;
										} else {
											size = 20;
										}
									}
									return {
										size: size,
									};
								},
							},
						},
						line2: {
							display: false,
							type: "line",
							yMin: 0,
							yMax: 0,
							borderColor: "rgb(146, 208, 80)",
							borderWidth: 2,
							label: {
								content: "",
								enabled: true,
								yAdjust: function (context) {
									var width = context.chart.width;

									if (width <= 320) {
										size = 10;
									} else {
										if (width > 320 && width < 600) {
											size = 15;
										} else {
											size = 20;
										}
									}
									return size * signo_grafica;
								},
								backgroundColor: "rgba(0,0,0,0)",
								color: "#000000",
								font: function (context) {
									var width = context.chart.width;

									if (width <= 320) {
										size = 12;
									} else {
										if (width > 320 && width < 600) {
											size = 16;
										} else {
											size = 20;
										}
									}
									return {
										size: size,
									};
								},
							},
						},
					},
				},
				legend: {
					display: false,
				},
				tooltip: {
					enabled: false,
				},
				title: {
					display: true,
					text: "Gráfica de kWh consumidos",
					font: {
						size: 20,
					},
					padding: {
						bottom: 30,
					},
				},
			},
		},
	});

	grafica_roi = new Chart($("#grafica_roi"), {
		type: "bar",
		data: {
			labels: [
				"1",
				"2",
				"3",
				"4",
				"5",
				"6",
				"7",
				"8",
				"9",
				"10",
				"11",
				"12",
				"13",
				"14",
				"15",
				"16",
				"17",
				"18",
				"19",
				"20",
				"21",
				"22",
				"23",
				"24",
				"25",
			],
			datasets: [
				{
					label: "Beneficio obtenido",
					data: [
						0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
						0, 0,
					],
					backgroundColor: "#F0A202",
				},
			],
		},
		options: {
			maintainAspectRatio: false,
			scales: {
				y: {
					beginAtZero: true,
					ticks: {
						font: {
							size: function (context) {
								var width = context.chart.width;

								if (width <= 320) {
									size = 12;
								} else {
									if (width > 320 && width < 600) {
										size = 16;
									} else {
										size = 20;
									}
								}
								return size;
							},
							weight: "bold",
						},
						callback: function (value, index, values) {
							return (
								"$" + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
							);
						},
					},
					grid: {
						display: false,
					},
					title: {
						text: "Ahorro",
						display: true,
						font: {
							size: 24,
						},
					},
				},
				x: {
					beginAtZero: true,
					ticks: {
						font: {
							size: function (context) {
								var width = context.chart.width;

								if (width <= 320) {
									size = 12;
								} else {
									if (width > 320 && width < 600) {
										size = 16;
									} else {
										size = 20;
									}
								}
								return size;
							},
							weight: "bold",
						},
					},
					grid: {
						display: false,
					},
					title: {
						text: "Años",
						display: true,
						font: {
							size: 24,
						},
					},
				},
			},
			plugins: {
				autocolors: false,
				legend: {
					display: false,
				},
				title: {
					display: true,
					text: "Retorno de inversión",
					font: {
						size: 20,
					},
				},
			},
		},
	});

	$("#num_paneles").inputSpinner();
	$("#cantidad_estructura").inputSpinner();
	$("#cantidad_microinversor").inputSpinner();
	$("#cantidad_optimizador").inputSpinner();
	$(".cantidad_modal").inputSpinner();

	/** LLAMADAS AJAX PARA DATOS INICIALES **/
	$.ajax({
		url: base_url + "cotizacion/obtener_datos_iniciales",
		type: "post",
		success: function (obj) {
			let inventario = obj["inventario"];

			$.each(inventario["paneles"], function (i, elemento) {
				$("#tipo_panel").append(
					"<option value=" +
						elemento.id_panel +
						">" +
						elemento.codigo +
						"</option>"
				);
			});

			$.each(inventario["sistemas_monitoreo"], function (i, elemento) {
				$("#sistema_monitoreo").append(
					"<option value=" +
						elemento.id_sistema_monitoreo +
						">" +
						elemento.codigo +
						"</option>"
				);
			});

			$.each(inventario["inversores"], function (i, elemento) {
				$("#inversor_central").append(
					"<option value=" +
						elemento.id_inversor +
						">" +
						elemento.codigo +
						"</option>"
				);
			});

			$.each(inventario["optimizadores"], function (i, elemento) {
				$("#optimizador").append(
					"<option value=" +
						elemento.id_optimizador +
						">" +
						elemento.codigo +
						"</option>"
				);
			});

			$.each(inventario["microinversores"], function (i, elemento) {
				$("#microinversor").append(
					"<option value=" +
						elemento.id_microinversor +
						">" +
						elemento.codigo +
						"</option>"
				);
			});

			$.each(inventario["tipos_estructura"], function (i, elemento) {
				$("#tipo_estructura").append(
					"<option value=" +
						elemento.id_tipo_estructura +
						">" +
						elemento.codigo +
						"</option>"
				);
			});

			cargar_cotizacion_temporal();
		},
	});

	function cargar_cotizacion_temporal() {
		$.ajax({
			url: base_url + "cotizacion/cargar_cotizacion_temporal",
			type: "post",
			success: function (obj) {
				console.log("COTIZACION TEMPORAL: ");
				console.log(obj);
				if (obj["tipo_cotizacion"] == "existente") {
					$("#alerta_cotizacion_guardada").removeClass("d-none");
					$("#alerta_cotizacion_nueva").addClass("d-none");

					let cotizacion_temporal = obj["cotizacion_temporal"];
					console.log(cotizacion_temporal);
					id_cotizacion_temporal = cotizacion_temporal.id_cotizacion_temporal;
					$("#fecha_cotizacion_guardada").html(
						cotizacion_temporal.fecha_edicion
					);
					$("#alerta_cotizacion").removeClass("d-none");
					$("#folio_cotizacion").val(
						cotizacion_temporal.id_cotizacion_temporal
					);
					$("#nombre_usuario").val(cotizacion_temporal.nombre);
					$("#ubicacion").val(cotizacion_temporal.ubicacion);
					$("#telefono").val(cotizacion_temporal.telefono);
					$("#correo").val(cotizacion_temporal.correo);
					$("#fecha").val(cotizacion_temporal.fecha_cotizacion);
					$('#mostrar_roi [value="' + cotizacion_temporal.mostrar_roi + '"')
						.prop("selected", true)
						.change();
					$("#num_servicio").val(cotizacion_temporal.numero_servicio);

					if (cotizacion_temporal.forma_calculo != null) {
						$(
							'#forma_calculo [value="' +
								cotizacion_temporal.forma_calculo +
								'"'
						).prop("selected", true);
						$('#tarifa [value="' + cotizacion_temporal.tarifa + '"').prop(
							"selected",
							true
						);
						$('#periodo [value="' + cotizacion_temporal.periodo + '"').prop(
							"selected",
							true
						);
						$("#consumo_promedio_kwh").val(
							cotizacion_temporal.consumo_promedio_kwh
						);
						$("#consumo_promedio_pesos").val(
							cotizacion_temporal.consumo_promedio_precio
						);

						if (cotizacion_temporal.periodo == "bimestral") {
							$("label[for='consumo_promedio_kwh']").text(
								"Consumo promedio bimestral (kWh)"
							);
							$("label[for='consumo_promedio_pesos']").text(
								"Consumo promedio bimestral ($)"
							);
							$("label[for='produccion_promedio']").text(
								"Producción bimestral"
							);
							$("#periodo_tabla th").html("Bimestral");
						} else {
							$("label[for='consumo_promedio_kwh']").text(
								"Consumo promedio mensual (kWh)"
							);
							$("label[for='consumo_promedio_pesos']").text(
								"Consumo promedio mensual ($)"
							);
							$("label[for='produccion_promedio']").text("Producción mensual");
							$("#periodo_tabla th").html("Mensual");
						}

						switch (cotizacion_temporal.tarifa) {
							case "tarifa_01":
								$("#admin_tarifa").val("Tarifa 01");
								break;
							case "tarifa_dac":
								$("#admin_tarifa").val("Tarifa DAC");
								break;
							case "tarifa_pdbt":
								$("#admin_tarifa").val("PDBT");
								break;
						}

						switch (cotizacion_temporal.forma_calculo) {
							case "consumo":
								$("#consumo_promedio_kwh").prop("readonly", false);
								break;
							case "precio":
								$("#consumo_promedio_pesos").prop("readonly", false);
								break;
							case "recibo":
								$("#periodos").removeClass("d-none");
								$(
									"#periodo_1, #periodo_2, #periodo_3, #periodo_4, #periodo_5, #periodo_6"
								).prop("readonly", false);
								$("#periodo_1").val(cotizacion_temporal.recibo_1);
								$("#periodo_2").val(cotizacion_temporal.recibo_2);
								$("#periodo_3").val(cotizacion_temporal.recibo_3);
								$("#periodo_4").val(cotizacion_temporal.recibo_4);
								$("#periodo_5").val(cotizacion_temporal.recibo_5);
								$("#periodo_6")
									.val(cotizacion_temporal.recibo_6)
									.trigger("input");
								$("#contenedor_grafica").removeClass("d-none");
								break;
						}

						habilitar_inputs();

						$(
							'#tipo_interconexion [value="' +
								cotizacion_temporal.tipo_interconexion +
								'"'
						)
							.prop("selected", true)
							.change();
					}

					if (cotizacion_temporal.paneles_elegidos == 1) {
						$("#potencia_total").val(cotizacion_temporal.potencia_total);
						$("#produccion_promedio").val(
							cotizacion_temporal.produccion_periodo
						);
						$("#produccion_anual").val(cotizacion_temporal.produccion_anual);
						$("#ahorro").val(cotizacion_temporal.porcentaje_produccion);
						$("#num_paneles").val(cotizacion_temporal.num_paneles);
						$("#cantidad_optimizador").val(cotizacion_temporal.num_paneles);
						$("#cantidad_microinversor").val(cotizacion_temporal.num_paneles);
						if (cotizacion_temporal.forma_calculo == "recibo") {
							if (
								cotizacion_temporal.produccion_periodo >
								cotizacion_temporal.consumo_promedio_kwh
							) {
								signo_grafica = -1;
							} else {
								signo_grafica = 1;
							}
							grafica_consumo.options.plugins.annotation.annotations.line2.yMin =
								cotizacion_temporal.produccion_periodo;
							grafica_consumo.options.plugins.annotation.annotations.line2.yMax =
								cotizacion_temporal.produccion_periodo;
							grafica_consumo.options.plugins.annotation.annotations.line2.display = true;
							grafica_consumo.options.plugins.annotation.annotations.line2.label.content =
								"Generación por paneles: " +
								cotizacion_temporal.produccion_periodo +
								" kWh";
							grafica_consumo.update();
						}

						datos_ahorro = obj["datos_ahorro"];
						console.log(datos_ahorro);
						mostrar_ahorros();
					}

					$("#admin_tasa_cambio").val(cotizacion_temporal.tasa_cambio);
					$("#admin_fecha_tasa_cambio").val(cotizacion_temporal.fecha_tasa);
					$("#admin_indice_utilidad").val(cotizacion_temporal.indice_utilidad);
					$("#admin_suministro").val(cotizacion_temporal.costo_suministro);
					$("#admin_gasto_bimestral").val(
						dinero(cotizacion_temporal.gasto_bimestral_cfe, false)
					);
					$("#admin_gasto_anual").val(
						dinero(cotizacion_temporal.gasto_anual_cfe, false)
					);
					$("#admin_costo_por_metro").val(cotizacion_temporal.costo_metro);
					$("#admin_costo_material_electrico").val(
						cotizacion_temporal.material_electrico
					);
					$("#admin_costo_instalacion").val(cotizacion_temporal.instalacion);

					if (totales) {
						console.log(obj["productos_temporales"]);
						elementos_cotizacion = obj["productos_temporales"];
						totales = obj["totales"];
						actualizar_lista_elementos();
					}
				} else if (obj["tipo_cotizacion"] == "nueva") {
					$("#folio_cotizacion").val(obj["nuevo_id_cotizacion_temporal"]);
					$("#alerta_cotizacion_guardada").addClass("d-none");
					$("#alerta_cotizacion_nueva").removeClass("d-none");
					id_cotizacion_temporal = obj["nuevo_id_cotizacion_temporal"];
					let cotizacion_temporal = obj["cotizacion_temporal"];
					console.log(cotizacion_temporal);
					$("#fecha_cotizacion_guardada").html(
						cotizacion_temporal.fecha_edicion
					);
					$("#alerta_cotizacion").removeClass("d-none");

					$("#admin_tasa_cambio").val(cotizacion_temporal.tasa_cambio);
					$("#admin_fecha_tasa_cambio").val(cotizacion_temporal.fecha_tasa);
					$("#admin_indice_utilidad").val(cotizacion_temporal.indice_utilidad);

					$("#admin_costo_por_metro").val(cotizacion_temporal.costo_metro);
				}

				$("#overlay").addClass("d-none");
			},
		});
	}
	/** LLAMADAS AJAX PARA DATOS **/

	$("#nombre_usuario").change(function () {
		let nombre = $(this).val();
		if (nombre) {
			$(this).removeClass("is-invalid");
			$.ajax({
				url: base_url + "cotizacion/guardar_nombre",
				type: "post",
				data: {
					id_cotizacion_temporal: id_cotizacion_temporal,
					nombre: nombre,
				},
				success: function (obj) {
					console.log("nombre guardado 2");
				},
			});
		} else {
			$(this).addClass("is-invalid");
		}
	});

	$("#ubicacion").change(function () {
		let ubicacion = $(this).val();
		if (ubicacion) {
			$(this).removeClass("is-invalid");
			$.ajax({
				url: base_url + "cotizacion/guardar_ubicacion",
				type: "post",
				data: {
					id_cotizacion_temporal: id_cotizacion_temporal,
					ubicacion: ubicacion,
				},
				success: function (obj) {
					console.log("ubicacion guardado");
				},
			});
		}
	});

	$("#telefono").change(function () {
		let telefono = $(this).val();
		if (telefono) {
			$(this).removeClass("is-invalid");
			$(this).removeClass("is-invalid");
			$.ajax({
				url: base_url + "cotizacion/guardar_telefono",
				type: "post",
				data: {
					id_cotizacion_temporal: id_cotizacion_temporal,
					telefono: telefono,
				},
				success: function (obj) {
					console.log("telefono guardado");
				},
			});
		} else {
			$(this).addClass("is-invalid");
		}
	});

	$("#correo").change(function () {
		let correo = $(this).val();
		if (correo) {
			$(this).removeClass("is-invalid");
			$.ajax({
				url: base_url + "cotizacion/guardar_correo",
				type: "post",
				data: {
					id_cotizacion_temporal: id_cotizacion_temporal,
					correo: correo,
				},
				success: function (obj) {
					console.log("correo guardado");
				},
			});
		}
	});

	$("#num_servicio").change(function () {
		let num_servicio = $(this).val();
		if (num_servicio) {
			$(this).removeClass("is-invalid");
			$.ajax({
				url: base_url + "cotizacion/guardar_num_servicio",
				type: "post",
				data: {
					id_cotizacion_temporal: id_cotizacion_temporal,
					num_servicio: num_servicio,
				},
				success: function (obj) {
					console.log("num_servicio guardado");
				},
			});
		}
	});

	$("#fecha").change(function () {
		let fecha = $(this).val();
		if (fecha) {
			$(this).removeClass("is-invalid");
			$.ajax({
				url: base_url + "cotizacion/guardar_fecha",
				type: "post",
				data: {
					id_cotizacion_temporal: id_cotizacion_temporal,
					fecha: fecha,
				},
				success: function (obj) {
					console.log("fecha guardado");
				},
			});
		} else {
			$(this).addClass("is-invalid");
		}
	});

	$("#forma_calculo").change(function () {
		let forma_calculo = $(this).val();
		$(this).removeClass("is-invalid");

		if (forma_calculo == "recibo") {
			$("#periodos").removeClass("d-none");
		} else {
			$("#periodos").addClass("d-none");
		}

		limpiar_inputs(forma_calculo);
		cambiar_inputs(forma_calculo);
	});

	$("#tarifa").change(function () {
		let tarifa = $(this).val();
		let forma_calculo = $("#forma_calculo").val();

		$(this).removeClass("is-invalid");

		$("#admin_tarifa").val($("#tarifa option:selected").text());

		cambiar_inputs(forma_calculo);
	});

	$("#periodo").change(function () {
		let periodo = $(this).val();
		let forma_calculo = $("#forma_calculo").val();

		$.ajax({
			url: base_url + "cotizacion/guardar_periodo",
			type: "post",
			data: {
				id_cotizacion_temporal: id_cotizacion_temporal,
				periodo: periodo,
			},
			beforeSend: function () {
				$("#overlay").removeClass("d-none");
			},
			success: function (obj) {
				$("#overlay").addClass("d-none");
				console.log("roi guardado");
				if (periodo == "bimestral") {
					$("label[for='consumo_promedio_kwh']").text(
						"Consumo promedio bimestral (kWh)"
					);
					$("label[for='consumo_promedio_pesos']").text(
						"Consumo promedio bimestral ($)"
					);
					$("label[for='produccion_promedio']").text("Producción bimestral");
					$("#periodo_tabla th").html("Bimestral");
				} else {
					$("label[for='consumo_promedio_kwh']").text(
						"Consumo promedio mensual (kWh)"
					);
					$("label[for='consumo_promedio_pesos']").text(
						"Consumo promedio mensual ($)"
					);
					$("label[for='produccion_promedio']").text("Producción mensual");
					$("#periodo_tabla th").html("Mensual");
				}
				//limpiar_inputs(forma_calculo);
			},
		});
	});

	$("#mostrar_roi").change(function () {
		let mostrar_roi = $(this).val();
		$.ajax({
			url: base_url + "cotizacion/guardar_mostrar_roi",
			type: "post",
			data: {
				id_cotizacion_temporal: id_cotizacion_temporal,
				mostrar_roi: mostrar_roi,
			},
			beforeSend: function () {
				$("#overlay").removeClass("d-none");
			},
			success: function (obj) {
				console.log("roi guardado");
				$("#overlay").addClass("d-none");
				switch (mostrar_roi) {
					case "si":
						$("#contenedor_roi").removeClass("d-none");
						$("#roi_texto").removeClass("d-none");
						break;
					case "no":
						$("#contenedor_roi").addClass("d-none");
						$("#roi_texto").addClass("d-none");
						break;
				}
			},
		});
	});

	function limpiar_inputs(forma_calculo) {
		if (
			!$("#forma_calculo option:selected").prop("disabled") &&
			!$("#tarifa option:selected").prop("disabled")
		) {
			$(
				"#periodo_1, #periodo_2, #periodo_3, #periodo_4, #periodo_5, #periodo_6, #consumo_promedio_kwh, #consumo_promedio_pesos"
			)
				.val("")
				.prop("readonly", true);
			$("#contenedor_grafica").addClass("d-none");
		}
	}

	function cambiar_inputs(forma_calculo) {
		if (
			!$("#forma_calculo option:selected").prop("disabled") &&
			!$("#tarifa option:selected").prop("disabled")
		) {
			switch (forma_calculo) {
				case "consumo":
					$("#consumo_promedio_kwh").prop("readonly", false);
					break;
				case "precio":
					$("#consumo_promedio_pesos").prop("readonly", false);
					break;
				case "recibo":
					$("#contenedor_grafica").removeClass("d-none");
					$(
						"#periodo_1, #periodo_2, #periodo_3, #periodo_4, #periodo_5, #periodo_6"
					).prop("readonly", false);
					break;
			}
		}
	}

	$("#tipo_interconexion").change(function () {
		let tipo_interconexion = $(this).val();
		$(this).removeClass("is-invalid");
		$.ajax({
			url: base_url + "cotizacion/guardar_tipo_interconexion",
			type: "post",
			data: {
				id_cotizacion_temporal: id_cotizacion_temporal,
				tipo_interconexion: tipo_interconexion,
			},
			beforeSend: function () {
				$("#overlay").removeClass("d-none");
			},
			success: function (obj) {
				$("#overlay").addClass("d-none");
				console.log("tipo_interconexion guardado");
				switch (tipo_interconexion) {
					case "inversor_central_austero":
						$("#inversor_central").prop("disabled", false);
						$("#microinversor").prop("disabled", true);
						$("#optimizador").prop("disabled", true);
						break;
					case "inversor_central_optimizadores":
						$("#inversor_central").prop("disabled", false);
						$("#microinversor").prop("disabled", true);
						$("#optimizador").prop("disabled", false);
						break;
					case "microinversores":
						$("#inversor_central").prop("disabled", true);
						$("#microinversor").prop("disabled", false);
						$("#optimizador").prop("disabled", true);
						break;
					case "personalizado":
						$("#inversor_central").prop("disabled", false);
						$("#microinversor").prop("disabled", false);
						$("#optimizador").prop("disabled", false);
						break;
				}
			},
		});
	});

	$(
		"#periodo_1, #periodo_2, #periodo_3, #periodo_4, #periodo_5, #periodo_6"
	).on("input", function () {
		var vacios = false;
		var suma_auxiliar = 0;
		var nuevos_datos = [];
		var promedio_consumo = 0;

		for (var i = 1; i <= 6; i++) {
			if ($("#periodo_" + i).val() == "") {
				vacios = true;
			} else {
				suma_auxiliar += parseFloat($("#periodo_" + i).val());
				nuevos_datos.push(parseFloat($("#periodo_" + i).val()));
				$("#periodo_" + i).removeClass("is-invalid");
				datos_recibo[i - 1] = parseFloat($("#periodo_" + i).val());
			}
		}

		if (nuevos_datos.length > 0) {
			if (!vacios) {
				promedio_consumo = round(suma_auxiliar / 6, 2);
				$("#consumo_promedio_kwh").val(promedio_consumo);
			}
			grafica_consumo.data.datasets[0].data = nuevos_datos;
			grafica_consumo.options.plugins.annotation.annotations.line1.yMin =
				promedio_consumo;
			grafica_consumo.options.plugins.annotation.annotations.line1.yMax =
				promedio_consumo;
			grafica_consumo.options.plugins.annotation.annotations.line1.display = true;
			grafica_consumo.options.plugins.annotation.annotations.line1.label.content =
				"Promedio de consumo: " + promedio_consumo + " kWh";
			grafica_consumo.update();
			grafica_consumo_fija = grafica_consumo;
		}
	});

	$("#calcular_consumos").click(function () {
		$("#overlay").removeClass("d-none");
		console.log("prueba 2");
		console.log("tarifa: " + $("#tarifa").val());
		console.log("periodo: " + $("#periodo").val());
		console.log("id_cotizacion_temporal: " + id_cotizacion_temporal);
		console.log("datos_recibo: " + datos_recibo);

		if (
			$("#forma_calculo").val() == "consumo" ||
			$("#forma_calculo").val() == "recibo"
		) {
			$.ajax({
				url: base_url + "cotizacion/calcular_precio_promedio",
				type: "post",
				data: {
					id_cotizacion_temporal: id_cotizacion_temporal,
					consumo_promedio_kwh: $("#consumo_promedio_kwh").val(),
					tarifa: $("#tarifa").val(),
					periodo: $("#periodo").val(),
					forma_calculo: $("#forma_calculo").val(),
					datos_recibo: datos_recibo,
				},
				success: function (obj) {
					if (obj["resultado"]) {
						$("#consumo_promedio_pesos").val(obj["consumo_promedio_pesos"]);
						$("#admin_gasto_bimestral").val(obj["gasto_bimestral"]);
						$("#admin_gasto_anual").val(obj["gasto_anual"]);
						$("#admin_suministro").val(obj["suministro"]);

						if (!$("#tipo_panel option:selected").prop("disabled")) {
							console.log("entro a if");
							$("#tipo_panel").change();
						} else {
							console.log("no entro a if");
							habilitar_inputs();
							$("#overlay").addClass("d-none");
						}
					}
					console.log(obj);
				},
			});
		} else {
			$.ajax({
				url: base_url + "cotizacion/calcular_consumo_promedio",
				type: "post",
				data: {
					id_cotizacion_temporal: id_cotizacion_temporal,
					consumo_promedio_pesos: $("#consumo_promedio_pesos").val(),
					tarifa: $("#tarifa").val(),
					periodo: $("#periodo").val(),
					forma_calculo: $("#forma_calculo").val(),
				},
				success: function (obj) {
					$("#overlay").addClass("d-none");
					if (obj["resultado"]) {
						$("#consumo_promedio_kwh").val(obj["consumo_promedio_kwh"]);
						$("#admin_gasto_bimestral").val(obj["gasto_bimestral"]);
						$("#admin_gasto_anual").val(obj["gasto_anual"]);
						$("#admin_suministro").val(obj["suministro"]);

						if (!$("#tipo_panel option:selected").prop("disabled")) {
							console.log("entro a if");
							$("#tipo_panel").change();
						} else {
							console.log("no entro a if");
							habilitar_inputs();
							$("#overlay").addClass("d-none");
						}
					}
					console.log(obj);
				},
			});
		}

		$("#consumo_promedio_kwh").removeClass("is-invalid");
		$("#consumo_promedio_pesos").removeClass("is-invalid");
	});

	function habilitar_inputs() {
		$(
			"#tipo_interconexion, #tipo_panel, #tipo_estructura, #sistema_monitoreo, #instalacion_electrica, #optimizador, #microinversor, #inversor_central"
		).prop("disabled", false);
	}

	$("#tipo_panel").change(function () {
		$(this).removeClass("is-invalid");
		$.ajax({
			url: base_url + "cotizacion/guardar_panel",
			data: {
				id_panel: $(this).val(),
				id_cotizacion_temporal: id_cotizacion_temporal,
			},
			type: "post",
			beforeSend: function () {
				$("#overlay").removeClass("d-none");
			},
			success: function (obj) {
				console.log(obj);
				$("#overlay").addClass("d-none");
				if (obj["resultado"]) {
					$("#potencia_total").val(obj["potencia_total"]);
					$("#produccion_promedio").val(obj["produccion_promedio"]);
					$("#produccion_anual").val(obj["produccion_anual"]);
					$("#ahorro").val(obj["ahorro"]);
					$("#num_paneles").prop("disabled", false).val(obj["num_paneles"]);
					$("#cantidad_optimizador").val(obj["num_paneles"]);
					$("#cantidad_microinversor").val(obj["num_paneles"]);

					console.log("PRODUCTOS TEMPORALES:");
					elementos_cotizacion = obj["productos_temporales"];
					console.log(elementos_cotizacion);

					console.log("TOTALES:");
					totales = obj["totales"];
					console.log(totales);

					console.log("DATOS AHORRO:");
					datos_ahorro = obj["datos_ahorro"];
					console.log(datos_ahorro);

					if ($("#forma_calculo").val() == "recibo") {
						if (
							obj["produccion_promedio"] >
							parseFloat($("#consumo_promedio_kwh").val())
						) {
							signo_grafica = -1;
						} else {
							signo_grafica = 1;
						}
						grafica_consumo.options.plugins.annotation.annotations.line2.yMin =
							obj["produccion_promedio"];
						grafica_consumo.options.plugins.annotation.annotations.line2.yMax =
							obj["produccion_promedio"];
						grafica_consumo.options.plugins.annotation.annotations.line2.display = true;
						grafica_consumo.options.plugins.annotation.annotations.line2.label.content =
							"Generación por paneles: " + obj["produccion_promedio"] + " kWh";
						grafica_consumo.update();
					}

					mostrar_ahorros();
					actualizar_lista_elementos();
				}
			},
		});
	});

	$("#num_paneles").change(function () {
		clearTimeout(wto);
		wto = setTimeout(function () {
			$.ajax({
				url: base_url + "cotizacion/guardar_numero_paneles",
				data: {
					id_panel: $("#tipo_panel").val(),
					id_cotizacion_temporal: id_cotizacion_temporal,
					num_paneles: $("#num_paneles").val(),
				},
				type: "post",
				beforeSend: function () {
					$("#overlay").removeClass("d-none");
				},
				success: function (obj) {
					$("#overlay").addClass("d-none");
					console.log(obj);
					if (obj["resultado"]) {
						$("#potencia_total").val(obj["potencia_total"]);
						$("#produccion_promedio").val(obj["produccion_promedio"]);
						$("#produccion_anual").val(obj["produccion_anual"]);
						$("#ahorro").val(obj["ahorro"]);
						$("#num_paneles").prop("disabled", false).val(obj["num_paneles"]);

						console.log(obj["productos_temporales"]);
						elementos_cotizacion = obj["productos_temporales"];
						totales = obj["totales"];
						datos_ahorro = obj["datos_ahorro"];
						console.log(datos_ahorro);

						if ($("#forma_calculo").val() == "recibo") {
							if (
								obj["produccion_promedio"] >
								parseFloat($("#consumo_promedio_kwh").val())
							) {
								signo_grafica = -1;
							} else {
								signo_grafica = 1;
							}
							grafica_consumo.options.plugins.annotation.annotations.line2.yMin =
								obj["produccion_promedio"];
							grafica_consumo.options.plugins.annotation.annotations.line2.yMax =
								obj["produccion_promedio"];
							grafica_consumo.options.plugins.annotation.annotations.line2.display = true;
							grafica_consumo.options.plugins.annotation.annotations.line2.label.content =
								"Generación por paneles: " +
								obj["produccion_promedio"] +
								" kWh";
							grafica_consumo.update();
						}

						mostrar_ahorros();
						actualizar_lista_elementos();
					}
				},
			});
		}, 500);
	});

	$("#tipo_estructura").change(function () {
		let id_tipo_estructura = $(this).val();

		$.ajax({
			url: base_url + "estructuras/obtener_estructuras_tipo",
			data: {
				id_tipo_estructura: id_tipo_estructura,
			},
			type: "post",
			beforeSend: function () {
				$("#overlay").removeClass("d-none");
			},
			success: function (obj) {
				$("#overlay").addClass("d-none");
				if (obj["resultado"]) {
					$("#estructura").prop("disabled", false);

					$.each(obj["estructuras"], function (i, elemento) {
						$("#estructura").append(
							'<option value="' +
								elemento.id_estructura +
								'">' +
								elemento.codigo +
								"</option>"
						);
					});
				} else {
					$("#estructura").prop("disabled", false);
				}
			},
		});
	});

	$("#agregar_estructura").click(function () {
		$.ajax({
			url: base_url + "cotizacion/guardar_producto",
			data: {
				id_producto: $("#estructura").val(),
				id_cotizacion_temporal: id_cotizacion_temporal,
				tipo_producto: "estructura",
				cantidad: $("#cantidad_estructura").val(),
				principal: 0,
			},
			type: "post",
			beforeSend: function () {
				$("#overlay").removeClass("d-none");
			},
			success: function (obj) {
				console.log(obj);
				if (obj["resultado"]) {
					console.log("estructura añadida");
					$("#cantidad_estructura").prop("disabled", true);
					$("#agregar_estructura").prop("disabled", true);
					$("#estructura").prop("disabled", true);
					$("#tipo_estructura option:selected").prop("selected", false);
					$("#tipo_estructura option:first").prop("selected", "selected");

					$("#estructura option:selected").prop("selected", false);
					$("#estructura option:first").prop("selected", "selected");
					$("#estructura option:not(:first)").remove();
					$("#cantidad_estructura").val(1);

					console.log(obj["productos_temporales"]);
					elementos_cotizacion = obj["productos_temporales"];
					datos_ahorro = obj["datos_ahorro"];
					totales = obj["totales"];
					actualizar_lista_elementos();
					console.log(datos_ahorro);
					mostrar_ahorros();
				} else {
					console.log("estructura no añadida");
				}
				$("#overlay").addClass("d-none");
			},
		});
	});

	$("#estructura").change(function () {
		$("#cantidad_estructura").prop("disabled", false);
		$("#agregar_estructura").prop("disabled", false);
	});

	$(
		"#inversor_central, #microinversor, #optimizador, #sistema_monitoreo"
	).change(function () {
		let id = $(this).attr("id");
		let tipo_producto;
		let cantidad;

		switch (id) {
			case "inversor_central":
				tipo_producto = "inversor";
				cantidad = 1;
				break;
			case "microinversor":
				tipo_producto = "microinversor";
				cantidad = $("#num_paneles").val();
				break;
			case "optimizador":
				tipo_producto = "optimizador";
				cantidad = $("#num_paneles").val();
				break;
			case "sistema_monitoreo":
				tipo_producto = "sistema_monitoreo";
				cantidad = 1;
				break;
		}

		$.ajax({
			url: base_url + "cotizacion/guardar_producto",
			data: {
				id_producto: $(this).val(),
				id_cotizacion_temporal: id_cotizacion_temporal,
				tipo_producto: tipo_producto,
				cantidad: cantidad,
				principal: 1,
			},
			type: "post",
			beforeSend: function () {
				$("#overlay").removeClass("d-none");
			},
			success: function (obj) {
				$("#overlay").addClass("d-none");
				console.log(obj);
				if (obj["resultado"]) {
					console.log(obj["productos_temporales"]);
					elementos_cotizacion = obj["productos_temporales"];
					datos_ahorro = obj["datos_ahorro"];
					totales = obj["totales"];
					actualizar_lista_elementos();
					console.log(datos_ahorro);
					mostrar_ahorros();
				} else {
					console.log("producto no añadido");
				}
			},
		});
	});

	$("#instalacion_electrica, #admin_costo_instalacion").change(function () {
		let metros = $("#instalacion_electrica").val();
		let instalacion = $("#admin_costo_instalacion").val();
		console.log("entra a instalacion eletrica");
		$.ajax({
			url: base_url + "cotizacion/guardar_instalacion_electrica",
			data: {
				id_cotizacion_temporal: id_cotizacion_temporal,
				metros: metros,
				instalacion: instalacion,
			},
			type: "post",
			beforeSend: function () {
				$("#overlay").removeClass("d-none");
			},
			success: function (obj) {
				$("#overlay").addClass("d-none");
				console.log(obj);
				if (obj["resultado"]) {
					console.log(obj["productos_temporales"]);
					elementos_cotizacion = obj["productos_temporales"];
					datos_ahorro = obj["datos_ahorro"];
					totales = obj["totales"];
					actualizar_lista_elementos();
					console.log(datos_ahorro);
					mostrar_ahorros();
				} else {
					console.log("producto no añadido");
				}
			},
		});
	});

	$("#admin_costo_material_electrico").change(function () {
		let material_electrico = $(this).val();
		console.log("entra a material eletrico");
		$.ajax({
			url: base_url + "cotizacion/guardar_material_electrico",
			data: {
				id_cotizacion_temporal: id_cotizacion_temporal,
				material_electrico: material_electrico,
			},
			type: "post",
			beforeSend: function () {
				$("#overlay").removeClass("d-none");
			},
			success: function (obj) {
				$("#overlay").addClass("d-none");
				console.log(obj);
				if (obj["resultado"]) {
					console.log(obj["productos_temporales"]);
					elementos_cotizacion = obj["productos_temporales"];
					datos_ahorro = obj["datos_ahorro"];
					totales = obj["totales"];
					actualizar_lista_elementos();
					console.log(datos_ahorro);
					mostrar_ahorros();
				} else {
					console.log("producto no añadido");
				}
			},
		});
	});

	$("#cambiar_indice").click(function () {
		if (!cambiando_indice) {
			cambiando_indice = true;
			$("#admin_indice_utilidad").prop("readonly", false);
			$(this).removeClass("btn-primary");
			$(this).addClass("btn-success");
			$(this).html("Guardar");

			$("#admin_indice_utilidad").on("input", function () {
				indice_correcto = false;
				var indice = $(this).val();
				if (indice.match(/^\d?\d(?:\.\d\d?)?$/g)) {
					indice_numerico = parseFloat(indice);
					if (!isNaN(indice_numerico)) {
						if (indice_numerico >= 1 || indice_numerico <= 100) {
							$("#cambiar_indice").prop("disabled", false);
							indice_correcto = true;
						} else {
							$(this).val("");
							$("#cambiar_indice").prop("disabled", true);
							indice_correcto = false;
						}
					} else {
						$(this).val("");
						$("#cambiar_indice").prop("disabled", true);
						indice_correcto = false;
					}
				} else {
					$(this).val("");
					$("#cambiar_indice").prop("disabled", true);
					indice_correcto = false;
				}
			});

			$("#admin_indice_utilidad").trigger("input");
		} else {
			if (indice_correcto) {
				$("#overlay").removeClass("d-none");
				$("#admin_indice_utilidad").prop("readonly", true);
				$(this).prop("disabled", false);
				$(this).addClass("btn-primary");
				$(this).removeClass("btn-success");
				$(this).html("Cambiar");
				$("#admin_indice_utilidad").off();
				cambiando_indice = false;
				indice_utilidad = $("#admin_indice_utilidad").val();
				console.log("valor correcto: " + indice_utilidad);
				$.ajax({
					url: base_url + "cotizacion/guardar_indice_utilidad",
					data: {
						id_cotizacion_temporal: id_cotizacion_temporal,
						indice_utilidad: indice_utilidad,
					},
					type: "post",
					success: function (obj) {
						console.log(obj);
						if (obj["resultado"]) {
							console.log(obj["productos_temporales"]);
							elementos_cotizacion = obj["productos_temporales"];
							datos_ahorro = obj["datos_ahorro"];
							totales = obj["totales"];
							actualizar_lista_elementos();
							console.log(datos_ahorro);
							mostrar_ahorros();
						} else {
							console.log("indice no cambiado");
						}
						$("#overlay").addClass("d-none");
					},
				});
			}
		}
	});

	$("#cambiar_tasa_usd").click(function () {
		if (!cambiando_tasa) {
			cambiando_tasa = true;
			$("#admin_tasa_cambio").prop("readonly", false);
			$(this).removeClass("btn-primary");
			$(this).addClass("btn-success");
			$(this).html("Guardar");

			$("#admin_tasa_cambio").on("input", function () {
				tasa_correcta = false;
				let tasa_cambio = $(this).val();
				if (tasa_cambio.match(/^\d?\d(?:\.\d\d?)?$/g)) {
					tasa_cambio_numerico = parseFloat(tasa_cambio);
					if (!isNaN(tasa_cambio_numerico)) {
						if (tasa_cambio_numerico > 0) {
							$("#cambiar_tasa_usd").prop("disabled", false);
							tasa_correcta = true;
						} else {
							$(this).val("");
							$("#cambiar_tasa_usd").prop("disabled", true);
							tasa_correcta = false;
						}
					} else {
						$(this).val("");
						$("#cambiar_tasa_usd").prop("disabled", true);
						tasa_correcta = false;
					}
				} else {
					$(this).val("");
					$("#cambiar_tasa_usd").prop("disabled", true);
					tasa_correcta = false;
				}
			});

			$("#admin_tasa_cambio").trigger("input");
		} else {
			if (tasa_correcta) {
				$("#overlay").removeClass("d-none");
				$("#admin_tasa_cambio").prop("readonly", true);
				$(this).prop("disabled", false);
				$(this).addClass("btn-primary");
				$(this).removeClass("btn-success");
				$(this).html("Cambiar");
				$("#admin_tasa_cambio").off();
				cambiando_tasa = false;
				let tasa_cambio_usd = $("#admin_tasa_cambio").val();
				console.log("valor correcto tasa: " + tasa_cambio_usd);
				$.ajax({
					url: base_url + "cotizacion/guardar_tasa_cambio",
					data: {
						id_cotizacion_temporal: id_cotizacion_temporal,
						tasa_cambio_usd: tasa_cambio_usd,
					},
					type: "post",
					success: function (obj) {
						console.log(obj);
						if (obj["resultado"]) {
							console.log(obj["productos_temporales"]);
							$("#admin_fecha_tasa_cambio").val(obj["fecha_tasa"]);
							elementos_cotizacion = obj["productos_temporales"];
							datos_ahorro = obj["datos_ahorro"];
							totales = obj["totales"];
							actualizar_lista_elementos();
							console.log(datos_ahorro);
							mostrar_ahorros();
						} else {
							console.log("tasa no cambiado");
						}
						$("#overlay").addClass("d-none");
					},
				});
			}
		}
	});

	$(document).on("click", ".eliminar-producto", function () {
		let row = $(this).closest("tr");
		let id_producto = $(row).attr("data-prod-id");
		let tipo_producto = $(row).attr("data-tipo");

		$.ajax({
			url: base_url + "cotizacion/eliminar_producto",
			data: {
				id_producto: id_producto,
				id_cotizacion_temporal: id_cotizacion_temporal,
				tipo_producto: tipo_producto,
			},
			type: "post",
			beforeSend: function () {
				$("#overlay").removeClass("d-none");
			},
			success: function (obj) {
				console.log(obj);
				if (obj["resultado"]) {
					console.log("PRODUCTOS TEMPORALES: ");
					console.log(obj["productos_temporales"]);
					elementos_cotizacion = obj["productos_temporales"];

					console.log("TOTALES: ");
					totales = obj["totales"];
					console.log(totales);

					console.log("DATOS AHORRO: ");
					datos_ahorro = obj["datos_ahorro"];
					console.log(datos_ahorro);

					if (obj["principal"] == 1) {
						console.log("entro a principal, tipo_producto: " + tipo_producto);
						switch (tipo_producto) {
							case "panel_solar":
								$("#tipo_panel option:first").prop("selected", true);
								$("#potencia_total").val("");
								$("#produccion_promedio").val("");
								$("#produccion_anual").val("");
								$("#ahorro").val("");
								$("#num_paneles").prop("disabled", true).val(0);
								break;
							case "inversor":
								console.log("entro al case");
								$("#inversor_central option:first").prop("selected", true);
								break;
							case "microinversor":
								$("#microinversor option:first").prop("selected", true);
								break;
							case "optimizador":
								$("#optimizador option:first").prop("selected", true);
								break;
							case "sistema_monitoreo":
								$("#sistema_monitoreo option:first").prop("selected", true);
								break;
						}
					}

					calcular();
				} else {
					console.log("producto no eliminado");
				}
				$("#overlay").addClass("d-none");
			},
		});
	});

	$(document).on("click", ".btn-agregar", function () {
		let row = $(this).closest("tr");
		let id_producto = $(row).attr("data-prod-id");
		let tipo_producto = $(row).attr("data-tipo");
		let cantidad = $(row).find("input").val();

		$.ajax({
			url: base_url + "cotizacion/guardar_producto",
			data: {
				id_producto: id_producto,
				id_cotizacion_temporal: id_cotizacion_temporal,
				tipo_producto: tipo_producto,
				cantidad: cantidad,
				principal: 0,
			},
			type: "post",
			beforeSend: function () {
				$("#overlay").removeClass("d-none");
			},
			success: function (obj) {
				console.log(obj);
				if (obj["resultado"]) {
					Swal.fire({
						icon: "success",
						title: "El producto se ha agregado correctamente",
						confirmButtonText: "Aceptar",
					});

					console.log(obj["productos_temporales"]);
					elementos_cotizacion = obj["productos_temporales"];
					totales = obj["totales"];
					actualizar_lista_elementos();
				} else {
					console.log("producto no añadido");
				}
				$("#overlay").addClass("d-none");
			},
		});
	});

	$(document).on("change", ".cantidad-producto", function () {
		let row = $(this).closest("tr");
		let id_producto = $(row).attr("data-prod-id");
		let tipo_producto = $(row).attr("data-tipo");
		let cantidad = $(this).val();
		let principal = $(row).attr("data-principal");

		console.log(row);
		console.log(id_producto);
		console.log(tipo_producto);
		console.log(cantidad);

		if (tipo_producto == "panel_solar" && principal == "1") {
			$("#num_paneles").val(cantidad).change();
		} else {
			clearTimeout(wto);
			wto = setTimeout(function () {
				$.ajax({
					url: base_url + "cotizacion/cambiar_cantidad_producto",
					data: {
						id_producto: id_producto,
						id_cotizacion_temporal: id_cotizacion_temporal,
						tipo_producto: tipo_producto,
						cantidad: cantidad,
					},
					type: "post",
					beforeSend: function () {
						$("#overlay").removeClass("d-none");
					},
					success: function (obj) {
						console.log(obj);
						if (obj["resultado"]) {
							console.log("PRODUCTOS TEMPORALES: ");
							console.log(obj["productos_temporales"]);
							elementos_cotizacion = obj["productos_temporales"];

							console.log("TOTALES: ");
							totales = obj["totales"];
							console.log(totales);

							console.log("DATOS AHORRO: ");
							datos_ahorro = obj["datos_ahorro"];
							console.log(datos_ahorro);

							actualizar_lista_elementos();
							calcular();
						} else {
							console.log("cantidad no cambiada");
						}
						$("#overlay").addClass("d-none");
					},
				});
			}, 500);
		}
	});

	$("#modal_tipo_producto").on("change", function () {
		let tipo_producto = $(this).val();
		var productos = null;
		let columnas = new Array();

		$("#tabla_agregar thead tr th").each(function () {
			columnas.push($(this).html());
		});

		switch (tipo_producto) {
			case "paneles_solares":
				$.ajax({
					url: base_url + "paneles/cargar_paneles",
					type: "post",
					beforeSend: function () {
						$("#overlay").removeClass("d-none");
					},
					success: function (obj) {
						tabla_agregar.clear().draw();
						productos = obj["paneles"].map(({ id_panel: id, ...rest }) => ({
							id,
							tipo: "panel",
							...rest,
						}));
						llenar_tabla();
						$("#overlay").addClass("d-none");
					},
				});
				break;
			case "optimizadores":
				$.ajax({
					url: base_url + "optimizadores/cargar_optimizadores",
					type: "post",
					beforeSend: function () {
						$("#overlay").removeClass("d-none");
					},
					success: function (obj) {
						tabla_agregar.clear().draw();
						productos = obj["optimizadores"].map(
							({ id_optimizador: id, ...rest }) => ({
								id,
								tipo: "optimizador",
								...rest,
							})
						);
						llenar_tabla();
						$("#overlay").addClass("d-none");
					},
				});
				break;
			case "inversores_centrales":
				$.ajax({
					url: base_url + "inversores/cargar_inversores",
					type: "post",
					beforeSend: function () {
						$("#overlay").removeClass("d-none");
					},
					success: function (obj) {
						tabla_agregar.clear().draw();
						productos = obj["inversores"].map(
							({ id_inversor: id, ...rest }) => ({
								id,
								tipo: "inversor",
								...rest,
							})
						);
						llenar_tabla();
						$("#overlay").addClass("d-none");
					},
				});
				break;
			case "estructuras":
				$.ajax({
					url: base_url + "estructuras/cargar_estructuras",
					type: "post",
					beforeSend: function () {
						$("#overlay").removeClass("d-none");
					},
					success: function (obj) {
						tabla_agregar.clear().draw();
						productos = obj["estructuras"].map(
							({ id_estructura: id, ...rest }) => ({
								id,
								tipo: "estructura",
								...rest,
							})
						);
						llenar_tabla();
						$("#overlay").addClass("d-none");
					},
				});
				break;
			case "microinversores":
				$.ajax({
					url: base_url + "microinversores/cargar_microinversores",
					type: "post",
					beforeSend: function () {
						$("#overlay").removeClass("d-none");
					},
					success: function (obj) {
						tabla_agregar.clear().draw();
						productos = obj["microinversores"].map(
							({ id_microinversor: id, ...rest }) => ({
								id,
								tipo: "microinversor",
								...rest,
							})
						);
						llenar_tabla();
						$("#overlay").addClass("d-none");
					},
				});
				break;
			case "sistemas_monitoreo":
				$.ajax({
					url: base_url + "sistemas_monitoreo/cargar_sistemas",
					type: "post",
					beforeSend: function () {
						$("#overlay").removeClass("d-none");
					},
					success: function (obj) {
						tabla_agregar.clear().draw();
						productos = obj["sistemas"].map(
							({ id_sistema_monitoreo: id, ...rest }) => ({
								id,
								tipo: "sistema_monitoreo",
								...rest,
							})
						);
						llenar_tabla();
						$("#overlay").addClass("d-none");
					},
				});
				break;
			case "extras":
				$.ajax({
					url: base_url + "extras/cargar_extras",
					type: "post",
					beforeSend: function () {
						$("#overlay").removeClass("d-none");
					},
					success: function (obj) {
						tabla_agregar.clear().draw();
						productos = obj["extras"].map(({ id_extra: id, ...rest }) => ({
							id,
							tipo: "extra",
							...rest,
						}));
						llenar_tabla();
						$("#overlay").addClass("d-none");
					},
				});
				break;
		}

		function llenar_tabla() {
			tabla_agregar.clear().draw();
			$.each(productos, function (i, elemento) {
				let nueva_fila = tabla_agregar.row
					.add([
						elemento.codigo,
						elemento.producto,
						elemento.marca,
						'<input type="number" class="form-control cantidad-modal" value="1" min="1">',
						'<button type="button" class="btn btn-success btn-agregar"><i class="fa fa-plus"></i></button>',
					])
					.draw()
					.node();

				$(nueva_fila).attr("data-prod-id", elemento.id);
				$(nueva_fila).attr("data-tipo", elemento.tipo);

				$(".cantidad-modal", nueva_fila).each(function (index, input) {
					$(input).inputSpinner();
				});

				$("td", nueva_fila).each(function (index, td) {
					$(td).attr("data-label", columnas[index]);
				});
			});
		}
	});

	$("#nuevo_extra").on("submit", function (e) {
		e.preventDefault();
		$("#overlay").removeClass("d-none");
		$.ajax({
			url: base_url + "extras/agregar_extra",
			type: "post",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			datatype: "json",
			success: function (obj) {
				if (obj["resultado"] == true) {
					$("#nuevo_extra").trigger("reset");

					$.ajax({
						url: base_url + "cotizacion/guardar_producto",
						data: {
							id_producto: obj["id_extra"],
							id_cotizacion_temporal: id_cotizacion_temporal,
							tipo_producto: "extra",
							cantidad: 1,
							principal: 0,
						},
						type: "post",
						success: function (obj) {
							console.log(obj);
							if (obj["resultado"]) {
								console.log(obj["productos_temporales"]);
								elementos_cotizacion = obj["productos_temporales"];
								datos_ahorro = obj["datos_ahorro"];
								totales = obj["totales"];
								actualizar_lista_elementos();
								console.log(datos_ahorro);
								mostrar_ahorros();

								Swal.fire({
									icon: "success",
									title: "El extra se ha guardado y agregado correctamente",
									confirmButtonText: "Aceptar",
								});
							} else {
								console.log("producto no añadido");
							}
						},
					});
				} else {
					swal.fire({
						icon: "error",
						title: "No se pudo agregar el extra",
					});
				}
				$("#overlay").addClass("d-none");
			},
			complete: function () {
				$("#modal_agregar_producto").trigger("reset");
			},
		});
	});

	function calcular() {
		if (totales != false) {
			actualizar_lista_elementos();
			if (totales.paneles_elegidos == 1) {
				mostrar_ahorros();
			} else {
				$("#periodo_tabla td:eq(0)").empty();
				$("#1_anio td:eq(0)").empty();
				$("#5_anios td:eq(0)").empty();
				$("#10_anios td:eq(0)").empty();
				$("#25_anios td:eq(0)").empty();

				$("#periodo_tabla td:eq(1)").empty();
				$("#1_anio td:eq(1)").empty();
				$("#5_anios td:eq(1)").empty();
				$("#10_anios td:eq(1)").empty();
				$("#25_anios td:eq(1)").empty();

				$("#periodo_tabla td:eq(2)").empty();
				$("#1_anio td:eq(2)").empty();
				$("#5_anios td:eq(2)").empty();
				$("#10_anios td:eq(2)").empty();
				$("#25_anios td:eq(2)").empty();

				grafica_roi.data.datasets[0].data = new Array(5).fill(0);
				grafica_roi.update();

				$("#retorno_inversion td:eq(0)").empty();
			}
		} else {
			tabla_productos.clear().draw();
			tabla_costos.clear().draw();

			$("#tabla_totales tbody").html(
				"<tr>" +
					'<th colspan="3">SUBTOTAL</th>' +
					"<td>" +
					dinero(0) +
					"</td>" +
					"</tr>" +
					"<tr>" +
					'<th colspan="3">IVA</th>' +
					"<td>" +
					dinero(0) +
					"</td>" +
					"</tr>" +
					"<tr>" +
					'<th colspan="3">TOTAL</th>' +
					"<td>" +
					dinero(0) +
					"</td>" +
					"</tr>"
			);

			$("#periodo_tabla td:eq(0)").empty();
			$("#1_anio td:eq(0)").empty();
			$("#5_anios td:eq(0)").empty();
			$("#10_anios td:eq(0)").empty();
			$("#25_anios td:eq(0)").empty();

			$("#periodo_tabla td:eq(1)").empty();
			$("#1_anio td:eq(1)").empty();
			$("#5_anios td:eq(1)").empty();
			$("#10_anios td:eq(1)").empty();
			$("#25_anios td:eq(1)").empty();

			$("#periodo_tabla td:eq(2)").empty();
			$("#1_anio td:eq(2)").empty();
			$("#5_anios td:eq(2)").empty();
			$("#10_anios td:eq(2)").empty();
			$("#25_anios td:eq(2)").empty();

			grafica_roi.data.datasets[0].data = new Array(5).fill(0);
			grafica_roi.update();

			$("#retorno_inversion td:eq(0)").empty();
		}
	}

	function mostrar_ahorros() {
		$("#periodo_tabla td:eq(0)").text(
			dinero(datos_ahorro.consumo_promedio_pesos)
		);
		$("#1_anio td:eq(0)").text(
			dinero(datos_ahorro.pagos_anuales_sin_paneles[0])
		);
		$("#5_anios td:eq(0)").text(
			dinero(datos_ahorro.pagos_anuales_sin_paneles[4])
		);
		$("#10_anios td:eq(0)").text(
			dinero(datos_ahorro.pagos_anuales_sin_paneles[9])
		);
		$("#25_anios td:eq(0)").text(
			dinero(datos_ahorro.pagos_anuales_sin_paneles[24])
		);

		$("#periodo_tabla td:eq(1)").text(dinero(datos_ahorro.restante_pesos));
		$("#1_anio td:eq(1)").text(
			dinero(datos_ahorro.pagos_anuales_con_paneles[0])
		);
		$("#5_anios td:eq(1)").text(
			dinero(datos_ahorro.pagos_anuales_con_paneles[4])
		);
		$("#10_anios td:eq(1)").text(
			dinero(datos_ahorro.pagos_anuales_con_paneles[9])
		);
		$("#25_anios td:eq(1)").text(
			dinero(datos_ahorro.pagos_anuales_con_paneles[24])
		);

		$("#periodo_tabla td:eq(2)").text(dinero(datos_ahorro.ahorro));
		$("#1_anio td:eq(2)").text(dinero(datos_ahorro.ahorro_anios[0]));
		$("#5_anios td:eq(2)").text(dinero(datos_ahorro.ahorro_anios[4]));
		$("#10_anios td:eq(2)").text(dinero(datos_ahorro.ahorro_anios[9]));
		$("#25_anios td:eq(2)").text(dinero(datos_ahorro.ahorro_anios[24]));

		grafica_roi.data.datasets[0].data = datos_ahorro.datos_roi;
		grafica_roi.update();

		$("#retorno_inversion td:eq(0)").text(
			datos_ahorro.retorno_inversion + " años"
		);
	}

	function actualizar_lista_elementos() {
		tabla_productos.clear().draw();
		tabla_costos.clear().draw();
		console.log(elementos_cotizacion);
		let tabla_totales = "";

		$.each(elementos_cotizacion, function (index, producto) {
			let nueva_fila = tabla_productos.row
				.add([
					producto.datos_producto.codigo,
					producto.datos_producto.producto,
					producto.datos_producto.marca,
					'<input type="number" class="form-control cantidad-producto" value="' +
						producto.cantidad +
						'" min="1">',
					'<button type="button" class="btn btn-danger eliminar-producto"><i class="fa fa-trash-o"></i></button>',
				])
				.draw()
				.node();

			$("td", nueva_fila).each(function (index, td) {
				$(td).attr("data-label", columnas_tabla_productos[index]);
				if (columnas_tabla_productos[index] == "Cantidad") {
					$(td).addClass("no-gutters");
				}
			});

			$(nueva_fila).attr("data-prod-id", producto.id_producto);
			$(nueva_fila).attr("data-tipo", producto.tipo_producto);
			$(nueva_fila).attr("data-principal", producto.principal);

			let props = {
				groupClass: "col-9 ml-auto justify-content-end",
			};

			$(".cantidad-producto", nueva_fila).each(function (index, input) {
				$(input).inputSpinner(props);
				//$(input).next(".input-group").addClass('col-9 ml-auto justify-content-end');
			});

			if (producto.principal == 1) {
				switch (producto.tipo_producto) {
					case "panel_solar":
						$('#tipo_panel [value="' + producto.id_producto + '"').prop(
							"selected",
							true
						);
						$("#num_paneles").prop("disabled", false);
						break;
					case "inversor":
						$('#inversor_central [value="' + producto.id_producto + '"').prop(
							"selected",
							true
						);
						break;
					case "microinversor":
						$('#microinversor [value="' + producto.id_producto + '"').prop(
							"selected",
							true
						);
						$("#cantidad_microinversor")
							.prop("disabled", false)
							.val(producto.cantidad);
						break;
					case "optimizador":
						$('#optimizador [value="' + producto.id_producto + '"').prop(
							"selected",
							true
						);
						$("#cantidad_optimizador")
							.prop("disabled", false)
							.val(producto.cantidad);
						break;
					case "sistema_monitoreo":
						$('#sistema_monitoreo [value="' + producto.id_producto + '"').prop(
							"selected",
							true
						);
						break;
					case "producto_fijo":
						if (producto.datos_producto.codigo == "INGENIERIA_INSTALACION") {
							$("#admin_costo_tuberia").val(
								dinero(totales.tuberia_cableado, false)
							);
							$("#instalacion_electrica").val(totales.metros_instalacion);
							$(
								"#tabla_productos tbody tr[data-prod-id=" +
									producto.id_producto +
									'][data-tipo="producto_fijo"] input.cantidad-producto'
							).prop("disabled", true);
							console.log("prod id : " + producto.id_producto);
						}
						if (producto.datos_producto.codigo == "MATERIAL_ELECTRICO") {
							$(
								"#tabla_productos tbody tr[data-prod-id=" +
									producto.id_producto +
									'][data-tipo="producto_fijo"] input.cantidad-producto'
							).prop("disabled", true);
							console.log("prod id : " + producto.id_producto);
						}
						break;
				}
			}

			let fila_costos = tabla_costos.row
				.add([
					producto.datos_producto.codigo,
					producto.datos_producto.producto,
					producto.datos_producto.marca,
					producto.cantidad,
					dinero(producto.cpu_usd),
					dinero(producto.cpu_mxn),
					dinero(producto.costo_total),
					dinero(producto.precio_final),
				])
				.draw()
				.node();

			$("td", fila_costos).each(function (index, td) {
				$(td).attr("data-label", columnas_tabla_costos[index]);
			});

			$(fila_costos).attr("data-prod-id", producto.id_producto);
			$(fila_costos).attr("data-tipo", producto.tipo_producto);

			tabla_totales +=
				"<tr>" +
				"<td>" +
				producto.datos_producto.codigo +
				"</td>" +
				"<td>" +
				producto.datos_producto.producto +
				"</td>" +
				"<td>" +
				producto.cantidad +
				"</td>" +
				"<td>" +
				dinero(producto.precio_final) +
				"</td>" +
				"</tr>";
		});

		$("#tabla_totales tbody").html(tabla_totales);

		$("#total_costos").html(dinero(totales.total_costos));
		$("#total_precios_finales").html(dinero(totales.subtotal));
		$("#subtotal").html(dinero(totales.subtotal));
		$("#iva").html(dinero(totales.subtotal_iva));
		$("#total").html(dinero(totales.total_final));

		$("#admin_costo_panel_instalado").val(
			dinero(totales.costo_por_panel, false)
		);
		$("#admin_costo_watt_instalado").val(dinero(totales.costo_por_watt, false));
		$("#admin_costo_proyecto").val(dinero(totales.costo_proveedores, false));
		$("#admin_proyecto_iva").val(dinero(totales.iva_proveedores, false));
		$("#admin_proyecto_utilidad").val(dinero(totales.utilidad, false));
		$("#admin_costo_proyecto_iva").val(
			dinero(totales.pago_minimo_cliente, false)
		);
		$("#admin_costo_proyecto_utilidad").val(
			dinero(totales.precio_al_cliente, false)
		);
		$("#admin_costo_proyecto_final").val(dinero(totales.precio_final, false));
		$("#admin_porcentaje_minimo").val(dinero(totales.porcentaje_minimo, false));
	}

	function revisar_cotizacion() {
		let llenos = true;

		/* if (!$("#nombre_usuario").val()) {
			llenos = false;
			$("#nombre_usuario").addClass("is-invalid");
		}

		if (!$("#ubicacion").val()) {
			llenos = false;
			$("#ubicacion").addClass("is-invalid");
		}

		if (!$("#telefono").val()) {
			llenos = false;
			$("#telefono").addClass("is-invalid");
		}

		if (!$("#correo").val()) {
			llenos = false;
			$("#correo").addClass("is-invalid");
		}

		if (!$("#num_servicio").val()) {
			llenos = false;
			$("#num_servicio").addClass("is-invalid");
		} */

		if (!$("#forma_calculo").val()) {
			llenos = false;
			$("#forma_calculo").addClass("is-invalid");
		}

		if (!$("#tarifa").val()) {
			llenos = false;
			$("#tarifa").addClass("is-invalid");
		}

		if (!$("#consumo_promedio_kwh").val()) {
			llenos = false;
			$("#consumo_promedio_kwh").addClass("is-invalid");
		}

		if (!$("#consumo_promedio_pesos").val()) {
			llenos = false;
			$("#consumo_promedio_pesos").addClass("is-invalid");
		}

		if (!$("#tipo_interconexion").val()) {
			llenos = false;
			$("#tipo_interconexion").addClass("is-invalid");
		}

		if (!$("#tipo_panel").val()) {
			llenos = false;
			$("#tipo_panel").addClass("is-invalid");
		}

		return llenos;
	}

	$("#generar_cotizacion").click(function (e) {
		if (revisar_cotizacion()) {
			$("#overlay").removeClass("d-none");
			$("#contenedor_grafica").addClass("d-none");
			$("#contenedor_roi").addClass("d-none");
			grafica_consumo.resize(1300, 500);
			grafica_roi.resize(1300, 400);
			const canvas1 = document.getElementById("grafica_consumo");
			const canvas2 = document.getElementById("grafica_roi");
			cambiar_fondo_canvas(canvas1, "rgb(255,255,255)");
			cambiar_fondo_canvas(canvas2, "rgb(255,255,255)");
			$.ajax({
				url: base_url + "cotizacion/guardar_cotizacion",
				data: {
					id_cotizacion_temporal: id_cotizacion_temporal,
					id_usuario: id_usuario,
					grafica_consumo: grafica_consumo.toBase64Image("image/jpeg", 0.3),
					grafica_roi: grafica_roi.toBase64Image("image/jpeg", 0.3),
					id_cliente: $("#clienteExistente").val(),
					tipo_cliente: $("#tipo_cliente").val(),
				},
				type: "post",
				success: function (obj) {
					window.location.replace(
						base_url +
							"cotizacion/previsualizar_cotizacion/" +
							obj["id_cotizacion"]
					);
				},
			});
		} else {
			e.preventDefault();
			Swal.fire({
				heightAuto: false,
				title: "Faltan datos",
				text: "No has llenado todos los datos requeridos para generar la cotización",
				icon: "error",
				didClose: () => $("html, body").animate({ scrollTop: 0 }, "fast"),
			});
			$("#overlay").addClass("d-none");
		}
	});
});
