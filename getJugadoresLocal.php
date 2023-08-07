<?php

    require_once __DIR__.'/includes/config.php';

    $tituloPagina = '';

    $rutaApp = RUTA_APP;

    $equipo = $_GET['equipo'];

    $jugadores = es\ucm\fdi\Partido::getJugadoresLocal($equipo);

    // Devolver la lista de jugadores en formato JSON
    header('Content-Type: application/json');
    echo json_encode($jugadores);
    
?>