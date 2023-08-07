<?php

    require_once __DIR__.'/includes/config.php';

    $equipos = es\ucm\fdi\Partido::getEquipos();

    foreach($equipos as $equipo){

        $equiposEstadisticas[] = es\ucm\fdi\Equipo::statsfromEquipoEnPartido($equipo);

    }

    // Devolver la lista de jugadores en formato JSON
    header('Content-Type: application/json');
    echo json_encode($equiposEstadisticas);

?>