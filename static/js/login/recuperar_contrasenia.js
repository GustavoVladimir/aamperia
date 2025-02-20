$(document).ready(function(){
	$('#recuperar-form').on('submit',function(e){
		e.preventDefault();
		
		var correo = $('#correo').val();
		$('#alerta').addClass('d-none');
		
		$.ajax({
			'url' : base_url + 'login/enviar_correo',
			'type' : 'post',
			'data' : {'correo' : correo},
			'datatype' : 'json',
			'success' : function(obj){
				console.log(obj);
				if(obj.correo == false){
					$('#alerta').removeClass('d-none');
					$('#alerta-datos-incorrectos').text('No se encontró el correo');
				} else {
					if(obj.mail_envio == true) {
						swal.fire({
							'icon' : 'success',
							'title' : 'Se envió el correo correctamente',
						});
					} else {
						swal.fire({
							'icon' : 'error',
							'title' : 'No se pudo enviar el correo, intenta más tarde',
						});
					}	 
				}	
			}
		});
	})
});