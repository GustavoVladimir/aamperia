$(document).ready(function() {
	var cambiando = false;
	var estado_contra = false;
	
	$('#cambiar_contrasenia').click(function() {
		if(!cambiando) {
			$(this).prop('disabled', true);
			$(this).html("Guardar");
			$('#cancelar_cambio').prop('disabled', false);
			$('#contrasenia').val('');
			$('#contrasenia').prop('disabled', false);
			$('#contrasenia_confirmar').val('');
			$('#contrasenia_confirmar').prop('disabled', false);
			cambiando = true;
		}
		else {
			$('#cambiar_contra').submit();
		}
	});
	
	$('#cancelar_cambio').click(function() {
		if(cambiando) {
			$('#cambiar_contrasenia').html("Cambiar contraseña");
			$('#cambiar_contrasenia').prop('disabled', false);
			$('#cancelar_cambio').prop('disabled', true);
			$('#contrasenia').val('***********');
			$('#contrasenia').prop('disabled', true);
			$('#contrasenia_confirmar').val('***********');
			$('#contrasenia_confirmar').prop('disabled', true);
			cambiando = false;
		}
	});
	
	$('#cambiar_contra').on('submit', function(e) {
		e.preventDefault();
		if(estado_contra) {
			$.ajax({
				'url' : base_url + 'cuenta/cambiar_contra',
				'type' : 'post',
				'data' : new FormData(this),
				'contentType': false,
				'cache': false,
				'processData': false,
				'success' : function(obj){
					if(obj['resultado']){
						swal.fire({
							'icon' : 'success',
							'title' : 'La contraseeña se actualizó correctamente',
							confirmButtonText: 'Aceptar'
						});
					}
					else{
						swal.fire({
							'icon' : 'error',
							'title' : 'No se pudo actualizar la contraseña',
							confirmButtonText: 'Aceptar'
						});
					}
					$('#cambiar_contrasenia').html("Cambiar contraseña");
					$('#cancelar_cambio').prop('disabled', true);
					$('#contrasenia').val('***********');
					$('#contrasenia').prop('disabled', true);
					$('#contrasenia_confirmar').val('***********');
					$('#contrasenia_confirmar').prop('disabled', true);
					cambiando = false;
				}
			});
		}
		else {
			$('#contrasenia, #contrasenia_confirmar').trigger('input');
		}
	});
	
	$('#contrasenia, #contrasenia_confirmar').on('input', function () {  
		var contra1 = $('#contrasenia').val();
		var contra2 = $('#contrasenia_confirmar').val();
		var resultado;
		console.log(contra1.length);
		if(contra1.length >= 8) {
			console.log("ya es mayor");
			$('#aviso_contra').html("");
			if(contra2 != contra1) {
				$('#aviso_contra2').html("Coloca la misma contraseña");
				$('#cambiar_contrasenia').prop('disabled', true);
				estado_contra = false;
			}
			else {
				$('#aviso_contra2').html("");
				$('#cambiar_contrasenia').prop('disabled', false);
				estado_contra = true;
			}
		}
		else {
			$('#aviso_contra').html("Al menos 8 caracteres");
			$('#cambiar_contrasenia').prop('disabled', true);
			estado_contra = false;
		}

	});
	
});

