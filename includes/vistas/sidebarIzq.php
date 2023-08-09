<aside id="sidebarIzq">
    <?php if (isset($_SESSION['login']) && ($_SESSION['login']===true)) { 
        $roles = es\ucm\fdi\Usuario::getRoles($_SESSION['nombre']);
    ?>
    
    <div class="infoCabecera">
        <?= mostrarSaludo(); ?>
    </div>
	<ul class="menu_box">
        <!-- Si es de Tipo Admin -->
        <?php if (in_array('A', $roles)) { ?>
            <li><a href="index.php">INICIO</a></li>
            <li><a href="pagina_admin.php">PANEL DE CONTROL</a></li>
            <li><a href="seleccion_equipo.php">MY LICEO</a></li>
            <li><a href="pagina_glosario.php">GLOSARIO</a></li>
        <?php } ?>

        <!-- Si es de Tipo DT -->
        <?php if (in_array('DT', $roles)) { ?>
            <li><a href="index.php">INICIO</a></li>
            <li><a href="pagina_misequipos.php">MIS EQUIPOS</a></li>
            <li><a href="seleccion_equipo.php">MY LICEO</a></li>
            <li><a href="pagina_glosario.php">GLOSARIO</a></li>
        <?php } ?>

        <!-- Si es de Tipo E -->
        <?php if (in_array('E', $roles)) { ?>
            <li><a href="index.php">INICIO</a></li>
            <li><a href="pagina_perfil.php">MI PERFIL</a></li>
            <li><a href="pagina_misequipos.php">MIS EQUIPOS</a></li>
            <li><a href="seleccion_equipo.php">MY LICEO</a></li>
            <li><a href="pagina_glosario.php">GLOSARIO</a></li>
        <?php } ?>
        
        <!-- Si es de Tipo J -->
        <?php if (in_array('J', $roles)) { ?>
            <li><a href="index.php">INICIO</a></li>
            <li><a href="pagina_perfil.php">MI PERFIL</a></li>
            <li><a href="pagina_misequipos.php">MIS EQUIPOS</a></li>
            <li><a href="pagina_glosario.php">GLOSARIO</a></li>
        <?php } ?>

        <li><a href='logout.php'><i class='fa fa-sign-out-alt'></i> LOGOUT</a></li>
	</ul>
    <?php } ?>

	
</aside>

<?php
    function mostrarSaludo() {

        $saludoCabecera = '';

        if (isset($_SESSION['login']) && ($_SESSION['login']===true)) {
            $saludoCabecera .= <<<EOS
            <h1>Usuario: {$_SESSION['nombre']} - Rol: {$_SESSION['roles']}</h1>
        EOS;
        } else {
            $saludoCabecera .= "Usuario desconocido. <a href='login.php'>Login</a> <a href='registro.php'>Registro</a>";
        }

        return $saludoCabecera;
    }
?>