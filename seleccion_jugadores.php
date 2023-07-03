<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Selección Jugadores';

$contenidoPrincipal = '';

$idEquipoLocal = $_GET['idEquipo'] ?? null;

$equipoLocal = es\ucm\fdi\Equipo::getNombreEquipo($idEquipoLocal);

$formulario = new es\ucm\fdi\FormularioSeleccionJugadores($idEquipoLocal);

$FormularioSeleccionJugadores = $formulario->gestiona();

$contenidoPrincipal .= <<<EOS

    $FormularioSeleccionJugadores
EOS;


require __DIR__.'/includes/vistas/plantilla.php';