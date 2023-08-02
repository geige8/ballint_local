<?php
    require_once __DIR__.'/includes/config.php';


    $jugador = $_GET['jugador'];


    $tituloPagina = 'Perfil';
    $rutaApp = RUTA_APP;
    $contenidoPrincipal = '';
    $rutaImgs=RUTA_IMGS;


    $usuario = es\ucm\fdi\Usuario::getDatosPerfilJugador($jugador);

    $player = es\ucm\fdi\Jugador::statsfromJugador($usuario);
    
    $htmlfrommostrarStatsJugador = es\ucm\fdi\Jugador::mostrarStatsJugador($player);
    $htmlfrommostrarAreasdeMejora = es\ucm\fdi\Jugador::mostrarStatsAreasdeMejora($player);
    $htmlfrommostrarStatsAvanzadasJugador = es\ucm\fdi\Jugador::mostrarStatsAvanzadasJugador($player);

    $idUser = es\ucm\fdi\Usuario::getidNombreUser($jugador);
    
    $equipos = es\ucm\fdi\Equipo::getEquiposfromUserId($idUser);
    $htmlEquiposfromUser = es\ucm\fdi\Equipo::mostrarListadoEquipos($equipos);

    $htmlUltimosPartidos =es\ucm\fdi\Jugador::mostrarUltimosPartidosJugador($jugador);

    $contenidoPrincipal .= <<<EOS
        <div class="paginaDetalle">
            <h1>Detalles del Perfil de '$jugador'</h1>
            <div>
                <h1>Stats de '$jugador'</h1>
                $htmlfrommostrarStatsJugador
            </div>
            <div>
                <h1>Areas de Mejora de '$jugador'</h1>
                    $htmlfrommostrarAreasdeMejora
            </div>
            <div>
                <h1>Stats Avanzadas de '$jugador'</h1>
                $htmlfrommostrarStatsAvanzadasJugador
            </div>
            <div>
                <h1>Equipos de '$jugador'</h1>
                $htmlEquiposfromUser
            </div>
            <div>
                <h1>Ultimos partidos de '$jugador'</h1>
                $htmlUltimosPartidos
            </div>
        </div>
    EOS;

    require __DIR__.'/includes/vistas/plantilla.php';
?>