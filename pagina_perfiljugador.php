<?php
require_once __DIR__.'/includes/config.php';


$jugador = $_GET['jugador'];


$tituloPagina = 'Perfil';
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';
$rutaImgs=RUTA_IMGS;


    $usuario = es\ucm\fdi\Usuario::getDatosPerfilJugador($jugador);

    $player = es\ucm\fdi\Jugador::statsfromJugador($usuario);
    $statsAvanzadas = es\ucm\fdi\Jugador::statsAvanzadasfromJugador($player);
    
    $htmlfrommostrarStatsJugador = es\ucm\fdi\Jugador::mostrarStatsJugador($player);
    $htmlfrommostrarStatsAvanzadasJugador = es\ucm\fdi\Jugador::mostrarStatsAvanzadasJugador($statsAvanzadas);

    $idUser = es\ucm\fdi\Usuario::getidNombreUser($jugador);
    
    $equipos = es\ucm\fdi\Equipo::getEquiposfromUserId($idUser);
    $htmlEquiposfromUser = es\ucm\fdi\Equipo::mostrarListadoEquipos($equipos);

    $htmlUltimosPartidos =es\ucm\fdi\Jugador::mostrarUltimosPartidosJugador($jugador);


    $contenidoPrincipal .= <<<EOS
    <h1>Detalles del Perfil de '$jugador'</h1>
    <h1>Stats de '$jugador'</h1>
    $htmlfrommostrarStatsJugador
    <h1>Stats Avanzadas de '$jugador'</h1>
    $htmlfrommostrarStatsAvanzadasJugador
    <h1>Equipos de '$jugador'</h1>
    $htmlEquiposfromUser
    <h1>Ultimos partidos de '$jugador'</h1>
    $htmlUltimosPartidos
    EOS;



require __DIR__.'/includes/vistas/plantilla.php';