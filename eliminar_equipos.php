<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Eliminar Equipos';
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';

$formulario = new es\ucm\fdi\FormularioEliminarEquipos();
$contenidoPrincipal .= $formulario->gestiona();

require __DIR__.'/includes/vistas/plantilla.php';
?>