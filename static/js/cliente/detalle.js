$(document).ready(function () {
	//cargar_datos();
	cargar_cliente();
	const comentariosContainer = $("#comentariosContainer");
	const recibosContainer = $("#recibosContainer");
	const tableBody = $("#cotizacionesTable tbody");

	// Función para cargar comentarios usando AJAX
	function cargarComentarios(id_cliente) {
		$.ajax({
			url: base_url + "/detalle/cargar_comentarios", // URL de la API para obtener los comentarios
			type: "post",
			data: { id_cliente: id_cliente },
			datatype: "json",
			success: function (data) {
				comentariosContainer.empty();
				data.forEach((comentario) => {
					const comentarioHtml = `
                        <div class="card mb-2">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">${comentario.fecha_registro} - <strong>${comentario.nombre_usuario} ${comentario.apellido_paterno} ${comentario.apellido_materno}</strong></h6>
                                <p class="card-text">${comentario.texto}</p>
                            </div>
                        </div>
                    `;
					/* CON BOTON DE ELIMINAR
					const comentarioHtml = `
						<div class="card mb-2">
							<div class="card-body d-flex justify-content-between align-items-center">
								<div>
									<h6 class="card-subtitle mb-2 text-muted">
										${comentario.fecha_registro} - 
										<strong>${comentario.nombre_usuario} ${comentario.apellido_paterno} ${comentario.apellido_materno}</strong>
									</h6>
									<p class="card-text">${comentario.texto}</p>
								</div>
								<a class="btn btn-danger btn-sm" onclick="eliminarComentario(${comentario.id_comentario})">
									<i class="fa fa-trash"></i>
								</a>
							</div>
						</div>
					`;
					*/
					comentariosContainer.append(comentarioHtml);
				});
			},
			error: function () {
				console.log("No se pudieron cargar los comentarios.");
			},
		});
	}

	/* TEMPORIZADORES NECESARIOS */
	setInterval(function () {
		cargarComentarios(id_cliente);
	}, 5000);

	// Función para cargar recibos usando AJAX
	function cargarRecibos(id_cliente) {
		$.ajax({
			url: base_url + "/detalle/cargar_recibos", // URL de la API para obtener los recibos
			method: "POST",
			data: { id_cliente: id_cliente },
			success: function (data) {
				recibosContainer.empty();
				data.forEach((recibo) => {
					const reciboHtml =
						recibo.tipo === "pdf"
							? `<div class="embed-responsive" style="width: 300px;">
                                <iframe  src="${recibo.url}" width="300" height="400" frameborder="0"></iframe>
								<div onclick="eliminar_archivo(${recibo.id_recibo})" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer;"></div>
                            </div>`
							: `<img onclick="eliminar_archivo(${recibo.id_recibo})" src="${recibo.url}" alt="Recibo de luz" class="img-thumbnail" style="width: 300px; height: auto;">`;
					recibosContainer.append(reciboHtml);
				});
			},
			error: function () {
				console.log("No se pudieron cargar los recibos.");
			},
		});
	}

	// Función para cargar cotizaciones usando AJAX
	function cargarCotizaciones() {
		$.ajax({
			url: "/api/cotizaciones", // URL de la API para obtener las cotizaciones
			method: "GET",
			success: function (data) {
				tableBody.empty();
				data.forEach((cotizacion) => {
					const cotizacionHtml = `
                        <tr>
                            <td>${cotizacion.id}</td>
                            <td>${cotizacion.fecha}</td>
                            <td>${cotizacion.estado}</td>
                            <td>${cotizacion.total}</td>
                            <td>
                                <button class="btn btn-primary btn-sm">Ver</button>
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </td>
                        </tr>
                    `;
					tableBody.append(cotizacionHtml);
				});
			},
			error: function () {
				console.log("No se pudieron cargar las cotizaciones.");
			},
		});
	}

	// Inicialización de la tabla de cotizaciones con DataTable
	$("#cotizacionesTable").DataTable();

	// Cargar comentarios, recibos y cotizaciones al cargar la página
	cargarComentarios(id_cliente);
	cargarRecibos(id_cliente);
	cargarCotizaciones();

	// Mostrar el modal para agregar un recibo
	$("#agregarReciboBtn").on("click", function () {
		$("#modalRecibo").modal("show");
		$("#previsualizacionRecibo").empty();
	});

	$("#agregar_comentario").on("submit", function (e) {
		// Crear una nueva instancia de FormData
		let formData = new FormData(this);

		// Agregar variables adicionales
		formData.append("id_cliente", id_cliente); // Agregar ID de cliente
		e.preventDefault();
		$.ajax({
			url: base_url + "detalle/agregar_comentario",
			type: "post",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (obj) {
				cargarComentarios(id_cliente);
			},
		});
	});

	// Previsualizar el archivo seleccionado
	$("#reciboArchivo").on("change", function () {
		const archivo = this.files[0];
		const tipoRecibo = $("#reciboTipo").val();
		const reader = new FileReader();

		$("#previsualizacionRecibo").empty(); // Limpiar previsualización anterior

		reader.onload = function (event) {
			let previsualizacionHtml = "";
			if (tipoRecibo === "pdf") {
				previsualizacionHtml = `<div class="embed-responsive" style="width: 300px;">
                                         <iframe src="${event.target.result}" width="300" height="400" frameborder="0"></iframe>
                                      </div>`;
			} else {
				previsualizacionHtml = `<img src="${event.target.result}" alt="Recibo de luz" class="img-thumbnail" style="width: 300px; height: auto;">`;
			}
			$("#previsualizacionRecibo").append(previsualizacionHtml);
		};

		if (archivo) {
			reader.readAsDataURL(archivo);
		}
	});

	// Subir un nuevo recibo
	$("#reciboForm").on("submit", function (e) {
		e.preventDefault();
		// Crear una nueva instancia de FormData
		let formData = new FormData(this);

		// Agregar variables adicionales
		let tipo_recibo = $("#reciboTipo").val();
		formData.append("id_cliente", id_cliente); // Agregar ID de cliente
		formData.append("tipo", tipo_recibo); // Agregar tipo de recibo
		$.ajax({
			url: base_url + "/detalle/upload_file", // URL de la API para subir el recibo
			type: "post",
			data: formData,
			cache: false,
			processData: false,
			contentType: false,
			success: function (obj) {
				if (obj.status == "success") {
					swal.fire({
						icon: "success",
						title: "Se agregó correctamente",
					});
				}
				cargarRecibos(id_cliente); // Recargar los recibos
				$("#modalRecibo").modal("hide");
				$("#reciboForm")[0].reset();
				$("#previsualizacionRecibo").empty();
			},
			error: function () {
				console.log("No se pudo subir el recibo.");
			},
		});
	});
});

