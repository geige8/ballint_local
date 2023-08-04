<?php
    require_once __DIR__.'/includes/config.php';


    $partido = $_GET['partido'];
    $fecha = $_GET['fecha'];
    $partidoId = $_GET['id'];

    $tituloPagina = 'Partido' . $partidoId;
    $rutaApp = RUTA_APP;
    $contenidoPrincipal = '';
    $rutaImgs=RUTA_IMGS;
    $htmlstatsPartidoEquipos = '';
    $htmlstatsPartidoJugadores = '';

    $statsPartidoEquipos = es\ucm\fdi\Partido::getstatsPartidoEquipos($partidoId);

    $htmldetallesPartidoEquipos = es\ucm\fdi\Equipo:: mostrarDetallesPartidoporEquipos($statsPartidoEquipos);

    //    
    
    $statsPartidoJugadores = es\ucm\fdi\Partido::getstatsPartidoJugadores($partidoId);

    foreach ($statsPartidoJugadores as $statsPartidoJugador){
        $statsJugadores[] = es\ucm\fdi\Jugador::statsfromJugadorEnPartido($statsPartidoJugador);
    }
    

    $htmlstatsPartidoJugadores .= es\ucm\fdi\Equipo:: mostrarStatsPartidoporJugadores($statsJugadores);

    //

    $statsPartidoEquipos = es\ucm\fdi\Partido:: getstatsPartidoEquipos($partidoId);

    $htmlstatsPartidoEquipos .= es\ucm\fdi\Equipo:: mostrarStatsPartidoporEquipos($statsPartidoEquipos);


    $contenidoPrincipal .= <<<EOS
        <div class="paginaDetalle">
            <div>
            <h1>Detalles del Partido #$partidoId vs '$partido' el '$fecha'</h1>
                $htmldetallesPartidoEquipos
            </div>
            <div>
                <h1> Datos sobre los Jugadores </h1>
                $htmlstatsPartidoJugadores
            </div>
            <div>
                <h1> Datos sobre los Equipos </h1>
                $htmlstatsPartidoEquipos
            </div>
        </div>
    EOS;
    
    require __DIR__.'/includes/vistas/plantilla.php';
?>
