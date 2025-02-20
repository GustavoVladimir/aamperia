var columnas = [];
var tabla;

$(document).ready(function() {
	$.ajaxSetup({
		'error' : function(xhr){
			Swal.fire({
				'icon' : 'error',
				'title' : 'Error en el servidor',
				'html' : '<b>Mensaje técnico:</b><br>' +
						 '<p>' + xhr.status + ' ' + xhr.statusText + '</p>',
				confirmButtonText: 'Aceptar'
			});
		}
	});
	
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
			'url' : base_url + 'microinversores/editar_microinversor',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					Swal.fire({
						'icon' : 'success',
						'title' : 'El microinversor se ha actualizado correctamente',
						confirmButtonText: 'Aceptar'
					});
				}
				else{
					Swal.fire({
						'icon' : 'error',
						'title' : 'El microinversor no se ha actualizado correctamente',
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
			'url' : base_url + 'microinversores/agregar_microinversor',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado']){
					Swal.fire({
						'icon' : 'success',
						'title' : 'El microinversor se ha agregado correctamente',
						confirmButtonText: 'Aceptar'
					});
					$('#formulario_agregar').trigger('reset');
					$('#agregar').modal('hide');
					cargar_datos();
				}else{
					Swal.fire({
						'icon' : 'error',
						'title' : 'El microinversor no se ha agregado correctamente',
						confirmButtonText: 'Aceptar'
					});
				}		
			},
			'complete' : function(data) {
				$('#formulario_agregar').trigger("reset");
			}
		});
	});
	
});

function cargar_datos() {
	$.ajax({
		'url' : base_url + 'microinversores/obtener_datos',
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado']){
				tabla.clear().draw();
				$.each(obj['microinversores'], function(i, elemento){
					var nuevaFila = tabla.row.add([
						elemento.codigo,
						elemento.marca,
						elemento.producto,
						elemento.potencia + " W",
						"$ " + elemento.costo,
						elemento.moneda,
						'<button type="button" class="btn btn-primary" data-toggle="modal" onclick="editar('+elemento.id_microinversor+')"><i class="fa fa-edit"></i></button> ' +
						'<button type="button" class="btn btn-info" data-toggle="modal" onclick="ver('+elemento.id_microinversor+')"><i class="fa fa-eye"></i></button> ' +
						'<button type="button" class="btn btn-danger" onclick="borrar('+elemento.id_microinversor+')"><i class="fa fa-trash-o" ></i></button>'
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
		'url' : base_url + 'microinversores/cargar_microinversor',
		'method' : 'post',
		'data': {
			'id_microinversor' : id 
		},
		'datatype' : 'json',
		'success' : function(obj) {
			if(obj['resultado']) {
				var microinversor = obj.microinversor;
				
				$('#id_editar').val(microinversor.id_microinversor);
				$('#codigo_editar').val(microinversor.codigo);
				$('#marca_editar').val(microinversor.marca);
				$('#producto_editar').val(microinversor.producto);
				$('#potencia_editar').val(microinversor.potencia);
				$('#costo_editar').val(microinversor.costo);
				$('#moneda_editar option[value="' + microinversor.moneda + '"]').prop('selected', true);
				$('#editar').modal('show');
			}
			else {
				Swal.fire({
					'icon' : 'error',
					'title' : 'No se encontró el microinversor',
					confirmButtonText: 'Aceptar'
				});
			}
		},
		'complete' : function(data) {
			$('#formulario-editar').trigger('reset');
		}
	});
}

function ver(id) {
	$.ajax({
		'url' : base_url + 'microinversores/cargar_microinversor',
		'method' : 'post',
		'data': {
			'id_microinversor' : id 
		},
		'datatype' : 'json',
		'success' : function(obj) {
			if(obj['resultado']) {
				var microinversor = obj.microinversor;
				
				$('#ver_id_microinversor').html(microinversor.id_microinversor);
				$('#ver_codigo').html(microinversor.codigo);
				$('#ver_marca').html(microinversor.marca);
				$('#ver_producto').html(microinversor.producto);
				$('#ver_potencia').html(microinversor.potencia + ' W');
				$('#ver_costo').html('$ ' + microinversor.costo);
				$('#ver_moneda').html('$ ' + microinversor.moneda);
				$('#ver_fecha_agregacion').html(microinversor.fecha_agregacion);
				$('#ver_fecha_actualizacion').html(microinversor.fecha_actualizacion);
				$('#ver').modal('show');
			}
			else {
				Swal.fire({
					'icon' : 'error',
					'title' : 'No se encontró el microinversor',
					confirmButtonText: 'Aceptar'
				});
			}
		}
	});
}

function borrar(id) {
	Swal.fire({
		'icon' : 'warning',
		'title' : '¿Está seguro que desea eliminar este microinversor?',
		denyButtonText: 'Cancelar',
		confirmButtonText: 'Aceptar',
		showDenyButton: true
	}).then((result) => {
		if(result.isConfirmed){
			$.ajax({
				'url' : base_url + 'microinversores/borrar_microinversor',
				'method' : 'post',
				'data': {
					'id_microinversor' : id 
				},
				'datatype' : 'json',
				'success' : function(obj) {
					if(obj['resultado']) {
						Swal.fire({
							'icon' : 'success',
							'title' : 'El microinversor se ha borrado correctamente',
							confirmButtonText: 'Aceptar'
						});
					}
					else {
						Swal.fire({
							'icon' : 'error',
							'title' : 'El microinversor no se pudo borrar',
							confirmButtonText: 'Aceptar'
						});
					}
				},
				'complete' : function(data) {
					cargar_datos();
				}
			});
		}
	});
}