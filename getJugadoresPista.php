<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = '';

$rutaApp = RUTA_APP;

$jugadores = es\ucm\fdi\Equipo::getJugadoresPista();

// Devolver la lista de jugadores en formato JSON
header('Content-Type: application/json');
echo json_encode($jugadores);
?>