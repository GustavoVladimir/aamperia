<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Datos actualizados | AAMPERIA</title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
			<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
			<link rel="stylesheet" href="<?= base_url() ?>/static/css/bootstrap.min.css">
			<link rel="stylesheet" href="<?= base_url() ?>/static/css/font-awesome.min.css">
			<link rel="stylesheet" href="<?= base_url() ?>/static/css/jquery-ui.min.css">
			<link rel="stylesheet" href="<?= base_url() ?>/static/css/login.css">
			<link rel="preconnect" href="https://fonts.gstatic.com">
			<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>img/favicon.png">
			<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
			<script>var base_url = "<?= base_url() ?>";</script>
			<script>var obj = <?= json_encode($obj) ?>;</script>
	</head>
	<body>
		<div class="container h-100">
				<div class="row align-items-center h-100">
					<div id="login-box" class="col-sm-6 mx-auto d-flex align-items-center">
						<div class="text-center">
							<img id="login-logo" src="<?= base_url() ?>img/logoazul.png" class="mb-4">
							<h2>Contraseña recuperada correctamente</h2>
							<p>Tu contraseña se ha actualizado de forma exitosa. Ahora puedes iniciar sesión con tus nuevos datos.</p>
							<a class="btn btn-success btn-block" href="<?= base_url() ?>">Inicio</a>
						</div>
					</div>
				</div>
			</div>
		<?php $this->load->view('include/scripts');  ?>
	</body>
</html>