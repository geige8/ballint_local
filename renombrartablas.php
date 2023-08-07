<?php

    require_once __DIR__.'/includes/config.php';

    $id = $_GET['id'];

    $result = es\ucm\fdi\Partido::renombrartablas($id);

?>