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
$htmlfromjugadoresdelequipo = '';
$htmlpartidos = '';

/////////////////////////////////

//1º Equipos a los que pertenece:
$equipos = es\ucm\fdi\Equipo::getEquiposfromUserId($_SESSION['id']);
$htmlEquiposfromUser = es\ucm\fdi\Equipo::mostrarListadoEquipos($equipos);


//2º Estadisticas del Equipo:
foreach($equipos as $equipo){
    $htmlfrommostrarStatsEquipo .= es\ucm\fdi\Equipo::mostrarStatsEquipo($equipo);
    $htmlpartidos .= es\ucm\fdi\Equipo::mostrarUltimosPartidosEquipo($equipo);
}

//3º Partidos del Entrenador:

$contenidoPrincipal .= <<<EOS
    <div class="equipos">
        <div class="misEquipos">
            <h2>Equipos a los que pertenece</h2>
            $htmlEquiposfromUser
        </div>
        <div class="statsEquipos">
            <h2>Estadisticas de los equipos: </h2>
            $htmlfrommostrarStatsEquipo
        </div>
        <!-- <div class="jugadoresEquipo">
            <h2>Jugadores del Equipo: </h2>
            $htmlfromjugadoresdelequipo
        </div> -->
        </div>
            <div class="lastgames">
            <h2>Últimos Partidos</h2>
            $htmlpartidos
        </div>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantilla.php';