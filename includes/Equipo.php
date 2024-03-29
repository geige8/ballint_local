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
    //Registro y eliminar de la Tabla Equipos

    public static function registrarEquipo($categoria_equipo,$seccion_equipo,$letra_equipo){
        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $idEquipo = $categoria_equipo .  $seccion_equipo . $letra_equipo;

        $query = "INSERT INTO equipos (id_equipo,categoria,seccion,letra)  VALUES ('$idEquipo','$categoria_equipo','$seccion_equipo','$letra_equipo')"; 

        $rs = $conn->query($query);

        if (!$rs) {
            $result = false;
            throw new \Exception('Ese Equipo ya existe. Intente de nuevo');
        }
        return $result;
    }

    public static function eliminarEquipo($equipoEliminar){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "DELETE FROM equipos WHERE id_equipo = '$equipoEliminar'";

        $rs = $conn->query($query);

        if (!$rs) {
            $result = false;
            throw new \Exception('El equipos no se puede eliminar');
        }elseif ($conn->affected_rows === 0) {
            $result = false;
            throw new \Exception('No se encontraron equipos para eliminar');
        }

        return $result;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//GETTERS

    //Obtener los id_equipo(NacionalMasculino) de todos los equipos
    public static function getListadoEquipos(){

        $equipos = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        $sql = "SELECT id_equipo FROM equipos ORDER BY id ASC";

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
    public static function getNombreEquipo($idEquipoLocal) {

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT categoria, seccion, letra FROM equipos WHERE id_equipo = '%s'", $conn->real_escape_string($idEquipoLocal));
        $rs = $conn->query($query);
        $result = false;
        $nombreEquipo = ''; 
    
        if ($rs) {
            while ($row = $rs->fetch_assoc()) {
                $nombreEquipo = 'LF' . $row['categoria'] . $row['seccion'] . $row['letra'];
            }
            $result = $nombreEquipo; 
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

    //Obtener los jugadores de un equipo
    public static function getJugadoresEquipo($equipo_id){

        $id_equipo = self::getidEquipo($equipo_id);

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("
        SELECT jugadores.id AS jugador_id, user, nombre, apellido1, apellido2, numero
        FROM jugadores 
        WHERE jugadores.user IN (
            SELECT user FROM credenciales WHERE id IN (
                SELECT usuario_id FROM usuarios_equipos WHERE equipo_id = '%s'
            )
            )
        ", $id_equipo);
    

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

//////////////////////////////////////////////////////////////////////////////////
//MANEJO TABLA EQUIPOS

    public static function guardaDatosEquipo($equipo){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $sql = "UPDATE equipos
        SET
        PPP = PPP + {$equipo['PPP']},
        PPR = PPR + {$equipo['PPR']},
        MT = MT + ({$equipo['MT']}),
        MSMS = MSMS + ({$equipo['MSMS']}),
        T2A = T2A + {$equipo['T2A']},
        T2F = T2F + {$equipo['T2F']},
        T3A = T3A + {$equipo['T3A']},
        T3F = T3F + {$equipo['T3F']},
        TLA = TLA + {$equipo['TLA']},
        TLF = TLF + {$equipo['TLF']},
        FLH = FLH + {$equipo['FLH']} + {$equipo['TEC']},
        FLR = FLR + {$equipo['FLR']},
        TEC = TEC + {$equipo['TEC']},
        RBO = RBO + {$equipo['RBO']},
        RBD = RBD + {$equipo['RBD']},
        ROB = ROB + {$equipo['ROB']},
        TAP = TAP + {$equipo['TAP']},
        PRD = PRD + {$equipo['PRD']},
        AST = AST + {$equipo['AST']},
        PTQ1 = PTQ1 + {$equipo['PTQ1']},
        PTQ2 = PTQ2 + {$equipo['PTQ2']},
        PTQ3 = PTQ3 + {$equipo['PTQ3']},
        PTQ4 = PTQ4 + {$equipo['PTQ4']},
        PTQE = PTQE + {$equipo['PTQE']}
        WHERE id_equipo = '{$equipo['equipo']}'";

        $resultado = $conn->query($sql);

        if (!$resultado) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        return $resultado;
    }

    //Añadir un partido jugado
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

    //Añadir un partido Ganado
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

    //Añadir un partido perdido
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ESTADISTICAS DE LOS EQUIPOS:
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Obtener las estadisticas del jugador
    public static function statsfromEquipo($team){

        $equipo = array();
    
        // Partidos Jugados
        $equipo['PJ'] = $team['PJ'];

        //Victorias
        $equipo['W'] = $team['W'];

        //Derrotas
        $equipo['L'] = $team['L'];

        // Puntos
        $equipo['PPP'] = $team['PPP'];

        // Puntos Promedio
        if ($team['PJ'] > 0) {
            $equipo['PTSP'] = number_format(($equipo['PPP'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['PTSP'] = 0;
        }

        //Puntos Recibidos
        $equipo['PPR'] = $team['PPR'];

        // Puntos Recibidos Promedio
        if ($team['PJ'] > 0) {
            $equipo['PTSPR'] = number_format(($equipo['PPR'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['PTSPR'] = 0;
        }

        // Minutos
        $equipo['MT'] = $team['MT'];

        $minutosjugados = floor($team['MT'] / 60) ?? 0;
        $segundosRestantes = $team['MT'] % 60 ?? 0;
        $tiempoFormato = sprintf("%02d:%02d", $minutosjugados, $segundosRestantes);
        $equipo['MTT'] = $tiempoFormato;
    
        // Minutos Promedio
        if ($team['PJ'] > 0) {
            $segundospromedio = ($team['MT'] ?? 0) / ($team['PJ'] ?? 0);
            // En este caso: $segundospromedio = 9 / 5 = 1.8 segundos por partido
            $minutosjugados = floor($segundospromedio / 60);

            $segundosRestantes = $segundospromedio - ($minutosjugados * 60);

            $segundosRestantes = ceil($segundosRestantes);

            $tiempoFormato = sprintf("%02d:%02d", $minutosjugados, $segundosRestantes);

            $equipo['MTP'] = $tiempoFormato;
        } else {
            $equipo['MTP'] = "00:00";
        }

        //Mas Menos
        $equipo['MSMS'] = $team['MSMS'];
    
        // Más Menos Promedio
        if ($team['PJ'] > 0) {
            $equipo['MSMSP'] = number_format(($team['MSMS'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['MSMSP'] = 0;
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

        // TECNICAS
        $equipo['TEC'] = $team['TEC'];
        if ($team['PJ'] > 0) {
            $equipo['TECP'] = number_format(($equipo['TEC'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['TECP'] = 0;
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
        $total_shots = $equipo['T2A'] + $equipo['T3A'] + ($equipo['TLA'] * 0.44);
        if ($total_shots > 0) {
            $equipo['T2PU'] = number_format(($equipo['T2A'] / $total_shots), 2) * 100;
            $equipo['T3PU'] = number_format(($equipo['T3A'] / $total_shots), 2) * 100;
            $equipo['T1PU'] = number_format((($equipo['TLA'] * 0.44) / $total_shots), 2) * 100;
        } else {
            $equipo['T2PU'] = 0;
            $equipo['T3PU'] = 0;
            $equipo['T1PU'] = 0;
        }
        //PORCENTAJE DE TIRO EFECTIVO: eFG% = (FG + 0.5 * 3P) / FGA
        $total_attempts = $equipo['TCA'] + $equipo['TCF'];
        if ($total_attempts > 0) {
            $equipo['eFGP'] = number_format((($equipo['T2A'] + $equipo['T3A'] + 0.5 * $equipo['T3A']) / $total_attempts),2) * 100;
        } else {
            $equipo['eFGP'] = 0;
        }
        //PORCENTAJE DE PÉRDIDAS (TO%)
        //TO% = TO / (FGA + 0.44 * FTA + TO)
        $denominator_TO = ($equipo['TCA'] + $equipo['TCF']) + (0.44 * ($equipo['TLA'] + $equipo['TLF'])) + $equipo['PRD'];

        if ($denominator_TO > 0) {
            $equipo['TOP'] = number_format((($equipo['PRD']) / $denominator_TO),2) * 100;
        }
        else{
            $equipo['TOP'] = 0;
        }
        //PORCENTAJE DE TIRO LIBRE RESPECTO AL TIRO DE CAMPO (FTM/FGA). 
        //La fórmula es: FTM/FGA
        $denominator_TLP = $equipo['TCA'] + $equipo['TCF'];

        if ($denominator_TLP > 0) {
            $equipo['TLP'] = number_format(($equipo['TCA'] / $denominator_TLP),2) * 100;
        } else {
            $equipo['TLP'] = 0;
        }
        //TRUE SHOOTING (TS%). 
        //Porcentaje de tiros de campo para un equipo ponderando el tiro de 3 puntos por 1,5 y añadiendo los tiros libres por 0,44. 
        //TS% = PTS / 2(FGA + 0.44 * FTA)
        $total_field_attempts = $equipo['TCA'] + $equipo['TCF'];
        $total_free_attempts = $equipo['TLA'] + $equipo['TLF'];
        if (($total_field_attempts + 0.44 * $total_free_attempts) > 0) {
            $equipo['TSP'] = number_format(($equipo['PPP']) / (2 * ($total_field_attempts + 0.44 * $total_free_attempts)),2) * 100;
        } else {
            $equipo['TSP'] = 0;
        }

        //PORCENTAJE DE ASISTENCIAS (AS%). 
        //Porcentaje de asistencias respecto a los tiros de campo anotados. 
        //La fórmula es: AS% = AS / (2PM + 3PM)
        $total_field_made = $equipo['T2A'] + $equipo['T3A'];
        if ($total_field_made > 0) {
            $equipo['ASP'] = number_format((($equipo['AST']) / $total_field_made),2) * 100;
        } else {
            $equipo['ASP'] = 0;
        }
        //Posesiones
        //Pos = FGA + TO - OR + (FTA*0.44)
        $equipo['POS'] = 0.96*(($equipo['TCA'] + $equipo['TCF']) + $equipo['PRD'] - $equipo['RBO'] + (($team['TLA'] + $team['TLF'])*0.44));
        
        if ($team['PJ'] > 0) {
            $equipo['POSP'] = number_format(($equipo['POS'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['POSP'] = 0;
        }

        //OER (OFFENSIVE EFFICIENCY RATING): 
        // La fórmula es: OER = PTS / POS
        if($equipo['POS'] > 0){
            $equipo['OER'] = number_format(($equipo['PPP'] / $equipo['POS']),2) * 100;
        } else {
            $equipo['OER'] = 0;
        }
        if ($team['PJ'] > 0) {
            $equipo['OERP'] = number_format(($equipo['OER'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['OERP'] = 0;
        }

        //DER (DEFENSIVE EFFICIENCY RATING)
        // La fórmula es: DER = PTS / POS
        if($equipo['POS'] > 0){
            $equipo['DER'] = number_format(($equipo['PPR'] / $equipo['POS']),2) * 100;
        } else {
            $equipo['DER'] = 0;
        }
        if ($team['PJ'] > 0) {
            $equipo['DERP'] = number_format(($equipo['DER'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['DERP'] = 0;
        }

        //Ritmo
        if($equipo['POS'] > 0){
            $equipo['PACE'] = number_format(($equipo['PPP'] / $equipo['POS']),2);
        } else {
            $equipo['PACE'] = 0;
        }

        if ($team['PJ'] > 0) {
            $equipo['PACEP'] = number_format(($equipo['PACE'] ?? 0) / ($team['PJ'] ?? 0), 2);
        } else {
            $equipo['PACEP'] = 0;
        }


        
        return $equipo;
    }  

    public static function statsfromEquipoenPartido($team){

        $equipo = array();

        $equipo['equipo'] = $team['equipo'];
    
        // Minutos
        $equipo['MT'] = $team['MT'];

        $minutosjugados = floor($team['MT'] / 60) ?? 0;
        $segundosRestantes = $team['MT'] % 60 ?? 0;
        $tiempoFormato = sprintf("%02d'%02d''", $minutosjugados, $segundosRestantes);
        $equipo['MTT'] = $tiempoFormato;
    
        //Mas Menos
        $equipo['MSMS'] = $team['MSMS'];
        
        // Puntos
        $equipo['PPP'] = $team['PPP'];
        $equipo['PPR'] = $team['PPR'];

        // Tiros de dos
        $equipo['T2A'] = $team['T2A'];
        $equipo['T2F'] = $team['T2F'];
        if (($team['T2A'] + $team['T2F']) > 0) {
            $equipo['T2P'] = number_format(($team['T2A'] / ($team['T2A'] + $team['T2F'])) * 100, 2);
        } else {
            $equipo['T2P'] = 0;
        }
    
        // Tiros de tres
        $equipo['T3A'] = $team['T3A'];
        $equipo['T3F'] = $team['T3F'];
        if (($team['T3A'] + $team['T3F']) > 0) {
            $equipo['T3P'] = number_format(($team['T3A'] / ($team['T3A'] + $team['T3F'])) * 100, 2);
        } else {
            $equipo['T3P'] = 0;
        }
    
        // Tiros Libres
        $equipo['TLA'] = $team['TLA'];
        $equipo['TLF'] = $team['TLF'];
        if (($team['TLA'] + $team['TLF']) > 0) {
            $equipo['TLP'] = number_format(($team['TLA'] / ($team['TLA'] + $team['TLF'])) * 100, 2);
        } else {
            $equipo['TLP'] = 0;
        }
    
        // Tiros de Campo
        $equipo['TCA'] = $team['T2A'] + $team['T3A'];
        $equipo['TCF'] = $team['T2F'] + $team['T3F'];
        if (($equipo['TCA'] + $equipo['TCF']) > 0) {
            $equipo['TCP'] = number_format(($equipo['TCA'] / ($equipo['TCA'] + $equipo['TCF'])) * 100, 2);
        } else {
            $equipo['TCP'] = 0;
        }
    
        // Faltas Hechas
        $equipo['FLH'] = $team['FLH'];
    
        // Faltas Recibidas
        $equipo['FLR'] = $team['FLR'];

        // TECNICAS
        $equipo['TEC'] = $team['TEC'];
    
        // Rebotes Partido
        $equipo['REB'] = $team['RBO'] + $team['RBD'];
    
        // Rebotes Ofensivos
        $equipo['RBO'] = $team['RBO'];
    
        // Rebotes Defensivos
        $equipo['RBD'] = $team['RBD'];
    
        // Robos Partido
        $equipo['ROB'] = $team['ROB'];
    
        // Tapones Partido
        $equipo['TAP'] = $team['TAP'];
    
        // Pérdida Partido
        $equipo['PRD'] = $team['PRD'];
    
        // Asistencias Partido
        $equipo['AST'] = $team['AST'];

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //ESTADISTICA AVANZADA

        // // Puntos de Titular
        // $equipo['TIT'] = $team['TIT']; //Llamar a función que obtenga eso

        // //Puntos de Suplente
        // $equipo['SUP'] = $team['SUP']; //Llamar a función que obtenga eso
    
        // // Promedio Puntos Titular
        // if ($team['PJ'] > 0) {
        //     $equipo['TITP'] = number_format(($team['TIT'] ?? 0) / ($team['PJ'] ?? 0), 2);
        // } else {
        //     $equipo['TITP'] = 0;
        // }

        //Puntos Por Cuartos
        $equipo['PTQ1'] = $team['PTQ1'];
        $equipo['PTQ2'] = $team['PTQ2'];
        $equipo['PTQ3'] = $team['PTQ3'];
        $equipo['PTQ4'] = $team['PTQ4'];
        $equipo['PTQE'] = $team['PTQE'];

        //PORCENTAJES DE USO DE TIRO
        if($equipo['T2A'] > 0){
            $equipo['T2PU'] = number_format((($equipo['T2A'])/($equipo['T2A']+$equipo['T3A']+($equipo['TLA']*0.44)))*100,2);
        }else{
            $equipo['T2PU'] = 0;
        }

        if($equipo['T3A'] > 0){
            $equipo['T3PU'] = number_format((($equipo['T3A'])/($equipo['T2A']+$equipo['T3A']+($equipo['TLA']*0.44)))*100,2);
        }else{
            $equipo['T3PU'] = 0;
        }

        if($equipo['TLA'] > 0){
            $equipo['T1PU'] = number_format((($equipo['TLA']*0.44)/($equipo['T2A']+$equipo['T3A']+($equipo['TLA']*0.44)))*100,2);
        }else{
            $equipo['T1PU'] = 0;
        }

     // PORCENTAJE DE TIRO EFECTIVO: eFG% = (FG + 0.5 * 3P) / FGA
        if(($equipo['TCA'] + $equipo['TCF']) > 0){
            $equipo['eFGP'] = number_format(((($equipo['T2A'] + $equipo['T3A']) + 0.5 * $equipo['T3A']) / ($equipo['TCA'] + $equipo['TCF'])) * 100, 2);
        } else {
            $equipo['eFGP'] = 0;
        }

        // PORCENTAJE DE PÉRDIDAS (TO%)
        // TO% = TO / (FGA + 0.44 * FTA + TO)
        if(($equipo['TCA'] + $equipo['TCF'] + 0.44 * ($equipo['TLA'] + $equipo['TLF']) + $equipo['PRD']) > 0){
            $equipo['TOP'] = number_format(($equipo['PRD']) / (($equipo['TCA'] + $equipo['TCF']) + (0.44 * ($equipo['TLA'] + $equipo['TLF'])) + $equipo['PRD']) * 100, 2);
        } else {
            $equipo['TOP'] = 0;
        }

        // PORCENTAJE DE TIRO LIBRE RESPECTO AL TIRO DE CAMPO (FTM/FGA)
        // La fórmula es: FTM / (FGA + FTM)
        if(($equipo['TCA'] + $equipo['TCF']) > 0){
            $equipo['TLP'] = number_format(($equipo['TCA']) / ($equipo['TCA'] + $equipo['TCF']) * 100, 2);
        } else {
            $equipo['TLP'] = 0;
        }

        // TRUE SHOOTING (TS%)
        // Porcentaje de tiros de campo para un equipo ponderando el tiro de 3 puntos por 1,5 y añadiendo los tiros libres por 0,44.
        // TS% = PTS / 2(FGA + 0.44 * FTA)
        if(($equipo['TCA'] + $equipo['TCF'] + 0.44 * ($equipo['TLA'] + $equipo['TLF'])) > 0){
            $equipo['TSP'] = number_format(($equipo['PPP']) / (2 * (($equipo['TCA'] + $equipo['TCF']) + (0.44 * ($equipo['TLA'] + $equipo['TLF'])))) * 100, 2);
        } else {
            $equipo['TSP'] = 0;
        }

        // PORCENTAJE DE ASISTENCIAS (AS%)
        // Porcentaje de asistencias respecto a los tiros de campo anotados.
        // La fórmula es: AS% = AS / (2PM + 3PM)
        if(($equipo['T2A'] + $equipo['T3A']) > 0){
            $equipo['ASP'] = number_format(($equipo['AST']) / (($equipo['T2A']) + ($equipo['T3A'])) * 100, 2);
        } else {
            $equipo['ASP'] = 0;
        }

        // Posesiones
        // Pos = FGA + TO - OR + (FTA*0.44)
        if(($equipo['TCA'] + $equipo['TCF'] + $equipo['PRD'] - $equipo['RBO'] + (($equipo['TLA'] + $equipo['TLF']) * 0.44)) > 0){
            $equipo['POS'] = number_format(0.96 * (($equipo['TCA'] + $equipo['TCF']) + $equipo['PRD'] - $equipo['RBO'] + (($equipo['TLA'] + $equipo['TLF']) * 0.44)),2);
        } else {
            $equipo['POS'] = 0;
        }

        // OER (OFFENSIVE EFFICIENCY RATING)
        // La fórmula es: OER = PTS / POS
        if($equipo['POS'] > 0){
            $equipo['OER'] = number_format(($equipo['PPP'] / $equipo['POS'])  * 100, 2);
        } else {
            $equipo['OER'] = 0;
        }

        // DER (DEFENSIVE EFFICIENCY RATING)
        // La fórmula es: DER = PTS / POS
        if($equipo['POS'] > 0){
            $equipo['DER'] = number_format(($equipo['PPR'] / $equipo['POS'])  * 100, 2);
        } else {
            $equipo['DER'] = 0;
        }

        // Ritmo
        if($equipo['POS'] > 0){
            $equipo['PACE'] = number_format(($equipo['PPP'] / $equipo['POS']), 2);
        } else {
            $equipo['PACE'] = 0;
        }



        return $equipo;
    }  

///////////////////////////////////////////////////////////////
//MOSTRAR:

    public static function mostrarStatsEquipo($equipo){

        $html = "";
        $html .= "
            <div class='stats'>

            <div class='stats-row'>
            <h3>Estadísticas de Partidos</h3>
                <div class='stat'>
                    <p>Partidos Jugados</p>
                    <p>{$equipo['PJ']}</p>
                </div>
                <div class='stat'>
                    <p>Victorias</p>
                    <p>{$equipo['W']}</p>
                </div>
                <div class='stat'>
                    <p>Derrotas</p>
                    <p>{$equipo['L']}</p>
                </div>
            </div>

            <div class='stats-row'>
            <h3>Estadísticas Clave</h3>
                <div class='stat'>
                    <p>Puntos PP</p>
                    <p>{$equipo['PTSP']}</p>
                </div>
                <div class='stat'>
                    <p>Puntos RPP</p>
                    <p>{$equipo['PTSPR']}</p>
                </div>
                <div class='stat'>
                    <p>Minutos Totales</p>
                    <p>{$equipo['MTT']}</p>
                </div>
                <div class='stat'>
                    <p>Minutos Promedio</p>
                    <p>{$equipo['MTP']}</p>
                </div>
                <div class='stat'>
                    <p>+/- PP</p>
                    <p>{$equipo['MSMSP']}</p>
                </div>
            </div>

            <div class='stats-row'>
            <h3>Estadísticas de Anotación</h3>
                <div class='stat'>
                    <p>PTS Q1</p>
                    <p>{$equipo['PTQ1']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q1 PP</p>
                    <p>{$equipo['PTQ1P']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q2</p>
                    <p>{$equipo['PTQ2']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q2 PP</p>
                    <p>{$equipo['PTQ2P']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q3</p>
                    <p>{$equipo['PTQ3']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q3 PP</p>
                    <p>{$equipo['PTQ3P']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q4</p>
                    <p>{$equipo['PTQ4']}</p>
                </div>
                <div class='stat'>
                    <p>PTS Q4 PP</p>
                    <p>{$equipo['PTQ4P']}</p>
                </div>
                <div class='stat'>
                    <p>PTS EXTRA</p>
                    <p>{$equipo['PTQE']}</p>
                </div>
                <div class='stat'>
                    <p>PTS EXTRA PP</p>
                    <p>{$equipo['PTQEP']}</p>
                </div>
            </div>

            <div class='stats-row'>
            <h3>Estadísticas de Tiro</h3>
                <div class='stat'>
                    <p>T2A</p>
                    <p>{$equipo['T2A']}</p>
                </div>
                <div class='stat'>
                    <p>T2A</p>
                    <p>{$equipo['T2P']}%</p>
                </div>
                <div class='stat'>
                    <p>T2A PP</p>
                    <p>{$equipo['T2PP']}</p>
                </div>
                <div class='stat'>
                    <p>T3A</p>
                    <p>{$equipo['T3A']}</p>
                </div>
                <div class='stat'>
                    <p>T3A</p>
                    <p>{$equipo['T3P']}%</p>
                </div>
                <div class='stat'>
                    <p>T3A PP</p>
                    <p>{$equipo['T3PP']}</p>
                </div>
                <div class='stat'>
                    <p>TLA</p>
                    <p>{$equipo['TLA']}</p>
                </div>
                <div class='stat'>
                    <p>TLA</p>
                    <p>{$equipo['TLP']}%</p>
                </div>
                <div class='stat'>
                    <p>TLA PP</p>
                    <p>{$equipo['TLPP']}</p>
                </div>
                <div class='stat'>
                    <p>TCA</p>
                    <p>{$equipo['TCA']}</p>
                </div>
                <div class='stat'>
                    <p>%TCA</p>
                    <p>{$equipo['TCP']}%</p>
                </div>
                <div class='stat'>
                    <p>TCA PP</p>
                    <p>{$equipo['TCPP']}</p>
                </div>
            </div>




            <div class='stats-row'>
            <h3>Estadísticas de Rebotes</h3>
                <div class='stat'>
                    <p>RBO</p>
                    <p>{$equipo['RBO']}</p>
                </div>
                <div class='stat'>
                    <p>RBO PP</p>
                    <p>{$equipo['RBOP']}</p>
                </div>
                <div class='stat'>
                    <p>RBD</p>
                    <p>{$equipo['RBD']}</p>
                </div>
                <div class='stat'>
                    <p>RBD PP</p>
                    <p>{$equipo['RBDP']}</p>
                </div>
                <div class='stat'>
                    <p>RBT</p>
                    <p>{$equipo['REB']}</p>
                </div>
                <div class='stat'>
                    <p>RBT PP</p>
                    <p>{$equipo['REBP']}</p>
                </div>
            </div>

            <div class='stats-row'>  
            <h3>Estadísticas de Juego</h3>  
                <div class='stat'>
                    <p>ROB</p>
                    <p>{$equipo['ROB']}</p>
                </div>
                <div class='stat'>
                    <p>ROB PP</p>
                    <p>{$equipo['ROBP']}</p>
                </div>
                <div class='stat'>
                    <p>TAP</p>
                    <p>{$equipo['TAP']}</p>
                </div>
                <div class='stat'>
                    <p>TAP PP</p>
                    <p>{$equipo['TAPP']}</p>
                </div>
                <div class='stat'>
                    <p>PRD</p>
                    <p>{$equipo['PRD']}</p>
                </div>
                <div class='stat'>
                    <p>PRD PP</p>
                    <p>{$equipo['PRDP']}</p>
                </div>
                <div class='stat'>
                    <p>AST</p>
                    <p>{$equipo['AST']}</p>
                </div>
                <div class='stat'>
                    <p>AST PP</p>
                    <p>{$equipo['ASTP']}</p>
                </div>
            </div>

            <div class='stats-row'>
            <h3>Estadísticas de Faltas</h3>
                <div class='stat'>
                    <p>FP</p>
                    <p>{$equipo['FLH']}</p>
                </div>
                <div class='stat'>
                    <p>FP PP</p>
                    <p>{$equipo['FLHP']}</p>
                </div>
                <div class='stat'>
                    <p>FR</p>
                    <p>{$equipo['FLR']}</p>
                </div>
                <div class='stat'>
                    <p>FR PP</p>
                    <p>{$equipo['FLRP']}</p>
                </div>
                <div class='stat'>
                    <p>TEC</p>
                    <p>{$equipo['TEC']}</p>
                </div>
                <div class='stat'>
                    <p>TEC PP</p>
                    <p>{$equipo['TEC']}</p>
                </div>
        </div>

            </div>    
        ";
        return $html;
    }

    public static function mostrarStatsAreasdeMejoraEquipo($equipo){

        $html = "<div class='stats'>";
    
        if ($equipo['T2P'] <= 30) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%T2A</p>";
            $html .= "<p class='stat-value'>{$equipo['T2P']}% - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        if ($equipo['T3P'] <= 30) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%T3A</p>";
            $html .= "<p class='stat-value'>{$equipo['T3P']}% - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        if ($equipo['TLP'] <= 30) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%TLA</p>";
            $html .= "<p class='stat-value'>{$equipo['TLP']}% - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        if ($equipo['TCP'] <= 30) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%TCA</p>";
            $html .= "<p class='stat-value'>{$equipo['TCP']}% - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        
        if ($equipo['FLHP'] >= 15) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>FLHP</p>";
            $html .= "<p class='stat-value'>{$equipo['FLHP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        if ($equipo['FLRP'] <= 5) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%FLRP</p>";
            $html .= "<p class='stat-value'>{$equipo['FLRP']}% - Tiene que mejorar</p>";
            $html .= "</div>";
        }

        if ($equipo['RBOP'] < 5 ) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>RBOP</p>";
            $html .= "<p class='stat-value'>{$equipo['RBOP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        if ($equipo['RBDP'] < 15) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%RBDP</p>";
            $html .= "<p class='stat-value'>{$equipo['RBDP']}% - Tiene que mejorar</p>";
            $html .= "</div>";
        } 
        if ($equipo['REBP'] < 15) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>REBP</p>";
            $html .= "<p class='stat-value'>{$equipo['REBP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        }
        
        if ($equipo['ROBP'] <= 5) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>ROBP</p>";
            $html .= "<p class='stat-value'>{$equipo['ROBP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        } 
        if ($equipo['TAPP'] <= 1) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%TAPP</p>";
            $html .= "<p class='stat-value'>{$equipo['TAPP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        } 
        if ($equipo['PRDP'] >= 10) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>%PRDP</p>";
            $html .= "<p class='stat-value'>{$equipo['PRDP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        } 
        if ($equipo['ASTP'] <= 5) {
            $html .= "<div class='stat-container'>";
            $html .= "<p class='stat-label'>ASTP</p>";
            $html .= "<p class='stat-value'>{$equipo['ASTP']} - Tiene que mejorar</p>";
            $html .= "</div>";
        }
    
        $html .= "</div>";
        return $html;
    }

    public static function mostrarStatsAvanzadasEquipo($equipoAvanzado){

        $html = "";

        $html .= "
        <div class='stats'>
            <div class='stat-container'>
                <p class='stat-label'>%USO T2</p>
                <p class='stat-value'>{$equipoAvanzado['T2PU']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>%USO T3</p>
                <p class='stat-value'>{$equipoAvanzado['T3PU']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>%USO TL</p>
                <p class='stat-value'>{$equipoAvanzado['T1PU']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>%TEFEC</p>
                <p class='stat-value'>{$equipoAvanzado['eFGP']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>TRUE S%</p>
                <p class='stat-value'>{$equipoAvanzado['TSP']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>AST %</p>
                <p class='stat-value'>{$equipoAvanzado['ASP']}%</p>
            </div>
                <div class='stat-container'>
                <p class='stat-label'>PRD %</p>
                <p class='stat-value'>{$equipoAvanzado['TOP']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>%TL/TC</p>
                <p class='stat-value'>{$equipoAvanzado['TLP']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>POS/PJ</p>
                <p class='stat-value'>{$equipoAvanzado['POSP']}</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>OFR%</p>
                <p class='stat-value'>{$equipoAvanzado['OERP']}%</p>
            </div>
            <div class='stat-container'>
            <p class='stat-label'>DFR%</p>
            <p class='stat-value'>{$equipoAvanzado['DERP']}%</p>
            </div>
            <div class='stat-container'>
                <p class='stat-label'>RITMO</p>
                <p class='stat-value'>{$equipoAvanzado['PACEP']} PTSxPOS</p>
            </div>
        </div>
        ";
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
                <td>{$estadisticas['PPP']}-{$estadisticas['PPR']}</td>
                <td>{$estadisticas['timeouts']}</td>
                <td>{$estadisticas['faltasbanquillo']}</td>
                <td>{$estadisticas['alternancias']}</td>
                <td>{$estadisticas['vecesempatados']}</td>
                <td>{$estadisticas['veceslider']}</td>
                <td>{$estadisticas['mayorventaja']}</td>
                <td>{$estadisticas['tiempolider']}</td>
                <td>{$estadisticas['PTQ1']}</td>
                <td>{$estadisticas['PTQ2']}</td>
                <td>{$estadisticas['PTQ3']}</td>
                <td>{$estadisticas['PTQ4']}</td>
                <td>{$estadisticas['PTQE']}</td>
            </tr>";
        return $html;
    }

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
            <th>Marcador</th>
            <th>Timeouts</th>
            <th>Faltas Banquillo</th>
            <th>Alternancias</th>
            <th>Veces Empatados</th>
            <th>Veces Líder</th>
            <th>Mayor Ventaja</th>
            <th>Tiempo Líder</th>
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

    //Pagina de Partido
    public static function mostrarDetallesPartidoporEquipos($estadisticas) {

        $html = "";
        $html .= "
        <table>
            <tr>
                <th>Equipo</th>
                <th>Marcador</th>
                <th>Timeouts</th>
                <th>Faltas Banquillo</th>
                <th>Alternancias</th>
                <th>Veces Empatados</th>
                <th>Veces Líder</th>
                <th>Mayor Ventaja</th>
                <th>Tiempo Líder</th>
                <th>PTQ1</th>
                <th>PTQ2</th>
                <th>PTQ3</th>
                <th>PTQ4</th>
                <th>PTQE</th>
            </tr>";

        foreach ($estadisticas as $equipoStats) {
            $html .= "
            <tr>
                <td>{$equipoStats['equipo']}</td>
                <td>{$equipoStats['PPP']}-{$equipoStats['PPR']}</td>
                <td>{$equipoStats['timeouts']}</td>
                <td>{$equipoStats['faltasbanquillo']}</td>
                <td>{$equipoStats['alternancias']}</td>
                <td>{$equipoStats['vecesempatados']}</td>
                <td>{$equipoStats['veceslider']}</td>
                <td>{$equipoStats['mayorventaja']}</td>
                <td>{$equipoStats['tiempolider']}</td>
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

    public static function mostrarStatsPartidoporEquipos($estadisticas) {

        $html = "";
        $html .= "
        <table>
            <tr>
                <th>Equipo</th>
                <th>Marcador</th>
                <th>MTT</th>
                <th>MSMS</th>
                <th>T2A</th>
                <th>T2P</th>
                <th>T3A</th>
                <th>T3P</th>
                <th>TCA</th>
                <th>TCP</th>
                <th>TLA</th>
                <th>TLP</th>
                <th>FLH</th>
                <th>FLR</th>
                <th>TEC</th>
                <th>RBO</th>
                <th>RBD</th>
                <th>REB</th>
                <th>ROB</th>
                <th>TAP</th>
                <th>PRD</th>
                <th>AST</th>
                <th>T2PU</th>
                <th>T3PU</th>
                <th>T1PU</th>
                <th>eFGP</th>
                <th>TOP</th>
                <th>TLP</th>
                <th>TSP</th>
                <th>ASP</th>
                <th>POS</th>
                <th>OER</th>
                <th>DER</th>
                <th>PACE</th>
            </tr>";

        foreach ($estadisticas as $equipoStats) {
            $html .= "
            <tr>
                <td>{$equipoStats['equipo']}</td>
                <td>{$equipoStats['PPP']}-{$equipoStats['PPR']}</td>
                <td>{$equipoStats['MTT']}</td>
                <td>{$equipoStats['MSMS']}</td>
                <td>{$equipoStats['T2A']}</td>
                <td>{$equipoStats['T2P']}</td>
                <td>{$equipoStats['T3A']}</td>
                <td>{$equipoStats['T3P']}</td>
                <td>{$equipoStats['TCA']}</td>
                <td>{$equipoStats['TCP']}</td>
                <td>{$equipoStats['TLA']}</td>
                <td>{$equipoStats['TLP']}</td>
                <td>{$equipoStats['FLH']}</td>
                <td>{$equipoStats['FLR']}</td>
                <td>{$equipoStats['TEC']}</td>
                <td>{$equipoStats['RBO']}</td>
                <td>{$equipoStats['RBD']}</td>
                <td>{$equipoStats['REB']}</td>
                <td>{$equipoStats['ROB']}</td>
                <td>{$equipoStats['TAP']}</td>
                <td>{$equipoStats['PRD']}</td>
                <td>{$equipoStats['AST']}</td>
                <td>{$equipoStats['T2PU']}</td>
                <td>{$equipoStats['T3PU']}</td>
                <td>{$equipoStats['T1PU']}</td>
                <td>{$equipoStats['eFGP']}</td>
                <td>{$equipoStats['TOP']}</td>
                <td>{$equipoStats['TLP']}</td>
                <td>{$equipoStats['TSP']}</td>
                <td>{$equipoStats['ASP']}</td>
                <td>{$equipoStats['POS']}</td>
                <td>{$equipoStats['OER']}</td>
                <td>{$equipoStats['DER']}</td>
                <td>{$equipoStats['PACE']}</td>
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
            <th>Equipo</th>
            <th>Nombre</th>
            <th>Nº</th>
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

        foreach ($estadisticas as $equipoStats) {
            $html .= "
            <tr>
                <td>{$equipoStats['equipo']}</td>
                <td>{$equipoStats['nombrejugador']}</td>
                <td>{$equipoStats['numero']}</td>
                <td>{$equipoStats['TIT']}</td>
                <td>{$equipoStats['MTT']}</td>
                <td>{$equipoStats['MSMS']}</td>
                <td>{$equipoStats['PTS']}</td>
                <td>{$equipoStats['T2A']}</td>
                <td>{$equipoStats['T2P']}</td>
                <td>{$equipoStats['T3A']}</td>
                <td>{$equipoStats['T3P']}</td>
                <td>{$equipoStats['TCA']}</td>
                <td>{$equipoStats['TCP']}</td>
                <td>{$equipoStats['TLA']}</td>
                <td>{$equipoStats['TLP']}</td>
                <td>{$equipoStats['FLH']}</td>
                <td>{$equipoStats['FLR']}</td>
                <td>{$equipoStats['TEC']}</td>
                <td>{$equipoStats['RBO']}</td>
                <td>{$equipoStats['RBD']}</td>
                <td>{$equipoStats['REB']}</td>
                <td>{$equipoStats['ROB']}</td>
                <td>{$equipoStats['TAP']}</td>
                <td>{$equipoStats['PRD']}</td>
                <td>{$equipoStats['AST']}</td>
                <td>{$equipoStats['PTQ1']}</td>
                <td>{$equipoStats['PTQ2']}</td>
                <td>{$equipoStats['PTQ3']}</td>
                <td>{$equipoStats['PTQ4']}</td>
                <td>{$equipoStats['PTQE']}</td>
                <td>{$equipoStats['T2PU']}</td>
                <td>{$equipoStats['T3PU']}</td>
                <td>{$equipoStats['T1PU']}</td>
                <td>{$equipoStats['eFGP']}</td>
                <td>{$equipoStats['TSP']}</td>
                <td>{$equipoStats['ASP']}</td>
                <td>{$equipoStats['GS']}</td>
                <td>{$equipoStats['VAL']}</td>          
            </tr>";
        }

        $html .= "</table>";
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

    public static function mostrarlistaEntrenadoresEquipo($equipo) {

        $listaEntrenadores = Entrenador::getEntrenadoresEquipo($equipo);

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

        foreach ($listaEntrenadores as $entrenador) {
            $html .= "
                <tr>
                    <td>{$i}</td>
                    <td>
                        <a href='pagina_perfilentrenador.php?entrenador={$entrenador['user']}'>
                            {$entrenador['user']}
                        </a>
                    </td>
                    <td>{$entrenador['nombre']}</td>
                    <td>{$entrenador['apellido1']}</td>
                    <td>{$entrenador['apellido2']}</td>
                </tr>";
            $i++;
        }
        
        $html .= "</table>";
        return $html;
    }

    public static function mostrarListadoEquipos($equipos){

        $html = '';
        $html .= <<<EOS
        <div class="cajasEquipos">
        EOS;

            foreach ($equipos as $equipo) {
                $html .= self::mostrarCajaEquipo($equipo);
            }
            $html .= <<<EOS
        </div>
        EOS;

        return $html;
    }

    public static function mostrarCajaEquipo($equipo){

        $datosEquipo = self::getDatosEquipo($equipo);
        $html = '';
        $html .= <<<EOS
            <div class="equipo">
                <a href="pagina_equipo.php?equipo={$equipo}">
                    <p>LF {$datosEquipo['categoria']} {$datosEquipo['seccion']} {$datosEquipo['letra']}</p>
                </a>
            </div>
        EOS;

        return $html;
    }

    public static function mostrarEquipos(){

        $equiposClub = self::getListadoEquipos();

        $equiposMostrar = self::mostrarListadoEquipos($equiposClub);

        return $equiposMostrar;
    }

}
?>

