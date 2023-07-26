<header>
	<div class="cabeza">
			<div class="imagenCabecera">
				<a href="index.php"><img src="<?= RUTA_IMGS . '/icono_club.png' ?>" alt="imagen"></a>
			</div>
			<div class="tituloCabecera">
				<h1>LICEO FRANCÉS</h1>
			</div>
		<?php if (isset($_SESSION['login']) && ($_SESSION['login']===true))  { ?>

			<div class="infoCabecera">
				<?= mostrarSaludo(); ?>
			</div>
	</div>
			<nav class="nav">
					<a href="perfil.php">MI PERFIL</a>
					<a href="misequipos.php">MIS EQUIPOS</a>
					<a href="seleccion_equipo.php">MY LICEO</a>
					<a href="pagina_glosario.php">GLOSARIO</a>
				</nav>
		<?php } ?>
	
</header>

<?php
function mostrarSaludo() {

	$saludoCabecera = '';

	if (isset($_SESSION['login']) && ($_SESSION['login']===true)) {
		$saludoCabecera .= <<<EOS
			<div class="elementoInformacionUsuario">
				<div class="apartadoCabecera">
					<h1> Usuario: {$_SESSION['nombre']} </h1>
				</div>
				<div class="apartadoCabecera">
					<h1> Rol: {$_SESSION['roles']} </h1>
				</div>
			</div>
			<div class="logoutCabecera">
				<a href='logout.php'>
					<i class='fa fa-sign-out-alt'></i>
				</a>
			</div>
		EOS;
	} else {
		$saludoCabecera .= "Usuario desconocido. <a href='login.php'>Login</a> <a href='registro.php'>Registro</a>";
	}

	return $saludoCabecera;
}
?>
