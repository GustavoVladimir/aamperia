/* HERRAMIENTAS GLOBALES JS DEL SITIO */

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
	
	function round(value, decimals) {
		return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
	}
	
	function dinero(n, simbolo, decimals) {
		var c = isNaN(decimals) ? 2 : Math.abs(decimals),
			d = '.',
			t = ',', 
			simbolo = (simbolo == false) ? "" : "$ ", 
			sign = (n < 0) ? '-' : '',
			i = parseInt(n = Math.abs(n).toFixed(c)) + '',
			j = ((j = i.length) > 3) ? j % 3 : 0;
	
		return simbolo + sign + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '');
	}
});
