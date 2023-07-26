<?php

require_once __DIR__.'/includes/config.php';

$jugador = $_GET['jugador'];

$accion = $_GET['accion'];

$equipo = $_GET['equipo'];

$result = es\ucm\fdi\Partido::actualizarTablaPartido($equipo,$jugador,$accion);

?>