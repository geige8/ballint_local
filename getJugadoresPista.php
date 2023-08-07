<?php

    require_once __DIR__.'/includes/config.php';

    $jugadores = es\ucm\fdi\Partido::getJugadoresPista();

    // Devolver la lista de jugadores en formato JSON
    header('Content-Type: application/json');
    echo json_encode($jugadores);

?>