<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = '';

$rutaApp = RUTA_APP;

$jugador =$_GET['jugador'];

print_r($jugador);

$evaluacion = es\ucm\fdi\Partido::getEvaluacionJugador($jugador);

// Devolver la lista de jugadores en formato JSON
header('Content-Type: application/json');
echo json_encode($evaluacion);
?>