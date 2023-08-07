<?php

    require_once __DIR__.'/includes/config.php';

    $tituloPagina = 'Registrar Usuarios';
    $rutaApp = RUTA_APP;
    $contenidoPrincipal = '';

    $formulario = new es\ucm\fdi\FormularioRegistroUsuarios();
    $contenidoPrincipal .= $formulario->gestiona();

    require __DIR__.'/includes/vistas/plantilla.php';
    
?>