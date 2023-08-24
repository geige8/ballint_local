<?php
namespace es\ucm\fdi;

class Jugador{

    protected $id;

    public function __construct($id){ //OK
        $this->id = $id;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //GETTERS TABLA JUGADORES
    //Obtener el numero de un jugador dado su user
    public static function getNumJugador($jugador){

        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT numero FROM jugadores WHERE user = '$jugador'";

        $rs = $conn->query($query);

        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = $fila['numero'];
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //Obtener el nombre Completo de un jugador como la suma de su nombre y apellidos, dado un user
    public static function getnombreJugador($jugador){

        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT nombre,apellido1,apellido2 FROM jugadores WHERE user = '$jugador'";

        $rs = $conn->query($query);

        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2'];
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //FUNCIONES

    //Guardar los datos de un jugador al finalizar el partido
    public static function guardaDatosJugador($jugador){

        $resultado = false;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $sql = "UPDATE jugadores
        SET 
        PJ = PJ + 1,
        MT = MT + {$jugador['MT']},
        TIT = TIT + ({$jugador['titular']} = 1),
        SUP = SUP + ({$jugador['titular']} = 0),
        MSMS = MSMS + {$jugador['MSMS']},
        T2A = T2A + {$jugador['T2A']},
        T2F = T2F + {$jugador['T2F']},
        T3A = T3A + {$jugador['T3A']},
        T3F = T3F + {$jugador['T3F']},
        TLA = TLA + {$jugador['TLA']},
        TLF = TLF + {$jugador['TLF']},
        FLH = FLH + {$jugador['FLH']} + {$jugador['TEC']},
        FLR = FLR + {$jugador['FLR']},
        TEC = TEC + {$jugador['TEC']},
        RBO = RBO + {$jugador['RBO']},
        RBD = RBD + {$jugador['RBD']},
        ROB = ROB + {$jugador['ROB']},
        TAP = TAP + {$jugador['TAP']},
        PRD = PRD + {$jugador['PRD']},
        AST = AST + {$jugador['AST']},
        PTQ1 = PTQ1 + {$jugador['PTQ1']},
        PTQ2 = PTQ2 + {$jugador['PTQ2']},
        PTQ3 = PTQ3 + {$jugador['PTQ3']},
        PTQ4 = PTQ4 + {$jugador['PTQ4']},
        PTQE = PTQE + {$jugador['PTQE']}
        WHERE user = '{$jugador['jugador']}'";

        // Ejecutar la consulta
        $resultado = $conn->query($sql);

        if (!$resultado) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        return $resultado;
    }

    //Obtener las estadisticas del jugador, dados los parametros un jugador
    public static function statsfromJugador($usuario){

        $jugador = array();
    
        // Partidos Jugados
        $jugador['PJ'] = $usuario['PJ'];
    
        // Segundos Totales de Juego
        $jugador['MT'] = $usuario['MT'];

        $minutosjugados = floor($usuario['MT'] / 60) ?? 0;
        $segundosRestantes = $usuario['MT'] % 60 ?? 0;
        $tiempoFormato = sprintf("%02d'%02d''", $minutosjugados, $segundosRestantes);
        $jugador['MTT'] = $tiempoFormato;
    
        // Minutos Promedio
        if ($usuario['PJ'] > 0) {
            $segundospromedio = ($usuario['MT'] ?? 0) / ($usuario['PJ'] ?? 0);
            // En este caso: $segundospromedio = 9 / 5 = 1.8 segundos por partido
            $minutosjugados = floor($segundospromedio / 60);

            $segundosRestantes = $segundospromedio - ($minutosjugados * 60);

            $segundosRestantes = ceil($segundosRestantes);

            $tiempoFormato = sprintf("%02d:%02d", $minutosjugados, $segundosRestantes);

            $jugador['MTP'] = $tiempoFormato;
        } else {
            $jugador['MTP'] = "00:00";
        }
    
        // Partidos de Titular
        $jugador['TIT'] = $usuario['TIT'];
    
        // Partidos de Suplente
        $jugador['SUP'] = $usuario['SUP'];
    
        //Mas Menos
        $jugador['MSMS'] = $usuario['MSMS'];
    
        // Más Menos Promedio
        if ($usuario['PJ'] > 0) {
            $jugador['MSMSP'] = number_format(($usuario['MSMS'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['MSMSP'] = 0;
        }
    
        // Puntos
        $jugador['PTS'] = $usuario['T2A'] * 2 + $usuario['T3A'] * 3 + $usuario['TLA'] * 1;
    
        // Puntos Promedio
        if ($usuario['PJ'] > 0) {
            $jugador['PTSP'] = number_format(($jugador['PTS'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['PTSP'] = 0;
        }
    
        // Tiros de dos
        $jugador['T2A'] = $usuario['T2A'];
        $jugador['T2F'] = $usuario['T2F'];
        if (($usuario['T2A'] + $usuario['T2F']) > 0) {
            $jugador['T2P'] = number_format(($usuario['T2A'] / ($usuario['T2A'] + $usuario['T2F'])) * 100, 2);
        } else {
            $jugador['T2P'] = 0;
        }
        if ($usuario['PJ'] > 0) {
            $jugador['T2PP'] = number_format(($jugador['T2A'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['T2PP'] = 0;
        }
    
        // Tiros de tres
        $jugador['T3A'] = $usuario['T3A'];
        $jugador['T3F'] = $usuario['T3F'];
        if (($usuario['T3A'] + $usuario['T3F']) > 0) {
            $jugador['T3P'] = number_format(($usuario['T3A'] / ($usuario['T3A'] + $usuario['T3F'])) * 100, 2);
        } else {
            $jugador['T3P'] = 0;
        }
        if ($usuario['PJ'] > 0) {
            $jugador['T3PP'] = number_format(($jugador['T3A'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['T3PP'] = 0;
        }
    
        // Tiros Libres
        $jugador['TLA'] = $usuario['TLA'];
        $jugador['TLF'] = $usuario['TLF'];
        if (($usuario['TLA'] + $usuario['TLF']) > 0) {
            $jugador['TLP'] = number_format(($usuario['TLA'] / ($usuario['TLA'] + $usuario['TLF'])) * 100, 2);
        } else {
            $jugador['TLP'] = 0;
        }
        if ($usuario['PJ'] > 0) {
            $jugador['TLPP'] = number_format(($jugador['TLA'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['TLPP'] = 0;
        }
    
        // Tiros de Campo
        $jugador['TCA'] = $usuario['T2A'] + $usuario['T3A'];
        $jugador['TCF'] = $usuario['T2F'] + $usuario['T3F'];
        if (($jugador['TCA'] + $jugador['TCF']) > 0) {
            $jugador['TCP'] = number_format(($jugador['TCA'] / ($jugador['TCA'] + $jugador['TCF'])) * 100, 2);
        } else {
            $jugador['TCP'] = 0;
        }
        if ($usuario['PJ'] > 0) {
            $jugador['TCPP'] = number_format(($jugador['TCA'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['TCPP'] = 0;
        }
    
        // Faltas Hechas
        $jugador['FLH'] = $usuario['FLH'];
        if ($usuario['PJ'] > 0) {
            $jugador['FLHP'] = number_format(($jugador['FLH'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['FLHP'] = 0;
        }
    
        // Faltas Recibidas
        $jugador['FLR'] = $usuario['FLR'];
        if ($usuario['PJ'] > 0) {
            $jugador['FLRP'] = number_format(($jugador['FLR'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['FLRP'] = 0;
        }

        // TECNICAS
        $jugador['TEC'] = $usuario['TEC'];
        if ($usuario['PJ'] > 0) {
            $jugador['TECP'] = number_format(($jugador['TEC'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['TECP'] = 0;
        }
    
        // Rebotes Partido
        $jugador['REB'] = $usuario['RBO'] + $usuario['RBD'];
        if ($usuario['PJ'] > 0) {
            $jugador['REBP'] = number_format(($jugador['REB'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['REBP'] = 0;
        }
    
        // Rebotes Ofensivos
        $jugador['RBO'] = $usuario['RBO'];
        if ($usuario['PJ'] > 0) {
            $jugador['RBOP'] = number_format(($jugador['RBO'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['RBOP'] = 0;
        }
    
        // Rebotes Defensivos
        $jugador['RBD'] = $usuario['RBD'];
        if ($usuario['PJ'] > 0) {
            $jugador['RBDP'] = number_format(($jugador['RBD'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['RBDP'] = 0;
        }
    
        // Robos Partido
        $jugador['ROB'] = $usuario['ROB'];
        if ($usuario['PJ'] > 0) {
            $jugador['ROBP'] = number_format(($jugador['ROB'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['ROBP'] = 0;
        }
    
        // Tapones Partido
        $jugador['TAP'] = $usuario['TAP'];
        if ($usuario['PJ'] > 0) {
            $jugador['TAPP'] = number_format(($jugador['TAP'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['TAPP'] = 0;
        }
    
        // Pérdida Partido
        $jugador['PRD'] = $usuario['PRD'];
        if ($usuario['PJ'] > 0) {
            $jugador['PRDP'] = number_format(($jugador['PRD'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['PRDP'] = 0;
        }
    
        // Asistencias Partido
        $jugador['AST'] = $usuario['AST'];
        if ($usuario['PJ'] > 0) {
            $jugador['ASTP'] = number_format(($jugador['AST'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['ASTP'] = 0;
        }

        //ESTADISTICA AVANZADA

        //Puntos Por Cuartos
        $jugador['PTQ1'] = $usuario['PTQ1'];
        $jugador['PTQ2'] = $usuario['PTQ2'];
        $jugador['PTQ3'] = $usuario['PTQ3'];
        $jugador['PTQ4'] = $usuario['PTQ4'];
        $jugador['PTQE'] = $usuario['PTQE'];

        if ($usuario['PJ'] > 0) {
            $jugador['PTQ1P'] = number_format(($jugador['PTQ1'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
            $jugador['PTQ2P'] = number_format(($jugador['PTQ2'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
            $jugador['PTQ3P'] = number_format(($jugador['PTQ3'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
            $jugador['PTQ4P'] = number_format(($jugador['PTQ4'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
            $jugador['PTQEP'] = number_format(($jugador['PTQE'] ?? 0) / ($usuario['PJ'] ?? 0), 2);

        } else {
            $jugador['PTQ1P'] = 0;
            $jugador['PTQ2P'] = 0;
            $jugador['PTQ3P'] = 0;
            $jugador['PTQ4P'] = 0;
            $jugador['PTQEP'] = 0;
        }

        // PORCENTAJES DE USO DE TIRO
        $total_shots = $jugador['T2A'] + $jugador['T3A'] + ($jugador['TLA'] * 0.44);
        if ($total_shots > 0) {
            $jugador['T2PU'] = number_format(($jugador['T2A'] / $total_shots), 2) * 100;
            $jugador['T3PU'] = number_format(($jugador['T3A'] / $total_shots), 2) * 100;
            $jugador['T1PU'] = number_format((($jugador['TLA'] * 0.44) / $total_shots), 2) * 100;
        } else {
            $jugador['T2PU'] = 0;
            $jugador['T3PU'] = 0;
            $jugador['T1PU'] = 0;
        }

        // PORCENTAJE DE TIRO EFECTIVO: eFG% = (FG + 0.5 * 3P) / FGA
        $total_attempts = $jugador['TCA'] + $jugador['TCF'];
        if ($total_attempts > 0) {
            $jugador['eFGP'] = number_format((($jugador['T2A'] + $jugador['T3A'] + 0.5 * $jugador['T3A']) / $total_attempts),2) * 100;
        } else {
            $jugador['eFGP'] = 0;
        }
        
        // PORCENTAJE DE PÉRDIDAS (TO%)
        // TO% = TO / (FGA + 0.44 * FTA + TO)
        $denominator_TO = ($jugador['TCA'] + $jugador['TCF']) + (0.44 * ($jugador['TLA'] + $jugador['TLF'])) + $jugador['PRD'];

        if ($denominator_TO > 0) {
            $jugador['TOP'] = number_format((($jugador['PRD']) / $denominator_TO),2) * 100;
        }
        else{
            $jugador['TOP'] = 0;
        }

        // PORCENTAJE DE TIRO LIBRE RESPECTO AL TIRO DE CAMPO (FTM/FGA).
        // La fórmula es: FTM/FGA
        $denominator_TLP = $jugador['TCA'] + $jugador['TCF'];

        if ($denominator_TLP > 0) {
            $jugador['TLP'] = number_format(($jugador['TCA'] / $denominator_TLP),2) * 100;
        } else {
            $jugador['TLP'] = 0;
        }


        // TRUE SHOOTING (TS%).
        // Porcentaje de tiros de campo para un equipo ponderando el tiro de 3 puntos por 1,5 y añadiendo los tiros libres por 0,44.
        // TS% = PTS / 2(FGA + 0.44 * FTA)
        $total_field_attempts = $jugador['TCA'] + $jugador['TCF'];
        $total_free_attempts = $jugador['TLA'] + $jugador['TLF'];
        if (($total_field_attempts + 0.44 * $total_free_attempts) > 0) {
            $jugador['TSP'] = number_format(($jugador['PTS']) / (2 * ($total_field_attempts + 0.44 * $total_free_attempts)),2) * 100;
        } else {
            $jugador['TSP'] = 0;
        }

        // PORCENTAJE DE ASISTENCIAS (AS%).
        // Porcentaje de asistencias respecto a los tiros de campo anotados.
        // La fórmula es: AS% = AS / (2PM + 3PM)
        $total_field_made = $jugador['T2A'] + $jugador['T3A'];
        if ($total_field_made > 0) {
            $jugador['ASP'] = number_format((($jugador['AST']) / $total_field_made),2) * 100;
        } else {
            $jugador['ASP'] = 0;
        }


        // GmSc - Game Score; the formula is PTS + 0.4 * FG - 0.7 * FGA - 0.4*(FTA - FT) + 0.7 * ORB + 0.3 * DRB + STL + 0.7 * AST + 0.7 * BLK - 0.4 * PF - TOV. 
        // Game Score was created by John Hollinger to give a rough measure of a player's productivity for a single game. 
        // The scale is similar to that of points scored, (40 is an outstanding performance, 10 is an average performance, etc.).
        $jugador['GS'] = number_format(($jugador['PTS']+0.4*$jugador['TCA']-0.7*($jugador['TCA']+$jugador['TCF'])-0.4*$jugador['TCF']
        +0.7*$jugador['RBO']+0.3*$jugador['RBD']+$jugador['ROB']+0.7*$jugador['AST']+0.7* $jugador['TAP']-0.4*$jugador['FLH']-$jugador['PRD']),2);

        //VALORACION

        $jugador['VAL'] = $jugador['PTS']+$jugador['REB']+$jugador['AST']+$jugador['ROB']+$jugador['FLR']+$jugador['TAP']-$jugador['TCF']-$jugador['PRD']-$jugador['FLH'];

        if ($usuario['PJ'] > 0) {
            $jugador['VALP'] = number_format(($jugador['VAL'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['VALP'] = 0;
        }
        
        return $jugador;
    }  

    //Obtener las estadisticas del jugador en partido, dados los parametros un jugador
    public static function statsfromJugadorEnPartido($usuario){

        $jugador = array();

        $jugador['equipo'] = $usuario['equipo'];

        $jugador['nombrejugador'] = $usuario['nombrejugador'];

        $jugador['numero'] = $usuario['numero'];
    
        // Minutos
        $jugador['MT'] = $usuario['MT'];

        $minutosjugados = floor($usuario['MT'] / 60) ?? 0;
        $segundosRestantes = $usuario['MT'] % 60 ?? 0;
        $tiempoFormato = sprintf("%02d'%02d''", $minutosjugados, $segundosRestantes);
        $jugador['MTT'] = $tiempoFormato;
    
        // Partidos de Titular
        $usuario['titular'] == 1 ?  $jugador['TIT'] = 'Sí' :  $jugador['TIT'] = 'No';   

        //Mas Menos
        $jugador['MSMS'] = $usuario['MSMS'];
        
        // Puntos
        $jugador['PTS'] = $usuario['T2A'] * 2 + $usuario['T3A'] * 3 + $usuario['TLA'] * 1;
    
        // Tiros de dos
        $jugador['T2A'] = $usuario['T2A'];
        $jugador['T2F'] = $usuario['T2F'];
        if (($usuario['T2A'] + $usuario['T2F']) > 0) {
            $jugador['T2P'] = number_format(($usuario['T2A'] / ($usuario['T2A'] + $usuario['T2F'])) * 100, 1);
        } else {
            $jugador['T2P'] = 0;
        }
    
        // Tiros de tres
        $jugador['T3A'] = $usuario['T3A'];
        $jugador['T3F'] = $usuario['T3F'];
        if (($usuario['T3A'] + $usuario['T3F']) > 0) {
            $jugador['T3P'] = number_format(($usuario['T3A'] / ($usuario['T3A'] + $usuario['T3F'])) * 100, 1);
        } else {
            $jugador['T3P'] = 0;
        }
    
        // Tiros Libres
        $jugador['TLA'] = $usuario['TLA'];
        $jugador['TLF'] = $usuario['TLF'];
        if (($usuario['TLA'] + $usuario['TLF']) > 0) {
            $jugador['TLP'] = number_format(($usuario['TLA'] / ($usuario['TLA'] + $usuario['TLF'])) * 100, 1);
        } else {
            $jugador['TLP'] = 0;
        }
    
        // Tiros de Campo
        $jugador['TCA'] = $usuario['T2A'] + $usuario['T3A'];
        $jugador['TCF'] = $usuario['T2F'] + $usuario['T3F'];
        if (($jugador['TCA'] + $jugador['TCF']) > 0) {
            $jugador['TCP'] = number_format(($jugador['TCA'] / ($jugador['TCA'] + $jugador['TCF'])) * 100, 1);
        } else {
            $jugador['TCP'] = 0;
        }
    
        // Faltas Hechas
        $jugador['FLH'] = $usuario['FLH'];
    
        // Faltas Recibidas
        $jugador['FLR'] = $usuario['FLR'];

        // TECNICAS
        $jugador['TEC'] = $usuario['TEC'];
    
        // Rebotes Partido
        $jugador['REB'] = $usuario['RBO'] + $usuario['RBD'];
    
        // Rebotes Ofensivos
        $jugador['RBO'] = $usuario['RBO'];
    
        // Rebotes Defensivos
        $jugador['RBD'] = $usuario['RBD'];
    
        // Robos Partido
        $jugador['ROB'] = $usuario['ROB'];
    
        // Tapones Partido
        $jugador['TAP'] = $usuario['TAP'];
    
        // Pérdida Partido
        $jugador['PRD'] = $usuario['PRD'];
    
        // Asistencias Partido
        $jugador['AST'] = $usuario['AST'];

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //ESTADISTICA AVANZADA

        //Puntos Por Cuartos
        $jugador['PTQ1'] = $usuario['PTQ1'];
        $jugador['PTQ2'] = $usuario['PTQ2'];
        $jugador['PTQ3'] = $usuario['PTQ3'];
        $jugador['PTQ4'] = $usuario['PTQ4'];
        $jugador['PTQE'] = $usuario['PTQE'];

        // PORCENTAJES DE USO DE TIRO
        $total_shots = $jugador['T2A'] + $jugador['T3A'] + ($jugador['TLA'] * 0.44);
        if ($total_shots > 0) {
            $jugador['T2PU'] = number_format(($jugador['T2A'] / $total_shots), 1) * 100;
            $jugador['T3PU'] = number_format(($jugador['T3A'] / $total_shots), 1) * 100;
            $jugador['T1PU'] = number_format((($jugador['TLA'] * 0.44) / $total_shots), 1) * 100;
        } else {
            $jugador['T2PU'] = 0;
            $jugador['T3PU'] = 0;
            $jugador['T1PU'] = 0;
        }

        // PORCENTAJE DE TIRO EFECTIVO: eFG% = (FG + 0.5 * 3P) / FGA
        $total_attempts = $jugador['TCA'] + $jugador['TCF'];
        if ($total_attempts > 0) {
            $jugador['eFGP'] = number_format((($jugador['T2A'] + $jugador['T3A'] + 0.5 * $jugador['T3A']) / $total_attempts) * 100, 1);
        } else {
            $jugador['eFGP'] = 0;
        }

        // TRUE SHOOTING (TS%).
        // Porcentaje de tiros de campo para un equipo ponderando el tiro de 3 puntos por 1,5 y añadiendo los tiros libres por 0,44.
        // TS% = PTS / 2(FGA + 0.44 * FTA)
        $total_field_attempts = $jugador['TCA'] + $jugador['TCF'];
        $total_free_attempts = $jugador['TLA'] + $jugador['TLF'];
        if (($total_field_attempts + 0.44 * $total_free_attempts) > 0) {
            $jugador['TSP'] = number_format(($jugador['PTS']) / (2 * ($total_field_attempts + 0.44 * $total_free_attempts))  * 100, 1);
        } else {
            $jugador['TSP'] = 0;
        }

        // PORCENTAJE DE ASISTENCIAS (AS%).
        // Porcentaje de asistencias respecto a los tiros de campo anotados.
        // La fórmula es: AS% = AS / (2PM + 3PM)
        $total_field_made = $jugador['T2A'] + $jugador['T3A'];
        if ($total_field_made > 0) {
            $jugador['ASP'] = number_format(($jugador['AST']) / $total_field_made  * 100, 1);
        } else {
            $jugador['ASP'] = 0;
        }

        // GmSc - Game Score; the formula is PTS + 0.4 * FG - 0.7 * FGA - 0.4*(FTA - FT) + 0.7 * ORB + 0.3 * DRB + STL + 0.7 * AST + 0.7 * BLK - 0.4 * PF - TOV. 
        // Game Score was created by John Hollinger to give a rough measure of a player's productivity for a single game. 
        // The scale is similar to that of points scored, (40 is an outstanding performance, 10 is an average performance, etc.).
        $jugador['GS'] = number_format($jugador['PTS']+0.4*$jugador['TCA']-0.7*($jugador['TCA']+
        $jugador['TCF'])-0.4*$jugador['TCF']+0.7*$jugador['RBO']+0.3*$jugador['RBD']+$jugador['ROB']+
        0.7*$jugador['AST']+0.7* $jugador['TAP']-0.4*$jugador['FLH']-$jugador['PRD'],1);

        //VALORACION

        $jugador['VAL'] = $jugador['PTS']+$jugador['REB']+$jugador['AST']+$jugador['ROB']+$jugador['FLR']+$jugador['TAP']-$jugador['TCF']-$jugador['PRD']-$jugador['FLH'];
        
        return $jugador;
    }  

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //MOSTRAR

    //Mostrar las stats de un jugador
    public static function mostrarStatsJugador($jugador){
        $html = "";
        $html .= "
        <div class='stats'>
            <div class='stats-row'>
            <h3>Estadísticas de Partidos</h3>
                <div class='stat'>
                    <p>Partidos Jugados</p>
                    <p>{$jugador['PJ']}</p>
                </div>
                <div class='stat'>
                    <p>Minutos Totales</p>
                    <p>{$jugador['MTT']}</p>
                </div>
                <div class='stat'>
                    <p>Minutos Promedio</p>
                    <p>{$jugador['MTP']}</p>
                </div>
                <div class='stat'>
                    <p>Partidos Titular</p>
                    <p>{$jugador['TIT']}</p>
                </div>
                <div class='stat'>
                    <p>Partidos Suplente</p>
                    <p>{$jugador['SUP']}</p>
                </div>
            </div>
        
            <div class='stats-row'>
            <h3>Estadísticas Clave</h3>
                <div class='stat'>
                    <p>PTS</p>
                    <p>{$jugador['PTS']}</p>
                </div>
                <div class='stat'>
                    <p>PPP</p>
                    <p>{$jugador['PTSP']}</p>
                </div>
                <div class='stat'>
                    <p>+/-</p>
                    <p>{$jugador['MSMS']}</p>
                </div>
                <div class='stat'>
                    <p>+/- PP</p>
                    <p>{$jugador['MSMSP']}</p>
                </div>
                <div class='stat'>
                    <p>Valoración</p>
                    <p>{$jugador['VAL']}</p>
                </div>
                <div class='stat'>
                    <p>Valoración PP</p>
                    <p>{$jugador['VALP']}</p>
                </div>
            </div>
        
            <div class='stats-row'>
            <h3>Estadísticas Tiro</h3>
                <div class='stat'>
                    <p>T2A</p>
                    <p>{$jugador['T2A']}</p>
                </div>
                <div class='stat'>
                    <p>T2A</p>
                    <p>{$jugador['T2P']}%</p>
                </div>
                <div class='stat'>
                    <p>T2A PP</p>
                    <p>{$jugador['T2PP']}</p>
                </div>
                <div class='stat'>
                    <p>T3A</p>
                    <p>{$jugador['T3A']}</p>
                </div>
                <div class='stat'>
                    <p>T3A</p>
                    <p>{$jugador['T3P']}%</p>
                </div>
                <div class='stat'>
                    <p>T3A PP</p>
                    <p>{$jugador['T3PP']}</p>
                </div>
                <div class='stat'>
                    <p>TLA</p>
                    <p>{$jugador['TLA']}</p>
                </div>
                <div class='stat'>
                    <p>TLA</p>
                    <p>{$jugador['TLP']}%</p>
                </div>
                <div class='stat'>
                    <p>TLA PP</p>
                    <p>{$jugador['TLPP']}</p>
                </div>
                <div class='stat'>
                    <p>TCA</p>
                    <p>{$jugador['TCA']}</p>
                </div>
                <div class='stat'>
                    <p>%TCA</p>
                    <p>{$jugador['TCP']}%</p>
                </div>
                <div class='stat'>
                    <p>TCA PP</p>
                    <p>{$jugador['TCPP']}</p>
                </div>
            </div>

            <div class='stats-row'>
            <h3>Estadísticas Anotación</h3>
                <div class='stat'>
                    <p>PTS Q1</p>
                    <p>{$jugador['PTQ1']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q1 PP</p>
                    <p>{$jugador['PTQ1P']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q2</p>
                    <p>{$jugador['PTQ2']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q2 PP</p>
                    <p>{$jugador['PTQ2P']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q3</p>
                    <p>{$jugador['PTQ3']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q3 PP</p>
                    <p>{$jugador['PTQ3P']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q4</p>
                    <p>{$jugador['PTQ4']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q4 PP</p>
                    <p>{$jugador['PTQ4P']}</p>
                </div>
                <div class='stat'>
                    <p>PTS EXTRA</p>
                    <p>{$jugador['PTQE']}</p>
                </div>
                <div class='stat'>
                    <p>PTS EXTRA PP</p>
                    <p>{$jugador['PTQEP']}</p>
                </div>
            </div>

            <div class='stats-row'>
            <h3>Estadísticas Rebotes</h3>
                <div class='stat'>
                    <p>RBO</p>
                    <p>{$jugador['RBO']}</p>
                </div>
                <div class='stat'>
                    <p>RBO PP</p>
                    <p>{$jugador['RBOP']}</p>
                </div>
                <div class='stat'>
                    <p>RBD</p>
                    <p>{$jugador['RBD']}</p>
                </div>
                <div class='stat'>
                    <p>RBD PP</p>
                    <p>{$jugador['RBDP']}</p>
                </div>
                <div class='stat'>
                    <p>RBT</p>
                    <p>{$jugador['REB']}</p>
                </div>
                <div class='stat'>
                    <p>RBT PP</p>
                    <p>{$jugador['REBP']}</p>
                </div>
            </div>

            <div class='stats-row'>
            <h3>Estadísticas de Juego</h3>
                <div class='stat'>
                    <p>ROB</p>
                    <p>{$jugador['ROB']}</p>
                </div>
                <div class='stat'>
                    <p>ROB PP</p>
                    <p>{$jugador['ROBP']}</p>
                </div>
                <div class='stat'>
                    <p>TAP</p>
                    <p>{$jugador['TAP']}</p>
                </div>
                <div class='stat'>
                    <p>TAP PP</p>
                    <p>{$jugador['TAPP']}</p>
                </div>
                <div class='stat'>
                    <p>PRD</p>
                    <p>{$jugador['PRD']}</p>
                </div>
                <div class='stat'>
                    <p>PRD PP</p>
                    <p>{$jugador['PRDP']}</p>
                </div>
                <div class='stat'>
                    <p>AST</p>
                    <p>{$jugador['AST']}</p>
                </div>
                <div class='stat'>
                    <p>AST PP</p>
                    <p>{$jugador['ASTP']}</p>
                </div>
            </div>

            <div class='stats-row'>
            <h3>Estadísticas Faltas</h3>
                <div class='stat'>
                    <p>FP</p>
                    <p>{$jugador['FLH']}</p>
                </div>
                <div class='stat'>
                    <p>FP PP</p>
                    <p>{$jugador['FLHP']}</p>
                </div>
                <div class='stat'>
                    <p>FR</p>
                    <p>{$jugador['FLR']}</p>
                </div>
                <div class='stat'>
                    <p>FR PP</p>
                    <p>{$jugador['FLRP']}</p>
                </div>
                <div class='stat'>
                    <p>TEC</p>
                    <p>{$jugador['TEC']}</p>
                </div>
                <div class='stat'>
                    <p>TEC PP</p>
                    <p>{$jugador['TEC']}</p>
                </div>
            </div>
        </div>";
        return $html;
    }

    //Mostrar las areas de mejora de un jugador
    public static function mostrarStatsAreasdeMejoraJugador($jugador){

        $html = "<div class='stats'>";
    
        if ($jugador['T2P'] <= 30) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%T2A</p>";
            $html .= "<p class='stat-value'>{$jugador['T2P']}% - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        if ($jugador['T3P'] <= 30) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%T3A</p>";
            $html .= "<p class='stat-value'>{$jugador['T3P']}% - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        if ($jugador['TLP'] <= 30) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%TLA</p>";
            $html .= "<p class='stat-value'>{$jugador['TLP']}% - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        if ($jugador['TCP'] <= 30) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%TCA</p>";
            $html .= "<p class='stat-value'>{$jugador['TCP']}% - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        
        if ($jugador['FLHP'] >= 3) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>FLHP</p>";
            $html .= "<p class='stat-value'>{$jugador['FLHP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        if ($jugador['FLRP'] <= 1) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%FLRP</p>";
            $html .= "<p class='stat-value'>{$jugador['FLRP']}% - Tiene que mejorar</p>";
            $html .= "</div>";
        }

        if ($jugador['RBOP'] < 1 ) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>RBOP</p>";
            $html .= "<p class='stat-value'>{$jugador['RBOP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        if ($jugador['RBDP'] < 3) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%RBDP</p>";
            $html .= "<p class='stat-value'>{$jugador['RBDP']}% - Tiene que mejorar</p>";
            $html .= "</div>";
        } 
        if ($jugador['REBP'] < 3) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>REBP</p>";
            $html .= "<p class='stat-value'>{$jugador['REBP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        
        if ($jugador['ROBP'] <= 1) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>ROBP</p>";
            $html .= "<p class='stat-value'>{$jugador['ROBP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        } 
        if ($jugador['TAPP'] <= 0.2) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%TAPP</p>";
            $html .= "<p class='stat-value'>{$jugador['TAPP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        } 
        if ($jugador['PRDP'] >= 2) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%PRDP</p>";
            $html .= "<p class='stat-value'>{$jugador['PRDP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        } 
        if ($jugador['ASTP'] <= 1) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>ASTP</p>";
            $html .= "<p class='stat-value'>{$jugador['ASTP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        }
    
        $html .= "</div>";
        return $html;
    }
    
    //Mostrar las Stats Avanzadas de un jugador
    public static function mostrarStatsAvanzadasJugador($jugadorAvanzado){

        $html = "";

        $html .= "
        <div class='stats'>
            <div class='stat-container'>
                <p class='stat-label'>%USO T2</p>
                <p class='stat-value'>{$jugadorAvanzado['T2PU']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>%USO T3</p>
                <p class='stat-value'>{$jugadorAvanzado['T3PU']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>%USO TL</p>
                <p class='stat-value'>{$jugadorAvanzado['T1PU']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>%TEFEC</p>
                <p class='stat-value'>{$jugadorAvanzado['eFGP']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>TRUE S%</p>
                <p class='stat-value'>{$jugadorAvanzado['TSP']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>AST %</p>
                <p class='stat-value'>{$jugadorAvanzado['ASP']}%</p>
            </div>
                <div class='stat-container'>
                <p class='stat-label'>PRD %</p>
                <p class='stat-value'>{$jugadorAvanzado['TOP']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>%TL/TC</p>
                <p class='stat-value'>{$jugadorAvanzado['TLP']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>GAMESCORE</p>
                <p class='stat-value'>{$jugadorAvanzado['GS']}%</p>
            </div>
        </div>
        ";
        return $html;
    }

    //Mostrar las stats de un jugador en un partido
    public static function mostrarStatsPartidoJugador($partido,$estadisticas,$partidoId){

        $html = "";

        $html .= "
                <tr>
                    <td>
                        <a href='pagina_partido.php?partido={$partido['visitante']}&fecha={$partido['fecha']}&id={$partidoId}'>
                        {$partido['visitante']}
                        </a>
                    </td>
                    <td>{$partido['fecha']}</td>
                    <td>{$estadisticas['TIT']}</td>
                    <td>{$estadisticas['MTT']}</td>
                    <td>{$estadisticas['MSMS']}</td>
                    <td>{$estadisticas['PTS']}</td>
                    <td>{$estadisticas['T2A']}</td>
                    <td>({$estadisticas['T2A']}/{$estadisticas['T2F']})-{$estadisticas['T2P']}%</td>
                    <td>{$estadisticas['T3A']}</td>
                    <td>({$estadisticas['T3A']}/{$estadisticas['T3F']})-{$estadisticas['T3P']}%</td>
                    <td>{$estadisticas['TCA']}</td>
                    <td>({$estadisticas['TCA']}/{$estadisticas['TCF']})-{$estadisticas['TCP']}%</td>
                    <td>{$estadisticas['TLA']}</td>
                    <td>({$estadisticas['TLA']}/{$estadisticas['TLF']})-{$estadisticas['TLP']}%</td>
                    <td>{$estadisticas['FLH']}</td>
                    <td>{$estadisticas['FLR']}</td>
                    <td>{$estadisticas['TEC']}</td>
                    <td>{$estadisticas['RBO']}</td>
                    <td>{$estadisticas['RBD']}</td>
                    <td>{$estadisticas['REB']}</td>
                    <td>{$estadisticas['ROB']}</td>
                    <td>{$estadisticas['TAP']}</td>
                    <td>{$estadisticas['PRD']}</td>
                    <td>{$estadisticas['AST']}</td>
                    <td>{$estadisticas['PTQ1']}</td>
                    <td>{$estadisticas['PTQ2']}</td>
                    <td>{$estadisticas['PTQ3']}</td>
                    <td>{$estadisticas['PTQ4']}</td>
                    <td>{$estadisticas['PTQE']}</td>
                    <td>{$estadisticas['T2PU']}%</td>
                    <td>{$estadisticas['T3PU']}%</td>
                    <td>{$estadisticas['T1PU']}%</td>
                    <td>{$estadisticas['eFGP']}%</td>
                    <td>{$estadisticas['TSP']}%</td>
                    <td>{$estadisticas['ASP']}%</td>
                    <td>{$estadisticas['GS']}</td>
                    <td>{$estadisticas['VAL']}</td>
                </tr>";
        return $html;
    }

    //Mostrar los ultimos partidos de un jugador
    public static function mostrarUltimosPartidosJugador($jugador){

        $html = "";

        $idUser = Usuario::getidNombreUser($jugador);

        $equiposdelUsuario = Equipo::getEquiposfromUserId($idUser);

        foreach($equiposdelUsuario as $equipo){
            
            //Para cada equipo al que pertenezca quiero mostrar los partidos.
            //Tengo que obtener el id de cada partido de ese equipo
            
            $partidos = Partido::getpartidosfromEquipo($equipo);

            usort($partidos, function($a, $b) {
                return strtotime($b['fecha']) - strtotime($a['fecha']);
            });

            if($partidos){
                
                $html .= "           
                <table>
                    <tr>
                        <th>Rival</th>
                        <th>Fecha</th>
                        <th>Titular</th>
                        <th>Minutos</th>
                        <th>+/-</th>
                        <th>PTS</th>
                        <th>T2A</th>
                        <th>T2%</th>
                        <th>T3A</th>
                        <th>T3%</th>
                        <th>TCA</th>
                        <th>TC%</th>
                        <th>TLA</th>
                        <th>TL%</th>
                        <th>FLH</th>
                        <th>FLR</th>
                        <th>TEC</th>
                        <th>RBO</th>
                        <th>RBD</th>
                        <th>RBT</th>
                        <th>ROB</th>
                        <th>TAP</th>
                        <th>PRD</th>
                        <th>AST</th>
                        <th>PTQ1</th>
                        <th>PTQ2</th>
                        <th>PTQ3</th>                    
                        <th>PTQ4</th>
                        <th>PTQE</th>
                        <th>T2%Us</th>                    
                        <th>T3%Us</th>
                        <th>TL%Us</th>
                        <th>eFG%</th>                    
                        <th>TS%</th>
                        <th>AS%</th>
                        <th>GS</th>
                        <th>VAL</th>
                    </tr>";

                //Ahora quiero buscar en la tabla de cada uno de esos partidos las estadisticas para ese jugador

                foreach($partidos as $partido){

                    //Necesito que me devuelva las estadisticas de ese jugador para ese partido si es que ha participado
                    $estadisticas = Partido::getstatsUsuario($partido['id'],$jugador);

                    if($estadisticas){

                        $estadisticasPartido = self::statsfromJugadorEnPartido($estadisticas);
                    
                        //Ademas necesito los datos de ese partido, pero ya los he obtenido antes.
        
                        //Ahora llamaría al metodo mostrar para que se muestre la fila entera de dichas estadisticas.

                        $html .= self::mostrarStatsPartidoJugador($partido,$estadisticasPartido,$partido['id']);
                    }
                }

            }

            $html .="</table>";

        }
        
        return $html;
    }

}
?>