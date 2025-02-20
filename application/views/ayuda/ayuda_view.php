<!doctype html>
<html lang="en">
	<head>
		<!-- HEADER (links de CSS y título) -->
		<?php $this->load->view('include/header', $datos_pagina); ?>
	</head>
	<body>
		<div class="wrapper d-flex align-items-stretch">
			<!-- MENU LATERAL -->
			<?php $this->load->view('include/menu_lateral', $datos_pagina);  ?>
			
			<div id="content" class="main mb-4">
				<!-- BARRA SUPERIOR DE USUARIO -->
				<?php $this->load->view('include/barra_superior', $datos_pagina);  ?>

				<div id="contenido" class="container-fluid">
					<div class="row mt-2">
						<div class="col">
							<h2>Ayuda y documentación</h2>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<!-- SCRIPTS DE JS -->
		<?php $this->load->view('include/scripts');  ?>
	</body>
</html>