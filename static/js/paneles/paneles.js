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
		'url' : base_url + 'paneles/traer_marca_panel',
		'datatype' : 'json',
		'success' : function(obj){
			var selectContenido = "";
			$.each(obj['marcas'],function(i,elemento){
				selectContenido += '<option value="'+elemento.marca+'">'+elemento.marca+'</option>';
			});
			$('#marca_panel').append(selectContenido);
		}
	});
	
	$('#marca_panel').change(function(){
		var marca = $(this).val();
		$.ajax({
			'url' : base_url + 'paneles/traer_paneles',
			'type' : 'post',
			'data' : {'marca' : marca},
			'datatype' : 'json',
			'success' : function(obj){
				tabla.clear().draw();
				if(obj['resultado']) {
					$.each(obj['paneles'], function(i,elemento){
						var nuevaFila = tabla.row.add([
						elemento.marca,
						elemento.codigo,
						elemento.producto,
						elemento.watts_panel + ' W',
						'$ ' + elemento.usd_watt,
						'$ ' + elemento.usd_panel,
						'<button type="button" class="btn btn-primary" onclick="editar('+elemento.id_panel+')"><i class="fa fa-edit"></i></button> ' +
						'<button type="button" class="btn btn-info" onclick="ver('+elemento.id_panel+')"><i class="fa fa-eye"></i></button> ' +
						'<button type="button" class="btn btn-danger" onclick="eliminar("'+elemento.id_panel+'");"><i class="fa fa-trash-o"></i></button> '
						]).draw().node();
						
						$('td', nuevaFila).each(function(index,td){
							$(td).attr('data-label',columnas[index]);
						});
					});
				}
			}
		});
	})
	
	$('#formulario_agregar').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			'url' : base_url + 'paneles/agregar_panel',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'datatype' : 'json',
			'success' : function(obj){
				console.log(obj['resultado']);
				if(obj['resultado'] == true){
					Swal.fire({
						'icon' : 'success',
						'title' : 'El panel se ha ingresado correctamente',
						confirmButtonText: 'Aceptar'
					});
					$('#formulario_agregar').trigger('reset');
					$('#agregar').modal('hide');
					cargar_datos();			
				}else{
					swal.fire({
						'icon' : 'error',
						'title' : 'No se pudo agregar el panel',
					});
				}
			}
		})
	});
	
	$('#formulario_modificar').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			'url' : base_url + 'paneles/modificar_panel',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'datatype' : 'json',
			'success' : function(obj){
				console.log(obj['resultado']);
				if(obj['resultado'] == true){
					swal.fire({
						'icon' : 'success',
						'title' : 'El panel se ha modificado correctamente',
					});	
					$('#editar').modal('hide');
					cargar_datos();
				} else{
					swal.fire({
						'icon' : 'error',
						'title' : 'No se guardaron los cambios realizados',
					});
				}
			}
		})
	});
	
	$('#usd_watt').on('input',function() {
		var usd_watt = parseFloat($(this).val());
		var watts = parseFloat($('#watts_panel').val());
		if(!isNaN(usd_watt) && !isNaN(watts)) {
			var usd_panel = round(watts*usd_watt,2);
			$('#usd_panel').val(usd_panel);
		}
	});
	
	$('#usd_panel').on('input',function() {
		var usd_panel = parseFloat($(this).val());
		var watts = parseFloat($('#watts_panel').val());
		if(!isNaN(usd_panel) && !isNaN(watts)) {
			var usd_watt = round(usd_panel/watts,3);
			$('#usd_watt').val(usd_watt);
		}
	});
	
	$('#modificar_usd_watt').on('input',function() {
		var usd_watt = parseFloat($(this).val());
		var watts = parseFloat($('#modificar_watts_panel').val());
		if(!isNaN(usd_watt) && !isNaN(watts)) {
			var usd_panel = round(watts*usd_watt,2);
			$('#modificar_usd_panel').val(usd_panel);
		}
	});
	
	$('#modificar_usd_panel').on('input',function() {
		var usd_panel = parseFloat($(this).val());
		var watts = parseFloat($('#modificar_watts_panel').val());
		if(!isNaN(usd_panel) && !isNaN(watts)) {
			var usd_watt = round(usd_panel/watts,3);
			$('#modificar_usd_watt').val(usd_watt);
		}
	});	
});

