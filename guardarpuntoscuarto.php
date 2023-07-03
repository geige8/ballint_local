<?php

require_once __DIR__.'/includes/config.php';

$local = $_GET['equipolocal'];
$visitante = $_GET['equipovisitante'];
$puntoslocal = $_GET['puntoslocal'];
$puntosvisitante = $_GET['puntosvisitante'];
$cuarto = $_GET['cuarto'];

$result = es\ucm\fdi\Partido::guardarpuntoscuarto($local,$visitante,$puntoslocal,$puntosvisitante,$cuarto);

?>