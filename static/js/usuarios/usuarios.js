var columnas = [];
var tabla_usuarios;

$(document).ready(function () {
	tabla_usuarios = $("#tabla-usuarios").DataTable({
		responsive: true,
		language: {
			url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json",
		},
	});

	$("#tabla-usuarios thead tr th").each(function () {
		columnas.push($(this).html());
	});

	cargar_usuarios();

	$("#formulario_agregar").on("submit", function (e) {
		e.preventDefault();

		$.ajax({
			url: base_url + "usuarios/agregar_usuario",
			type: "post",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function (obj) {
				if (obj["resultado"]) {
					swal.fire({
						icon: "success",
						title: "El usuario se ha agregado correctamente",
						confirmButtonText: "Aceptar",
					});
				} else {
					swal.fire({
						icon: "error",
						title: "El usuario no se ha agregado correctamente",
						confirmButtonText: "Aceptar",
					});
				}
				$("#agregar-usuario").modal("hide");
				$("#formulario_agregar").trigger("reset");
				cargar_usuarios();
			},
		});
	});

	$("#formulario_editar").on("submit", function (e) {
		e.preventDefault();
		$("#nivel_editar").prop("disabled", false);
		$.ajax({
			url: base_url + "usuarios/editar_usuario",
			type: "post",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function (obj) {
				if (obj["resultado"]) {
					swal.fire({
						icon: "success",
						title: "El usuario se ha actualizado correctamente",
						confirmButtonText: "Aceptar",
					});
				} else {
					swal.fire({
						icon: "error",
						title: "El usuario no se ha actualizado",
						confirmButtonText: "Aceptar",
					});
				}
				$("#editar-usuario").modal("hide");
				$("#formulario_editar").trigger("reset");
				cargar_usuarios();
			},
		});
	});
});

function cargar_usuarios() {
	$.ajax({
		url: base_url + "usuarios/cargar_usuarios",
		datatype: "json",
		success: function (obj) {
			tabla_usuarios.clear().draw();
			let nivel = "";
			if (obj["resultado"]) {
				$.each(obj["usuarios"], function (i, elemento) {
					switch (elemento.nivel) {
						case "Propietario":
							nivel = '<span class="badge badge-success">Propietario</span>';
							break;
						case "Administrador":
							nivel = '<span class="badge badge-info">Administrador</span>';
							break;
						case "Empleado":
							nivel = '<span class="badge badge-secondary">Empleado</span>';
							break;
						case "Inactivo":
							nivel = '<span class="badge badge-danger">Inactivo</span>';
							break;
						case "Tercero":
							nivel = '<span class="badge badge-warning">Tercero</span>';
							break;
					}

					var nuevaFila = tabla_usuarios.row
						.add([
							elemento.nombre +
								" " +
								elemento.apellido_paterno +
								" " +
								elemento.apellido_materno,
							elemento.correo,
							elemento.usuario,
							elemento.telefono,
							nivel,
							'<button type="button" class="btn btn-primary" onclick="editar_usuario(' +
								elemento.id_usuario +
								')"><i class="fa fa-edit"></i></button> ' +
								'<button type="button" class="btn btn-info" onclick="ver_usuario(' +
								elemento.id_usuario +
								')"><i class="fa fa-eye"></i></button> ',
						])
						.draw()
						.node();
					$("td", nuevaFila).each(function (index, td) {
						$(td).attr("data-label", columnas[index]);
					});
				});
			}
		},
	});
}

