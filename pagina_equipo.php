<?php
require_once __DIR__.'/includes/config.php';


$equipo = $_GET['equipo'];


$tituloPagina = $equipo;
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';
$rutaImgs=RUTA_IMGS;

$datosEquipo = es\ucm\fdi\Equipo::datosfromEquipo($equipo);

$statsEquipo = es\ucm\fdi\Equipo::statsfromEquipo($datosEquipo);

$htmlfrommostrarStatsEquipo = es\ucm\fdi\Equipo::mostrarStatsEquipo($statsEquipo);
$htmlfrommostrarStatsAvanzadasJugadorEquipo = es\ucm\fdi\Equipo::mostrarStatsAvanzadasEquipo($statsEquipo);
$htmllistajugadoresEquipo = es\ucm\fdi\Equipo::mostrarlistajugadoresEquipo($equipo);
$htmllistaentrenadoresEquipo = es\ucm\fdi\Equipo::mostrarlistaEntrenadoresEquipo($equipo);
$htmlUltimosPartidosEquipo = es\ucm\fdi\Equipo::mostrarUltimosPartidosEquipo($equipo);


    $contenidoPrincipal .= <<<EOS
        <div class="paginaDetalle">
            <h1>Detalles del Equipo '$equipo'</h1>
            <div class="statsEquipos">
                <h2>Estadisticas de {$datosEquipo['nombre_equipo']}: </h2>
                $htmlfrommostrarStatsEquipo
            </div>
            <div>
                <h1>Stats Avanzadas de {$datosEquipo['nombre_equipo']}:</h1>
                $htmlfrommostrarStatsAvanzadasJugadorEquipo
            </div>
            <div>
                <h1>Entrenadores del  '$equipo'</h1>
                $htmllistaentrenadoresEquipo
            </div>
            <div>
                <h1>Jugadores del  '$equipo'</h1>
                $htmllistajugadoresEquipo
            </div>
            <div class="lastgames">
            <h2>Ultimos Partidos de {$datosEquipo['nombre_equipo']}: </h2>
                $htmlUltimosPartidosEquipo
            </div>
        </div>
    EOS;



require __DIR__.'/includes/vistas/plantilla.php';