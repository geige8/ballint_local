<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Usuario a Equipo';
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';

$formulario = new es\ucm\fdi\FormularioEliminarUsuarioaEquipo();
$contenidoPrincipal .= $formulario->gestiona();

require __DIR__.'/includes/vistas/plantilla.php';
?>