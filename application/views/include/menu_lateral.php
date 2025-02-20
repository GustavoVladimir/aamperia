<nav id="sidebar" class="pb-5 minimizado">
	<div class="sticky-menu mb-5">
		<button type="button" id="cerrar_sidebar" class="btn d-xl-none boton-sidebar mt-4">
			<i class="fa fa-bars"></i>
		</button>
		<button type="button" id="minimizar_sidebar" class="btn boton-sidebar d-none d-xl-block">
			<i class="fa fa-bars"></i>
		</button>
		<img class="logo-barra" src="<?= base_url() ?>img/logoblanco.png">
		<ul class="list-unstyled components mb-5">

			<?php if ($this->session->usuario['nivel'] != "Tercero") { ?>
				<li class="<?= $seccion == 'cotizador' ? 'active' : '' ?>">
					<a href="<?= base_url() ?>cotizacion" target="_self"><i class="fa fa-file-text-o"></i>Cotizador</a>
				</li>
				<li class="<?= $seccion == 'historial_cotizaciones' ? 'active' : '' ?>">
					<a href="<?= base_url() ?>historial_cotizaciones" target="_self"><i class="fa fa-files-o"></i>Cotizaciones realizadas</a>
				</li>
			<?php } ?>

			<li class="<?= $seccion == 'Clientes' ? 'active' : '' ?>">
				<a href="<?= base_url() ?>clientes" target="_self"><i class="fa fa-users" aria-hidden="true"></i>
					Clientes</a>
			</li>

			<?php if ($this->session->usuario['nivel'] == "Administrador" || $this->session->usuario['nivel'] == "Propietario") { ?>
				<li>
					<a data-toggle="collapse" href="#gestion_general" role="button" aria-expanded="false" aria-controls="gestion_general" class="collapsed"><i class="fa fa-sliders"></i>Gestión general</a>
				</li>
				<li class="collapse <?= $seccion == 'gestion_general' ? 'show' : '' ?>" id="gestion_general">
					<ul class="list-unstyled components">
						<li class="<?= $subseccion == 'usuarios' ? 'active' : '' ?>">
							<a href="<?= base_url() ?>usuarios" target="_self"><i class="fa fa-id-card-o"></i>Usuarios</a>
						</li>
					</ul>
				</li>
				<li>
					<a data-toggle="collapse" href="#gestion_especifica" role="button" aria-expanded="false" aria-controls="gestion_especifica" class="<?= $seccion == 'gestion_especifica' ? '' : 'collapse' ?>"><i class="fa fa-cogs"></i>Gestión específica</a>
				</li>
				<li class="collapse <?= $seccion == 'gestion_especifica' ? 'show' : '' ?>" id="gestion_especifica" style="">
					<ul class="list-unstyled components">
						<li class="<?= $subseccion == 'paneles' ? 'active' : '' ?>">
							<a href="<?= base_url() ?>paneles" target="_self"><i class="fa fa-sun-o"></i>Paneles solares</a>
						</li>
						<li class="<?= $subseccion == 'optimizadores' ? 'active' : '' ?>">
							<a href="<?= base_url() ?>optimizadores" target="_self"><i class="fa fa-dashboard"></i>Optimizadores</a>
						</li>
						<li class="<?= $subseccion == 'inversores' ? 'active' : '' ?>">
							<a href="<?= base_url() ?>inversores" target="_self"><i class="fa fa-hdd-o"></i>Inversores centrales</a>
						</li>
						<li class="<?= $subseccion == 'estructuras' ? 'active' : '' ?>">
							<a href="<?= base_url() ?>estructuras" target="_self"><i class="fa fa-building"></i>Estructuras</a>
						</li>
						<li class="<?= $subseccion == 'microinversores' ? 'active' : '' ?>">
							<a href="<?= base_url() ?>microinversores" target="_self"><i class="fa fa-microchip"></i>Microinversores</a>
						</li>
						<li class="<?= $subseccion == 'sistemas_monitoreo' ? 'active' : '' ?>">
							<a href="<?= base_url() ?>sistemas_monitoreo" target="_self"><i class="fa fa-bullhorn"></i>Sistemas de monitoreo</a>
						</li>
						<li class="<?= $subseccion == 'extras' ? 'active' : '' ?>">
							<a href="<?= base_url() ?>extras" target="_self"><i class="fa fa-plus-square-o"></i>Extras</a>
						</li>
					</ul>
				</li>
				<li class="<?= $seccion == 'configuracion_general' ? 'active' : '' ?>">
					<a href="<?= base_url() ?>configuracion" target="_self"><i class="fa fa-cog"></i>Configuración general</a>
				</li>
				<li class="<?= $seccion == 'ayuda' ? 'active' : '' ?>">
					<a href="<?= base_url() ?>ayuda" target="_self"><i class="fa fa-question-circle"></i>Ayuda y documentación</a>
				</li>
			<?php } ?>
		</ul>
	</div>
</nav>
