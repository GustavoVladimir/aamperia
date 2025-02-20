var columnas = [];
var tabla;

$(document).ready(function() {
	$('#tabla_crud thead tr th').each(function() {
		columnas.push($(this).html());
	});

	tabla = $('#tabla_crud').DataTable({
		responsive: true,
		"language": {
			"url" : "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
		}
	});
	
	cargar_datos();
	
	$('#formulario_editar').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'optimizadores/editar_optimizador',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					swal.fire({
						'icon' : 'success',
						'title' : 'El optimizador se ha actualizado correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
				else{
					swal.fire({
						'icon' : 'error',
						'title' : 'El optimizador no se ha actualizado correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
				$('#editar').modal('hide');
				cargar_datos();
			}
		});
	});
	
	$('#formulario_agregar').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			'url' : base_url + 'optimizadores/agregar_optimizador',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					Swal.fire({
						'icon' : 'success',
						'title' : 'El optimizador se ha ingresado correctamente',
						confirmButtonText: 'Aceptar'
					});
					$('#formulario_agregar').trigger('reset');
					$('#agregar').modal('hide');
					cargar_datos();
				} else {
					swal.fire({
						'icon' : 'error',
						'title' : 'El optimizador no se ha agregado correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
			}
		});
	});
	
});

function cargar_datos() {
	$.ajax({
		'url' : base_url + 'optimizadores/obtener_datos',
		'datatype' : 'json',
		'success' : function(obj){
			tabla.clear().draw();
			if(obj['resultado']) {
				$.each(obj['optimizadores'], function(i, elemento){
					var nuevaFila = tabla.row.add([
						elemento.codigo,
						elemento.marca,
						elemento.producto,
						"$ " + elemento.costo,
						elemento.moneda,
						'<button type="button" class="btn btn-primary" data-toggle="modal" onclick="editar('+elemento.id_optimizador+')"><i class="fa fa-edit"></i></button> ' +
						'<button type="button" class="btn btn-info" data-toggle="modal" onclick="ver('+elemento.id_optimizador+')"><i class="fa fa-eye"></i></button> ' +
						'<button type="button" class="btn btn-danger" onclick="borrar('+elemento.id_optimizador+')"><i class="fa fa-trash-o" ></i></button>'
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
		'url' : base_url + 'optimizadores/cargar_optimizador',
		'method' : 'post',
		'data': {
			'id_optimizador' : id 
		},
		'datatype' : 'json',
		'success' : function(obj) {
			if(obj['resultado']) {
				var optimizador = obj['optimizador'];
				console.log(optimizador);
				
				$('#id_editar').val(optimizador.id_optimizador);
				$('#codigo_editar').val(optimizador.codigo);
				$('#marca_editar').val(optimizador.marca);
				$('#producto_editar').val(optimizador.producto);
				$('#costo_editar').val(optimizador.costo);
				$('#moneda_editar option[value="' + optimizador.moneda + '"]').prop('selected', true);
				
				$('#editar').modal('show');
			}
			else {
				Swal.fire('Error al editar', 'No se encontró el optimizador.', 'error');
			}
		}
	});
}

function ver(id) {
	$.ajax({
		'url' : base_url + 'optimizadores/cargar_optimizador',
		'method' : 'post',
		'data': {
			'id_optimizador' : id 
		},
		'datatype' : 'json',
		'success' : function(obj) {
			if(obj['resultado']) {
				var optimizador = obj.optimizador;
				
				$('#ver_id_optimizador').html(optimizador.id_optimizador);
				$('#ver_codigo').html(optimizador.codigo);
				$('#ver_marca').html(optimizador.marca);
				$('#ver_producto').html(optimizador.producto);
				$('#ver_costo').html('$ ' + optimizador.costo);
				$('#ver_moneda').html(optimizador.moneda);
				$('#ver_fecha_agregacion').html(optimizador.fecha_agregacion);
				$('#ver_fecha_actualizacion').html(optimizador.fecha_actualizacion);
				
				$('#ver').modal('show');
			}
			else {
				Swal.fire('Error al ver', 'No se encontró el optimizador.', 'error');
			}
		}
	});
}

function borrar(id) {
	Swal.fire({
		'icon' : 'warning',
		'title' : '¿Está seguro que desea eliminar este optimizador?',
		denyButtonText: 'Cancelar',
		confirmButtonText: 'Aceptar',
		showDenyButton: true
	}).then((result) => {
		if(result.isConfirmed){
			$.ajax({
				'url' : base_url + 'optimizadores/borrar_optimizador',
				'method' : 'post',
				'data': {
					'id_optimizador' : id 
				},
				'datatype' : 'json',
				'success' : function(obj) {
					if(obj['resultado']) {
						swal.fire({
							'icon' : 'success',
							'title' : 'El optimizador se ha borrado correctamente',
							confirmButtonText: 'Aceptar'
						});
					}
					else {
						swal.fire({
							'icon' : 'error',
							'title' : 'El optimizador no se pudo borrar',
							confirmButtonText: 'Aceptar'
						});
					}
					
					cargar_datos();
				}
			});
		}
	});
}