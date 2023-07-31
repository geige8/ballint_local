<?php

require_once __DIR__.'/includes/config.php';

$jugador = $_GET['jugador'];
$cuarto = $_GET['cuarto'];
$puntos = $_GET['puntos'];


$result = es\ucm\fdi\Partido::guardarpuntoscuartoJugador($cuarto,$jugador,$puntos);

?>