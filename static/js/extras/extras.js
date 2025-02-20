var tabla;
var columnas = [];

$(document).ready(function(){
	tabla = $('#tabla_crud').DataTable({
		responsive: true,
		order: [[1, "asc"]],
		"language": {
			"url" : "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
		}
	});
	
	$('#tabla_crud thead tr th').each(function() {
		columnas.push($(this).html());
	});
	
	cargar_datos();

	$('#formulario_agregar').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			'url' : base_url + 'extras/agregar_extra',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'datatype' : 'json',
			'success' : function(obj){
				if(obj['resultado'] == true){
					Swal.fire({
						'icon' : 'success',
						'title' : 'El extra se ha ingresado correctamente',
						confirmButtonText: 'Aceptar'
					});
					$('#formulario_agregar').trigger('reset');
					$('#agregar').modal('hide');
					cargar_datos();
				}else{
					swal.fire({
						'icon' : 'error',
						'title' : 'No se pudo agregar el extra',
					});
				}
			},
			'complete' : function() {
				$('#formulario_agregar').trigger('reset');
			}
		})
	});
	
	$('#formulario_editar').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			'url' : base_url + 'extras/modificar_extra',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'datatype' : 'json',
			'success' : function(obj){
				if(obj['resultado'] == true){
					cargar_datos();
					swal.fire({
						'icon' : 'success',
						'title' : 'El extra se ha actualizado correctamente',
						confirmButtonText: 'Aceptar'
					});	
				} else {
					swal.fire({
						'icon' : 'error',
						'title' : 'No se pudo editar el extra',
					});
				}
				$('#editar').modal('hide');
			}
		})
	});
});

function cargar_datos() {
	$.ajax({
		'url' : base_url + 'extras/cargar_extras',
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado']) {
				tabla.clear().draw();
				$.each(obj['extras'], function(i,elemento){
					var nuevaFila = tabla.row.add([
						elemento.marca,
						elemento.codigo,
						elemento.producto,
						'$ ' + elemento.costo,
						elemento.moneda,
						'<button type="button" class="btn btn-primary" data-toggle="modal" onclick="editar('+elemento.id_extra+')"><i class="fa fa-edit"></i></button> ' +
						'<button type="button" class="btn btn-info" data-toggle="modal" onclick="ver('+elemento.id_extra+')"><i class="fa fa-eye"></i></button> ' +
						'<button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminar('+elemento.id_extra+')"><i class="fa fa-trash-o"></i></button>'
					]).draw().node();
					
					$('td', nuevaFila).each(function(index,td){
						$(td).attr('data-label',columnas[index]);
					});
				});
			} else {
				swal.fire({
					'icon' : 'error',
					'title' : 'No se pudieron cargar los extras',
				});
			}
		}
	});
}

function editar(id_extra){
	$.ajax({
		'url' : base_url + 'extras/cargar_extra',
		'type' : 'post',
		'data' : {'id_extra' : id_extra},
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado']) {
				$('#modificar_marca').val(obj['extras']['marca']);
				$('#modificar_codigo').val(obj['extras']['codigo']);
				$('#modificar_producto').val(obj['extras']['producto']);
				$('#modificar_costo').val(obj['extras']['costo']);
				$('#modificar_moneda option[value="' + obj['extras']['moneda'] + '"]').prop('selected', true);
				$('#modificar_descripcion').val(obj['extras']['descripcion']);
				$('#id_extra').val(obj['extras']['id_extra']);
				$('#editar').modal('show');
			} else {
				swal.fire({
					'icon' : 'error',
					'title' : 'No se pudo editar el extra',
				});
			}
		}
	});
}

function eliminar(id_extra){
	swal.fire({
		'icon' : 'warning',
		'title' : '¿Está seguro que desea eliminar el extra?',
		showCancelButton: true,
		confirmButtonText: 'Aceptar',
	}).then((result) => {
		if(result.isConfirmed){
			$.ajax({
				'url' : base_url + 'extras/eliminar_inversor',
				'type' : 'post',
				'data' : {'id_extra' : id_extra},
				'datatype' : 'json',
				'success' : function(obj){
					if(obj['resultado'] == true){
						cargar_datos();
						swal.fire({
							'icon' : 'success',
							'title' : 'El extra se ha eliminado correctamente',
						});
					}else{
						swal.fire({
							'icon' : 'error',
							'title' : 'No se pudo eliminar el extra',
						});
					}
				}
			});
		}	
	})
}

function ver(id_extra){
	$.ajax({
		'url' : base_url + 'extras/cargar_extra',
		'type' : 'post',
		'data' : {'id_extra' : id_extra},
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado'] == true){
				$('#ver_marca').html(obj['extras']['marca'] == null ? "-" : obj['extras']['marca']);
				$('#ver_id').html(obj['extras']['id_extra']);
				$('#ver_codigo').html(obj['extras']['codigo'] == null ? "-" : obj['extras']['codigo']);
				$('#ver_producto').html(obj['extras']['producto'] == null ? "-" : obj['extras']['producto']);
				$('#ver_costo').html(obj['extras']['costo'] == null ? "-" : '$ ' + obj['extras']['costo']);
				$('#ver_moneda').html(obj['extras']['moneda'] == null ? "-" : obj['extras']['moneda']);
				$('#ver_fecha_agregacion').html(obj['extras']['fecha_agregacion'] == null ? "-" : obj['extras']['fecha_agregacion']);
				$('#ver_fecha_actualizacion').html(obj['extras']['fecha_actualizacion'] == null ? "-" : obj['extras']['fecha_actualizacion']);
				$('#ver').modal('show');
			}
			
		}
	});
}