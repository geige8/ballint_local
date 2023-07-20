<?php
require_once __DIR__.'/includes/config.php';

function mostrarStatsJugador($jugador){

    $html = "";

    $html .= "
        </div>
            <p>Partidos Jugados: {$jugador['PJ']}</p>
            <p>Minutos Totales: {$jugador['MT']}</p>
            <p>Minutos Promedio: {$jugador['MTP']}</p>

            <p>Partidos Titular: {$jugador['TIT']}</p>
            <p>Partidos Suplente: {$jugador['SUP']}</p>
            <p>Promedio: {$jugador['TITP']}</p>

            <p>+/-: {$jugador['MSMS']}</p>

            <p>Puntos: {$jugador['PTS']}</p>
            <p>Puntos Promedio: {$jugador['PTSP']}</p>

            <p>T2A: {$jugador['T2A']}</p>
            <p>%T2A: {$jugador['T2P']}%</p>
            <p>%T2APP: {$jugador['T2PP']}</p>

            <p>T3A: {$jugador['T3A']}</p>
            <p>%T3A: {$jugador['T3P']}%</p>
            <p>%T3APP: {$jugador['T3PP']}</p>

            <p>TLA: {$jugador['TLA']}</p>
            <p>%TLA: {$jugador['TLP']}%</p>
            <p>%TLAPP: {$jugador['TLPP']}</p>

            <p>TCA: {$jugador['TCA']}</p>
            <p>%TCA: {$jugador['TCP']}%</p>
            <p>%TCAPP: {$jugador['TCPP']}</p>

            <p>Faltas: {$jugador['FLH']}</p>
            <p>Faltas PP: {$jugador['FLHP']}</p>

            <p>Faltas R: {$jugador['FLR']}</p>
            <p>Faltas R PP: {$jugador['FLRP']}</p>

            <p>Rebotes Ofensivos: {$jugador['RBO']}</p>
            <p>Rebotes Ofensivos PP: {$jugador['RBOP']}</p>
            
            <p>Rebotes Defensivos: {$jugador['RBD']}</p>
            <p>Rebotes Defensivos PP: {$jugador['RBDP']}</p>

            <p>Rebotes: {$jugador['REB']}</p>
            <p>Rebotes PP: {$jugador['REBP']}</p>

            <p>Robos: {$jugador['ROB']}</p>
            <p>Robos PP: {$jugador['ROBP']}</p>

            <p>Tapones: {$jugador['TAP']}</p>
            <p>Tapones PP: {$jugador['TAPP']}</p>

            <p>Pérdidas: {$jugador['PRD']}</p>
            <p>Pérdidas PP: {$jugador['PRDP']}</p>

            <p>Asistencias: {$jugador['AST']}</p>
            <p>Asistencias PP: {$jugador['ASTP']}</p>
        </div>
    ";
    return $html;
}

//Función para mostrar los datos de los últimos partidos.

function mostrarUltimosPartidosJugador(){

    $html = "";


    //Obtener el usuario en cuestión
    $usuario = $_SESSION['nombre'];

    //1ºEncontrar el equipo/equipos a los que pertenece, para cada uno mostrar los equipos.
    $idUsuario = $_SESSION['id'];

    $equiposdelUsuario = es\ucm\fdi\Equipo::getEquiposfromUserId($idUsuario);

    foreach($equiposdelUsuario as $equipo){

    //Para cada equipo al que pertenezca quiero mostrar los partidos.
    //Tengo que obtener el id de cada partido de ese equipo
    
    $partidos = es\ucm\fdi\Partido::getpartidosfromEquipo($equipo);

    //Ahora quiero buscar en la tabla de cada uno de esos partidos las estadisticas para ese jugador

    foreach($partidos as $partido){

    //Necesito que me devuelva las estadisticas de ese jugador para ese partido si es que ha participado
    
    $estadisticas = es\ucm\fdi\Partido::getstatsUsuario($partido['id'],$usuario);
 
    //Ademas necesito los datos de ese partido, pero ya los he obtenido antes.

    //Ahora llamaría al metodo mostrar para que se muestre la fila entera de dichas estadisticas.

    $html .= mostrarStatsPartidoJugador($partido,$estadisticas);
    
    }
    

    }


    return $html;
}

function mostrarStatsPartidoJugador($partido,$estadisticas){

    $html = "";

    $html .= "
<table>
    <tr>
        <th>Rival</th>
        <th>Fecha</th>
        <th>Titular</th>
        <th>Minutos</th>
        <th>+/-</th>
        <th>T2A</th>
        <th>T2F</th>
        <th>T3A</th>
        <th>T3F</th>
        <th>TLA</th>
        <th>TLF</th>
        <th>FLH</th>
        <th>FLR</th>
        <th>TEC</th>
        <th>RBO</th>
        <th>RBD</th>
        <th>ROB</th>
        <th>TAP</th>
        <th>PRD</th>
        <th>AST</th>
    </tr>
    <tr>
        <td>{$partido['visitante']}</td>
        <td>{$partido['fecha']}</td>
        <td>{$estadisticas['titular']}</td>
        <td>{$estadisticas['segundosjugados']}</td>
        <td>{$estadisticas['masmenos']}</td>
        <td>{$estadisticas['T2A']}</td>
        <td>{$estadisticas['T2F']}</td>
        <td>{$estadisticas['T3A']}</td>
        <td>{$estadisticas['T3F']}</td>
        <td>{$estadisticas['TLA']}</td>
        <td>{$estadisticas['TLF']}</td>
        <td>{$estadisticas['FLH']}</td>
        <td>{$estadisticas['FLR']}</td>
        <td>{$estadisticas['TEC']}</td>
        <td>{$estadisticas['RBO']}</td>
        <td>{$estadisticas['RBD']}</td>
        <td>{$estadisticas['ROB']}</td>
        <td>{$estadisticas['TAP']}</td>
        <td>{$estadisticas['PRD']}</td>
        <td>{$estadisticas['AST']}</td>
    </tr>
</table>";
    return $html;
}

