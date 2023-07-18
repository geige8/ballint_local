<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'BallInt';

$rutaApp = RUTA_APP;

//1º PASO DIFERENCIAR LOGEADO O NO
if (isset($_SESSION["login"])) {

    header('Location: perfil.php');

} else {
    header('Location: login.php');
}




require __DIR__.'/includes/vistas/plantilla.php';