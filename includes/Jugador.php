<?php
namespace es\ucm\fdi;

class Jugador{

    protected $id;

    public function __construct($id){ //OK
        $this->id = $id;
    }

    //Obtener el numero de un jugador
    public static function getNumJugador($jugador){

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT numero FROM jugadores WHERE user = '$jugador'";

        $rs = $conn->query($query);
        $result = false;

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

    public static function getnombreJugador($jugador){

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT nombre,apellido1,apellido2 FROM jugadores WHERE user = '$jugador'";

        $rs = $conn->query($query);
        $result = false;

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

    public static function guardaDatosJugador($jugador){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $sql = "UPDATE jugadores
        SET 
        PJ = PJ + 1,
        MT = MT + {$jugador['segundosjugados']},
        TIT = TIT + ({$jugador['titular']} = 1),
        SUP = SUP + ({$jugador['titular']} = 0),
        MSMS = MSMS + {$jugador['masmenos']},
        T2A = T2A + {$jugador['T2A']},
        T2F = T2F + {$jugador['T2F']},
        T3A = T3A + {$jugador['T3A']},
        T3F = T3F + {$jugador['T3F']},
        TLA = TLA + {$jugador['TLA']},
        TLF = TLF + {$jugador['TLF']},
        FLH = FLH + {$jugador['FLH']} + {$jugador['TEC']},
        FLR = FLR + {$jugador['FLR']},
        RBO = RBO + {$jugador['RBO']},
        RBD = RBD + {$jugador['RBD']},
        ROB = ROB + {$jugador['ROB']},
        TAP = TAP + {$jugador['TAP']},
        PRD = PRD + {$jugador['PRD']},
        AST = AST + {$jugador['AST']}
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
    
        // Promedio Partidos Titular
        if ($usuario['PJ'] > 0) {
            $jugador['TITP'] = number_format(($usuario['TIT'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['TITP'] = 0;
        }
    
        // Más Menos Promedio
        if ($usuario['PJ'] > 0) {
            $jugador['MSMS'] = number_format(($usuario['MSMS'] ?? 0) / ($usuario['PJ'] ?? 0), 2);
        } else {
            $jugador['MSMS'] = 0;
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
    
        // Estadística Avanzada (Aquí agregar las líneas restantes si las hay)
    
        return $jugador;
    }
    
    public static function statsAvanzadasfromJugador($jugador){

        $jugadorAvanzado = array();

        //PORCENTAJES DE USO DE TIRO
        $jugadorAvanzado['T2P'] = number_format((($jugador['T2A'])/($jugador['T2A']+$jugador['T3A']+($jugador['TLA']*0.44))),2);
        $jugadorAvanzado['T3P'] = number_format((($jugador['T3A'])/($jugador['T2A']+$jugador['T3A']+($jugador['TLA']*0.44))),2);
        $jugadorAvanzado['T1P'] = number_format((($jugador['TLA']*0.44)/($jugador['T2A']+$jugador['T3A']+($jugador['TLA']*0.44))),2);

        //PORCENTAJE DE TIRO EFECTIVO: eFG% = (FG + 0.5 * 3P) / FGA
        $jugadorAvanzado['eFGP'] = ((($jugador['T2A']+$jugador['T3A'])+0.5*$jugador['T3A'])/($jugador['TCA']+$jugador['TCF']));

        //TRUE SHOOTING (TS%). 
        //Porcentaje de tiros de campo para un equipo ponderando el tiro de 3 puntos por 1,5 y añadiendo los tiros libres por 0,44. 
        //TS% = PTS / 2(FGA + 0.44 * FTA)
        $jugadorAvanzado['TSP'] = ($jugador['PTS'])/(2*(($jugador['TCA']+$jugador['TCF'])+(0.44*($jugador['TLA'] + $jugador['TLF']))));

        //PORCENTAJE DE ASISTENCIAS (AS%). 
        //Porcentaje de asistencias respecto a los tiros de campo anotados. 
        //La fórmula es: AS% = AS / (2PM + 3PM)
        $jugadorAvanzado['ASP'] = ($jugador['AST'])/(($jugador['T2A'])+($jugador['T3A']));

        //El indicador de uso del jugador (USG%) se calcula con la siguiente expresión, lo usaremos solo en los partidos

        // GmSc - Game Score; the formula is PTS + 0.4 * FG - 0.7 * FGA - 0.4*(FTA - FT) + 0.7 * ORB + 0.3 * DRB + STL + 0.7 * AST + 0.7 * BLK - 0.4 * PF - TOV. 
        // Game Score was created by John Hollinger to give a rough measure of a player's productivity for a single game. 
        // The scale is similar to that of points scored, (40 is an outstanding performance, 10 is an average performance, etc.).

        return $jugadorAvanzado;
    }
    

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Mostrar:
    public static function mostrarStatsJugador($jugador){

        $html = "";

        $html .= "
        <div class='stats'>
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

            <p>Asistencias: {$jugador['AST']}</p>
        </div>    
        ";
        return $html;
    }

    public static function mostrarStatsAvanzadasJugador($jugadorAvanzado){

        $html = "";

        $html .= "
            <p>PORCENTAJES DE USO DE TIRO de 2: {$jugadorAvanzado['T2P']}%</p>
            <p>PORCENTAJES DE USO DE TIRO de 3: {$jugadorAvanzado['T3P']}%</p>
            <p>PORCENTAJES DE USO DE TIRO de 1: {$jugadorAvanzado['T1P']}%</p>
            <p>PORCENTAJE DE TIRO EFECTIVO: {$jugadorAvanzado['eFGP']}%</p>
            <p>TRUE SHOOTING: {$jugadorAvanzado['TSP']}%</p>
            <p>PORCENTAJE DE ASISTENCIAS: {$jugadorAvanzado['ASP']}%</p>
        ";
        return $html;
    }

    //Función para mostrar los datos de los últimos partidos.

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
            
                //Ademas necesito los datos de ese partido, pero ya los he obtenido antes.

                //Ahora llamaría al metodo mostrar para que se muestre la fila entera de dichas estadisticas.

                if($estadisticas){
                    $html .= self::mostrarStatsPartidoJugador($partido,$estadisticas,$partido['id']);
                }
            
            }
        }
        
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
            <td>
            <a href='pagina_partido.php?partido={$partido['visitante']}&fecha={$partido['fecha']}&id={$partidoId}'>
            {$partido['visitante']}
        </a>
            </td>
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

}
