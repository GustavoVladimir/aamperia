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
			'beforeSend': function() {
				$("#overlay").removeClass('d-none');
			},
			'success' : function(obj){
				if(obj['resultado']){
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
				$("#overlay").addClass('d-none');
			}
		})
	});
	
	$('#asesor_cotizacion').change(function() {
		if($(this).val() == "Todos") {
			tabla.search( '' ).columns().search( '' ).draw();
		}
		else {
			tabla.column(6).search($(this).val()).draw();
		}
	});
	
	$('#estado_cotizacion').change(function() {
		if($(this).val() == "Todos") {
			tabla.search( '' ).columns().search( '' ).draw();
		}
		else {
			tabla.column(8).search($(this).val()).draw();
		}
	});
});

function cargar_datos() {
	$.ajax({
		'url' : base_url + 'usuarios/cargar_responsables',
		'datatype' : 'json',
		'success' : function(obj){
			if(obj.resultado){
				$.each(obj.responsables, function(i, elemento) {
					$('#asesor_cotizacion').append('<option value=' + elemento.responsable + '>' + elemento.responsable + '</option>');
				});
			}
			else {
				Swal.fire('Ocurrió un error', 'No hay usuarios registrados o no se pudieron cargar', 'warning');
			}
		}
	});
	
	$.ajax({
		'url' : base_url + 'historial_cotizaciones/cargar_cotizaciones',
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado']) {
				tabla.clear().draw();
				
				$.each(obj['cotizaciones'], function(i,elemento){
					let estado = "";
					let tipo_interconexion = "";
					let botones = '<a class="btn btn-info" href="' + base_url + 'cotizaciones_pdf/' + elemento.nombre_archivo + '" target="_blank"><i class="fa fa-eye"></i></a>' +
							'<a class="btn btn-success" href="' + base_url + 'cotizaciones_pdf/' + elemento.nombre_archivo + '" download="' + elemento.nombre_archivo + '"><i class="fa fa-download"></i></a>' +
							'<button type="button" class="btn btn-primary" data-toggle="modal" onclick="editar('+elemento.id_cotizacion+')"><i class="fa fa-edit"></i></button>' + 
							'<button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminar('+elemento.id_cotizacion+')"><i class="fa fa-trash-o"></i></button>';
					switch(elemento.estado_cotizacion) {
						case "Pendiente" :
							estado = '<span class="badge badge-info">Pendiente</span>';
							break;
						case "Incompleto" :
							estado = '<span class="badge badge-dark">Incompleto</span>';
							botones = '<a class="btn btn-success" href="' + base_url + 'cotizacion/previsualizar_cotizacion/' + elemento.id_cotizacion+'" target="_blank"><i class="fa fa-external-link"></i></a>' +
							'<button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminar('+elemento.id_cotizacion+')"><i class="fa fa-trash-o"></i></button>';
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
					switch(elemento.tipo_interconexion) {
						case "inversor_central_austero" :
							tipo_interconexion = "Inversor central (austero)";
							break;
						case "inversor_central_optimizadores" :
							tipo_interconexion = "Inversor central con optimizadores";
							break;
						case "microinversores" :
							tipo_interconexion = "Microinversores";
							break;
						case "personalizado" :
							tipo_interconexion = "Personalizado";
							break;	
					}
					var nuevaFila = tabla.row.add([
						elemento.nombre,
						elemento.telefono,
						tipo_interconexion,
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
			$('#overlay').addClass('d-none');
		}
	});
}


function eliminar(id_cotizacion){
	swal.fire({
		'icon' : 'warning',
		'title' : '¿Está seguro que desea eliminar la cotización?',
		showCancelButton: true,
		confirmButtonText: 'Aceptar',
	}).then((result) => {
		if(result.isConfirmed){
			$.ajax({
				'url' : base_url + 'historial_cotizaciones/eliminar_cotizacion',
				'type' : 'post',
				'data' : {'id_cotizacion' : id_cotizacion},
				'datatype' : 'json',
				'beforeSend': function() {
					$("#overlay").removeClass('d-none');
				},
				'success' : function(obj){
					if(obj['resultado']){
						swal.fire({
							'icon' : 'success',
							'title' : 'La cotización se ha eliminado correctamente',
						});
						cargar_datos();
					}else{
						swal.fire({
							'icon' : 'error',
							'title' : 'No se pudo eliminar la cotización',
						});
					}
					$("#overlay").addClass('d-none');
				}
			});
		}	
	})
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
				$('#boton_modificar').unbind('click');
				$('#boton_modificar').click(function() {
					$.ajax({
						'url' : base_url + 'modificar_cotizacion/precargar_cotizacion',
						'type' : 'post',
						'data' : {'id_cotizacion' : obj['cotizacion'].id_cotizacion},
						'datatype' : 'json',
						'beforeSend': function() {
							$("#overlay").removeClass('d-none');
						},
						'success' : function(obj) {
							//console.log(obj);
							//$('#overlay').addClass('d-none');
							window.location.replace(base_url + 'modificar_cotizacion');
						},
						'error' : function(xhr){
							Swal.fire({
								'icon' : 'error',
								'title' : 'Error en el servidor',
								'html' : '<b>Mensaje técnico:</b><br>' +
										 '<p>' + xhr.status + ' ' + xhr.statusText + '</p>',
								confirmButtonText: 'Aceptar'
							});
							console.log(xhr.responseText);
							$('#overlay').addClass('d-none');
						}
					});
				});
				$('#editar').modal('show');
			}
		}
	});
}
