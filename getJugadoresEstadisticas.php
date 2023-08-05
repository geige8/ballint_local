<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = '';

$rutaApp = RUTA_APP;

$jugadores = es\ucm\fdi\Partido::getJugadores();

foreach($jugadores as $jugador){

    $jugadoresEstadisticas[] = es\ucm\fdi\Jugador::statsfromJugadorEnPartido($jugador);

}

// Devolver la lista de jugadores en formato JSON
header('Content-Type: application/json');
echo json_encode($jugadoresEstadisticas);
?>