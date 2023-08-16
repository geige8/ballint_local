<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Contenido';

$contenidoPrincipal = '';

$local = $_GET['idEquipo'];

$nombreLocal = es\ucm\fdi\Equipo::getNombreEquipo($local);

$visitante = $_GET['idEquipoVisit'];

$jugadoresLocal = htmlspecialchars(json_encode(es\ucm\fdi\Partido::getJugadoresEquipoPartido($local)));
$jugadoresVisitante = htmlspecialchars(json_encode(es\ucm\fdi\Partido::getJugadoresEquipoPartido($visitante)));

$idPartido = es\ucm\fdi\Partido::getIdPartido($local,$visitante);




$contenidoPrincipal .= <<<EOS

<body onload="seleccionQuintetoInicial(`$nombreLocal`,`$visitante`,$jugadoresLocal,$jugadoresVisitante)">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.15/jspdf.plugin.autotable.min.js"></script>


    <div class="container">
        <div class="cabecera-stats">
            <div class="buttons-coach-local">
                <h1>BENCH</h1>
                <button class="timeout" data-accion="timeout" onclick="addTimeOut(`$local`)">TO</button>
                <p class="timeoutP">0</p>
                <button class="faltabanquillo" data-accion="faltabanquillo" onclick="addFaltaBanquillo(`$local`)">FL</button>
                <p class="faltabanquilloP">0</p>
            </div>

            <div class="localScore-display">
                <h1>{$local}</h1>
                <p class="points">0</p>
            </div>

            <div class="temporizador">
                <select id="periodSelect">
                    <option value="Periodo 1">Periodo 1</option>
                    <option value="Periodo 2">Periodo 2</option>
                    <option value="Periodo 3">Periodo 3</option>
                    <option value="Periodo 4">Periodo 4</option>
                    <option value="Extra 1">Extra 1</option>
                    <option value="Extra 2">Extra 2</option>
                    <option value="Extra 3">Extra 3</option>
                </select>

                <select id="durationSelect">
                    <option value="1">1 minuto</option>
                    <option value="2">2 minutos</option>
                    <option value="3">3 minutos</option>
                    <option value="4">4 minutos</option>                     
                    <option value="5">5 minutos</option>            
                    <option value="6">6 minutos</option>
                    <option value="7">7 minutos</option>
                    <option value="8">8 minutos</option>
                    <option value="9">9 minutos</option>
                    <option value="10">10 minutos</option>                     
                    <option value="11">11 minutos</option>            
                    <option value="12">12 minutos</option>
                </select>

                <div class="timer-display">
                00 : 00
                </div>

                <div class="buttons">
                    <button id="start-timer">Start</button>
                    <button id="pause-timer">Pause</button>
                    <button id="reset-timer">Poner Tiempo</button>
                </div>

                <div class="endgame">
                    <button id="endgame-button">FINALIZAR PARTIDO</button>
                </div>

            </div>

            <div class="visitScore-display">
                <h1>{$visitante}</h1>
                <p class="points">0</p>
            </div>

            <div class="buttons-coach-visit">
                <h1>BENCH</h1>
                <button class="timeout" data-accion="timeout" onclick="addTimeOut(`$visitante`)">TO</button>
                <p class="timeoutP">0</p>
                <button class="faltabanquillo" data-accion="faltabanquillo" onclick="addFaltaBanquillo(`$visitante`)">FL</button>
                <p class="faltabanquilloP">0</p>
            </div>

        </div>    
    </div> 
    <div class="cuerpoAnalizador">
        <div id="accionesLocal" class="acciones">
            <h1> $local </h1>
            <div class="botones">
                <button class="sub" data-accion="SUB" onclick="mostrarVentanaSub(`$local`)">SUB</button>
                <button class="action" data-accion="T2A" onclick="mostrarVentanaEmergente('T2A',`$local`)">T2A</button>
                <button class="action" data-accion="T2F" onclick="mostrarVentanaEmergente('T2F',`$local`)">T2F</button>
                <button class="action" data-accion="T3A" onclick="mostrarVentanaEmergente('T3A',`$local`)">T3A</button>
                <button class="action" data-accion="T3F" onclick="mostrarVentanaEmergente('T3F',`$local`)">T3F</button>
                <button class="action" data-accion="TLA" onclick="mostrarVentanaEmergente('TLA',`$local`)">TLA</button>
                <button class="action" data-accion="TLF" onclick="mostrarVentanaEmergente('TLF',`$local`)">TLF</button>
                <button class="action" data-accion="FLH" onclick="mostrarVentanaEmergente('FLH',`$local`)">FLH</button>
                <button class="action" data-accion="FLR" onclick="mostrarVentanaEmergente('FLR',`$local`)">FLR</button>
                <button class="action" data-accion="TEC" onclick="mostrarVentanaEmergente('TEC',`$local`)">TEC</button>
                <button class="action" data-accion="RBO" onclick="mostrarVentanaEmergente('RBO',`$local`)">RBO</button>
                <button class="action" data-accion="RBD" onclick="mostrarVentanaEmergente('RBD',`$local`)">RBD</button>
                <button class="action" data-accion="ROB" onclick="mostrarVentanaEmergente('ROB',`$local`)">ROB</button>
                <button class="action" data-accion="TAP" onclick="mostrarVentanaEmergente('TAP',`$local`)">TAP</button>
                <button class="action" data-accion="PRD" onclick="mostrarVentanaEmergente('PRD',`$local`)">PRD</button>
                <button class="action" data-accion="AST" onclick="mostrarVentanaEmergente('AST',`$local`)">AST</button>
            </div>
        </div>
    
        <div id="comparativaEquipos">
            <div class="idpartido-display">
                <p>ID PARTIDO: </p><p class="id">{$idPartido}</p>
            </div>
            <div class="graficos-button">
                <button id="graficos-button">Seleccionar Gráficos</button>
            </div>
            <h1> En pista: </h1>
            <div class="jugadoresPista">
                <div class="localPlayers-display">
                </div>
                <div class="visitPlayers-display">
                </div>
            </div>
            <div class="comparativa">
                <p class="T2A-Local">0</p>
                <p>/</p>
                <p class="T2F-Local" hidden>0</p>
                <p class="T2T-Local">0</p>
                <p class="T2P-Local">0</p>
                <p>%</p>
                    <h1>T2A</h1>
                <p class="T2A-Visitante">0</p>
                <p>/</p>
                <p class="T2F-Visitante" hidden>0</p>
                <p class="T2T-Visitante">0</p>
                <p class="T2P-Visitante">0</p>
                <p>%</p>
            </div>
            <div class="comparativa">
                <p class="T3A-Local">0</p>
                <p>/</p>
                <p class="T3F-Local" hidden>0</p>
                <p class="T3T-Local">0</p>
                <p class="T3P-Local">0</p>
                <p>%</p>
                    <h1>T3A</h1>
                <p class="T3A-Visitante">0</p>
                <p>/</p>
                <p class="T3F-Visitante" hidden>0</p>
                <p class="T3T-Visitante">0</p>
                <p class="T3P-Visitante">0</p>
                <p>%</p>
            </div>
            <div class="comparativa">
                <p class="TLA-Local">0</p>
                <p>/</p>
                <p class="TLF-Local" hidden>0</p>
                <p class="TLT-Local">0</p>
                <p class="TLP-Local">0</p>
                <p>%</p>
                    <h1>TLA</h1>
                <p class="TLA-Visitante">0</p>
                <p>/</p>
                <p class="TLF-Visitante" hidden>0</p>
                <p class="TLT-Visitante">0</p>
                <p class="TLP-Visitante">0</p>
                <p>%</p>
            </div>
            <div class="comparativa">
                <p class="FLH-Local">0</p>
                    <h1>FALTAS</h1>
                <p class="FLH-Visitante">0</p>
            </div>
            <div class="comparativa">
                <p class="RBO-Local">0</p>
                    <h1>REBO</h1>
                <p class="RBO-Visitante">0</p>
            </div>
            <div class="comparativa">
                <p class="RBD-Local">0</p>
                    <h1>REBD</h1>
                <p class="RBD-Visitante">0</p>
            </div>
            <div class="comparativa">
                <p class="RB-Local">0</p>
                    <h1>REB</h1>
                <p class="RB-Visitante">0</p>
            </div>
            <div class="comparativa">
                <p class="ROB-Local">0</p>
                    <h1>ROB</h1>
                <p class="ROB-Visitante">0</p>
            </div>
            <div class="comparativa">
                <p class="TAP-Local">0</p>
                    <h1>TAP</h1>
                <p class="TAP-Visitante">0</p>
            </div>
            <div class="comparativa">
                <p class="PRD-Local">0</p>
                    <h1>PRD</h1>
                <p class="PRD-Visitante">0</p>
            </div>
            <div class="comparativa">
                <p class="AST-Local">0</p>
                    <h1>AST</h1>
                <p class="AST-Visitante">0</p>
            </div>
        </div>

        <div id="accionesVisitante" class="acciones">
            <h1> $visitante </h1>
            <div class="botones">
                <button class="sub" data-accion="SUB" onclick="mostrarVentanaSub(`$visitante`)">SUB</button>
                <button class="action" data-accion="T2A" onclick="mostrarVentanaEmergente('T2A',`$visitante`)">T2A</button>
                <button class="action" data-accion="T2F" onclick="mostrarVentanaEmergente('T2F',`$visitante`)">T2F</button>
                <button class="action" data-accion="T3A" onclick="mostrarVentanaEmergente('T3A',`$visitante`)">T3A</button>
                <button class="action" data-accion="T3F" onclick="mostrarVentanaEmergente('T3F',`$visitante`)">T3F</button>
                <button class="action" data-accion="TLA" onclick="mostrarVentanaEmergente('TLA',`$visitante`)">TLA</button>
                <button class="action" data-accion="TLF" onclick="mostrarVentanaEmergente('TLF',`$visitante`)">TLF</button>
                <button class="action" data-accion="FLH" onclick="mostrarVentanaEmergente('FLH',`$visitante`)">FLH</button>
                <button class="action" data-accion="FLR" onclick="mostrarVentanaEmergente('FLR',`$visitante`)">FLR</button>
                <button class="action" data-accion="TEC" onclick="mostrarVentanaEmergente('TEC',`$visitante`)">TEC</button>
                <button class="action" data-accion="RBO" onclick="mostrarVentanaEmergente('RBO',`$visitante`)">RBO</button>
                <button class="action" data-accion="RBD" onclick="mostrarVentanaEmergente('RBD',`$visitante`)">RBD</button>
                <button class="action" data-accion="ROB" onclick="mostrarVentanaEmergente('ROB',`$visitante`)">ROB</button>
                <button class="action" data-accion="TAP" onclick="mostrarVentanaEmergente('TAP',`$visitante`)">TAP</button>
                <button class="action" data-accion="PRD" onclick="mostrarVentanaEmergente('PRD',`$visitante`)">PRD</button>
                <button class="action" data-accion="AST" onclick="mostrarVentanaEmergente('AST',`$visitante`)">AST</button>
            </div>
        </div>

    </div>
</div>
<script src="js\marcador.js"></script>
EOS;
require __DIR__.'/includes/vistas/plantillaAnalizador.php';
