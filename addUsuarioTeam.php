<?php
    require_once __DIR__.'/includes/config.php';

    $tituloPagina = 'Añadir Usuario-Equipo';
    $rutaApp = RUTA_APP;
    $contenidoPrincipal = '';

    $formulario = new es\ucm\fdi\FormularioRegistroUsuarioaEquipo();
    $contenidoPrincipal .= $formulario->gestiona();

    require __DIR__.'/includes/vistas/plantilla.php';
?>