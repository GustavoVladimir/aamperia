var columnas = [];
var tabla;

$(document).ready(function () {
	$("#tabla_crud thead tr th").each(function () {
		columnas.push($(this).html());
	});

	tabla = $("#tabla_crud").DataTable({
		responsive: true,
		language: {
			url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json",
		},
		order: [[0, "desc"]],
	});

	cargar_datos();
	$("#formulario_editar").on("submit", function (e) {
		e.preventDefault();

		$.ajax({
			url: base_url + "clientes/editar_cliente",
			type: "post",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function (obj) {
				if (obj == true) {
					swal.fire({
						icon: "success",
						title: "La cliente se ha actualizado correctamente",
						confirmButtonText: "Aceptar",
					});
					cargar_datos();
				} else {
					swal.fire({
						icon: "error",
						title: "La cliente no se ha actualizado correctamente",
						confirmButtonText: "Aceptar",
					});
				}
				$("#editar").modal("hide");
			},
		});
	});

	$("#formulario_agregar").on("submit", function (e) {
		console.log("hola");
		e.preventDefault();
		$.ajax({
			url: base_url + "clientes/agregar_cliente",
			type: "post",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function (obj) {
				if (obj["resultado"]) {
					Swal.fire({
						icon: "success",
						title: "La cliente se ha agregado correctamente",
						confirmButtonText: "Aceptar",
					});
					$("#formulario_agregar").trigger("reset");
					$("#agregar").modal("hide");
					cargar_datos();
				} else {
					swal.fire({
						icon: "error",
						title: "La cliente no se ha agregado correctamente",
						confirmButtonText: "Aceptar",
					});
				}
			},
		});
	});
});

function cargar_datos() {
	let nombreCompleto = "";
	$.ajax({
		url: base_url + "clientes/obtener_datos",
		datatype: "json",
		success: function (obj) {
			tabla.clear().draw();
			$.each(obj, function (i, elemento) {
				nombreCompleto =
					elemento.nombre_usuario +
					" " +
					elemento.apellido_paterno +
					" " +
					elemento.apellido_materno;

				// Asignar color del badge según el estado
				var badgeClass = "";
				switch (elemento.status) {
					case "En Proceso":
						badgeClass = "badge-warning";
						break;
					case "Vendido":
						badgeClass = "badge-success";
						break;
					case "Cobrado":
						badgeClass = "badge-info";
						break;
					case "Listo para pago":
						badgeClass = "badge-primary";
						break;
					default:
						badgeClass = "badge-secondary";
				}

				// Construcción de botones (se ocultan si el usuario es "Tercero")
				var botones = "";
				if (usuario.nivel !== "Tercero") {
					botones = `
						<button type="button" class="btn btn-primary" data-toggle="modal" onclick="editar(${elemento.id_cliente})">
							<i class="fa fa-edit"></i>
						</button> 
						<button type="button" class="btn btn-danger" onclick="borrar(${elemento.id_cliente})">
							<i class="fa fa-trash-o"></i>
						</button>`;
				}

				// Agregar la fila a la tabla
				var nuevaFila = tabla.row
					.add([
						`<a href="${base_url}clientes/detalle_cliente/${elemento.id_cliente}">${elemento.id_cliente}</a>`,
						elemento.nombre,
						elemento.ubicacion,
						elemento.correo,
						elemento.telefono,
						elemento.numero_servicio,
						`<span class="badge ${badgeClass}">${elemento.status}</span>`,
						`<span class="badge badge-success">${nombreCompleto}</span>`,
						botones, // Se añaden los botones solo si el usuario no es "Tercero"
					])
					.draw()
					.node();

				// Agregar etiquetas de datos
				$("td", nuevaFila).each(function (index, td) {
					$(td).attr("data-label", columnas[index]);
				});
			});
		},
	});
}

function editar(id) {
	$.ajax({
		url: base_url + "clientes/cargar_cliente", // URL to the controller method
		method: "post", // Request method
		data: {
			id_cliente: id, // Sending client ID to fetch client data
		},
		datatype: "json", // Expecting JSON response
		success: function (obj) {
			var cliente = obj; // Assuming the response contains the client data
			// Pre-fill the modal form fields with the client data
			$("#id_cliente").val(cliente.id_cliente); // Hidden input field for the client ID
			$("#nombre").val(cliente.nombre); // Field for client name
			$("#ubicacion").val(cliente.ubicacion); // Field for client location
			$("#correo").val(cliente.correo); // Field for client email
			$("#numero_servicio").val(cliente.numero_servicio); // Field for service number
			$("#telefono").val(cliente.telefono); // Field for client phone number
			$("#status").val(cliente.status);
			// Show the modal after populating the fields
			$("#editar").modal("show");
		},
		error: function (xhr, status, error) {
			console.error("Error loading client data: ", error);
		},
	});
}

function borrar(id) {
	Swal.fire({
		icon: "warning",
		title: "¿Está seguro que desea eliminar esta cliente?",
		denyButtonText: "Cancelar",
		confirmButtonText: "Aceptar",
		showDenyButton: true,
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: base_url + "clientes/borrar_cliente",
				method: "post",
				data: {
					id_cliente: id,
				},
				datatype: "json",
				success: function (obj) {
					swal.fire({
						icon: obj.status,
						title: obj.message,
						confirmButtonText: "Aceptar",
					});
					cargar_datos();
				},
			});
		}
	});
}
