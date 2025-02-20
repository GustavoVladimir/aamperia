<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Recuperación de contraseña</title>
	</head>
	<body style="background-color: black ">
		<!--Copia desde aquí-->
		<table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;">
			<tr>
				<!--<td style="background-color: #ecf0f1; text-align: left; padding: 0">
						<center><img src="<?= base_url() ?>/img/logoazul.png" width="115" height="100"></center>
				</td>-->
			</tr>
			<tr>
				<td style="background-color: #ecf0f1">
					<div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif; text-align: center">
						<img src="https://agctecnologias.com/cotizador/img/logoazul.png" width="200px" style="margin-bottom:20px">
						<h2 style="color: #e67e22; margin: 0 0 7px">Recuperación de contraseña</h2>
						<p style="margin: 2px; font-size: 15px">
							Da click en el siguiente botón para poder recuperar tu contraseña:
							</p>
						<br>
						<div style="width: 100%; text-align: center">
							<a style="text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #005b8f" href="<?= base_url() ?>recuperar/valida_token/<?= $token ?>">Recuperar contraseña</a>	
						</div>
						<p style="color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0">AAMPERIA © 2022</p>
					</div>
				</td>
			</tr>
		</table>
		<!--hasta aquí-->
	</body>
</html>