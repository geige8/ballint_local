<?php
namespace es\ucm\fdi;

class Jugador{

    protected $id;

    public function __construct($id){ //OK
        $this->id = $id;
    }



    public static function statsfromJugador($usuario){

        $jugador = array();

        // Partidos Jugados
        $jugador['PJ'] = $usuario['PJ'];
    
        // Minutos
        $minutosjugados = floor($usuario['MT'] / 60) ?? 0;
        $segundosRestantes = $usuario['MT'] % 60 ?? 0;
        $tiempoFormato = sprintf("%02d:%02d", $minutosjugados, $segundosRestantes);
        $jugador['MT'] = $tiempoFormato;
    
        // Minutos Promedio
        $segundospromedio = (($usuario['MT'] ?? 0) / ($usuario['PJ'] ?? 0) ?? 0);
        $minutosjugados = floor($segundospromedio / 60);
        $segundosRestantes = $segundospromedio % 60;
        $tiempoFormato = sprintf("%02d:%02d", $minutosjugados, $segundosRestantes);
        $jugador['MTP'] = $tiempoFormato;
    
        // Partidos de Titular
        $jugador['TIT'] = $usuario['TIT'];
    
        // Partidos de Suplente
        $jugador['SUP'] = $usuario['SUP'];
    
        // Promedio Partidos Titular
        $jugador['TITP'] = number_format((($usuario['TIT']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
    
        // Más Menos Promedio
        $jugador['MSMS'] = number_format((($usuario['MSMS'] ?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
        // Puntos
        $jugador['PTS'] = $usuario['T2A'] * 2 + $usuario['T3A'] * 3 + $usuario['TLA'] * 1;
        // Puntos Promedio
        $jugador['PTSP'] = number_format((($jugador['PTS']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
        //Tiros de dos
        $jugador['T2A'] = $usuario['T2A'];
        $jugador['T2F'] = $usuario['T2F'];
        $jugador['T2P'] = number_format((($usuario['T2A'] / (($usuario['T2A'] + $usuario['T2F']) ?: 1)) ?: 0) * 100, 2);
        $jugador['T2PP'] = number_format((($jugador['T2A']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
        //Tiros de tres
        $jugador['T3A'] = $usuario['T3A'];
        $jugador['T3F'] = $usuario['T3F'];
        $jugador['T3P'] = number_format((($usuario['T3A'] / (($usuario['T3A'] + $usuario['T3F']) ?: 1)) ?: 0) * 100, 2);
        $jugador['T3PP'] = number_format((($jugador['T3A']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
        //Tiros Libres 
        $jugador['TLA'] = $usuario['TLA'];
        $jugador['TLF'] = $usuario['TLF'];
        $jugador['TLP'] = number_format((($usuario['TLA'] / (($usuario['TLA'] + $usuario['TLF']) ?: 1)) ?: 0) * 100, 2);
        $jugador['TLPP'] = number_format((($jugador['TLA']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
        //
        //Tiros de Campo 
        $jugador['TCA'] = $usuario['T2A'] + $usuario['T3A'];
        $jugador['TCF'] = $usuario['T2F'] + $usuario['T3F'];
        $jugador['TCP'] = number_format((($jugador['TCA'] / (($jugador['TCA'] + $jugador['TCF']) ?: 1)) ?: 0) * 100, 2);
        $jugador['TCPP'] = number_format((($jugador['TCA']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
        //
        //Faltas Hechas
        $jugador['FLH'] = $usuario['FLH'];
        $jugador['FLHP'] = number_format((($jugador['FLH']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
        //Faltas Recibidas
        $jugador['FLR'] = $usuario['FLR'];
        $jugador['FLRP'] = number_format((($jugador['FLR']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
        //
        //Rebotes Partido
        $jugador['REB'] = $usuario['RBO'] + $usuario['RBD'];
        $jugador['REBP'] = number_format((($jugador['REB']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
        //Rebotes Ofensivos
        $jugador['RBO'] = $usuario['RBO'];
        $jugador['RBOP'] = number_format((($jugador['RBO']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
        //Rebotes Defensivos
        $jugador['RBD'] = $usuario['RBD'];
        $jugador['RBDP'] = number_format((($jugador['RBD']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
        //
        //Robos Partido
        $jugador['ROB'] = $usuario['ROB'];
        $jugador['ROBP'] = number_format((($jugador['ROB']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);

        //Tapones Partido
        $jugador['TAP'] = $usuario['TAP'];
        $jugador['TAPP'] = number_format((($jugador['TAP']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);

        //Pérdida Partido
        $jugador['PRD'] = $usuario['PRD'];
        $jugador['PRDP'] = number_format((($jugador['PRD']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);
        //Asistencias Partido
        $jugador['AST'] = $usuario['AST'];
        $jugador['ASTP'] = number_format((($jugador['AST']?? 0) / ($usuario['PJ'] ?? 0)) ?? 0, 2);

        //Estadística Avanzada
        return $jugador;

    }




}
