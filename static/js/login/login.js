$(document).ready(function(){
	
	$('#login-form').on('submit', function(e){
		var usuario = $('#usuario').val();
		var password = $('#password').val();
		$('#alerta').addClass('d-none');
		e.preventDefault();
		$.ajax({
			'url' : base_url + 'login/validar',
			'type' : 'post',
			'data' : {
				'usuario' : usuario,
				'password' : password,
			},
			'datatype' : 'json',
			'success' : function(obj){
				console.log(obj);
				if(obj.usuario == false){
					$('#alerta').removeClass('d-none');
					$('#alerta-datos-incorrectos').text('El usuario es incorrecto');
				}else if(obj.contrasenia == false){
					$('#alerta').removeClass('d-none');
					$('#alerta-datos-incorrectos').text('La contraseña es incorrecta');
				}
				// else if(obj.usuario == true && obj.contrasenia == true){
					
				// }
			}
		})
	})
});