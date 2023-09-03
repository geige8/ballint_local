<?php

    require_once __DIR__.'/includes/config.php';

    $parcial = es\ucm\fdi\Partido::getParcialCambio();

    header('Content-Type: application/json');
    echo json_encode($parcial);

?>