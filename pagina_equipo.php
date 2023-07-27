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
        <div class="paginaDetalle">
            <h1>Detalles del Equipo '$equipo'</h1>
            <div>
                <h1>Estadisticas del  '$equipo'</h1>
                $htmlStatsEquipo
            </div>
            <div>
                <h1>Jugadores del  '$equipo'</h1>
                $htmllistajugadoresEquipo
            </div>
            <div>
                <h1>Ultimos Partidos del  '$equipo'</h1>
                $htmlpartidos
            </div>
        </div>
    EOS;



require __DIR__.'/includes/vistas/plantilla.php';