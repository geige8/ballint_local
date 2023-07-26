<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Glosario';
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';
$rutaImgs=RUTA_IMGS;

    $contenidoPrincipal .= <<<EOS
    <h1>GLOSARIO DE TERMINOS SOBRE LA PÁGINA:</h1>
    EOS;



require __DIR__.'/includes/vistas/plantilla.php';