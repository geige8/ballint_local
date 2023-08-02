<?php
namespace es\ucm\fdi;

class Equipo{


    protected $id;
    protected $nombre;
    protected $seccion;


    public function __construct($id,$nombre, $seccion){ //OK
        $this->id = $id;
        $this->nombre = $nombre;
        $this->seccion = $seccion;
    }
///////////////////////////////////////////////////////////////
    //Registro

    public static function registrarEquipo($categoria_equipo,$seccion_equipo,$letra_equipo){
        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $idEquipo = $categoria_equipo .  $seccion_equipo;
        $nombreEquipo = 'Liceo Frances ' . $categoria_equipo . ' ' . $seccion_equipo;

        $query = "INSERT INTO equipos (id_equipo,categoria,nombre_equipo,seccion,letra)  VALUES ('$idEquipo','$categoria_equipo','$nombreEquipo','$seccion_equipo','$letra_equipo')"; 

        $rs = $conn->query($query);

        if (!$rs) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//GETTERS

    //Obtener los id_equipo(NacionalMasculino) de todos los equipos
    public static function getListadoEquipos(){

        $equipos = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        $sql = "SELECT id_equipo FROM equipos";

        if ($resultado = $conn->query($sql)) {

            while ($fila = $resultado->fetch_assoc()) {
                $equipos[] = $fila['id_equipo'];
            }
            $resultado->free();
        }

        return $equipos;

    }

    //Obtener todos los datos de un equipo
    public static function getDatosEquipo($equipo){

        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM equipos WHERE id_equipo='%s'", $conn->real_escape_string($equipo));
        $rs = $conn->query($query);

        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = $fila;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //Obtener el nombre completo de un equipo basado en su id_equipo(NacionalMasculino)
    public static function getNombreEquipo($idEquipoLocal){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT nombre_equipo FROM equipos WHERE id_equipo = '%s'", $conn->real_escape_string($idEquipoLocal));

        $rs = $conn->query($query);

        $result = false;

        $equipos = array();

            if ($rs) {
                while ($row = $rs->fetch_assoc()) {
                    $equipos = $row['nombre_equipo'];
                }
                $result = $equipos;
                $rs->free();
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }

        return $result;
    }

    //Obtener el id (1,2,3) de un equipo basado en su id_equipo(NacionalMasculino)
    public static function getidEquipo($equipo_id){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT id FROM equipos WHERE id_equipo = '%s'", $conn->real_escape_string($equipo_id));

        $rs = $conn->query($query);

        $result = false;

        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = $fila['id'];
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }   
    
    //Obtener los equipos para un Id de Usuario (1,2,3)
    public static function getEquiposfromUserId($idUser){

      $conn = Aplicacion::getInstance()->getConexionBd();

      $query = sprintf("SELECT id_equipo
      FROM usuarios_equipos
      JOIN equipos ON usuarios_equipos.equipo_id = equipos.id
      WHERE usuarios_equipos.usuario_id = '%s'", $conn->real_escape_string($idUser));

      $rs = $conn->query($query);

      $result = false;

      $equipos = array();

      if ($rs) {
        while ($row = $rs->fetch_assoc()) {
            $equipos[] = $row['id_equipo'];
        }
        $result = $equipos;
        $rs->free();
      } else {
          error_log("Error BD ({$conn->errno}): {$conn->error}");
      }
      return $result;
    }

    //Obtener las estadisticas de un Equipo
    public static function datosfromEquipo($equipo){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM equipos WHERE id_equipo = '$equipo'");

        $rs = $conn->query($query);

        if ($rs) {
            $row = $rs->fetch_assoc();
            $result = $row;
            $rs->free();
        } 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

//////////////////////////////////////////////////////////////////////////////////
//MANEJO TABLA EQUIPOS

    public static function guardaDatosJugadorenEquipo($jugador){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $sql = "UPDATE equipos
        SET 
        MT = MT + {$jugador['MT']},
        MSMS = MSMS + ({$jugador['MSMS']}/5),
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
        WHERE id_equipo = '{$jugador['equipo']}'";

        $resultado = $conn->query($sql);

        if (!$resultado) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        return $resultado;
    }

    public static function addpartidojugado($equipo){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE equipos SET PJ = PJ + 1 WHERE id_equipo = '%s'", $conn->real_escape_string($equipo));

        $resultado = $conn->query($query);

        if (!$resultado) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        return $result;
    }

    public static function addpartidoganado($equipo,$idPartido){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE equipos SET W = W + 1 WHERE id_equipo = '%s'", $conn->real_escape_string($equipo));
        
        $resultado = $conn->query($query);

        if (!$resultado) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        $query = sprintf("UPDATE partidos SET WL = 1 WHERE id = '%s'", $conn->real_escape_string($idPartido));

        $resultado = $conn->query($query);

        if (!$resultado) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        return $result;
    }

    public static function addpartidoperdido($equipo,$idPartido){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE equipos SET L = L + 1 WHERE id_equipo = '%s'", $conn->real_escape_string($equipo));
       
        $resultado = $conn->query($query);

        if (!$resultado) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        $query = sprintf("UPDATE partidos SET WL = 1 WHERE id = '%s'", $conn->real_escape_string($idPartido));

        $resultado = $conn->query($query);

        if (!$resultado) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        return $result;
    }

    public static function getJugadoresEquipo($equipo_id){

        $id_equipo = self::getidEquipo($equipo_id);

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT user,nombre,apellido1,apellido2,numero
        FROM jugadores 
        INNER JOIN usuarios_equipos 
        ON jugadores.id = usuarios_equipos.usuario_id  
        WHERE usuarios_equipos.equipo_id = '$id_equipo'");

        $rs = $conn->query($query);

        $result = false;
        $jugadores = array();
            if ($rs) {
                $i = 0;
                while ($row = $rs->fetch_assoc()) {
                    $jugadores[$i] = array(
                        'user' => $row['user'],
                        'nombre' => $row['nombre'],
                        'apellido1' => $row['apellido1'],
                        'apellido2' => $row['apellido2'],
                        'numero' => $row['numero']

                    );
                    $i++;
                }
                $result = $jugadores;
                $rs->free();
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        return $result;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ESTADISTICAS DE LOS EQUIPOS:
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Obtener las estadisticas del jugador
    public static function statsfromEquipo($team){

        $equipo = array();
    
        // Partidos Jugados
        $equipo['PJ'] = $team['PJ'];
    
        // Minutos
        $minutosjugados = floor($team['MT'] / 60) ?? 0;
        $segundosRestantes = $team['MT'] % 60 ?? 0;
        $tiempoFormato = sprintf("%02d:%02d", $minutosjugados, $segundosRestantes);
        $equipo['MT'] = $tiempoFormato;
    
        // Minutos Promedio
        if ($team['PJ'] > 0) {
            $segundospromedio = ($team['MT'] ?? 0) / ($team['PJ'] ?? 0);
            $minutosjugados = floor($segundospromedio / 60);
            $segundosRestantes = $segundospromedio % 60;
            $tiempoFormato = sprintf("%02d:%02d", $minutosjugados, $segundosRestantes);
            $equipo['MTP'] = $tiempoFormato;
        } else {
            $equipo['MTP'] = "00:00";
        }
    
        // Más Menos Promedio
        if ($team['PJ'] > 0) {
            $equipo['MSMS'] = number_format(($team['MSMS'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['MSMS'] = 0;
        }
    
        // Puntos
        $equipo['PPP'] = $team['PPP'];

        // Puntos Promedio
        if ($team['PJ'] > 0) {
            $equipo['PTSP'] = number_format(($equipo['PPP'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['PTSP'] = 0;
        }

        $equipo['PPR'] = $team['PPR'];
        // Puntos Recibidos Promedio
        if ($team['PJ'] > 0) {
            $equipo['PTSPR'] = number_format(($equipo['PPR'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['PTSPR'] = 0;
        }
    
        // Tiros de dos
        $equipo['T2A'] = $team['T2A'];
        $equipo['T2F'] = $team['T2F'];
        if (($team['T2A'] + $team['T2F']) > 0) {
            $equipo['T2P'] = number_format(($team['T2A'] / ($team['T2A'] + $team['T2F'])) * 100, 2);
        } else {
            $equipo['T2P'] = 0;
        }
        if ($team['PJ'] > 0) {
            $equipo['T2PP'] = number_format(($equipo['T2A'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['T2PP'] = 0;
        }
    
        // Tiros de tres
        $equipo['T3A'] = $team['T3A'];
        $equipo['T3F'] = $team['T3F'];
        if (($team['T3A'] + $team['T3F']) > 0) {
            $equipo['T3P'] = number_format(($team['T3A'] / ($team['T3A'] + $team['T3F'])) * 100, 2);
        } else {
            $equipo['T3P'] = 0;
        }
        if ($team['PJ'] > 0) {
            $equipo['T3PP'] = number_format(($equipo['T3A'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['T3PP'] = 0;
        }
    
        // Tiros Libres
        $equipo['TLA'] = $team['TLA'];
        $equipo['TLF'] = $team['TLF'];
        if (($team['TLA'] + $team['TLF']) > 0) {
            $equipo['TLP'] = number_format(($team['TLA'] / ($team['TLA'] + $team['TLF'])) * 100, 2);
        } else {
            $equipo['TLP'] = 0;
        }
        if ($team['PJ'] > 0) {
            $equipo['TLPP'] = number_format(($equipo['TLA'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['TLPP'] = 0;
        }
    
        // Tiros de Campo
        $equipo['TCA'] = $team['T2A'] + $team['T3A'];
        $equipo['TCF'] = $team['T2F'] + $team['T3F'];
        if (($equipo['TCA'] + $equipo['TCF']) > 0) {
            $equipo['TCP'] = number_format(($equipo['TCA'] / ($equipo['TCA'] + $equipo['TCF'])) * 100, 2);
        } else {
            $equipo['TCP'] = 0;
        }
        if ($team['PJ'] > 0) {
            $equipo['TCPP'] = number_format(($equipo['TCA'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['TCPP'] = 0;
        }
    
        // Faltas Hechas
        $equipo['FLH'] = $team['FLH'];
        if ($team['PJ'] > 0) {
            $equipo['FLHP'] = number_format(($equipo['FLH'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['FLHP'] = 0;
        }
    
        // Faltas Recibidas
        $equipo['FLR'] = $team['FLR'];
        if ($team['PJ'] > 0) {
            $equipo['FLRP'] = number_format(($equipo['FLR'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['FLRP'] = 0;
        }
    
        // Rebotes Partido
        $equipo['REB'] = $team['RBO'] + $team['RBD'];
        if ($team['PJ'] > 0) {
            $equipo['REBP'] = number_format(($equipo['REB'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['REBP'] = 0;
        }
    
        // Rebotes Ofensivos
        $equipo['RBO'] = $team['RBO'];
        if ($team['PJ'] > 0) {
            $equipo['RBOP'] = number_format(($equipo['RBO'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['RBOP'] = 0;
        }
    
        // Rebotes Defensivos
        $equipo['RBD'] = $team['RBD'];
        if ($team['PJ'] > 0) {
            $equipo['RBDP'] = number_format(($equipo['RBD'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['RBDP'] = 0;
        }
    
        // Robos Partido
        $equipo['ROB'] = $team['ROB'];
        if ($team['PJ'] > 0) {
            $equipo['ROBP'] = number_format(($equipo['ROB'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['ROBP'] = 0;
        }
    
        // Tapones Partido
        $equipo['TAP'] = $team['TAP'];
        if ($team['PJ'] > 0) {
            $equipo['TAPP'] = number_format(($equipo['TAP'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['TAPP'] = 0;
        }
    
        // Pérdida Partido
        $equipo['PRD'] = $team['PRD'];
        if ($team['PJ'] > 0) {
            $equipo['PRDP'] = number_format(($equipo['PRD'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['PRDP'] = 0;
        }
    
        // Asistencias Partido
        $equipo['AST'] = $team['AST'];
        if ($team['PJ'] > 0) {
            $equipo['ASTP'] = number_format(($equipo['AST'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['ASTP'] = 0;
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //ESTADISTICA AVANZADA

        // Puntos de Titular
        $equipo['TIT'] = $team['TIT']; //Llamar a función que obtenga eso

        //Puntos de Suplente
        $equipo['SUP'] = $team['SUP']; //Llamar a función que obtenga eso
    
        // Promedio Partidos Titular
        if ($team['PJ'] > 0) {
            $equipo['TITP'] = number_format(($team['TIT'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['TITP'] = 0;
        }

        //Puntos Por Cuartos
        $equipo['PTQ1'] = $team['PTQ1'];
        $equipo['PTQ2'] = $team['PTQ2'];
        $equipo['PTQ3'] = $team['PTQ3'];
        $equipo['PTQ4'] = $team['PTQ4'];
        $equipo['PTQE'] = $team['PTQE'];

        if ($team['PJ'] > 0) {
            $equipo['PTQ1P'] = number_format(($equipo['PTQ1'] ?? 0) / ($team['PJ'] ?? 0), 2);
            $equipo['PTQ2P'] = number_format(($equipo['PTQ2'] ?? 0) / ($team['PJ'] ?? 0), 2);
            $equipo['PTQ3P'] = number_format(($equipo['PTQ3'] ?? 0) / ($team['PJ'] ?? 0), 2);
            $equipo['PTQ4P'] = number_format(($equipo['PTQ4'] ?? 0) / ($team['PJ'] ?? 0), 2);
            $equipo['PTQEP'] = number_format(($equipo['PTQE'] ?? 0) / ($team['PJ'] ?? 0), 2);

        } else {
            $equipo['PTQ1P'] = 0;
            $equipo['PTQ2P'] = 0;
            $equipo['PTQ3P'] = 0;
            $equipo['PTQ4P'] = 0;
            $equipo['PTQEP'] = 0;
        }

        //PORCENTAJES DE USO DE TIRO
        $equipo['T2PU'] = number_format((($equipo['T2A'])/($equipo['T2A']+$equipo['T3A']+($equipo['TLA']*0.44))),2)*100;
        $equipo['T3PU'] = number_format((($equipo['T3A'])/($equipo['T2A']+$equipo['T3A']+($equipo['TLA']*0.44))),2)*100;
        $equipo['T1PU'] = number_format((($equipo['TLA']*0.44)/($equipo['T2A']+$equipo['T3A']+($equipo['TLA']*0.44))),2)*100;

        //PORCENTAJE DE TIRO EFECTIVO: eFG% = (FG + 0.5 * 3P) / FGA
        $equipo['eFGP'] = ((($equipo['T2A']+$equipo['T3A'])+0.5*$equipo['T3A'])/($equipo['TCA']+$equipo['TCF']))*100;

        //PORCENTAJE DE REBOTE OFENSIVO (%OR)
        //OR% = ORB / (ORB + Opp DRB)
        //$equipoAvanzado['ORP'] =

        //PORCENTAJE DE PÉRDIDAS (TO%)
        //TO% = TO / (FGA + 0.44 * FTA + TO)
        $equipo['TOP'] = (($equipo['PRD'])/(($equipo['TCA'] + $equipo['TCF'])+ (0.44*($equipo['TLA'] + $equipo['TLF'])) + $equipo['PRD']))*100;

        //PORCENTAJE DE TIRO LIBRE RESPECTO AL TIRO DE CAMPO (FTM/FGA). 
        //La fórmula es: FTM/FGA
        $equipo['TLP'] = ($equipo['TCA']/($equipo['TCA'] + $equipo['TCF']))*100;

        //TRUE SHOOTING (TS%). 
        //Porcentaje de tiros de campo para un equipo ponderando el tiro de 3 puntos por 1,5 y añadiendo los tiros libres por 0,44. 
        //TS% = PTS / 2(FGA + 0.44 * FTA)
        $equipo['TSP'] = ($equipo['PTS'])/(2*(($equipo['TCA']+$equipo['TCF'])+(0.44*($equipo['TLA'] + $equipo['TLF']))))*100;

        //PORCENTAJE DE ASISTENCIAS (AS%). 
        //Porcentaje de asistencias respecto a los tiros de campo anotados. 
        //La fórmula es: AS% = AS / (2PM + 3PM)
        $equipo['ASP'] = ($equipo['AST'])/(($equipo['T2A'])+($equipo['T3A']))*100;

        //Posesiones
        //Pos = FGA + TO - OR + (FTA*0.44)
        $equipo['POS'] = 0.96*(($equipo['TCA'] + $equipo['TCF']) + $equipo['PRD'] - $equipo['RBO'] + (($team['TLA'] + $team['TLF'])*0.44));

        //OER (OFFENSIVE EFFICIENCY RATING): 
        //La fórmula es: OER  = PTS / POS
        $equipo['OER'] = ($equipo['PPP']/$equipo['POS'])*100;

        //DER (DEFENSIVE EFFICIENCY RATING)
        //La fórmula es: DER = PTS / POS
        $equipo['DER'] = ($equipo['PPR']/$equipo['POS'])*100;

        //Ritmo
        $equipo['PACE']=($equipo['PPP']/$equipo['POS'])*100;

        
        return $equipo;
    }  


///////////////////////////////////////////////////////////////
//MOSTRAR:

    public static function mostrarStatsEquipo($equipo){

        $statsequipo = self::datosfromEquipo($equipo);

        $html = "";
        $html .= "
        <table>
            <tr>
                <th>PJ</th>
                <th>MT</th>
                <th>MSMS</th>
                <th>T2A</th>
                <th>T2F</th>
                <th>T3A</th>
                <th>T3F</th>
                <th>TLA</th>
                <th>TLF</th>
                <th>FLH</th>
                <th>FLR</th>
                <th>RBO</th>
                <th>RBD</th>
                <th>ROB</th>
                <th>TAP</th>
                <th>PRD</th>
                <th>AST</th>
            </tr>
            <tr>
                <td>{$statsequipo['PJ']}</td>
                <td>{$statsequipo['MT']}</td>
                <td>{$statsequipo['MSMS']}</td>
                <td>{$statsequipo['T2A']}</td>
                <td>{$statsequipo['T2F']}</td>
                <td>{$statsequipo['T3A']}</td>
                <td>{$statsequipo['T3F']}</td>
                <td>{$statsequipo['TLA']}</td>
                <td>{$statsequipo['TLF']}</td>
                <td>{$statsequipo['FLH']}</td>
                <td>{$statsequipo['FLR']}</td>
                <td>{$statsequipo['RBO']}</td>
                <td>{$statsequipo['RBD']}</td>
                <td>{$statsequipo['ROB']}</td>
                <td>{$statsequipo['TAP']}</td>
                <td>{$statsequipo['PRD']}</td>
                <td>{$statsequipo['AST']}</td>
            </tr>
        </table>";
        return $html;
    }

    public static function mostrarlistajugadoresEquipo($equipo) {

        $listaJugadores = self::getJugadoresEquipo($equipo);

        $html = "";
        $i = 1;
        $html .= "
            <table>
                <tr>
                    <th> </th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Apellido 1</th>
                    <th>Apellido 2</th>
                </tr>";

        foreach ($listaJugadores as $jugador) {
            $html .= "
                <tr>
                    <td>{$i}</td>
                    <td>
                        <a href='pagina_perfiljugador.php?jugador={$jugador['user']}'>
                            {$jugador['user']}
                        </a>
                    </td>
                    <td>{$jugador['nombre']}</td>
                    <td>{$jugador['apellido1']}</td>
                    <td>{$jugador['apellido2']}</td>
                </tr>";
            $i++;
        }
        
        $html .= "</table>";
        return $html;
    }

    public static function mostrarListadoEquipos($equipos){

        
        $html = '';
        foreach ($equipos as $equipo) {
            $html .= self::mostrarCajaEquipo($equipo);
        }

        return $html;
    }

    public static function mostrarCajaEquipo($equipo){

        $datosEquipo = self::getDatosEquipo($equipo);
        $html = '';
        $html .= <<<EOS
            <div class="equipo">
                <a href="pagina_equipo.php?equipo={$equipo}">
                    <p>{$datosEquipo['nombre_equipo']}</p>
                </a>
            </div>
        EOS;

        return $html;
    }

    public static function mostrarStatsPartidoEquipo($partido, $estadisticas,$partidoId) {

        $html = "";
        $html .= "
            <tr>
                <td>
                    <a href='pagina_partido.php?partido={$partido['visitante']}&fecha={$partido['fecha']}&id={$partidoId}'>
                        {$partido['visitante']}
                    </a>
                </td>
                <td>{$partido['fecha']}</td>
                <td>{$estadisticas['timeouts']}</td>
                <td>{$estadisticas['faltasbanquillo']}</td>
                <td>{$estadisticas['puntos']}</td>
                <td>{$estadisticas['lider']}</td>
                <td>{$estadisticas['empate']}</td>
                <td>{$estadisticas['alternancias']}</td>
                <td>{$estadisticas['vecesempatados']}</td>
                <td>{$estadisticas['veceslider']}</td>
                <td>{$estadisticas['PTQ1']}</td>
                <td>{$estadisticas['PTQ2']}</td>
                <td>{$estadisticas['PTQ3']}</td>
                <td>{$estadisticas['PTQ4']}</td>
                <td>{$estadisticas['PTQE']}</td>
            </tr>";
        return $html;
    }

    public static function mostrarStatsPartidoporEquipos($estadisticas) {

        $html = "";
        $html .= "
        <table>
            <tr>
                <th>Equipo</th>
                <th>Puntos</th>
                <th>Timeouts</th>
                <th>Faltas Banquillo</th>
                <th>Puntos</th>
                <th>Líder</th>
                <th>Empate</th>
                <th>Alternancias</th>
                <th>Veces Empatados</th>
                <th>Veces Líder</th>
                <th>PTQ1</th>
                <th>PTQ2</th>
                <th>PTQ3</th>
                <th>PTQ4</th>
                <th>PTQE</th>
            </tr>";

        foreach ($estadisticas as $equipoStats) {
            $puntos = $equipoStats['PTQ1'] + $equipoStats['PTQ2'] + $equipoStats['PTQ3'] + $equipoStats['PTQ4'] + $equipoStats['PTQE'];
            $html .= "
            <tr>
                <td>{$equipoStats['equipo']}</td>
                <td>{$puntos}</td>
                <td>{$equipoStats['timeouts']}</td>
                <td>{$equipoStats['faltasbanquillo']}</td>
                <td>{$equipoStats['puntos']}</td>
                <td>{$equipoStats['lider']}</td>
                <td>{$equipoStats['empate']}</td>
                <td>{$equipoStats['alternancias']}</td>
                <td>{$equipoStats['vecesempatados']}</td>
                <td>{$equipoStats['veceslider']}</td>
                <td>{$equipoStats['PTQ1']}</td>
                <td>{$equipoStats['PTQ2']}</td>
                <td>{$equipoStats['PTQ3']}</td>
                <td>{$equipoStats['PTQ4']}</td>
                <td>{$equipoStats['PTQE']}</td>
            </tr>";
        }

        $html .= "</table>";
        return $html;
    }

    public static function mostrarStatsPartidoporJugadores($estadisticas) {
        $html = "";
        $html .= "
        <table>
            <tr>
            <th>EQUIPO</th>
            <th>USER</th>
            <th>NOMBRE</th>
            <th>NUMERO</th>
            <th>TITULAR</th>
            <th>MT</th>
            <th>MSMS</th>
            <th>T2A</th>
            <th>T2F</th>
            <th>T3A</th>
            <th>T3F</th>
            <th>TLA</th>
            <th>TLF</th>
            <th>FLH</th>
            <th>FLR</th>
            <th>RBO</th>
            <th>RBD</th>
            <th>ROB</th>
            <th>TAP</th>
            <th>PRD</th>
            <th>AST</th>
            </tr>";

        foreach ($estadisticas as $equipoStats) {
            $html .= "
            <tr>
                <td>{$equipoStats['equipo']}</td>
                <td>{$equipoStats['jugador']}</td>
                <td>{$equipoStats['nombrejugador']}</td>
                <td>{$equipoStats['numero']}</td>
                <td>{$equipoStats['titular']}</td>
                <td>{$equipoStats['MT']}</td>
                <td>{$equipoStats['MSMS']}</td>
                <td>{$equipoStats['T2A']}</td>
                <td>{$equipoStats['T2F']}</td>
                <td>{$equipoStats['T3A']}</td>
                <td>{$equipoStats['T3F']}</td>
                <td>{$equipoStats['TLA']}</td>
                <td>{$equipoStats['TLF']}</td>
                <td>{$equipoStats['FLH']}</td>
                <td>{$equipoStats['FLR']}</td>
                <td>{$equipoStats['RBO']}</td>
                <td>{$equipoStats['RBD']}</td>
                <td>{$equipoStats['ROB']}</td>
                <td>{$equipoStats['TAP']}</td>
                <td>{$equipoStats['PRD']}</td>
                <td>{$equipoStats['AST']}</td>
            </tr>";
        }

        $html .= "</table>";
        return $html;
    }

    //Obtener las estadisticas de dichos partidos:
    public static function mostrarUltimosPartidosEquipo($equipo){

        $html = "";

        //Para cada equipo al que pertenezca quiero mostrar los partidos.
        //Tengo que obtener el id de cada partido de ese equipo
        
        $partidos = Partido::getpartidosfromEquipo($equipo);

            // Ordenar los partidos por fecha en orden descendente (los más recientes primero)
            usort($partidos, function($a, $b) {
                return strtotime($b['fecha']) - strtotime($a['fecha']);
            });

        //Ahora quiero buscar en la tabla de cada uno de esos partidos las estadisticas para ese jugador
        $html .="
        <table>
        <tr>
            <th>Rival</th>
            <th>Fecha</th>
            <th>Timeouts</th>
            <th>Faltas Banquillo</th>
            <th>Puntos</th>
            <th>Líder</th>
            <th>Empate</th>
            <th>Alternancias</th>
            <th>Veces Empatados</th>
            <th>Veces Líder</th>
            <th>PTQ1</th>
            <th>PTQ2</th>
            <th>PTQ3</th>
            <th>PTQ4</th>
            <th>PTQE</th>
        </tr>";

        foreach($partidos as $partido){

            //Necesito que me devuelva las estadisticas de ese jugador para ese partido si es que ha participado
            
            $estadisticas = Partido::getstatsPartidoEquipos($partido['id']);
        
            //Ademas necesito los datos de ese partido, pero ya los he obtenido antes.

            //Ahora llamaría al metodo mostrar para que se muestre la fila entera de dichas estadisticas.

            $html .= self::mostrarStatsPartidoEquipo($partido,$estadisticas[0],$partido['id']);
        
        }
        $html .="</table>";

        return $html;
    }

    public static function mostrarEquipos(){

        $equiposClub = self::getListadoEquipos();

        $equiposMostrar = self::mostrarListadoEquipos($equiposClub);

        return $equiposMostrar;
    }

}
?>

