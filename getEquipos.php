<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = '';

$rutaApp = RUTA_APP;

$equipos = es\ucm\fdi\Partido::getEquipos();

// Devolver la lista de jugadores en formato JSON
header('Content-Type: application/json');
echo json_encode($equipos);
?>