$(document).ready(function(){
	var fecha_d = fecha_cotizacion.split("-");
	var fecha_original = new Date(fecha_d[0], fecha_d[1] - 1, fecha_d[2])
	var nueva_fecha;
	
	var anticipo_porcentaje = parseInt($('#anticipo').val());
	var fin_instalacion_porcentaje = parseInt($('#fin-instalacion').val());
	var cambio_medidor_porcentaje = parseInt($('#cambio-medidor').val());
	
	var anticipo = 0;
	var fin_instalacion = 0;
	var cambio_medidor = 0;
	
	$('#anticipo').on('input',function() {
		anticipo_porcentaje = parseInt($('#anticipo').val());
		if(!isNaN(anticipo_porcentaje) && anticipo_porcentaje <= 100 && anticipo_porcentaje >= 0){
			anticipo = calcular_porcentaje(total, anticipo_porcentaje);
			$('#anticipo-result').text(dinero(anticipo));
		}else if(anticipo_porcentaje > 100){
			anticipo_porcentaje = 100;
			$('#anticipo-result').text(dinero(total));
			$('#anticipo').val(anticipo_porcentaje);
		}else if(anticipo_porcentaje < 0){
			anticipo_porcentaje = 0;
			$('#anticipo-result').text(dinero(0));
			$('#anticipo').val(anticipo_porcentaje);
		}
	});
	
	$('#fin-instalacion').on('input',function() {
		fin_instalacion_porcentaje = parseInt($('#fin-instalacion').val());
		if(!isNaN(fin_instalacion_porcentaje) && fin_instalacion_porcentaje <= 100 && fin_instalacion_porcentaje >= 0){
			fin_instalacion = calcular_porcentaje(total, fin_instalacion_porcentaje);
			$('#fin-instalacion-result').text(dinero(fin_instalacion));
		}else if(fin_instalacion_porcentaje > 100){
			fin_instalacion_porcentaje = 100;
			$('#fin-instalacion-result').text(dinero(total));
			$('#fin-instalacion').val(fin_instalacion_porcentaje);
		}else if(fin_instalacion_porcentaje < 0){
			fin_instalacion_porcentaje = 0;
			$('#fin-instalacion-result').text(dinero(0));
			$('#fin-instalacion').val(fin_instalacion_porcentaje);
		}
	});
	
	$('#cambio-medidor').on('input',function() {
		cambio_medidor_porcentaje = parseInt($('#cambio-medidor').val());
		if(!isNaN(cambio_medidor_porcentaje) && cambio_medidor_porcentaje <= 100 && cambio_medidor_porcentaje >= 0){
			cambio_medidor = calcular_porcentaje(total, cambio_medidor_porcentaje);
			$('#cambio-medidor-result').text(dinero(cambio_medidor));
		}else if(cambio_medidor_porcentaje > 100){
			cambio_medidor_porcentaje = 100;
			$('#cambio-medidor-result').text(dinero(total));
			$('#cambio-medidor').val(cambio_medidor_porcentaje);
		}else if(cambio_medidor_porcentaje < 0){
			cambio_medidor_porcentaje = 0;
			$('#cambio-medidor-result').text(dinero(0));
			$('#cambio-medidor').val(cambio_medidor_porcentaje);
		}
	});
	
	$('#dias_vigencia').change(function() {
		var dias = parseInt($(this).val());
		nueva_fecha = addDays(fecha_original, dias);
		$('#vigencia_1').html(('0' + nueva_fecha.getDate()).slice(-2) + '/' + ('0' + (nueva_fecha.getMonth()+1)).slice(-2) + '/' + nueva_fecha.getFullYear());
		$('#vigencia_2').html(('0' + nueva_fecha.getDate()).slice(-2) + '/' + ('0' + (nueva_fecha.getMonth()+1)).slice(-2) + '/' + nueva_fecha.getFullYear());
	});
	
	$('#dias_vigencia').trigger("change");
	$('#anticipo').trigger('input');
	$('#fin-instalacion').trigger('input');
	$('#cambio-medidor').trigger('input');
	
	$('#descargar_cotizacion').click(function() {
		$('#overlay').removeClass('d-none');
		var condiciones_pago = {
			'anticipo_porcentaje' : anticipo_porcentaje,
			'fin_instalacion_porcentaje' : fin_instalacion_porcentaje,
			'cambio_medidor_porcentaje' : cambio_medidor_porcentaje,
			'anticipo' : anticipo,
			'fin_instalacion' : fin_instalacion,
			'cambio_medidor' : cambio_medidor 
		}
		if(anticipo_porcentaje + fin_instalacion_porcentaje + cambio_medidor_porcentaje == 100) {
			$.ajax({
				'url' : base_url + 'cotizacion/finalizar_cotizacion',
				'data' : {
					'id_cotizacion' : id_cotizacion,
					'condiciones_pago' : condiciones_pago,
					'vigencia' : $('#dias_vigencia').val(),
					'tiempo_entrega' : $('#tiempo_entrega').val()
				},
				'type' : 'post',
				'success' : function(obj){
					$.ajax({
						'url' : base_url + 'cotizacion/guardar_pdf_cotizacion',
						'data' : {
							'id_cotizacion' : id_cotizacion
						},
						'type' : 'post',
						'success' : function(obj){
							window.open(base_url + 'cotizaciones_pdf/' + obj['nombre_archivo']);
							window.location.replace(base_url);
						}
					});
				}
			});
		}
		else {
			Swal.fire('Valores incorrectos', 'Los porcentajes de pago no son correctos', 'error');
			$('#overlay').addClass('d-none');
		}
	});

	function calcular_porcentaje(total, porcentaje){
		var valor = round((total/100)*porcentaje, 2);
		return valor;
	}
	
	function addDays(date, days) {
		var result = new Date(date);
		result.setDate(result.getDate() + days);
		return result;
	}
});

function cancelar_cotizacion(id_cotizacion) {
	swal.fire({
		'icon' : 'warning',
		'title' : '¿Desea cancelar la cotización?',
		showCancelButton: true,
		confirmButtonText: 'Aceptar',
		cancelButtonText: 'Cancelar'
	}).then((result) => {
		if(result.isConfirmed) {
			$.ajax({
				'url' : base_url + 'reporte/cancelar_cotizacion',
				'type' : 'post',
				'data' : {'id_cotizacion' : id_cotizacion},
				'datatype' : 'json',
				'success' : function(obj){
					if(obj['resultado'] == true){
						Swal.fire({
							'icon' : 'success',
							'title' : 'La cotización se ha cancelado correctamente.',
						}).then(function() {
							window.location.replace(base_url);
						});
					}
				}
			});
		}
	});
}
