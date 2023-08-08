<header>
	<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === true)) { ?>
		<div id="sidebarButtonContainer">
			<button id="toggleSidebar">MENU</button>
		</div>
	<?php } ?>

	<div class="cabeza">
		<div class="tituloCabecera">
			<h1>LICEO </h1><a href="index.php"><img src="<?= RUTA_IMGS . '/icono_club.png' ?>" alt="imagen"></a><h1>FRANCÉS</h1>
		</div>
	</div>
</header>


