<!doctype html>
<html lang="en">
	<head>
		<title>Recuperar contraseña | AAMPERIA</title>
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
	</head>
	<body>
		<div class="container h-100">
			<div class="row align-items-center h-100">
				<div id="login-box" class="col-sm-6 mx-auto d-flex align-items-center">
					<div>
						<img id="login-logo" src="<?= base_url() ?>img/logoazul.png">
						<form id="recuperar-form" class="text-center" method="post">
							<div class="form-group">
								<label for="correo">Correo electrónico</label>
								<input class="form-control" type="email" id="correo" name="correo" required>
								<small class="form-text text-muted">Se enviará un enlace a este correo para restablecer la contraseña.</small>
							</div>
							<?php if($this->session->flashdata('mensaje_error')) { ?>
								<div class="form-group mt-4" id="alerta">
									<div class="alert alert-danger" role="alert" id="alerta-datos-incorrectos"><?=$this->session->flashdata('mensaje_error')?></div>
								</div>
							<?php } ?>
							<div class="form-group mt-4">
								<button type="submit" class="btn btn-success btn-block">Recuperar contraseña</button>
							</div>
							<div class="form-group">
								<a href="<?= base_url() ?>login/">Iniciar sesión con una cuenta existente</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('include/scripts');  ?>
		<script src="<?= base_url() ?>/static/js/recuperar/recuperar.js"></script>
	</body>
</html>