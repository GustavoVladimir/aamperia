<!DOCTYPE html>
<html lang="es">
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
			<script>var obj = <?= json_encode($obj) ?>;</script>
	</head>
	<body>
		<div class="container h-100">
				<div class="row align-items-center h-100">
					<div id="login-box" class="col-sm-6 mx-auto d-flex align-items-center">
						<div>
							<img id="login-logo" src="<?= base_url() ?>img/logoazul.png">
							<form id="pass-form" class="text-center mt-4" method="post" action="<?=base_url()?>recuperar/cambiar_pass">
								<input type="hidden" name="token" value="<?=$valor_token?>">
								<div class="form-group">
									<label for="pass">Nueva contraseña</label>
									<input class="form-control" type="password" id="password" name="password">
									<small class="form-text text-muted">Inserta tu nueva contraseña</small>
								</div>
								
								<div class="form-group">
									<label for="pass1">Confirmar la nueva contraseña</label>
									<input class="form-control" type="password" id="confirmar_password" name="confirmar_password">
									<small class="form-text text-muted">Confirma tu nueva contraseña</small>
								</div>
							
								<?php if($this->session->flashdata('mensaje_error')) { ?>
									<div class="form-group mt-4 d-none">
										<div class="alert alert-danger" role="alert"></div>
									</div>
								<? } ?>
								
								<div class="form-group mt-4">
									<button type="submit" class="btn btn-success btn-block">Cambiar contraseña</button>
								</div>
								
								<div class="form-group mt-2">
									<a class="btn btn-danger btn-block" href="<?= base_url() ?>">Cancelar y volver al inicio</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php $this->load->view('include/scripts');  ?>
		<script src="<?= base_url() ?>static/js/recuperar/cambiar_pass.js"></script>
	</body>
</html>