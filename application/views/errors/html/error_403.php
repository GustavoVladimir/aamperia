<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Error 403 | AAMPERIA</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		<link rel="stylesheet" href="<?= base_url() ?>/static/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?= base_url() ?>/static/css/login.css">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>img/favicon.png">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	</head>
	<body>
		<div class="container h-100">
			<div class="row align-items-center h-100">
				<div id="login-box" class="col-sm-6 mx-auto d-flex align-items-center">
					<div class="text-center">
						<img id="login-logo" src="<?= base_url() ?>img/logoazul.png">
						<span class="display-3 d-block">Error 403</span>
						<div class="mb-4 lead">La página que estás buscando no existe o no se encuentra disponible actualmente.</div>
						<a href="<?=base_url()?>" class="btn btn-link">Regresar al inicio</a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>