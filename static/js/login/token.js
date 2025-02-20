$(document).ready(function(){
	
	if(obj.vigencia == false){
		swal.fire({
			'icon' : 'error',
			'title' : 'Algo salio mal, intententalo más tarde'
		}).then((result) => {	
		  if (result.isConfirmed) {
			window.location.href = base_url;
		  }
		})
	}else{
		$('#pass-form').on('submit',function(e){
			e.preventDefault();
			var pass = $('#pass').val();
			var pass1 = $('#pass1').val();
			
			if(pass != pass1){
				$('#alerta').removeClass('d-none');
				$('#alerta-datos-incorrectos').text('Las contraseñas son diferentes');
			}else{
				$.ajax({
					'url' : base_url + 'login/cambiar_pass',
					'type' : 'post',
					'data' : {
						'id_usuario' : obj.id_usuario,
						'password' : pass
					},
					'datatype' : 'json',
					'success' : function(obj){
						console.log(obj.cambio);
					}
				})
			}
		});
	}
	
}); 