<?php

    require_once __DIR__.'/includes/config.php';

    $parcial = es\ucm\fdi\Partido::getParcialCambio();

    // Devolver la lista de jugadores en formato JSON
    header('Content-Type: application/json');
    echo json_encode($parcial);

?>