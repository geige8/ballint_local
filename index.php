<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'BallInt';

$rutaApp = RUTA_APP;

$jugadores = es\ucm\fdi\Equipo::getJugadoresEquipo('sub22masc');
print_r($jugadores);
//1º PASO DIFERENCIAR LOGEADO O NO
if (isset($_SESSION["login"])) {

    $contenidoPrincipal = <<<EOS
        
    EOS;

} else {
    header('Location: login.php');
}




require __DIR__.'/includes/vistas/plantilla.php';