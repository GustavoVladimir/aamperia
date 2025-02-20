var columnas = [];
var tabla;

$(document).ready(function() {
	$.ajaxSetup({
		'error' : function(xhr){
			swal.fire({
				'icon' : 'error',
				'title' : 'Error en el servidor',
				'html' : '<b>Mensaje técnico:</b><br>' +
						 '<p>' + xhr.status + ' ' + xhr.statusText + '</p>',
				confirmButtonText: 'Aceptar'
			});
		}
	});
	
	$('#tabla-crud thead tr th').each(function() {
		columnas.push($(this).html());
	});

	tabla = $('#tabla-crud').DataTable({
		responsive: true,
		"language": {
			"url" : "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
		}
	});
	
	cargarDatos();
	
	$('#formulario-editar').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'sistemas_monitoreo/editar_sistema',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'El sistema se ha actualizado correctamente',
						confirmButtonText: 'Aceptar'
					});
					$('#editar').modal('hide');
					cargarDatos();
				}else{
					swal.fire({
						'icon' : 'error',
						'title' : 'El sistema no se ha actualizado correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
			}
		});
	});
	
	$('#formulario-agregar').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'sistemas_monitoreo/agregar_sistema',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'El sistema se ha agregado correctamente',
						confirmButtonText: 'Aceptar'
					});
					$('#formulario-agregar').trigger('reset');
					$('#agregar').modal('hide');
					cargarDatos();
				}else{
					swal.fire({
						'icon' : 'error',
						'title' : 'El sistema no se ha agregado correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
				$('#agregar').modal('hide');
			}
		});
	});
	
});

function cargarDatos() {
	$.ajax({
		'url' : base_url + 'sistemas_monitoreo/obtener_datos',
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado']){
				tabla.clear().draw();
				$.each(obj['sistemas'], function(i, elemento){
					var nuevaFila = tabla.row.add([
						elemento.codigo,
						elemento.marca,
						elemento.producto,
						"$ " + elemento.costo,
						elemento.moneda,
						'<button type="button" class="btn btn-primary" data-toggle="modal" onclick="editar('+elemento.id_sistema_monitoreo+')"><i class="fa fa-edit"></i></button> ' +
						'<button type="button" class="btn btn-info" data-toggle="modal" onclick="ver('+elemento.id_sistema_monitoreo+')"><i class="fa fa-eye"></i></button> ' +
						'<button type="button" class="btn btn-danger" onclick="borrar('+elemento.id_sistema_monitoreo+')"><i class="fa fa-trash-o" ></i></button>'
					]).draw().node();
					$('td', nuevaFila).each(function(index,td){
						$(td).attr('data-label',columnas[index]);
					});
				});
			}
		}
	});
}

function editar(id) {
	$.ajax({
		'url' : base_url + 'sistemas_monitoreo/cargar_sistema',
		'method' : 'post',
		'data': {
			'id_sistema_monitoreo' : id 
		},
		'datatype' : 'json',
		'success' : function(obj) {
			if(obj['resultado']) {
				$('#formulario-editar').trigger('reset');
				
				var sistema = obj.sistema;
				
				$('#id_sistema_monitoreo').val(sistema.id_sistema_monitoreo);
				$('#codigo').val(sistema.codigo);
				$('#producto').val(sistema.producto);
				$('#marca').val(sistema.marca);
				$('#costo').val(sistema.costo);
				$('#moneda option[value="' + sistema.moneda + '"]').prop('selected', true);
				
				$('#editar').modal('show');
			}
			else {
				Swal.fire('Error al cargar', 'No se encontró el sistema', 'error');
			}
		}
	});
}

function ver(id) {
	$.ajax({
		'url' : base_url + 'sistemas_monitoreo/cargar_sistema',
		'method' : 'post',
		'data': {
			'id_sistema_monitoreo' : id 
		},
		'datatype' : 'json',
		'success' : function(obj) {
			if(obj['resultado']) {
				var sistema = obj.sistema;
				
				$('#ver_id_sistema').html(sistema.id_sistema_monitoreo);
				$('#ver_codigo').html(sistema.codigo);
				$('#ver_producto').html(sistema.producto);
				$('#ver_marca').html(sistema.marca);
				$('#ver_costo').html("$ " + sistema.costo);
				$('#ver_moneda').html(sistema.moneda);
				$('#ver_fecha_agregacion').html(sistema.fecha_agregacion);
				$('#ver_fecha_actualizacion').html(sistema.fecha_actualizacion);
				
				$('#ver').modal('show');
			}
			else {
				Swal.fire('Error al ver', 'No se encontró el sistema', 'error');
			}
		}
	});
}

function borrar(id) {
	Swal.fire({
		'icon' : 'warning',
		'title' : '¿Está seguro que desea eliminar este sistema?',
		denyButtonText: 'Cancelar',
		confirmButtonText: 'Aceptar',
		showDenyButton: true
	}).then((result) => {
		if(result.isConfirmed){
			$.ajax({
				'url' : base_url + 'sistemas_monitoreo/borrar_sistema',
				'method' : 'post',
				'data': {
					'id_sistema_monitoreo' : id 
				},
				'datatype' : 'json',
				'success' : function(obj) {
					if(obj['resultado']) {
						swal.fire({
							'icon' : 'success',
							'title' : 'El sistema se ha borrado correctamente',
							confirmButtonText: 'Aceptar'
						});
						cargarDatos();
					}
					else {
						swal.fire({
							'icon' : 'error',
							'title' : 'El sistema no se pudo borrar',
							confirmButtonText: 'Aceptar'
						});
					}
				}
			});
		}
	});
}