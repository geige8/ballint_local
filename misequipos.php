<?php
require_once __DIR__.'/includes/config.php';

//Obtener las estadisticas de dichos partidos:
function mostrarUltimosPartidosEntrenador($equiposdelUsuario){

    $html = "";

    foreach($equiposdelUsuario as $equipo){

        //Para cada equipo al que pertenezca quiero mostrar los partidos.
        //Tengo que obtener el id de cada partido de ese equipo
        
        $partidos = es\ucm\fdi\Partido::getpartidosfromEquipo($equipo);

        //Ahora quiero buscar en la tabla de cada uno de esos partidos las estadisticas para ese jugador

        foreach($partidos as $partido){

            //Necesito que me devuelva las estadisticas de ese jugador para ese partido si es que ha participado
            
            $estadisticas = es\ucm\fdi\Partido::getstatsUsuarioEntrenador($partido['id']);
        
            //Ademas necesito los datos de ese partido, pero ya los he obtenido antes.

            //Ahora llamaría al metodo mostrar para que se muestre la fila entera de dichas estadisticas.

            $html .= mostrarStatsPartidoEntrenador($partido,$estadisticas);
        
        }
    
    }
    return $html;
}

function mostrarStatsPartidoEntrenador($partido,$estadisticas){

    $html = "";
    $html .= "
    <table>
        <tr>
            <th>Rival</th>
            <th>Fecha</th>
            <th>Timeouts</th>
            <th>Faltas Banquillo</th>
            <th>Puntos</th>
            <th>Líder</th>
            <th>Empate</th>
            <th>Alternancias</th>
            <th>Veces Empatados</th>
            <th>Veces Líder</th>
            <th>Q1</th>
            <th>Q2</th>
            <th>Q3</th>
            <th>Q4</th>
            <th>Extra</th>
        </tr>
        <tr>
            <td>{$partido['visitante']}</td>
            <td>{$partido['fecha']}</td>
            <td>{$estadisticas['timeouts']}</td>
            <td>{$estadisticas['faltasbanquillo']}</td>
            <td>{$estadisticas['puntos']}</td>
            <td>{$estadisticas['lider']}</td>
            <td>{$estadisticas['empate']}</td>
            <td>{$estadisticas['alternancias']}</td>
            <td>{$estadisticas['vecesempatados']}</td>
            <td>{$estadisticas['veceslider']}</td>
            <td>{$estadisticas['q1']}</td>
            <td>{$estadisticas['q2']}</td>
            <td>{$estadisticas['q3']}</td>
            <td>{$estadisticas['q4']}</td>
            <td>{$estadisticas['extra']}</td>
        </tr>
    </table>";
    return $html;
}

function mostrarStatsEquipo($statsequipo){

    $html = "";
    $html .= "
    <table>
        <tr>
            <th>PJ</th>
            <th>MT</th>
            <th>MSMS</th>
            <th>T2A</th>
            <th>T2F</th>
            <th>T3A</th>
            <th>T3F</th>
            <th>TLA</th>
            <th>TLF</th>
            <th>FLH</th>
            <th>FLR</th>
            <th>RBO</th>
            <th>RBD</th>
            <th>ROB</th>
            <th>TAP</th>
            <th>PRD</th>
            <th>AST</th>
        </tr>
        <tr>
            <td>{$statsequipo['PJ']}</td>
            <td>{$statsequipo['MT']}</td>
            <td>{$statsequipo['MSMS']}</td>
            <td>{$statsequipo['T2A']}</td>
            <td>{$statsequipo['T2F']}</td>
            <td>{$statsequipo['T3A']}</td>
            <td>{$statsequipo['T3F']}</td>
            <td>{$statsequipo['TLA']}</td>
            <td>{$statsequipo['TLF']}</td>
            <td>{$statsequipo['FLH']}</td>
            <td>{$statsequipo['FLR']}</td>
            <td>{$statsequipo['RBO']}</td>
            <td>{$statsequipo['RBD']}</td>
            <td>{$statsequipo['ROB']}</td>
            <td>{$statsequipo['TAP']}</td>
            <td>{$statsequipo['PRD']}</td>
            <td>{$statsequipo['AST']}</td>
        </tr>
    </table>";
    return $html;
}

function mostrarlistajugadoresEquipo($listaJugadores){

    $html = "";
    $i = 1;
        $html .= "
        <table>
            <tr>
                <th> </th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Apellido 1</th>
                <th>Apellido 2</th>
            </tr>";

    foreach($listaJugadores as $jugador){
    $html .= "
            <tr>
                <td>$i</td>
                <td>{$jugador['user']}</td>
                <td>{$jugador['nombre']}</td>
                <td>{$jugador['apellido1']}</td>
                <td>{$jugador['apellido2']}</td>
            </tr>
        </table>";
        $i++;
    }
    return $html;
}

//Mostrar los Equipos
function mostrarListadoEquipos($arrayEquipos){

    $html = '';
    foreach ($arrayEquipos as $equipo) {
        $html .= mostrarCajaEquipo($equipo);
    }

    return $html;
}

function mostrarCajaEquipo($equipo){

    $datosEquipo = es\ucm\fdi\Equipo::getDatosEquipo($equipo);
    $html = '';

    $html .= <<<EOS
        <div class="equipo">
            <p>{$datosEquipo['nombre_equipo']}</p>
        </div>
    EOS;

    return $html;
}


$tituloPagina = 'Mis Equipos';
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';
$htmlfrommostrarStatsJugador = '';
$htmlfromjugadoresdelequipo = '';
$rutaImgs=RUTA_IMGS;

//1º Equipos a los que pertenece:
$equipos = es\ucm\fdi\Equipo::getEquiposfromUserId($_SESSION['id']);
$htmlEquiposfromUser = mostrarListadoEquipos($equipos);

//2º Estadisticas del Equipo:
foreach($equipos as $equipo){
    $listaJugadores = es\ucm\fdi\Equipo::getJugadoresEquipo($equipo);
    $htmlfromjugadoresdelequipo .= mostrarlistajugadoresEquipo($listaJugadores);
    $statsequipo = es\ucm\fdi\Equipo::statsfromEquipo($equipo);
    $htmlfrommostrarStatsJugador .= mostrarStatsEquipo($statsequipo);
}

//3º Partidos del Entrenador:
$htmlpartidos = mostrarUltimosPartidosEntrenador($equipos);


$contenidoPrincipal .= <<<EOS
<div class="equipos">
    <div class="misEquipos">
        <h2>Equipos a los que pertenece</h2>
        $htmlEquiposfromUser
    </div>
    <div class="statsEquipos">
        <h2>Estadisticas de los equipos: </h2>
        $htmlfrommostrarStatsJugador
    </div>
    <div class="jugadoresEquipo">
    <h2>Jugadores del Equipo: </h2>
        $htmlfromjugadoresdelequipo
    </div>
    </div>
        <div class="lastgames">
        <h2>Últimos Partidos</h2>
        $htmlpartidos
    </div>

</div>
EOS;

require __DIR__.'/includes/vistas/plantilla.php';