<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Eliminar Usuarios';
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';

$formulario = new es\ucm\fdi\FormularioEliminarUsuarios();
$contenidoPrincipal .= $formulario->gestiona();

require __DIR__.'/includes/vistas/plantilla.php';
?>