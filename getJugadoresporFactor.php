<?php

    require_once __DIR__.'/includes/config.php';

    $factor = $_GET['factor'];
    $equipo = $_GET['equipo'];

    // Condición para verificar si $factor es igual a cualquiera de las opciones mencionadas
        if ($factor == "T2P" || $factor == "T3P" || $factor == "TLP" || $factor == "PTSP" || $factor == "MSMSP"|| $factor == "REB" || $factor == "VAL") {

            $jugadores = es\ucm\fdi\Partido::getJugadoresporFactorAvanzado($factor,$equipo);
        } else {
            $jugadores = es\ucm\fdi\Partido::getJugadoresporFactor($factor,$equipo);
        }

    // Devolver la lista de jugadores en formato JSON
    header('Content-Type: application/json');
    echo json_encode($jugadores);

?>