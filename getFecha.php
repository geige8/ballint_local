<?php

    require_once __DIR__.'/includes/config.php';

    $partido_id = $_GET['partido_id'];

    $fecha = es\ucm\fdi\Partido::getFecha($partido_id);

    // Devolver la lista de jugadores en formato JSON
    header('Content-Type: application/json');
    echo json_encode($fecha);

?>