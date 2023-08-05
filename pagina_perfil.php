<?php
require_once __DIR__.'/includes/config.php';

///////////////////////////////////////////
$tituloPagina = 'Perfil';
$rutaApp = RUTA_APP;
$rutaImgs=RUTA_IMGS;

///////////////////////////////////////////
$contenidoPrincipal = '';
$htmlUltimosPartidos = '';

///////////////////////////////////////////////////
//Instancio y llamo a la funcion correspondiente
$form = new es\ucm\fdi\FormularioCambiarPassword();
$htmlcambiarPasswordForm = $form->gestiona();

////////////////////////////////////////////////////

$roles = es\ucm\fdi\Usuario::getRoles($_SESSION['nombre']);

// Verificar si el conjunto de roles contiene un rol específico
if (in_array('J', $roles)) {

    //Obtengo los datos del perfil del Jugador
    $usuario = es\ucm\fdi\Usuario::getDatosPerfilJugador($_SESSION['nombre']);

    //Estadisticas de Jugador
    $jugador = es\ucm\fdi\Jugador::statsfromJugador($usuario);
    
    $htmlfrommostrarStatsJugador = es\ucm\fdi\Jugador::mostrarStatsJugador($jugador);
    $htmlfrommostrarAreasdeMejora = es\ucm\fdi\Jugador::mostrarStatsAreasdeMejoraJugador($jugador);
    $htmlfrommostrarStatsAvanzadasJugador = es\ucm\fdi\Jugador::mostrarStatsAvanzadasJugador($jugador);

    $equipos = es\ucm\fdi\Equipo::getEquiposfromUserId($_SESSION['id']);
    $htmlEquiposfromUser = es\ucm\fdi\Equipo::mostrarListadoEquipos($equipos);

    $htmlUltimosPartidos =es\ucm\fdi\Jugador::mostrarUltimosPartidosJugador($_SESSION['nombre']);

//////////////////////////////////////////
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
        </div>

        <div class="cuadrostats">
            <h1>Estadisticas de {$usuario['user']} {$usuario['apellido1']} {$usuario['apellido2']}</h1>
            $htmlfrommostrarStatsJugador
        </div>

        <div class="cuadrostatsMejora">
        <h1>Areas de Mejora de {$usuario['user']} {$usuario['apellido1']} {$usuario['apellido2']}</h1>
            $htmlfrommostrarAreasdeMejora
        </div>

        <div class="cuadrostatsAvanzadas">
            <h1>Estadisticas Avanzadas de {$usuario['user']} {$usuario['apellido1']} {$usuario['apellido2']}</h1>
            $htmlfrommostrarStatsAvanzadasJugador
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
    EOS;
} else {

    //Obtengo los datos del perfil del Entrenador
    $usuario = es\ucm\fdi\Usuario::getDatosPerfilEntrenador($_SESSION['nombre']);

    //Equipos a los que pertenece
    $equipos = es\ucm\fdi\Equipo::getEquiposfromUserId($_SESSION['id']);
    $htmlEquiposfromUser = es\ucm\fdi\Equipo::mostrarListadoEquipos($equipos);

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
        </div>
        <div class="perfilEquipos">
        <h2>Mis Equipos</h2>
        $htmlEquiposfromUser
        </div>

    EOS;

    //2º Estadisticas del Equipo:
    foreach($equipos as $equipo){

            $htmlUltimosPartidos .= es\ucm\fdi\Equipo::mostrarUltimosPartidosEquipo($equipo);
            $contenidoPrincipal .= <<<EOS
            <div class="lastgames">
                <h2>Ultimos Partidos de {$equipo}: </h2>
                $htmlUltimosPartidos
            </div>
        </div>
        EOS;
    }
}

require __DIR__.'/includes/vistas/plantilla.php';
