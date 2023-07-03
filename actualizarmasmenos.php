<?php

require_once __DIR__.'/includes/config.php';


$puntos = $_GET['puntos'];

$equipo = $_GET['equipo'];

$result = es\ucm\fdi\Equipo::actualizarmasmenos($puntos,$equipo);

?>