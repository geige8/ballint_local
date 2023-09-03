<?php

    require_once __DIR__.'/includes/config.php';

    $tituloPagina = 'BALLINT';

    $rutaApp = RUTA_APP;
    $contenidoPrincipal = '';
    $rutaImgs=RUTA_IMGS;

    $htmlEquiposClub = es\ucm\fdi\Equipo::mostrarEquipos();  

    //1º PASO DIFERENCIAR LOGEADO O NO
    if (isset($_SESSION["login"])) {

        $roles = es\ucm\fdi\Usuario::getRoles($_SESSION['nombre']);

        $contenidoPrincipal .= <<<EOS
        <h1>Bienvenido {$_SESSION['nombre']}, estos son todos los equipos del club:</h1>
        $htmlEquiposClub        
        EOS;  

    } else {
        header('Location: login.php');
    }

    require __DIR__.'/includes/vistas/plantilla.php';

?>