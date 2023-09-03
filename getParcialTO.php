<?php

    require_once __DIR__.'/includes/config.php';

    $parcial = es\ucm\fdi\Partido::getParcialTO();

    header('Content-Type: application/json');
    echo json_encode($parcial);

?>

