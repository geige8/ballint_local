<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Contenido';

$contenidoPrincipal = '';

$local = $_GET['idEquipo'];

$nombreLocal = es\ucm\fdi\Equipo::getNombreEquipo($local);

$visitante = $_GET['idEquipoVisit'];

//Instancio y llamo a la funcion correspondiente
//$form = new es\ucm\fdi\FormularioAccionPartido($_GET['idEquipo']);
//$htmlaccionPartido = $form->gestiona();

$contenidoPrincipal .= <<<EOS

<div class="container">

    <div class="cabecera-stats">

        <select id="durationSelect">
            <option value="10">10 minutos</option>
            <option value="5">5 minutos</option>
            <option value="12">12 minutos</option>
        </select>
        
        <select id="periodSelect">
            <option value="Periodo 1">Periodo 1</option>
            <option value="Periodo 2">Periodo 2</option>
            <option value="Periodo 3">Periodo 3</option>
            <option value="Periodo 4">Periodo 4</option>
            <option value="Extra 1">Extra 1</option>
            <option value="Extra 2">Extra 2</option>
            <option value="Extra 3">Extra 3</option>
        </select>

        <div class="timer-display">
        00 : 00
        </div>

        <div class="buttons">
            <button id="start-timer">Start</button>
            <button id="pause-timer">Pause</button>
            <button id="reset-timer">Reset</button>
        </div>

        <div class="localScore-display">
            <h1>{$nombreLocal}</h1>
            <p class="points">0</p>
        </div>

        <div class="visitScore-display">
            <h1>{$visitante}</h1>
            <p class="points">0</p>
        </div>
        <div class="buttons-coach-local">
            <h1>Locales</h1>
            <p class="timeouts">0</p>
            <button class="timeout">TimeOut</button>
            <p class="faltasbanquillo">0</p>
            <button class="faltabanquillo">Falta</button>
        </div>
        <div class="buttons-coach-visit">
            <h1>Visitantes</h1>
            <p class="timeouts">0</p>
            <button class="timeout">TimeOut</button>
            <p class="faltasbanquillo">0</p>
            <button class="faltabanquillo">Falta</button>
        </div>

    </div>

    <h1> Historial acciones </h1>

    <div class="info-display">
    
    </div>

    <div id="accionesLocal">
        <h1> Locales </h1>
        <button class="sub" data-accion="SUB">SUB</button>

        <button class="action" data-accion="T2A" onclick="mostrarVentanaEmergente('T2A',`$local`)">T2A</button>
        <button class="action" data-accion="T2F" onclick="mostrarVentanaEmergente('T2F',`$local`)">T2F</button>
        <button class="action" data-accion="T3A" onclick="mostrarVentanaEmergente('T3A',`$local`)">T3A</button>
        <button class="action" data-accion="T3F" onclick="mostrarVentanaEmergente('T3F',`$local`)">T3F</button>
        <button class="action" data-accion="TLA" onclick="mostrarVentanaEmergente('TLA',`$local`)">TLA</button>
        <button class="action" data-accion="TLF" onclick="mostrarVentanaEmergente('TLF',`$local`)">TLF</button>
        <button class="action" data-accion="FAL" onclick="mostrarVentanaEmergente('FAL',`$local`)">FAL</button>
        <button class="action" data-accion="TEC" onclick="mostrarVentanaEmergente('TEC',`$local`)">TEC</button>
        <button class="action" data-accion="RBO" onclick="mostrarVentanaEmergente('RBO',`$local`)">RBO</button>
        <button class="action" data-accion="RBD" onclick="mostrarVentanaEmergente('RBD',`$local`)">RBD</button>
        <button class="action" data-accion="ROB" onclick="mostrarVentanaEmergente('ROB',`$local`)">ROB</button>
        <button class="action" data-accion="TAP" onclick="mostrarVentanaEmergente('TAP',`$local`)">TAP</button>
        <button class="action" data-accion="PRD" onclick="mostrarVentanaEmergente('PRD',`$local`)">PRD</button>
        <button class="action" data-accion="AST" onclick="mostrarVentanaEmergente('AST',`$local`)">AST</button>
    </div>

    <div id="accionesVisitante">
        <h1> Visitantes </h1>
        <button class="sub" data-accion="SUB">SUB</button>

        <button class="action" data-accion="T2A" onclick="mostrarVentanaEmergente('T2A',`$visitante`)">T2A</button>
        <button class="action" data-accion="T2F" onclick="mostrarVentanaEmergente('T2F',`$visitante`)">T2F</button>
        <button class="action" data-accion="T3A" onclick="mostrarVentanaEmergente('T3A',`$visitante`)">T3A</button>
        <button class="action" data-accion="T3F" onclick="mostrarVentanaEmergente('T3F',`$visitante`)">T3F</button>
        <button class="action" data-accion="TLA" onclick="mostrarVentanaEmergente('TLA',`$visitante`)">TLA</button>
        <button class="action" data-accion="TLF" onclick="mostrarVentanaEmergente('TLF',`$visitante`)">TLF</button>
        <button class="action" data-accion="FAL" onclick="mostrarVentanaEmergente('FAL',`$visitante`)">FAL</button>
        <button class="action" data-accion="TEC" onclick="mostrarVentanaEmergente('TEC',`$visitante`)">TEC</button>
        <button class="action" data-accion="RBO" onclick="mostrarVentanaEmergente('RBO',`$visitante`)">RBO</button>
        <button class="action" data-accion="RBD" onclick="mostrarVentanaEmergente('RBD',`$visitante`)">RBD</button>
        <button class="action" data-accion="ROB" onclick="mostrarVentanaEmergente('ROB',`$visitante`)">ROB</button>
        <button class="action" data-accion="TAP" onclick="mostrarVentanaEmergente('TAP',`$visitante`)">TAP</button>
        <button class="action" data-accion="PRD" onclick="mostrarVentanaEmergente('PRD',`$visitante`)">PRD</button>
        <button class="action" data-accion="AST" onclick="mostrarVentanaEmergente('AST',`$visitante`)">AST</button>
    </div>
    
    <div id="comparativaEquipos">
        <div>
            <p class="T2">0</p>
                <h1>T2</h1>
            <p class="T2">0</p>
        </div>
        <div>
            <p class="T3">0</p>
                <h1>T3</h1>
            <p class="T3">0</p>
        </div>
        <div>
            <p class="TL">0</p>
                <h1>TL</h1>
            <p class="TL">0</p>
        </div>
        <div>
            <p class="FAL">0</p>
                <h1>FALTAS</h1>
            <p class="FAL">0</p>
        </div>
        <div>
            <p class="RBO">0</p>
                <h1>REBO</h1>
            <p class="RBO">0</p>
        </div>
        <div>
            <p class="RBD">0</p>
                <h1>REBD</h1>
            <p class="RBD">0</p>
        </div>
        <div>
            <p class="RB">0</p>
                <h1>REB</h1>
            <p class="RB">0</p>
        </div>
        <div>
            <p class="ROB">0</p>
                <h1>ROB</h1>
            <p class="ROB">0</p>
        </div>
        <div>
            <p class="TAP">0</p>
                <h1>TAP</h1>
            <p class="TAP">0</p>
        </div>
        <div>
            <p class="PRD">0</p>
                <h1>PRD</h1>
            <p class="PRD">0</p>
        </div>
        <div>
            <p class="AST">0</p>
                <h1>AST</h1>
            <p class="AST">0</p>
        </div>
    </div>
</div>

<script src="js\marcador.js"></script>
EOS;

require __DIR__.'/includes/vistas/plantilla.php';


/*     <div class="points-container">
        <div class="points-local">
            <h3>Equipo Local</h3>
            <p class="points">0</p>
            <button class="add-points" data-points="1">+1 punto</button>
            <button class="add-points" data-points="2">+2 puntos</button>
            <button class="add-points" data-points="3">+3 puntos</button>
        </div>
        <div class="points-visit">
            <h3>Equipo Visitante</h3>
            <p class="points">0</p>
            <button class="add-points" data-points="1">+1 punto</button>
            <button class="add-points" data-points="2">+2 puntos</button>
            <button class="add-points" data-points="3">+3 puntos</button>
        </div>
    </div>

    <div class="timeout-container">
        <div class="timeout-local">
            <p class="timeout">0</p>
            <button class="add-timeout" data-timeout="1">TIMEOUT LOCAL</button>
        </div>
        <div class="timeout-visit">
            <p class="timeout">0</p>
            <button class="add-timeout" data-timeout="1">TIMEOUT VISITOR</button>
        </div>
    </div>
 */