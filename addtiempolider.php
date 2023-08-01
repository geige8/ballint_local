<?php

require_once __DIR__.'/includes/config.php';

$ganador = $_GET['ganador'];

$result = es\ucm\fdi\Partido::addtiempolider($ganador);

?>