function mostrarUltimosPartidosEntrenador(){

    $html = "";

    //Obtener el usuario en cuestión
    $usuario = $_SESSION['nombre'];

    //1ºEncontrar el equipo/equipos a los que pertenece, para cada uno mostrar los equipos.
    $idUsuario = $_SESSION['id'];

    $equiposdelUsuario = es\ucm\fdi\Equipo::getEquiposfromUserId($idUsuario);

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


$tituloPagina = 'Perfil';
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';
$rutaImgs=RUTA_IMGS;


//Instancio y llamo a la funcion correspondiente
$form = new es\ucm\fdi\FormularioCambiarPassword();
$htmlcambiarPasswordForm = $form->gestiona();

$roles = es\ucm\fdi\Usuario::getRoles($_SESSION['nombre']);

// Verificar si el conjunto de roles contiene un rol específico
if (in_array('J', $roles)) {
    //Obtengo los datos del perfil en cuestión
    $usuario = es\ucm\fdi\Usuario::getDatosPerfilJugador($_SESSION['nombre']);

    //Si su rol es E o J
    $equipos = es\ucm\fdi\Equipo::getEquiposfromUserId($usuario['id']);
    $htmlEquiposfromUser = mostrarListadoEquipos($equipos);

    //Si su rol es J
    $jugador = es\ucm\fdi\Jugador::statsfromJugador($usuario);

    $htmlfrommostrarStatsJugador = mostrarStatsJugador($jugador);

    $htmlUltimosPartidos = mostrarUltimosPartidosJugador();

    $contenidoPrincipal .= <<<EOS
    <div class="perfil">
        <div class="perfilCabecera">
            <div class="tituloCabecera">
                <img src="{$rutaImgs}/{$usuario['user']}.jpg" alt="imagen">
                <p>Nombre: {$usuario['nombre']} {$usuario['apellido1']} {$usuario['apellido2']}</p>
                <p>ID#{$usuario['id']} - @{$usuario['user']}</p>
                <p></p>
            </div>
            <div class="cambiarPassword">
                <button onclick='mostrarVentanaCambioPass(`{$htmlcambiarPasswordForm}`)'>Cambiar contraseña</button>
            </div>  
            <div class="cuadrostats">
                <h1>Estadisticas de {$usuario['user']} {$usuario['apellido1']} {$usuario['apellido2']}</h1>
                $htmlfrommostrarStatsJugador
            </div>
            <div class="cuadrostats">
                <h1>Estadisticas Avanzadas de {$usuario['user']} {$usuario['apellido1']} {$usuario['apellido2']}</h1>
            
            </div>
            <div class="perfilEquipos">
                <h2>Equipos a los que pertenece</h2>
                $htmlEquiposfromUser
            </div>
            <div class="lastgames">
            <h2>Últimos Partidos</h2>
                $htmlUltimosPartidos
            </div>

        </div>
    </div>
EOS;
} else {
    $usuario = es\ucm\fdi\Usuario::getDatosPerfilEntrenador($_SESSION['nombre']);
    //Si su rol es E o J
    $equipos = es\ucm\fdi\Equipo::getEquiposfromUserId($usuario['id']);
    $htmlEquiposfromUser = mostrarListadoEquipos($equipos);
    $htmlUltimosPartidos = mostrarUltimosPartidosEntrenador();
    $contenidoPrincipal .= <<<EOS
    <div class="perfil">
        <div class="perfilCabecera">
            <div class="tituloCabecera">
                <img src="{$rutaImgs}/{$usuario['user']}.jpg" alt="imagen">
                <p>Nombre: {$usuario['nombre']} {$usuario['apellido1']} {$usuario['apellido2']}</p>
                <p>ID#{$usuario['id']} - @{$usuario['user']}</p>
                <p></p>
            </div>
            <div class="cambiarPassword">
                <button onclick='mostrarVentanaCambioPass(`{$htmlcambiarPasswordForm}`)'>Cambiar contraseña</button>
            </div>  
            <div class="perfilEquipos">
                <h2>Equipos a los que pertenece</h2>
                $htmlEquiposfromUser
            </div>
            <div class="lastgames">
            <h2>Últimos Partidos</h2>
            $htmlUltimosPartidos
            </div>

        </div>
    </div>
    EOS;
}

require __DIR__.'/includes/vistas/plantilla.php';