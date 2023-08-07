<?php

    require_once __DIR__.'/includes/config.php';

    $equipo = $_GET['equipo'];

    $ganador = $_GET['ganador'];

    $idPartido = $_GET['idPartido'];

    $ptsLocal = $_GET['ptsLocal'];

    $ptsVisitante = $_GET['ptsVisitante'];

    $result = es\ucm\fdi\Partido::saveplayers($equipo,$ganador,$idPartido);

?>