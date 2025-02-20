$(document).ready(function(){
	$.ajax({
		'url' : base_url + 'Usuarios/visualizar_usuario2',
		'type' : 'post',
		'data' : {id_usuarios},
		'datatype' : 'json',
		'success' : function(obj){
			if(obj['resultado']){
				var data = obj['datos_usuario'];
				console.log(data);
				$('#nombre_usuario').val(data.nombre);
				$('#apellido_paterno_usuario').val(data.apellido_paterno);
				$('#apellido_materno_usuario').val(data.apellido_materno);
				$('#usuario').val(data.usuario);
				$('#nivel_usuario').val(data.nivel);
				$('#prefijo_usuario').val(data.prefijo);
			}
			else {
				Swal.fire("Error","No se encontó el usuario","error");
				$('#guardar').prop("disabled",true);
			}
		}
	})
	
	$('#formulario_usuarios').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			'url' : base_url + 'Usuarios/editar_usuario',
			'type' : 'post',
			'data' : new FormData(this),
			'contentType': false,
            'cache': false,
            'processData': false,
			'success' : function(obj){
				if(obj['resultado'] == true){
					swal.fire({
						'icon' : 'success',
						'title' : 'El usuario se ha actualizado correctamente',
						confirmButtonText: 'Aceptar',
					}).then((result) => {
						window.location.href = base_url + 'Usuarios';
					})
				}else{
					alert('No se pudo actualizar el usuario');
				}
			}
		})
	});
});