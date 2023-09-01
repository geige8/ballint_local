<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Glosario';
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';
$rutaImgs = RUTA_IMGS;

$contenidoPrincipal .= <<<EOS
    <h1>GLOSARIO DE TERMINOS SOBRE LA PÁGINA:</h1>
    <ul>
    <p>La definición de roles es la siguiente:</p>
    <ul>
        <li>- Entrenador: Tiene Index, Mi Perfil, Mis Equipos, My Liceo y Glosario</li>
        <li>- Jugador: Tiene Index, Mi Perfil, Mis Equipos y Glosario</li>
        <li>- Director Técnico: Tiene Index, Mi Perfil, Mis Equipos, My Liceo y Glosario</li>
    </ul>
    <!-- Definiciones y Estadísticas Avanzadas -->
    <div>
        <h2>Definiciones</h2>
        <ul>
            <li>El complemento PP, significa Por Partido</li>
            <li>PTS: Puntos</li>
            <li>TO: Tiempo Muerto</li>
            <li>FL: Falta</li>
            <li>SUB: Substitución</li>
            <li>T2A: Tiro de 2 Anotado</li>
            <li>T2F: Tiro de 2 Fallado</li>
            <li>T3A: Tiro de 3 Anotado</li>
            <li>T3F: Tiro de 3 Fallado</li>
            <li>TCA: Tiro de Campo Anotado</li>
            <li>TCF: Tiro de Campo Fallado</li>
            <li>TLA: Tiro Libre Anotado</li>
            <li>TLF: Tiro Libre Fallado</li>
            <li>REB. Rebotes</li>
            <li>RBD: Rebote Defensivo</li>
            <li>RBO: Rebote Ofensivo</li>
            <li>ROB: Robos</li>
            <li>TAP: Tapones</li>
            <li>PRD: Pérdida</li>
            <li>AST: Asistencia</li>
            <li>FP: Faltas Personales</li>
            <li>FR: Faltas Recibidas</li>
            <li>TEC: Faltas Técnicas o Antideportivas</li>
        </ul>
    </div>

    <div>
        <h2>Estadísticas Avanzadas - Jugador</h2>
        <ul>
            <li>Porcentaje de Uso de Tiro: Posesiones que finalizan en una acción determinada dividido por el total de jugadas (acciones que acaban en tiro o balón perdido) (6)</li>
            <li>%T2: Tiros de 2 anotados / (T2A + T3A +(TLA*0.44))</li>
            <li>%T3: Tiros de 3 anotados / (T2A + T3A +(TLA*0.44))</li>
            <li>%TL: Tiros Libres anotados * 0.44 / (T2A + T3A +(TLA*0.44))</li>
            <li>Porcentaje de Tiro Efectivo: (FG + 0.5 * 3P) / FGA</li>
            <li>True Shooting: PTS / (2*(FGA + 0.44 * FTA))</li>
            <li>Porcentaje de Asistencias: AS / (2PM + 3PM)</li>
            <li>Porcentaje de Pérdidas: TO / (FGA + 0.44 * FTA + TO)</li>
            <li>Porcentaje de Tiro Libre respecto al tiro de campo: FTM / FGA</li>
            <li>Game Score: PTS + 0.4 * FG - 0.7 * FGA - 0.4*(FTA - FT) + 0.7 * ORB + 0.3 * DRB + STL + 0.7 * AST + 0.7 * BLK - 0.4 * PF - TOV</li>
            <li>Valoración: Suma de aspectos positivos (puntos, rebotes, asistencias, robos, tapones y faltas recibidas) menos aspectos negativos (tiros fallados, pérdidas y faltas personales)</li>
        </ul>
    </div>

    <div>
        <h2>Estadísticas Avanzadas - Equipo</h2>
        <ul>
            <li>Porcentaje de Uso de Tiro: Posesiones que finalizan en una acción determinada dividido por el total de jugadas (acciones que acaban en tiro o balón perdido) (6)</li>
            <li>%T2: Tiros de 2 anotados / (T2A + T3A +(TLA*0.44))</li>
            <li>%T3: Tiros de 3 anotados / (T2A + T3A +(TLA*0.44))</li>
            <li>%TL: Tiros Libres anotados * 0.44 / (T2A + T3A +(TLA*0.44))</li>
            <li>Porcentaje de Tiro Efectivo: (FG + 0.5 * 3P) / FGA</li>
            <li>True Shooting: PTS / (2*(FGA + 0.44 * FTA))</li>
            <li>Porcentaje de Asistencias: AS / (2PM + 3PM)</li>
            <li>Porcentaje de Pérdidas: TO / (FGA + 0.44 * FTA + TO)</li>
            <li>Porcentaje de Tiro Libre respecto al tiro de campo: FTM / FGA</li>
            <li>Posesiones: FGA + TO - OR + (FTA*0.44)</li>
            <li>Efficiency Offense: PTS / Posesiones</li>
            <li>Efficiency Defense: PTS recibidos / Posesiones</li>
            <li>Ritmo: (PTS/POS) * 100</li>
        </ul>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantilla.php';
?>
