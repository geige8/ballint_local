<?php
require_once __DIR__.'/includes/config.php';


$partido = $_GET['partido'];
$fecha = $_GET['fecha'];

$tituloPagina = 'Perfil';
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';
$rutaImgs=RUTA_IMGS;




    $contenidoPrincipal .= <<<EOS
    <h1>Detalles del Partido vs '$partido' el '$fecha'</h1>
    EOS;



require __DIR__.'/includes/vistas/plantilla.php';