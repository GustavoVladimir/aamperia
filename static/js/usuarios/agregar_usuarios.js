$(document).ready(function(){
	
	$('#formulario_usuarios').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			'url' : base_url + 'Usuarios/agregar_usuario',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado'] == true){
					swal.fire({
						'icon' : 'success',
						'title' : 'El usuario se ha ingresado correctamente',
						showCancelButton: true,
						confirmButtonText: 'Agregar otro usuario',
						cancelButtonText: 'Volver a la gestión de usuarios',
					}).then((result) => {
						if (result.isConfirmed) {
							$("#formulario_usuario")[0].reset();
						} else{
							window.location.href = base_url + 'Usuarios';
						}
					})
						
				}else{
					alert('No se pudo ingresar el usuario');
				}
			}
		})
	});
});




