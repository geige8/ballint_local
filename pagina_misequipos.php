<?php
    require_once __DIR__.'/includes/config.php';

    /////////////////////////////////
    //Pagina Mis Equipos
    $tituloPagina = 'Mis Equipos';
    $rutaApp = RUTA_APP;
    $rutaImgs=RUTA_IMGS;

    /////////////////////////////////
    //Variables
    $contenidoPrincipal = '';
    $htmlfrommostrarStatsEquipo = '';
    $htmlpartidos = '';
    /////////////////////////////////

    //1º Equipos a los que pertenece:
    $equipos = es\ucm\fdi\Equipo::getEquiposfromUserId($_SESSION['id']);
    $htmlEquiposfromUser = es\ucm\fdi\Equipo::mostrarListadoEquipos($equipos);

    $contenidoPrincipal .= <<<EOS
        <div class="equipos">
            <div class="misequipos">
                <h2>Mis Equipos:</h2>
                $htmlEquiposfromUser
            </div>
    EOS;

    foreach($equipos as $equipo){
        
        $datosEquipo = es\ucm\fdi\Equipo::datosfromEquipo($equipo);

        $statsEquipo = es\ucm\fdi\Equipo::statsfromEquipo($datosEquipo);
        
        $htmlfrommostrarStatsEquipo = es\ucm\fdi\Equipo::mostrarStatsEquipo($statsEquipo);
        $htmlfrommostrarAreasdeMejoraEquipo = es\ucm\fdi\Equipo::mostrarStatsAreasdeMejoraEquipo($statsEquipo);
        $htmlfrommostrarStatsAvanzadasJugadorEquipo = es\ucm\fdi\Equipo::mostrarStatsAvanzadasEquipo($statsEquipo);
        $htmlUltimosPartidosEquipo =es\ucm\fdi\Equipo::mostrarUltimosPartidosEquipo($equipo);


        $contenidoPrincipal .= <<<EOS
            <div class="statsEquipos">
            <h2>Estadísticas del LF {$datosEquipo['categoria']} {$datosEquipo['seccion']} {$datosEquipo['letra']}: </h2>
                $htmlfrommostrarStatsEquipo
            </div>
            <div class="cuadrostatsMejora">
            <h2>Áreas de Mejora del LF {$datosEquipo['categoria']} {$datosEquipo['seccion']} {$datosEquipo['letra']}:</h2>
                $htmlfrommostrarAreasdeMejoraEquipo
            </div>
            <div class="cuadrostatsAvanzadas">
                <h2>Estadísticas Avanzadas del LF {$datosEquipo['categoria']} {$datosEquipo['seccion']} {$datosEquipo['letra']}:</h2>
                $htmlfrommostrarStatsAvanzadasJugadorEquipo
            </div>
            <div class="lastgames">
                <h2>Ultimos Partidos del LF {$datosEquipo['categoria']} {$datosEquipo['seccion']} {$datosEquipo['letra']}: </h2>
                $htmlUltimosPartidosEquipo
            </div>
        EOS;
    }

    $contenidoPrincipal .= <<<EOS
        </div>
    EOS;


    require __DIR__.'/includes/vistas/plantilla.php';

?>