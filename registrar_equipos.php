<?php

    require_once __DIR__.'/includes/config.php';

    $tituloPagina = 'Registrar Equipos';
    $rutaApp = RUTA_APP;
    $contenidoPrincipal = '';

    $formulario = new es\ucm\fdi\FormularioRegistroEquipos();
    $contenidoPrincipal .= $formulario->gestiona();

    require __DIR__.'/includes/vistas/plantilla.php';

?>