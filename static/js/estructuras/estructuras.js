var columnas = [];
var tabla;
var columnas_tipo = [];
var tabla_tipos;

$(document).ready(function() {
	
	$('#tabla_crud thead tr th').each(function() {
		columnas.push($(this).html());
	});

	tabla_tipos = $('#tabla_tipos').DataTable({
		responsive: true,
		"language": {
			"url" : "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
		}
	});
	
	$('#tabla_tipos thead tr th').each(function() {
		columnas_tipo.push($(this).html());
	});

	tabla = $('#tabla_crud').DataTable({
		responsive: true,
		"language": {
			"url" : "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
		}
	});
	
	cargar_datos();
	cargar_datos_tipo();
	
	$('#formulario_editar').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'estructuras/editar_estructura',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'La estructura se ha actualizado correctamente',
						confirmButtonText: 'Aceptar'
					});
					cargar_datos();
				}else{
					swal.fire({
						'icon' : 'error',
						'title' : 'La estructura no se ha actualizado correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
				$('#editar').modal('hide');
			}
		});
	});
	
	$('#formulario_agregar').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'estructuras/agregar_estructura',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					Swal.fire({
						'icon' : 'success',
						'title' : 'La estructura se ha agregado correctamente',
						confirmButtonText: 'Aceptar'
					});
					$('#formulario_agregar').trigger('reset');
					$('#agregar').modal('hide');
					cargar_datos();
				}else{
					swal.fire({
						'icon' : 'error',
						'title' : 'La estructura no se ha agregado correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
			}
		});
	});
	
	$('#formulario_agregar_tipo').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'estructuras/agregar_tipo_estructura',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'El tipo de estructura se ha agregado correctamente',
						confirmButtonText: 'Aceptar'
					});
					cargar_datos_tipo();
					$('#agregar_tipo').modal('hide');
				}else{
					swal.fire({
						'icon' : 'error',
						'title' : 'El tipo de estructura no se ha agregado correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
			},
			'complete' : function(data) {
				$('#formulario_agregar_tipo').trigger("reset");
			}
		});
	});
	
	$('#formulario_editar_tipo').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'estructuras/editar_tipo_estructura',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'El tipo de estructura se ha actualizado correctamente',
						confirmButtonText: 'Aceptar'
					});
					cargar_datos_tipo();
				}else{
					swal.fire({
						'icon' : 'error',
						'title' : 'El tipo de estructura no se ha actualizado correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
				$('#editar_tipo').modal('hide');
			}
		});
	});
});

function cargar_datos() {
	$.ajax({
		'url' : base_url + 'estructuras/obtener_datos',
		'datatype' : 'json',
		'success' : function(obj){
			tabla.clear().draw();
			$.each(obj['estructuras'], function(i, elemento){
				var nuevaFila = tabla.row.add([
					elemento.codigo,
					elemento.modulos,
					elemento.marca,
					elemento.tipo_codigo == null ? 'N/A' : elemento.tipo_codigo,
					elemento.celdas,
					elemento.angulo + '°',
					"$ " + elemento.costo,
					elemento.moneda,
					'<button type="button" class="btn btn-primary" data-toggle="modal" onclick="editar('+elemento.id_estructura+')"><i class="fa fa-edit"></i></button> ' +
					'<button type="button" class="btn btn-info" data-toggle="modal" onclick="ver('+elemento.id_estructura+')"><i class="fa fa-eye"></i></button> ' +
					'<button type="button" class="btn btn-danger" onclick="borrar('+elemento.id_estructura+')"><i class="fa fa-trash-o" ></i></button>'
				]).draw().node();
				$('td', nuevaFila).each(function(index,td){
					$(td).attr('data-label',columnas[index]);
				});
			});
		}
	});
}

function cargar_datos_tipo() {
	$.ajax({
		'url' : base_url + 'estructuras/cargar_tipos_estructura',
		'datatype' : 'json',
		'success' : function(obj){
			tabla_tipos.clear().draw();
			$('#tipo_nuevo').not(':first').remove();
			$('#tipo').not(':first').remove();
			$.each(obj['tipos'], function(i, elemento){
				var nuevaFila = tabla_tipos.row.add([
					elemento.codigo,
					elemento.tipo,
					'<button type="button" class="btn btn-primary" data-toggle="modal" onclick="editar_tipo('+elemento.id_tipo_estructura+')"><i class="fa fa-edit"></i></button> ' +
					'<button type="button" class="btn btn-danger" onclick="borrar_tipo('+elemento.id_tipo_estructura+')"><i class="fa fa-trash-o" ></i></button>'
				]).draw().node();
				$('td', nuevaFila).each(function(index,td){
					$(td).attr('data-label',columnas_tipo[index]);
				});

				$('#tipo_nuevo').append('<option value="' + elemento.id_tipo_estructura + '">' + elemento.codigo + '</option>');
				$('#tipo').append('<option value="' + elemento.id_tipo_estructura + '">' + elemento.codigo + '</option>');
			});
		}
	});
}

