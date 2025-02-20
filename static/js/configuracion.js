$(document).ready(function() {
	/*$('input[type=radio][name=tasa_cambio_modo]').on("change", function() {
		if (this.value == 'automatica') {
			$('#valor_dolar').prop("disabled", true);
		}
		else if (this.value == 'manual') {
			$('#valor_dolar').prop("disabled", false);
		}
	});*/
	
	$.ajax({
		'url' : base_url + '/configuracion/obtener_datos_generales',
		'type': 'post',
		'datatype' : 'json',
		'success' : function(obj){
			console.dir(obj);
			if(obj['resultado'] == true) {
				$('#iva').val(obj['iva']);
				$('#dap').val(obj['dap']);
				$('#indice_utilidad').val(obj['indice_utilidad']);
				$('#hps').val(obj['hps']);
				$('#eficiencia').val(obj['eficiencia']);
				$('#periodo').val(obj['periodo']);
				$('#costo_referido').val(obj['costo_referido']);
				if(obj['obtencion_tasa'] == "auto") {
					$('#tasa_automatica').prop("checked", true);
					//$('#valor_dolar').prop("disabled", true);
				}
				else {
					if(obj['obtencion_tasa'] == "manual") {
						$('#tasa_manual').prop("checked", true);
						//$('#valor_dolar').prop("disabled", false);
					}
				}
				$('#valor_dolar').val(obj['tasa_cambio']);
				var aviso = "Última actualización el " + obj['solo_fecha_tasa'] + " a las " + obj['solo_hora_tasa'];
				$('#aviso_tasa').text(aviso);
			}
		}
	});
	
	$.ajax({
		'url' : base_url + '/configuracion/obtener_tarifas_cfe',
		'type': 'post',
		'datatype' : 'json',
		'success' : function(obj){
			console.dir(obj);
			if(obj['resultado'] == true) {
				$('#tarifa_d1').val(obj['d1']);
				$('#limite_inf_d1').val(obj['d1_limite_inferior']);
				$('#limite_sup_d1').val(obj['d1_limite_superior']);
				$('#tarifa_d2').val(obj['d2']);
				$('#limite_inf_d2').val(obj['d2_limite_inferior']);
				$('#limite_sup_d2').val(obj['d2_limite_superior']);
				$('#tarifa_d3').val(obj['d3']);
				$('#limite_inf_d3').val(obj['d3_limite_inferior']);
				$('#limite_sup_d3').val(obj['d3_limite_superior']);
				$('#tarifa_dac').val(obj['dac']);
				$('#tarifa_pdbt').val(obj['pdbt']);
				if(obj['tipo_obtencion'] == "auto") {
					$('#cfe_automatico').prop("checked", true);
				}
				else {
					if(obj['tipo_obtencion'] == "manual") {
						$('#cfe_manual').prop("checked", true);
					}
				}
				var aviso = "Última actualización el " + obj['solo_fecha_tasa'] + " a las " + obj['solo_hora_tasa'];
				$('#aviso_cfe').text(aviso);
			}
		}
	});

	
});