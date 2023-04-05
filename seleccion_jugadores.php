<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Selección Jugadores';

$contenidoPrincipal = '';

$idEquipoLocal = $_GET['idEquipo'] ?? null;

$equipoLocal = es\ucm\fdi\Equipo::getNombreEquipo($idEquipoLocal);

$formulario = new es\ucm\fdi\FormularioSeleccionJugadores($idEquipoLocal);

$FormularioSeleccionJugadores = $formulario->gestiona();


$contenidoPrincipal .=" <h1>Selección de Jugadores</h1>";


// Obtener el nombre del equipo local a partir de su id


$contenidoPrincipal .= "<h2>Equipo Local: $equipoLocal</h2>";




$contenidoPrincipal .= <<<EOS
<h1>Selección de Jugadores</h1>
    $idEquipoLocal
    $FormularioSeleccionJugadores
EOS;


require __DIR__.'/includes/vistas/plantilla.php';