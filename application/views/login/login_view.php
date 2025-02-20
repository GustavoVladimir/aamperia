<!doctype html>
<html lang="en">
	<head>
		<title>Iniciar sesión | AAMPERIA</title>
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
		<script>var base_url = "<? base_url() ?>";</script>
	</head>
	<body>
		<div class="container h-100">
			<div class="row align-items-center h-100">
				<div id="login-box" class="col-sm-6 mx-auto d-flex align-items-center">
					<div>
						<img id="login-logo" src="<?= base_url() ?>img/logoazul.png">
						<form id="login-form" class="text-center" method="post" action="<?= base_url() ?>/login/iniciar_sesion">
							<div class="form-group">
								<label for="usuario">Usuario o correo</label>
								<input name="usuario" required class="form-control" type="text" id="usuario" value="<?php if($this->session->flashdata('nombre_usuario')) { echo $this->session->flashdata('nombre_usuario'); } ?>" autofocus autocomplete="username">
							</div>
							<div class="form-group mb-4">
								<label for="contrasenia">Contraseña</label>
								<input name="contrasenia" required class="form-control" type="password" id="contrasenia" autocomplete="current-password">
							</div>
							
							<div class="form-group mt-4">
								<button type="submit" class="btn btn-success btn-block">Iniciar sesión</button>
							</div>
							<?php if($this->session->flashdata('mensaje_error')) { ?>
								<div class="form-group mt-4" id="alerta">
									<div class="alert alert-danger" role="alert" id="alerta-datos-incorrectos"><?=$this->session->flashdata('mensaje_error')?></div>
								</div>
							<?php } ?>
							<div class="form-group">
								<a href="<?= base_url() ?>recuperar">¿Olvidaste tu contraseña?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<script src="<?= base_url() ?>/static/js/jquery.min.js"></script>
		<script src="<?= base_url() ?>/static/js/bootstrap.bundle.min.js"></script>
		<!--<script src="<?= base_url() ?>/static/js/login/login.js"></script>-->
	</body>
</html>