function editar(id) {	
	$.ajax({
		'url' : base_url + 'estructuras/cargar_estructura',
		'method' : 'post',
		'data': {
			'id_estructura' : id 
		},
		'datatype' : 'json',
		'success' : function(obj) {
			if(obj['resultado']) {
				$('#formulario-editar').trigger('reset');
				
				var estructura = obj.estructura;
				
				$('#id_estructura').val(estructura.id_estructura);
				$('#codigo').val(estructura.codigo);
				$('#producto').val(estructura.producto);
				$('#marca').val(estructura.marca);
				$('#modulos').val(estructura.modulos);
				$('#celdas').val(estructura.celdas);
				$('#angulo').val(estructura.angulo);
				$('#costo').val(estructura.costo);
				$('#moneda option[value="' + estructura.moneda + '"]').prop('selected', true);
				$('#tipo option[value="' + estructura.id_tipo_estructura + '"]').prop('selected', true);
				$('#editar').modal('show');
			}
			else {
				Swal.fire('Error al editar', 'No se encontró la estructura', 'error');
			}
		}
	});
}

function editar_tipo(id) {
	$.ajax({
		'url' : base_url + 'estructuras/cargar_tipo_estructura',
		'method' : 'post',
		'data': {
			'id_tipo_estructura' : id 
		},
		'datatype' : 'json',
		'success' : function(obj) {
			if(obj['resultado']) {
				$('#formulario_editar_tipoeditar').trigger('reset');
				
				var tipo = obj.tipo;
				
				$('#tipo_id_tipo_estructura_editar').val(tipo.id_tipo_estructura);
				$('#tipo_codigo_editar').val(tipo.codigo);
				$('#tipo_tipo_editar').val(tipo.tipo);
				$('#editar_tipo').modal('show');
			}
			else {
				Swal.fire('Error al editar', 'No se encontró el tipo de estructura', 'error');
			}
		}
	});
}

function ver(id) {
	$.ajax({
		'url' : base_url + 'estructuras/cargar_estructura',
		'method' : 'post',
		'data': {
			'id_estructura' : id 
		},
		'datatype' : 'json',
		'success' : function(obj) {
			if(obj['resultado']) {
				var estructura = obj.estructura;
				
				$('#ver_id_estructura').html(estructura.id_estructura == null ? "-" : estructura.id_estructura);
				$('#ver_codigo').html(estructura.codigo == null ? "-" : estructura.codigo);
				$('#ver_producto').html(estructura.producto == null ? "-" : estructura.producto);
				$('#ver_marca').html(estructura.marca == null ? "-" : estructura.marca);
				$('#ver_modulos').html(estructura.modulos == null ? "-" : estructura.modulos);
				$('#ver_celdas').html(estructura.celdas == null ? "-" : estructura.celdas);
				$('#ver_angulo').html(estructura.angulo == null ? "-" : estructura.angulo + "°");
				$('#ver_costo').html(estructura.costo == null ? "-" : "$ " + estructura.costo);
				$('#ver_moneda').html(estructura.moneda == null ? "-" : "$ " + estructura.moneda);
				$('#ver_tipo').html(estructura.tipo == null ? "-" : estructura.tipo);
				$('#ver_fecha_agregacion').html(estructura.fecha_agregacion == null ? "-" : estructura.fecha_agregacion);
				$('#ver_fecha_actualizacion').html(estructura.fecha_actualizacion == null ? "-" : estructura.fecha_actualizacion);
				$('#ver').modal('show');
			}
			else {
				Swal.fire('Error al ver', 'No se encontró la estructura.', 'error');
			}
		}
	});
}

function borrar(id) {
	Swal.fire({
		'icon' : 'warning',
		'title' : '¿Está seguro que desea eliminar esta estructura?',
		denyButtonText: 'Cancelar',
		confirmButtonText: 'Aceptar',
		showDenyButton: true
	}).then((result) => {
		if(result.isConfirmed){
			$.ajax({
				'url' : base_url + 'estructuras/borrar_estructura',
				'method' : 'post',
				'data': {
					'id_estructura' : id 
				},
				'datatype' : 'json',
				'success' : function(obj) {
					if(obj['resultado']) {
						swal.fire({
							'icon' : 'success',
							'title' : 'La estructura se ha borrado correctamente',
							confirmButtonText: 'Aceptar'
						});
						cargar_datos();
					}
					else {
						swal.fire({
							'icon' : 'error',
							'title' : 'La estructura no se pudo borrar',
							confirmButtonText: 'Aceptar'
						});
					}
				}
			});
		}
	});
}

function borrar_tipo(id) {
	Swal.fire({
		'icon' : 'warning',
		'title' : '¿Está seguro que desea eliminar este tipo de estructura?',
		denyButtonText: 'Cancelar',
		confirmButtonText: 'Aceptar',
		showDenyButton: true
	}).then((result) => {
		if(result.isConfirmed){
			$.ajax({
				'url' : base_url + 'estructuras/borrar_tipo_estructura',
				'method' : 'post',
				'data': {
					'id_tipo_estructura' : id 
				},
				'datatype' : 'json',
				'success' : function(obj) {
					if(obj['resultado']) {
						swal.fire({
							'icon' : 'success',
							'title' : 'El tipo de estructura se ha borrado correctamente',
							confirmButtonText: 'Aceptar'
						});
						cargar_datos();
						cargar_datos_tipo();
					}
					else {
						swal.fire({
							'icon' : 'error',
							'title' : 'El tipo de estructura no se pudo borrar, asegúrate que no se esté usando en alguna estructura',
							confirmButtonText: 'Aceptar'
						});
					}
				}
			});
		}
	});
}