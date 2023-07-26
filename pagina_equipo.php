<?php
require_once __DIR__.'/includes/config.php';


$equipo = $_GET['equipo'];


$tituloPagina = 'Perfil';
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';
$rutaImgs=RUTA_IMGS;


$htmlStatsEquipo = es\ucm\fdi\Equipo::mostrarStatsEquipo($equipo);
$htmllistajugadoresEquipo = es\ucm\fdi\Equipo::mostrarlistajugadoresEquipo($equipo);
$htmlpartidos = es\ucm\fdi\Equipo::mostrarUltimosPartidosEquipo($equipo);




    $contenidoPrincipal .= <<<EOS
    <h1>Detalles del Equipo '$equipo'</h1>
    
    <h1>Estadisticas del  '$equipo'</h1>
    $htmlStatsEquipo

    <h1>Jugadores del  '$equipo'</h1>
    $htmllistajugadoresEquipo

    <h1>Ultimos Partidos del  '$equipo'</h1>
    $htmlpartidos
    EOS;



require __DIR__.'/includes/vistas/plantilla.php';