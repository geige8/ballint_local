<?php
    require_once __DIR__.'/includes/config.php';


    $partido = $_GET['partido'];
    $fecha = $_GET['fecha'];
    $partidoId = $_GET['id'];

    $tituloPagina = 'Perfil';
    $rutaApp = RUTA_APP;
    $contenidoPrincipal = '';
    $rutaImgs=RUTA_IMGS;
    $htmlstatsPartidoEquipo = '';
    $htmlstatsPartidoJugadores = '';

    $statsPartidoEquipos = es\ucm\fdi\Partido::getstatsPartidoEquipos($partidoId);

    $htmlstatsPartidoEquipos = es\ucm\fdi\Equipo:: mostrarStatsPartidoporEquipos($statsPartidoEquipos);
    
    $statsPartidoJugadores = es\ucm\fdi\Partido:: getstatsPartidoJugadores($partidoId);

    $htmlstatsPartidoJugadores .= es\ucm\fdi\Equipo:: mostrarStatsPartidoporJugadores($statsPartidoJugadores);

    $contenidoPrincipal .= <<<EOS
        <div class="paginaDetalle">
            <h1>Detalles del Partido #$partidoId vs '$partido' el '$fecha'</h1>
            <div>
                <h1> Datos sobre los equipos </h1>
                $htmlstatsPartidoEquipos
            </div>
            <div>
                <h1> Datos sobre los jugadores </h1>
                $htmlstatsPartidoJugadores
            </div>
            <div>
                <h1> Datos sobre la estadistica avanzada </h1>
            </div>
        </div>
    EOS;
    
    require __DIR__.'/includes/vistas/plantilla.php';
?>
