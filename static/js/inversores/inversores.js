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
	
	$.ajax({
		'url' : base_url + 'inversores/traer_marca_inversor',
		'datatype' : 'json',
		'success' : function(obj){
			var selectContenido = "";
			selectContenido += 
			'<option value="'+""+'">Todos los articulos</option>'
			$.each(obj['resultado'],function(i,elemento){
				selectContenido += 
				'<option value="'+elemento.marca+'">'+elemento.marca+'</option>'
			});
			$('#marca_inversor').append(selectContenido);
		}
	});

	$('#formulario_agregar').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			'url' : base_url + 'inversores/agregar_inversor',
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
						'title' : 'El inversor se ha ingresado correctamente',
						confirmButtonText: 'Aceptar'
					});
					$('#formulario_agregar').trigger('reset');
					$('#agregar').modal('hide');
					cargar_datos();
				}else{
					swal.fire({
						'icon' : 'error',
						'title' : 'No se pudo agregar el inversor',
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
			'url' : base_url + 'inversores/modificar_inversor',
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
						'title' : 'El sistema se ha actualizado correctamente',
						confirmButtonText: 'Aceptar'
					});	
				} else {
					swal.fire({
						'icon' : 'error',
						'title' : 'No se pudo editar el inversor',
					});
				}
				$('#editar').modal('hide');
			}
		})
	});
});

function cargar_datos() {
	$.ajax({
		'url' : base_url + 'inversores/traer_inversores',
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado']) {
				tabla.clear().draw();
				$.each(obj['inversores'], function(i,elemento){
					var nuevaFila = tabla.row.add([
						elemento.marca,
						elemento.codigo,
						elemento.producto,
						elemento.potencia + ' W',
						'$ ' + elemento.costo,
						elemento.moneda,
						'<button type="button" class="btn btn-primary" data-toggle="modal" onclick="editar('+elemento.id_inversor+')"><i class="fa fa-edit"></i></button> ' +
						'<button type="button" class="btn btn-info" data-toggle="modal" onclick="ver('+elemento.id_inversor+')"><i class="fa fa-eye"></i></button> ' +
						'<button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminar('+elemento.id_inversor+')"><i class="fa fa-trash-o"></i></button>'
					]).draw().node();
					
					$('td', nuevaFila).each(function(index,td){
						$(td).attr('data-label',columnas[index]);
					});
				});
			} else {
				swal.fire({
					'icon' : 'error',
					'title' : 'No se pudieron cargar los inversores',
				});
			}
		}
	});
}

function editar(id_inversor){
	$.ajax({
		'url' : base_url + 'inversores/traer_inversores',
		'type' : 'post',
		'data' : {'id_inversor' : id_inversor},
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado']) {
				$('#modificar_marca').val(obj['inversores']['marca']);
				$('#modificar_codigo').val(obj['inversores']['codigo']);
				$('#modificar_producto').val(obj['inversores']['producto']);
				$('#modificar_potencia').val(obj['inversores']['potencia']);
				$('#modificar_costo').val(obj['inversores']['costo']);
				$('#modificar_moneda option[value="' + obj['inversores']['moneda'] + '"]').prop('selected', true);
				$('#modificar_descripcion').val(obj['inversores']['descripcion']);
				$('#id_inversor').val(obj['inversores']['id_inversor']);
				$('#editar').modal('show');
			} else {
				swal.fire({
					'icon' : 'error',
					'title' : 'No se pudo editar el inversor',
				});
			}
		}
	});
}

function eliminar(id_inversor){
	swal.fire({
		'icon' : 'warning',
		'title' : '¿Está seguro que desea eliminar el inversor?',
		showCancelButton: true,
		confirmButtonText: 'Aceptar',
	}).then((result) => {
		if(result.isConfirmed){
			$.ajax({
				'url' : base_url + 'inversores/eliminar_inversor',
				'type' : 'post',
				'data' : {'id_inversor' : id_inversor},
				'datatype' : 'json',
				'success' : function(obj){
					if(obj['resultado'] == true){
						cargar_datos();
						swal.fire({
							'icon' : 'success',
							'title' : 'El inversor se ha eliminado correctamente',
						});
					}else{
						swal.fire({
							'icon' : 'error',
							'title' : 'No se pudo eliminar el inversor',
						});
					}
				}
			});
		}	
	})
}

function ver(id_inversor){
	$.ajax({
		'url' : base_url + 'inversores/traer_inversores',
		'type' : 'post',
		'data' : {'id_inversor' : id_inversor},
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado'] == true){
				$('#ver_marca').html(obj['inversores']['marca'] == null ? "-" : obj['inversores']['marca']);
				$('#ver_id').html(obj['inversores']['id_inversor']);
				$('#ver_codigo').html(obj['inversores']['codigo'] == null ? "-" : obj['inversores']['codigo']);
				$('#ver_producto').html(obj['inversores']['producto'] == null ? "-" : obj['inversores']['producto']);
				$('#ver_potencia').html(obj['inversores']['potencia'] == null ? "-" : obj['inversores']['potencia'] + ' W');
				$('#ver_costo').html(obj['inversores']['costo'] == null ? "-" : '$ ' + obj['inversores']['costo']);
				$('#ver_moneda').html(obj['inversores']['moneda'] == null ? "-" : obj['inversores']['moneda']);
				$('#ver_fecha_agregacion').html(obj['inversores']['fecha_agregacion'] == null ? "-" : obj['inversores']['fecha_agregacion']);
				$('#ver_fecha_actualizacion').html(obj['inversores']['fecha_actualizacion'] == null ? "-" : obj['inversores']['fecha_actualizacion']);
				$('#ver').modal('show');
			}
			
		}
	});
}