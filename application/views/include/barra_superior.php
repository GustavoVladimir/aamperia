<div class="alert alert-primary" role="alert">
	Te encuentras en entorno de pruebas
</div>
<nav id="topbar" class="navbar navbar-expand-lg">
	<div class="container-fluid">
		<button type="button" id="boton-sidebar" class="btn d-xl-none boton-sidebar">
			<i class="fa fa-bars"></i>
			<span class="sr-only">Toggle Menu</span>
		</button>
		<div id="boton-usuario" class="btn-group ml-auto">
			<a class="dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span><?= $this->session->usuario['nombre'] . ' ' . $this->session->usuario['apellido_paterno'] . ' ' . $this->session->usuario['apellido_materno'] ?></span>
				<span class="sr-only">Toggle Dropdown</span>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item" href="<?= base_url() ?>cuenta">Cuenta</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="<?= base_url() ?>logout">Cerrar sesión</a>
			</div>
		</div>
	</div>
</nav>
<script>
	let usuario = <?= json_encode($this->session->userdata('usuario')) ?>;
	console.log("Sesión del usuario:", usuario);
</script>
