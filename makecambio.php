<?php

    require_once __DIR__.'/includes/config.php';

    $listaJugadores = json_decode(file_get_contents("php://input"), true);

    $result = es\ucm\fdi\Partido::cambiojugador($listaJugadores);


?>