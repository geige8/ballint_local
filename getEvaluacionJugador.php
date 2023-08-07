<?php

    require_once __DIR__.'/includes/config.php';

    $jugador = $_GET['jugador'];

    $evaluacion = es\ucm\fdi\Partido::getEvaluacionJugador($jugador);

    // Devolver la lista de jugadores en formato JSON
    header('Content-Type: application/json');
    echo json_encode($evaluacion);

?>