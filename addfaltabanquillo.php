<?php

require_once __DIR__.'/includes/config.php';

$equipo = $_GET['equipo'];

$result = es\ucm\fdi\Partido::addfaltabanquillo($equipo);

?>