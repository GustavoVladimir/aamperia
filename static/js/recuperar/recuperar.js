$(document).ready(function(){
	$('#recuperar-form').on('submit',function(e){
		e.preventDefault();
		
		var correo = $('#correo').val();
		$('#alerta').addClass('d-none');
		$.ajax({
			'url' : base_url + 'recuperar/enviar_correo',
			'type' : 'post',
			'data' : {'correo' : correo},
			'datatype' : 'json',
			'success' : function(obj){
				if(!obj.correo){
					swal.fire({
						'icon' : 'error',
						'title' : 'Correo no encontrado',
						'text' : 'El correo ingresado no se encuentra registrado, verifica que lo hayas ingresado bien.',
						heightAuto: false
					});
				} else {
					if(!obj.activo) {
						swal.fire({
							'icon' : 'error',
							'title' : 'Cuenta inactiva',
							'text' : 'El correo ingresado pertenece a una cuenta inactiva. Contacta con AAMPERIA si crees que se trata de un error.',
							heightAuto: false
						});
					}
					else {
						if(obj.mail_envio == true) {
							swal.fire({
								'icon' : 'success',
								'title' : 'Se envió el correo correctamente',
								'text' : 'Revisa tu correo para poder restablecer tu contraseña.',
								heightAuto: false
							});
						} else {
							swal.fire({
								'icon' : 'error',
								'title' : 'Correo no enviado',
								'text' : 'No se pudo enviar el correo para restablecer tu contraseña, vuelve a intentar más tarde.',
								heightAuto: false
							});
						}	 
					}
				}	
			}
		});
	})
});