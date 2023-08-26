<?php

    require_once __DIR__.'/includes/config.php';

    $jugador = $_GET['jugador'];

    $tituloPagina = 'Detalle';
    $rutaApp = RUTA_APP;
    $contenidoPrincipal = '';
    $rutaImgs=RUTA_IMGS;

    $usuario = es\ucm\fdi\Usuario::getDatosPerfilJugador($jugador);

    $player = es\ucm\fdi\Jugador::statsfromJugador($usuario);
    
    $htmlfrommostrarStatsJugador = es\ucm\fdi\Jugador::mostrarStatsJugador($player);
    $htmlfrommostrarStatsAvanzadasJugador = es\ucm\fdi\Jugador::mostrarStatsAvanzadasJugador($player);

    $idUser = es\ucm\fdi\Usuario::getidNombreUser($jugador);
    
    $equipos = es\ucm\fdi\Equipo::getEquiposfromUserId($idUser);
    $htmlEquiposfromUser = es\ucm\fdi\Equipo::mostrarListadoEquipos($equipos);

    $htmlUltimosPartidos =es\ucm\fdi\Jugador::mostrarUltimosPartidosJugador($jugador);

    $contenidoPrincipal .= <<<EOS
        <div class="paginaDetalle">
            <h1>Detalles del Perfil de $jugador</h1>
            <div class="cuadrostats">
                <h2>Estadísticas de $jugador:</h2>
                $htmlfrommostrarStatsJugador
            </div>
            <div class="cuadrostatsAvanzadas">
                <h2>Estadísticas Avanzadas de $jugador:</h2>
                $htmlfrommostrarStatsAvanzadasJugador
            </div>
            <div class="perfilEquipos">
                <h2>Equipos a los que pertenece de $jugador:</h2>
                $htmlEquiposfromUser
            </div>
            <div class="lastgames">
                <h2>Últimos Partidos de de $jugador:</h2>
                $htmlUltimosPartidos
            </div>
        </div>
    EOS;

    require __DIR__.'/includes/vistas/plantilla.php';
?>