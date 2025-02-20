$(document).ready(function () {
	cargar_clientes();
});

function nuevo_cliente() {
	$("#nuevo_cliente").removeClass("d-none");
	$("#cliente_existente").addClass("d-none");
	$("#tipo_cliente").val(1);
}

function cliente_existente() {
	$("#nuevo_cliente").addClass("d-none");
	$("#cliente_existente").removeClass("d-none");
	$("#tipo_cliente").val(2);
}

function cargar_clientes() {
	$.ajax({
		url: base_url + "cotizacion/cargar_clientes",
		dataType: "json", // Corregido 'datatype' a 'dataType'
		success: function (obj) {
			// Limpiar el select antes de agregar nuevos clientes
			$("#clienteExistente").empty();

			// Comprobar si la respuesta contiene datos
			if (obj && Array.isArray(obj)) {
				$.each(obj, function (i, elemento) {
					// Suponiendo que cada cliente tiene 'id' y 'nombre'
					$("#clienteExistente").append(
						'<option value="' +
							elemento.id_cliente +
							'">' +
							elemento.nombre +
							"</option>"
					);
				});
			} else {
				console.error("No se recibieron clientes válidos.");
			}

			// Inicializar select2 después de agregar los elementos
			$("#clienteExistente").select2();
		},
		error: function (xhr, status, error) {
			console.error("Error al cargar los clientes:", error);
		},
	});
}
