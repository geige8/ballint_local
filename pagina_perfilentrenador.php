<?php
    require_once __DIR__.'/includes/config.php';

    $entrenador = $_GET['entrenador'];

    $tituloPagina = 'Perfil';
    $rutaApp = RUTA_APP;
    $contenidoPrincipal = '';
    $rutaImgs=RUTA_IMGS;

    $usuario = es\ucm\fdi\Usuario::getDatosPerfilEntrenador($entrenador);

    $idUser = es\ucm\fdi\Usuario::getidNombreUser($entrenador);
    
    $equipos = es\ucm\fdi\Equipo::getEquiposfromUserId($idUser);
    $htmlEquiposfromUser = es\ucm\fdi\Equipo::mostrarListadoEquipos($equipos);

    $contenidoPrincipal .= <<<EOS
        <div class="paginaDetalle">
            <h1>Detalles del Perfil de $entrenador</h1>
            <div>
                <h1>Equipos de $entrenador</h1>
                $htmlEquiposfromUser
            </div>
    EOS;

    //2º Estadisticas del Equipo:
    foreach($equipos as $equipo){

        $htmlUltimosPartidos = es\ucm\fdi\Equipo::mostrarUltimosPartidosEquipo($equipo);
        $contenidoPrincipal .= <<<EOS
        <div class="lastgames">
            <h2>Ultimos Partidos de {$equipo}: </h2>
            $htmlUltimosPartidos
        </div>
        EOS;
    }

    $contenidoPrincipal .= <<<EOS
        </div>
    EOS;

    require __DIR__.'/includes/vistas/plantilla.php';
?>