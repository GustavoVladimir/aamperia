$(document).ready(function(){
	$.ajax({
		'url' : base_url + 'Usuarios/visualizar_usuario',
		'type' : 'post',
		'data' : {id_usuarios},
		'datatype' : 'json',
		'success' : function(obj){
			var data = obj['datos_usuario'];
			console.log(data);
			$('#nombre_usuario').val(data.nombre);
			$('#usuario').val(data.usuario);
			$('#nivel_usuario').val(data.nivel);
			$('#prefijo_usuario').val(data.prefijo);
		}
	})
});