function cargar_datos() {
	$.ajax({
		'url' : base_url + 'paneles/traer_paneles',
		'datatype' : 'json',
		'success' : function(obj){
			tabla.clear().draw();
			$.each(obj['paneles'], function(i,elemento){
				var nuevaFila = tabla.row.add([
					elemento.marca,
					elemento.codigo,
					elemento.producto,
					elemento.watts_panel,
					'$ ' + elemento.usd_watt,
					'$ ' + elemento.usd_panel,
					'<button type="button" class="btn btn-primary" onclick="editar('+elemento.id_panel+')"><i class="fa fa-edit"></i></button> ' +
					'<button type="button" class="btn btn-info" onclick="ver('+elemento.id_panel+')"><i class="fa fa-eye"></i></button> ' +
					'<button type="button" class="btn btn-danger" onclick="eliminar('+elemento.id_panel+')"><i class="fa fa-trash-o"></i></button>'
				]).draw().node();
				
				$('td', nuevaFila).each(function(index,td){
					$(td).attr('data-label',columnas[index]);
				});
				
			});
		}
	});
}

function eliminar(id_panel){
	swal.fire({
		'icon' : 'warning',
		'title' : '¿Está seguro que desea eliminar el panel?',
		showCancelButton: true,
		confirmButtonText: `Aceptar`,
	}).then((result) => {
		if(result.isConfirmed){
			$.ajax({
				'url' : base_url + 'paneles/eliminar_panel',
				'type' : 'post',
				'data' : {'id_panel' : id_panel},
				'datatype' : 'json',
				'success' : function(obj){
					if(obj['resultado'] == true){
						swal.fire({
							'icon' : 'success',
							'title' : 'El panel se ha eliminado correctamente.',
						});
						cargar_datos();
					}else{
						swal.fire({
							'icon' : 'error',
							'title' : 'No se pudo eliminar el panel.',
						});
					}
				}
			});
		}	
	})
}

function editar(id_panel){
	$.ajax({
		'url' : base_url + 'paneles/traer_paneles',
		'type' : 'post',
		'data' : {'id_panel' : id_panel},
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado']) {
				$('#modificar_marca').val(obj['paneles'].marca);
				$('#modificar_codigo').val(obj['paneles'].codigo);
				$('#modificar_producto').val(obj['paneles'].producto);
				$('#modificar_watts_panel').val(obj['paneles'].watts_panel);
				$('#modificar_usd_watt').val(obj['paneles'].usd_watt);
				$('#modificar_usd_panel').val(obj['paneles'].usd_panel);
				$('#id_panel').val(obj['paneles'].id_panel);
				$('#editar').modal('show');
			}
		}
	});
}

function ver(id_panel){
	$.ajax({
		'url' : base_url + 'paneles/traer_paneles',
		'type' : 'post',
		'data' : {'id_panel' : id_panel},
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado']) {
				
				$('#ver_marca').html(obj['paneles']['marca'] == null ? "-" : obj['paneles']['marca']);
				$('#ver_id').html(obj['paneles']['id_panel']);
				$('#ver_codigo').html(obj['paneles']['codigo'] == null ? "-" : obj['paneles']['codigo']);
				$('#ver_producto').html(obj['paneles']['producto'] == null ? "-" : obj['paneles']['producto']);
				$('#ver_watts_panel').html(obj['paneles']['codigo'] == null ? "-" : obj['paneles']['watts_panel']);
				$('#ver_usd_panel').html(obj['paneles']['usd_panel'] == null ? "-" : obj['paneles']['usd_panel']);
				$('#ver_usd_watt').html(obj['paneles']['usd_watt'] == null ? "-" : obj['paneles']['usd_watt']);
				$('#ver_fecha_agregacion').html(obj['paneles']['fecha_agregacion'] == null ? "-" : obj['paneles']['fecha_agregacion']);
				$('#ver_fecha_actualizacion').html(obj['paneles']['fecha_actualizacion'] == null ? "-" : obj['paneles']['fecha_actualizacion']);
				$('#ver').modal('show');
			}
			else {
				swal.fire({
					'icon' : 'error',
					'title' : 'No se puede editar el panel',
				});
			}
		}
	});
}