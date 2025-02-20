$(document).ready(function(){
	var anticipo = parseInt($('#anticipo').val());
	var porcentaje = 0;
	var total = obj.totales_cotizacion.costo_final;
	var fin_instalacion = parseInt($('#fin-instalacion').val());
	var cambio_medidor = parseInt($('#cambio-medidor').val());
	var Tcont = "";
	var Tbody = "";
	
	$.ajax({
		'url' : base_url + 'reporte/traer_terminos',
		'datatype' : 'json',
		'success' : function(obj){
			$('#terminos').html(obj.terminos);
		}
	});

	$('#anticipo-result').text(round(anticipo_porcentaje(total,anticipo),2));
	$('#fin-instalacion-result').text(round(anticipo_porcentaje(total,fin_instalacion),2));
	$('#cambio-medidor-result').text(round(anticipo_porcentaje(total,cambio_medidor),2));
	
	$('#nombre-cliente').text(obj.datos_cotizacion.nombre_usuario);
	$('#ubicacion').text(obj.datos_cotizacion.ubicacion);
	$('#nombre-asesor').text(obj.datos_cotizacion.asesor);
	$('#consumo-promedio').text(obj.datos_consumo.consumo_promedio_kwh + ' (kwh)');
	$('#consumo-pesos').text('$ ' + obj.datos_consumo.consumo_promedio_pesos);
	$('#numero-paneles').text(obj.paneles.num_paneles);
	$('#produccion-anual').text(obj.sistema.produccion_anual);
	$('#produccion-bimestral').text(obj.sistema.produccion_promedio + ' (kwh)');
	$('#tipo-interconexion').text(obj.sistema.tipo_interconexion);
	$('#subtotal').text(obj.totales_cotizacion.costo_proyecto_utilidad);
	$('#iva').text(obj.totales_cotizacion.iva);
	$('#total').text(obj.totales_cotizacion.costo_final);
	$('#retorno-inversion').text(obj.totales_cotizacion.retorno_inversion);
	
	console.log("entra al js");
	
	$.each(obj.datos_ahorro,function(i,elemento){
		console.log("entra al each de datos ahorro");
		Tcont +=
		'<tr>' +
		'<th>' +elemento.periodo+'</th>'+
		'<td>' +elemento.actual+'</td>'+
		'<td>' +elemento.aamperia+'</td>'+
		'<td>' +elemento.ahorro+'</td>'+
		'</tr>';
	});
	
	console.log(Tcont);
	
	$('#ahorros-estimados').html(Tcont);
	
	
	$.each(obj.productos_cotizacion,function(i,elemento){
		Tbody +=
		'<tr>' +
		'<th>' + elemento.nombre + '</th>' + 
		'<td>' + elemento.cantidad + '</td>' + 
		'<td>' + elemento.p_unitario + '</td>' + 
		'<td>' + elemento.importe + '</td>' + 
		'</tr>';
	});
	
	$('#sistema').html(Tbody);
	
	$('#imagen-grafica').attr('src',obj.grafica_imagen);
	
	$('#anticipo').on('input',function(){
		anticipo = parseInt($('#anticipo').val());
		if(!isNaN(anticipo) && anticipo <= 100 && anticipo >= 0){
			$('#anticipo-result').text("");
			$('#anticipo-result').text(round(anticipo_porcentaje(total,anticipo),2));
		}else if(anticipo > 100){
			anticipo = 100;
			$('#anticipo-result').text("");
			$('#anticipo-result').text(total);
			$('#anticipo').val(anticipo);
		}else if(anticipo < 0){
			anticipo = 0;
			$('#anticipo-result').text("");
			$('#anticipo-result').text(anticipo);
			$('#anticipo').val(anticipo);
		}
	});

	$('#fin-instalacion').on('input',function(){
		fin_instalacion = parseInt($('#fin-instalacion').val());
		if(!isNaN(fin_instalacion) && fin_instalacion <= 100 && fin_instalacion >= 0){
			$('#fin-instalacion-result').text("");
			$('#fin-instalacion-result').text(round(anticipo_porcentaje(total,fin_instalacion),2));
		}else if(fin_instalacion > 100){
			fin_instalacion	= 100;
			$('#fin-instalacion-result').text("");
			$('#fin-instalacion-result').text(total);
			$('#fin-instalacion').val(fin_instalacion);
		}else if(fin_instalacion < 0){
			fin_instalacion	= 0;
			$('#fin-instalacion-result').text("");
			$('#fin-instalacion-result').text(fin_instalacion);
			$('#fin-instalacion').val(fin_instalacion);
		}
	});
	
	$('#cambio-medidor').on('input',function(){
		cambio_medidor = parseInt($('#cambio-medidor').val());
		if(!isNaN(cambio_medidor) && cambio_medidor <= 100 && cambio_medidor >= 0){
			$('#cambio-medidor-result').text("");
			$('#cambio-medidor-result').text(round(anticipo_porcentaje(total,cambio_medidor),2));
		}else if(cambio_medidor > 100){
			cambio_medidor = 100;
			$('#cambio-medidor-result').text("");
			$('#cambio-medidor-result').text(total);
			$('#cambio-medidor').val(cambio_medidor);
		}else if(cambio_medidor < 0){
			cambio_medidor = 0;
			$('#cambio-medidor-result').text("");
			$('#cambio-medidor-result').text(cambio_medidor);
			$('#cambio-medidor').val(cambio_medidor);
		}
	});
	
	console.log("final de archivo");

	function anticipo_porcentaje(total,anticipo){
		var valor = (total/100)*anticipo;
		return valor;
	}
});

