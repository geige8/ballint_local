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
                <h1>Detalles del $equipo</h1>
                <div class="cuadrostats">
                    <h2>Estadísticas del LF {$datosEquipo['categoria']} {$datosEquipo['seccion']} {$datosEquipo['letra']}: </h2>
                    $htmlfrommostrarStatsEquipo
                </div>
                <div class="cuadrostatsAvanzadas">
                    <h2>Stats Avanzadas de LF {$datosEquipo['categoria']} {$datosEquipo['seccion']} {$datosEquipo['letra']}:</h2>
                    $htmlfrommostrarStatsAvanzadasJugadorEquipo
                </div>
                <div class="cuadroEntrenadores">
                    <h2>Entrenadores del  '$equipo'</h2>
                    $htmllistaentrenadoresEquipo
                </div>
                <div class="cuadroJugadores">
                    <h2>Jugadores del  '$equipo'</h2>
                    $htmllistajugadoresEquipo
                </div>
                <div class="lastgames">
                <h2>Ultimos Partidos de LF {$datosEquipo['categoria']} {$datosEquipo['seccion']} {$datosEquipo['letra']}: </h2>
                    $htmlUltimosPartidosEquipo
                </div>
            </div>
        EOS;

    require __DIR__.'/includes/vistas/plantilla.php';
?>