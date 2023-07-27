<header>
	<?php if (isset($_SESSION['login']) && ($_SESSION['login']===true)) { ?>
		<button id="toggleSidebar"> HOME
			<i class="fas fa-bars"></i> <!-- Utiliza la clase "fa-bars" para el icono de hamburguesa -->
		</button>
	<?php } ?>
	<div class="cabeza">
		<div class="tituloCabecera">
			<h1>LICEO </h1><a href="index.php"><img src="<?= RUTA_IMGS . '/icono_club.png' ?>" alt="imagen"></a><h1>FRANCÉS</h1>
		</div>
	</div>
</header>


