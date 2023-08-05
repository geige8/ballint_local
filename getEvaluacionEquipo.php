<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = '';

$rutaApp = RUTA_APP;

$equipo = $_GET['equipo'];

$evaluacion = es\ucm\fdi\Partido::getEvaluacionEquipo($equipo);

// Devolver la lista de jugadores en formato JSON
header('Content-Type: application/json');
echo json_encode($evaluacion);
?>