function eliminar_archivo(id_recibo) {
	swal
		.fire({
			icon: "warning",
			title: "Desea eliminar el recibo?",
			denyButtonText: "Cancelar",
			confirmButtonText: "Aceptar",
			showDenyButton: true,
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url + "detalle/borrar_recibo",
					method: "post",
					data: {
						id_recibo: id_recibo,
					},
					datatype: "json",
					success: function (obj) {
						if (obj["resultado"]) {
							swal.fire({
								icon: "success",
								title: "El recibo se ha borrado correctamente",
								confirmButtonText: "Aceptar",
							});
							cargar_datos();
						} else {
							swal.fire({
								icon: "error",
								title: "El recibo no se pudo borrar",
								confirmButtonText: "Aceptar",
							});
						}
					},
				});
			}
		});
}

function cargar_datos() {
	$.ajax({
		url: base_url + "usuarios/cargar_responsables",
		datatype: "json",
		success: function (obj) {
			if (obj.resultado) {
				$.each(obj.responsables, function (i, elemento) {
					$("#asesor_cotizacion").append(
						"<option value=" +
							elemento.responsable +
							">" +
							elemento.responsable +
							"</option>"
					);
				});
			} else {
				if (usuario.nivel !== "Tercero") {
					Swal.fire(
						"Ocurrió un error",
						"No hay usuarios registrados o no se pudieron cargar",
						"warning"
					);
				}
			}
		},
	});

	$.ajax({
		url: base_url + "historial_cotizaciones/cargar_cotizaciones",
		datatype: "json",
		success: function (obj) {
			if (obj["resultado"]) {
				tabla.clear().draw();

				$.each(obj["cotizaciones"], function (i, elemento) {
					if (elemento.id_cliente == id_cliente) {
						let estado = "";
						let tipo_interconexion = "";
						let botones =
							'<a class="btn btn-info" href="' +
							base_url +
							"cotizaciones_pdf/" +
							elemento.nombre_archivo +
							'" target="_blank"><i class="fa fa-eye"></i></a>' +
							'<a class="btn btn-success" href="' +
							base_url +
							"cotizaciones_pdf/" +
							elemento.nombre_archivo +
							'" download="' +
							elemento.nombre_archivo +
							'"><i class="fa fa-download"></i></a>' +
							'<button type="button" class="btn btn-primary" data-toggle="modal" onclick="editar(' +
							elemento.id_cotizacion +
							')"><i class="fa fa-edit"></i></button>' +
							'<button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminar(' +
							elemento.id_cotizacion +
							')"><i class="fa fa-trash-o"></i></button>';
						switch (elemento.estado_cotizacion) {
							case "Pendiente":
								estado = '<span class="badge badge-info">Pendiente</span>';
								break;
							case "Incompleto":
								estado = '<span class="badge badge-dark">Incompleto</span>';
								botones =
									'<a class="btn btn-success" href="' +
									base_url +
									"cotizacion/previsualizar_cotizacion/" +
									elemento.id_cotizacion +
									'" target="_blank"><i class="fa fa-external-link"></i></a>' +
									'<button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminar(' +
									elemento.id_cotizacion +
									')"><i class="fa fa-trash-o"></i></button>';
								break;
							case "Aceptado":
								estado = '<span class="badge badge-success">Aceptado</span>';
								break;
							case "Rechazado":
								estado = '<span class="badge badge-danger">Rechazado</span>';
								break;
							case "Cancelado":
								estado = '<span class="badge badge-secondary">Cancelado</span>';
								break;
							case "Vencido":
								estado = '<span class="badge badge-warning">Vencido</span>';
								break;
						}
						switch (elemento.tipo_interconexion) {
							case "inversor_central_austero":
								tipo_interconexion = "Inversor central (austero)";
								break;
							case "inversor_central_optimizadores":
								tipo_interconexion = "Inversor central con optimizadores";
								break;
							case "microinversores":
								tipo_interconexion = "Microinversores";
								break;
							case "personalizado":
								tipo_interconexion = "Personalizado";
								break;
						}
						var nuevaFila = tabla.row
							.add([
								tipo_interconexion,
								dinero(elemento.total),
								elemento.num_paneles,
								elemento.fecha_cotizacion,
								elemento.nombre_asesor,
								elemento.vigencia,
								estado,
								botones,
							])
							.draw()
							.node();

						$("td", nuevaFila).each(function (index, td) {
							$(td).attr("data-label", columnas[index]);
						});
					}
				});
			} else {
				swal.fire({
					icon: "error",
					title: "No se pudieron cargar las cotizaciones",
				});
			}
			$("#overlay").addClass("d-none");
		},
	});
}

function cargar_cliente() {
	$.ajax({
		url: base_url + "clientes/cargar_cliente",
		type: "post",
		data: { id_cliente: id_cliente },
		datatype: "json",
		success: function (obj) {
			$("#nombreCliente").text(obj.nombre);
			$("#nombreAsesor").text(
				obj.nombre_usuario +
					" " +
					obj.apellido_paterno +
					" " +
					obj.apellido_materno
			);
			$("#emailCliente").text(obj.correo);
			$("#telefonoCliente").text(obj.telefono);
			$("#direccionCliente").text(obj.ubicacion);
			$("#numServ").text(obj.numero_servicio);
			$("#fechaRegistro").text(obj.fecha_creacion);
		},
	});
}
