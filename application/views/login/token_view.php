<!DOCTYPE html>
<html lang="es">
<head>
	<title>Ingresar token</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		<link rel="stylesheet" href="<?= base_url() ?>/static/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?= base_url() ?>/static/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?= base_url() ?>/static/css/jquery-ui.min.css">
		<link rel="stylesheet" href="<?= base_url() ?>/static/css/login.css">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
		<script>var base_url = "<?= base_url() ?>";</script>
		<script>var obj = <?= json_encode($obj) ?>;</script>
</head>
<body>
	<div class="container h-100">
			<div class="row align-items-center h-100">
				<div id="login-box" class="col-sm-6 mx-auto d-flex align-items-center">
					<div>
						<img id="login-logo" src="<?= base_url() ?>img/logoazul.png">
						<form id="pass-form" class="text-center" method="post">
							<div class="form-group">
								<label for="pass">Contraseña</label>
								<input class="form-control" type="password" id="pass">
								<small id="emailHelp" class="form-text text-muted">Inserta tu nueva contraseña.</small>
							</div>
							
							<div class="form-group">
								<label for="pass1">Confirmar contraseña contraseña</label>
								<input class="form-control" type="password" id="pass1">
								<small id="emailHelp" class="form-text text-muted">Confirma tu contraseña.</small>
							</div>
							
							<div class="form-group mt-4">
								<button type="submit" class="btn btn-success btn-block">Recuperar contraseña</button>
							</div>
							<div class="form-group mt-4 d-none" id="alerta">
								<div class="alert alert-danger" role="alert" id="alerta-datos-incorrectos"></div>
							</div>
							<div class="form-group">
								<a href="<?= base_url() ?>">Iniciar sesión con una cuenta existente</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php $this->load->view('include/scripts');  ?>
	<script src="<?= base_url() ?>static/js/login/token.js"></script>
</body>
</html>