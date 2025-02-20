var tabla;
var columnas = [];

$(document).ready(function(){
	tabla = $('#tabla_crud').DataTable({
		responsive: true,
		aaSorting: [],
		"language": {
			"url" : "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
		},
		"columnDefs": [
			{ "width": "5%", "targets": 0 },
			{ "width": "5%", "targets": 2 },
		]
	});
	
	$('#tabla_crud thead tr th').each(function() {
		columnas.push($(this).html());
	});
	
	cargar_datos();
	
	$('#formulario_modificar').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			'url' : base_url + 'historial_cotizaciones/modificar_cotizacion',
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
						'title' : 'El estado de la cotización se ha modificado correctamente',
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
});

function cargar_datos() {
	$.ajax({
		'url' : base_url + 'historial_cotizaciones/cargar_cotizaciones_empleado',
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado']) {
				tabla.clear().draw();
				
				$.each(obj['cotizaciones'], function(i,elemento){
					var estado = "";
					var botones = '<a class="btn btn-info" href="' + base_url + 'historial_cotizaciones/ver_cotizacion/' + elemento.	id_cotizacion+'" target="_blank"><i class="fa fa-eye"></i></a> ' +
						'<a class="btn btn-success" href="' + base_url + 'historial_cotizaciones/descargar_cotizacion/' + elemento.id_cotizacion+'"><i class="fa fa-download"></i></a> ' +
						'<button type="button" class="btn btn-primary" data-toggle="modal" onclick="editar('+elemento.id_cotizacion+')"><i class="fa fa-edit"></i></button>';
					switch(elemento.estado_cotizacion) {
						case "Pendiente" :
							estado = '<span class="badge badge-info">Pendiente</span>';
							break;
						case "Incompleto" :
							estado = '<span class="badge badge-dark">Incompleto</span>';
							botones = '<a class="btn btn-secondary" href="' + base_url + 'cotizacion/previsualizar_cotizacion/' + elemento.id_cotizacion+'" target="_blank"><i class="fa fa-external-link"></i></a>';
							break;
						case "Aceptado" :
							estado = '<span class="badge badge-success">Aceptado</span>';
							break;
						case "Rechazado" :
							estado = '<span class="badge badge-danger">Rechazado</span>';
							break;
						case "Cancelado" :
							estado = '<span class="badge badge-secondary">Cancelado</span>';
							break;
						case "Vencido" :
							estado = '<span class="badge badge-warning">Vencido</span>';
							break;
					}
					var nuevaFila = tabla.row.add([
						elemento.nombre,
						elemento.telefono,
						elemento.tipo_interconexion,
						dinero(elemento.total),
						elemento.num_paneles,
						elemento.fecha_cotizacion,
						elemento.nombre_asesor,
						elemento.vigencia,
						estado,
						botones
					]).draw().node();
					
					$('td', nuevaFila).each(function(index,td){
						$(td).attr('data-label',columnas[index]);
					});
				});
			} else {
				swal.fire({
					'icon' : 'error',
					'title' : 'No se pudieron cargar las cotizaciones',
				});
			}
		}
	});
}

function editar(id_cotizacion){
	$.ajax({
		'url' : base_url + 'historial_cotizaciones/cargar_cotizacion',
		'type' : 'post',
		'data' : {'id_cotizacion' : id_cotizacion},
		'datatype' : 'json',
		'success' : function(obj){
			console.log(obj);
			if(obj['resultado']) {
				$('#id_cotizacion').val(obj['cotizacion'].id_cotizacion);
				$('#nombre').val(obj['cotizacion'].nombre);
				$('#telefono').val(obj['cotizacion'].telefono);
				$('#tipo').val(obj['cotizacion'].tipo_interconexion);
				$('#precio').val(dinero(obj['cotizacion'].total, false));
				$('#paneles').val(obj['cotizacion'].num_paneles);
				$('#fecha').val(obj['cotizacion'].fecha_cotizacion);
				$('#vigencia').val(obj['cotizacion'].vigencia);
				$('#asesor').val(obj['cotizacion'].nombre_asesor);
				$('#id_cotizacion').val(obj['cotizacion'].id_cotizacion);
				$('#estado option[value="' + obj['cotizacion'].estado_cotizacion + '"]').prop('selected', true);
				$('#editar').modal('show');
			}
		}
	});
}