function editar_usuario(id_usuario) {
	$.ajax({
		url: base_url + "usuarios/cargar_usuario",
		type: "post",
		data: {
			id_usuario: id_usuario,
		},
		datatype: "json",
		success: function (obj) {
			if (obj["resultado"]) {
				var data = obj["datos_usuario"];
				$("#id_usuario_editar").val(id_usuario);
				$("#usuario_editar").val(data.usuario);
				$("#nombre_editar").val(data.nombre);
				$("#correo_editar").val(data.correo);
				$("#apellido_paterno_editar").val(data.apellido_paterno);
				$("#apellido_materno_editar").val(data.apellido_materno);
				$("#telefono_editar").val(data.telefono);
				if (nivel == "Administrador") {
					if (data.nivel == "Administrador" || data.nivel == "Propietario") {
						$("#nivel_editar").empty();
						$("#nivel_editar").append(
							'<option value="Propietario">Propietario</option>'
						);
						$("#nivel_editar").append(
							'<option value="Administrador">Administrador</option>'
						);
						$("#nivel_editar").append(
							'<option value="Empleado">Empleado</option>'
						);
						$("#nivel_editar").append(
							'<option value="Tercero">Tercero</option>'
						);
						$("#nivel_editar").append(
							'<option value="Inactivo">Inactivo</option>'
						);
						$("#nivel_editar").prop("required", false);
						$("#nivel_editar").prop("disabled", true);

						$("#id_usuario_editar").prop("disabled", true);
						$("#usuario_editar").prop("disabled", true);
						$("#nombre_editar").prop("disabled", true);
						$("#correo_editar").prop("disabled", true);
						$("#apellido_paterno_editar").prop("disabled", true);
						$("#apellido_materno_editar").prop("disabled", true);
						$("#telefono_editar").prop("disabled", true);
						$("#enviar_edit").prop("disabled", true);
					} else {
						$("#nivel_editar").empty();
						$("#nivel_editar").append(
							'<option value="Empleado">Empleado</option>'
						);
						$("#nivel_editar").append(
							'<option value="Tercero">Tercero</option>'
						);
						$("#nivel_editar").append(
							'<option value="Inactivo">Inactivo</option>'
						);
						$("#nivel_editar").prop("required", true);
						$("#nivel_editar").prop("disabled", false);

						$("#id_usuario_editar").prop("disabled", false);
						$("#usuario_editar").prop("disabled", false);
						$("#nombre_editar").prop("disabled", false);
						$("#correo_editar").prop("disabled", false);
						$("#apellido_paterno_editar").prop("disabled", false);
						$("#apellido_materno_editar").prop("disabled", false);
						$("#telefono_editar").prop("disabled", false);
						$("#enviar_edit").prop("disabled", false);
					}
				} else {
					if (nivel == "Propietario") {
						$("#nivel_editar").empty();
						$("#nivel_editar").append(
							'<option value="Propietario">Propietario</option>'
						);
						$("#nivel_editar").append(
							'<option value="Administrador">Administrador</option>'
						);
						$("#nivel_editar").append(
							'<option value="Empleado">Empleado</option>'
						);
						$("#nivel_editar").append(
							'<option value="Tercero">Tercero</option>'
						);
						$("#nivel_editar").append(
							'<option value="Inactivo">Inactivo</option>'
						);
						$("#nivel_editar").prop("required", true);
						$("#nivel_editar").prop("disabled", false);

						$("#id_usuario_editar").prop("disabled", false);
						$("#usuario_editar").prop("disabled", false);
						$("#nombre_editar").prop("disabled", false);
						$("#correo_editar").prop("disabled", false);
						$("#apellido_paterno_editar").prop("disabled", false);
						$("#apellido_materno_editar").prop("disabled", false);
						$("#telefono_editar").prop("disabled", false);
						$("#enviar_edit").prop("disabled", false);
					}
				}
				$('#nivel_editar option[value="' + data.nivel + '"]').prop(
					"selected",
					true
				);
				$("#editar-usuario").modal("show");
			} else {
				Swal.fire("Error", "No se encontó el usuario", "error");
			}
		},
	});
}

function ver_usuario(id_usuario) {
	$.ajax({
		url: base_url + "usuarios/cargar_usuario",
		type: "post",
		data: {
			id_usuario: id_usuario,
		},
		datatype: "json",
		success: function (obj) {
			if (obj["resultado"]) {
				var data = obj["datos_usuario"];
				$("#ver_id_usuario").html(data.id_usuario);
				$("#ver_usuario").html(data.usuario);
				$("#ver_nombre").html(data.nombre);
				$("#ver_apellido_paterno").html(data.apellido_paterno);
				$("#ver_apellido_materno").html(data.apellido_materno);
				$("#ver_correo").html(data.correo);
				$("#ver_telefono").html(data.telefono);
				$("#ver_nivel").html(data.nivel);
				$("#ver_fecha_registro").html(data.fecha_registro);
				$("#ver").modal("show");
			} else {
				Swal.fire("Error", "No se encontó el usuario", "error");
			}
		},
	});
}

function eliminar_usuario(id_usuario) {
	swal
		.fire({
			icon: "warning",
			title: "¿Está seguro que desea eliminar este usuario?",
			showCancelButton: true,
			confirmButtonText: "Aceptar",
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url + "usuarios/eliminar_usuario",
					type: "post",
					data: { id_usuario: id_usuario },
					datatype: "json",
					success: function (obj) {
						if (obj["resultado"] == true) {
							swal.fire({
								icon: "success",
								title: "El usuario se ha eliminado correctamente",
							});
						} else {
							swal.fire({
								icon: "danger",
								title: "No se pudo eliminar al usuario",
							});
						}
						cargar_usuarios();
					},
				});
			}
		});
}
