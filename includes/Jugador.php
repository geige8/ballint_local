<?php
namespace es\ucm\fdi;

class Jugador{

    protected $id;

    public function __construct($id){ //OK
        $this->id = $id;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Obtener el numero de un jugador
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

    //Obtener el nombre de un jugador
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

    //Guardar los datos de un jugador al finalizar el partido
    public static function guardaDatosJugador($jugador){

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
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Obtener las estadisticas del jugador
    public static function statsfromJugador($usuario){

        $jugador = array();
    
        // Partidos Jugados
        $jugador['PJ'] = $usuario['PJ'];
    
        // Minutos
        $jugador['MT'] = $usuario['MT'];

        $minutosjugados = floor($usuario['MT'] / 60) ?? 0;
        $segundosRestantes = $usuario['MT'] % 60 ?? 0;
        $tiempoFormato = sprintf("%02d'%02d''", $minutosjugados, $segundosRestantes);
        $jugador['MTT'] = $tiempoFormato;
    
        // Minutos Promedio
        if ($usuario['PJ'] > 0) {
            $segundospromedio = ($usuario['MT'] ?? 0) / ($usuario['PJ'] ?? 0);
            $minutosjugados = floor($segundospromedio / 60);
            $segundosRestantes = $segundospromedio % 60;
            $tiempoFormato = sprintf("%02d:%02d", $minutosjugados, $segundosRestantes);
            $jugador['MTP'] = $tiempoFormato;
        } else {
            $jugador['MTP'] = "00:00";
        }
    
        // Partidos de Titular
        $jugador['TIT'] = $usuario['TIT'];
    
        // Partidos de Suplente
        $jugador['SUP'] = $usuario['SUP'];
    
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

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
            $jugador['eFGP'] = (($jugador['T2A'] + $jugador['T3A'] + 0.5 * $jugador['T3A']) / $total_attempts) * 100;
        } else {
            $jugador['eFGP'] = 0;
        }
        
        // PORCENTAJE DE PÉRDIDAS (TO%)
        // TO% = TO / (FGA + 0.44 * FTA + TO)
        $denominator_TO = ($jugador['TCA'] + $jugador['TCF']) + (0.44 * ($jugador['TLA'] + $jugador['TLF'])) + $jugador['PRD'];

        if ($denominator_TO > 0) {
            $jugador['TOP'] = (($jugador['PRD']) / $denominator_TO) * 100;
        }
        else{
            $jugador['TOP'] = 0;
        }

        // PORCENTAJE DE TIRO LIBRE RESPECTO AL TIRO DE CAMPO (FTM/FGA).
        // La fórmula es: FTM/FGA
        $denominator_TLP = $jugador['TCA'] + $jugador['TCF'];

        if ($denominator_TLP > 0) {
            $jugador['TLP'] = ($jugador['TCA'] / $denominator_TLP) * 100;
        } else {
            $jugador['TLP'] = 0;
        }


        // TRUE SHOOTING (TS%).
        // Porcentaje de tiros de campo para un equipo ponderando el tiro de 3 puntos por 1,5 y añadiendo los tiros libres por 0,44.
        // TS% = PTS / 2(FGA + 0.44 * FTA)
        $total_field_attempts = $jugador['TCA'] + $jugador['TCF'];
        $total_free_attempts = $jugador['TLA'] + $jugador['TLF'];
        if (($total_field_attempts + 0.44 * $total_free_attempts) > 0) {
            $jugador['TSP'] = ($jugador['PTS']) / (2 * ($total_field_attempts + 0.44 * $total_free_attempts)) * 100;
        } else {
            $jugador['TSP'] = 0;
        }

        // PORCENTAJE DE ASISTENCIAS (AS%).
        // Porcentaje de asistencias respecto a los tiros de campo anotados.
        // La fórmula es: AS% = AS / (2PM + 3PM)
        $total_field_made = $jugador['T2A'] + $jugador['T3A'];
        if ($total_field_made > 0) {
            $jugador['ASP'] = ($jugador['AST']) / $total_field_made * 100;
        } else {
            $jugador['ASP'] = 0;
        }

        //El indicador de uso del jugador (USG%) se calcula con la siguiente expresión, lo usaremos solo en los partidos
        //$jugador['PUSO'] = (((($jugador['TCA']+$jugador['TCF'])+(0.44*($jugador['TLA'] + $jugador['TLF']))+$jugador['PRD'])*($equipo['MT']/5))/(($jugador['MT'])*(($equipo['TCA']+$equipo['TCF'])+(0.44*($equipo['TLA'] + $equipo['TLF']))+$equipo['PRD'])))*100;
        
        // GmSc - Game Score; the formula is PTS + 0.4 * FG - 0.7 * FGA - 0.4*(FTA - FT) + 0.7 * ORB + 0.3 * DRB + STL + 0.7 * AST + 0.7 * BLK - 0.4 * PF - TOV. 
        // Game Score was created by John Hollinger to give a rough measure of a player's productivity for a single game. 
        // The scale is similar to that of points scored, (40 is an outstanding performance, 10 is an average performance, etc.).
        $jugador['GS'] = ($jugador['PTS']+0.4*$jugador['TCA']-0.7*($jugador['TCA']+$jugador['TCF'])-0.4*$jugador['TCF']+0.7*$jugador['RBO']+0.3*$jugador['RBD']+$jugador['ROB']+0.7*$jugador['AST']+0.7* $jugador['TAP']-0.4*$jugador['FLH']-$jugador['PRD']);

        //VALORACION

        $jugador['VAL'] = $jugador['PTS']+$jugador['REB']+$jugador['AST']+$jugador['ROB']+$jugador['FLR']+$jugador['TAP']-$jugador['TCF']-$jugador['PRD']-$jugador['FLH'];

        if ($usuario['PJ'] > 0) {
            $jugador['VALP'] = number_format(($jugador['VAL'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['VALP'] = 0;
        }
        
        return $jugador;
    }  

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
            $jugador['T2P'] = number_format(($usuario['T2A'] / ($usuario['T2A'] + $usuario['T2F'])) * 100, 2);
        } else {
            $jugador['T2P'] = 0;
        }
    
        // Tiros de tres
        $jugador['T3A'] = $usuario['T3A'];
        $jugador['T3F'] = $usuario['T3F'];
        if (($usuario['T3A'] + $usuario['T3F']) > 0) {
            $jugador['T3P'] = number_format(($usuario['T3A'] / ($usuario['T3A'] + $usuario['T3F'])) * 100, 2);
        } else {
            $jugador['T3P'] = 0;
        }
    
        // Tiros Libres
        $jugador['TLA'] = $usuario['TLA'];
        $jugador['TLF'] = $usuario['TLF'];
        if (($usuario['TLA'] + $usuario['TLF']) > 0) {
            $jugador['TLP'] = number_format(($usuario['TLA'] / ($usuario['TLA'] + $usuario['TLF'])) * 100, 2);
        } else {
            $jugador['TLP'] = 0;
        }
    
        // Tiros de Campo
        $jugador['TCA'] = $usuario['T2A'] + $usuario['T3A'];
        $jugador['TCF'] = $usuario['T2F'] + $usuario['T3F'];
        if (($jugador['TCA'] + $jugador['TCF']) > 0) {
            $jugador['TCP'] = number_format(($jugador['TCA'] / ($jugador['TCA'] + $jugador['TCF'])) * 100, 2);
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
            $jugador['eFGP'] = (($jugador['T2A'] + $jugador['T3A'] + 0.5 * $jugador['T3A']) / $total_attempts) * 100;
        } else {
            $jugador['eFGP'] = 0;
        }

        // TRUE SHOOTING (TS%).
        // Porcentaje de tiros de campo para un equipo ponderando el tiro de 3 puntos por 1,5 y añadiendo los tiros libres por 0,44.
        // TS% = PTS / 2(FGA + 0.44 * FTA)
        $total_field_attempts = $jugador['TCA'] + $jugador['TCF'];
        $total_free_attempts = $jugador['TLA'] + $jugador['TLF'];
        if (($total_field_attempts + 0.44 * $total_free_attempts) > 0) {
            $jugador['TSP'] = ($jugador['PTS']) / (2 * ($total_field_attempts + 0.44 * $total_free_attempts)) * 100;
        } else {
            $jugador['TSP'] = 0;
        }

        // PORCENTAJE DE ASISTENCIAS (AS%).
        // Porcentaje de asistencias respecto a los tiros de campo anotados.
        // La fórmula es: AS% = AS / (2PM + 3PM)
        $total_field_made = $jugador['T2A'] + $jugador['T3A'];
        if ($total_field_made > 0) {
            $jugador['ASP'] = ($jugador['AST']) / $total_field_made * 100;
        } else {
            $jugador['ASP'] = 0;
        }

        //El indicador de uso del jugador (USG%) se calcula con la siguiente expresión, lo usaremos solo en los partidos
        //$jugador['PUSO'] = (((($jugador['TCA']+$jugador['TCF'])+(0.44*($jugador['TLA'] + $jugador['TLF']))+$jugador['PRD'])*($equipo['MT']/5))/(($jugador['MT'])*(($equipo['TCA']+$equipo['TCF'])+(0.44*($equipo['TLA'] + $equipo['TLF']))+$equipo['PRD'])))*100;
        
        // GmSc - Game Score; the formula is PTS + 0.4 * FG - 0.7 * FGA - 0.4*(FTA - FT) + 0.7 * ORB + 0.3 * DRB + STL + 0.7 * AST + 0.7 * BLK - 0.4 * PF - TOV. 
        // Game Score was created by John Hollinger to give a rough measure of a player's productivity for a single game. 
        // The scale is similar to that of points scored, (40 is an outstanding performance, 10 is an average performance, etc.).
        $jugador['GS'] = ($jugador['PTS']+0.4*$jugador['TCA']-0.7*($jugador['TCA']+$jugador['TCF'])-0.4*$jugador['TCF']+0.7*$jugador['RBO']+0.3*$jugador['RBD']+$jugador['ROB']+0.7*$jugador['AST']+0.7* $jugador['TAP']-0.4*$jugador['FLH']-$jugador['PRD']);

        //VALORACION

        $jugador['VAL'] = $jugador['PTS']+$jugador['REB']+$jugador['AST']+$jugador['ROB']+$jugador['FLR']+$jugador['TAP']-$jugador['TCF']-$jugador['PRD']-$jugador['FLH'];
        
        return $jugador;
    }  

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //MOSTRAR:
    public static function mostrarStatsJugador($jugador){

        $html = "";

        $html .= "
        <div class='stats'>
            <p>Partidos Jugados: {$jugador['PJ']}</p>
            <p>Minutos Totales: {$jugador['MTT']}</p>
            <p>Minutos Promedio: {$jugador['MTP']}</p>

            <p>Partidos Titular: {$jugador['TIT']}</p>
            <p>Partidos Suplente: {$jugador['SUP']}</p>

            <p>+/-: {$jugador['MSMS']}</p>
            <p>+/- PP: {$jugador['MSMSP']}</p>

            <p>PTS: {$jugador['PTS']}</p>
            <p>PPP: {$jugador['PTSP']}</p>

            <p>T2A: {$jugador['T2A']}</p>
            <p>T2A: {$jugador['T2P']}%</p>
            <p>T2A PP: {$jugador['T2PP']}</p>

            <p>T3A: {$jugador['T3A']}</p>
            <p>T3A: {$jugador['T3P']}%</p>
            <p>T3A PP: {$jugador['T3PP']}</p>

            <p>TLA: {$jugador['TLA']}</p>
            <p>TLA: {$jugador['TLP']}%</p>
            <p>TLA PP: {$jugador['TLPP']}</p>

            <p>TCA: {$jugador['TCA']}</p>
            <p>%TCA: {$jugador['TCP']}%</p>
            <p>TCA PP: {$jugador['TCPP']}</p>

            <p>FP: {$jugador['FLH']}</p>
            <p>FP PP: {$jugador['FLHP']}</p>

            <p>FR: {$jugador['FLR']}</p>
            <p>FR PP: {$jugador['FLRP']}</p>

            <p>TEC: {$jugador['TEC']}</p>
            <p>TEC PP: {$jugador['TEC']}</p>

            <p>RBO: {$jugador['RBO']}</p>
            <p>RBO PP: {$jugador['RBOP']}</p>
            
            <p>RBD: {$jugador['RBD']}</p>
            <p>RBD PP: {$jugador['RBDP']}</p>

            <p>RBT: {$jugador['REB']}</p>
            <p>RBT PP: {$jugador['REBP']}</p>

            <p>ROB: {$jugador['ROB']}</p>
            <p>ROB PP: {$jugador['ROBP']}</p>

            <p>TAP: {$jugador['TAP']}</p>
            <p>TAP PP: {$jugador['TAPP']}</p>

            <p>PRD: {$jugador['PRD']}</p>
            <p>PRD PP: {$jugador['PRDP']}</p>

            <p>AST: {$jugador['AST']}</p>
            <p>AST PP: {$jugador['ASTP']}</p>

            <p>Puntos en Q1: {$jugador['PTQ1']}</p>
            <p>Puntos en Q1 PP: {$jugador['PTQ1P']}</p>

            <p>Puntos en Q2:  {$jugador['PTQ2']}</p>
            <p>Puntos en Q2 PP: {$jugador['PTQ2P']}</p>

            <p>Puntos en Q3: {$jugador['PTQ3']}</p>
            <p>Puntos en Q3 PP: {$jugador['PTQ3P']}</p>

            <p>Puntos en Q4:  {$jugador['PTQ4']}</p>
            <p>Puntos en Q4 PP: {$jugador['PTQ4P']}</p>

            <p>Puntos en EXTRA:  {$jugador['PTQE']}</p>
            <p>Puntos en EXTRA PP: {$jugador['PTQEP']}</p>

            <p>Valoración:  {$jugador['VAL']}</p>
            <p>Valoración PP: {$jugador['VALP']}</p>

        </div>    
        ";
        return $html;
    }

    public static function mostrarStatsAreasdeMejoraJugador($jugador){

        $html = "<div class='stats'>";


            // Verificar y agregar el mensaje para T2P
            if ($jugador['T2P'] <= 30) {
                $html .= "<p>%T2A: {$jugador['T2P']}% - Tiene que mejorar</p>";
            }
            if ($jugador['T3P'] <= 30) {
                $html .= "<p>%T3A: {$jugador['T3P']}% - Tiene que mejorar</p>";
            }
            if ($jugador['TLP'] <= 30) {
                $html .= "<p>%TLA: {$jugador['TLP']}% - Tiene que mejorar</p>";
            }
            if ($jugador['TCP'] <= 30) {
                $html .= "<p>%TCA: {$jugador['TCP']}% - Tiene que mejorar</p>";
            }

            /////

            if ($jugador['FLHP'] >= 3) {
                $html .= "<p>FLHP: {$jugador['FLHP']} - Tiene que mejorar</p>";
            }
            if ($jugador['FLRP'] <= 1) {
                $html .= "<p>%FLRP: {$jugador['FLRP']}% - Tiene que mejorar</p>";
            }

            ///////

            if ($jugador['RBOP'] < 1 ) {
                $html .= "<p>RBOP: {$jugador['RBOP']} - Tiene que mejorar</p>";
            }
            if ($jugador['RBDP'] < 3) {
                $html .= "<p>%RBDP: {$jugador['RBDP']}% - Tiene que mejorar</p>";
            } 
            if ($jugador['REBP'] < 3) {
                $html .= "<p>REBP: {$jugador['REBP']} - Tiene que mejorar</p>";
            }

            ////////

            if ($jugador['ROBP'] <= 1) {
                $html .= "<p>ROBP: {$jugador['ROBP']} - Tiene que mejorar</p>";
            } 
            if ($jugador['TAPP'] <= 0.2) {
                $html .= "<p>%TAPP: {$jugador['TAPP']} - Tiene que mejorar</p>";
            } 
            if ($jugador['PRDP'] >= 2) {
                $html .= "<p>%PRDP: {$jugador['PRDP']} - Tiene que mejorar</p>";
            } 
            if ($jugador['ASTP'] <= 1) {
                $html .= "<p>ASTP: {$jugador['ASTP']} - Tiene que mejorar</p>";
            } 


        $html .= "</div>";
        return $html;
    }

    public static function mostrarStatsAvanzadasJugador($jugadorAvanzado){

        $html = "";

        $html .= "
            <p>PORCENTAJES DE USO DE TIRO de 2: {$jugadorAvanzado['T2PU']}%</p>
            <p>PORCENTAJES DE USO DE TIRO de 3: {$jugadorAvanzado['T3PU']}%</p>
            <p>PORCENTAJES DE USO DE TIRO de 1: {$jugadorAvanzado['T1PU']}%</p>
            <p>PORCENTAJE DE TIRO EFECTIVO: {$jugadorAvanzado['eFGP']}%</p>
            <p>TRUE SHOOTING: {$jugadorAvanzado['TSP']}%</p>
            <p>PORCENTAJE DE ASISTENCIAS: {$jugadorAvanzado['ASP']}%</p>
            <p>PORCENTAJE DE PERDIDAS: {$jugadorAvanzado['TOP']}%</p>
            <p>PORCENTAJE DE TIRO LIBRE RESPECTO AL TIRO DE CAMPO: {$jugadorAvanzado['TLP']}%</p>
            <p>GAME SCORE: {$jugadorAvanzado['GS']}%</p>

        ";
        return $html;
    }

    public static function mostrarStatsPartidoJugador($partido,$estadisticas,$partidoId){


        $html = "";

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
                </tr>
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
                </tr>
            </table>";
        return $html;
    }

    public static function mostrarUltimosPartidosJugador($jugador){

        $html = "";

        $idUser = Usuario::getidNombreUser($jugador);

        $equiposdelUsuario = Equipo::getEquiposfromUserId($idUser);

        foreach($equiposdelUsuario as $equipo){

            //Para cada equipo al que pertenezca quiero mostrar los partidos.
            //Tengo que obtener el id de cada partido de ese equipo
            
            $partidos = Partido::getpartidosfromEquipo($equipo);

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
        
        return $html;
    }

}
