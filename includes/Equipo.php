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

    public static function getDatosEquipo($equipo){

      //Obtengo la conexión realizada
      $conn = Aplicacion::getInstance()->getConexionBd();

      $query = sprintf("SELECT * FROM equipos WHERE id_equipo='%s'", $conn->real_escape_string($equipo));
      $rs = $conn->query($query);
      $result = false;

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
    


    public static function getEquiposfromUserId($idUser){

        //Obtengo la conexión realizada
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

    public static function getEquipos(){

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT id_equipo, nombre_equipo FROM equipos";

        $rs = $conn->query($query);
        $result = false;
        $equipos = array();
            if ($rs) {
                while ($row = $rs->fetch_assoc()) {
                    $equipos[$row['id_equipo']] = $row['nombre_equipo'];
                }
                $result = $equipos;
                $rs->free();
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        return $result;
    }


    public static function saveplayers($equipo) {
        // Obtener todos los jugadores
        $listajugadores = self::getJugadores();
        $resultado = self::addpartidojugado($equipo);
        // Iterar sobre cada jugador
        foreach ($listajugadores as $jugador) {
            // Llamar a la función guardaDatosJugador y almacenar el resultado en una variable
            $resultado = self::guardaDatosJugador($jugador);
            $resultado = self::guardaDatosJugadorenEquipo($jugador);
            // Controlar el resultado
            if ($resultado) {
                echo "El jugador {$jugador['id']} se ha guardado correctamente.";
            } else {
                echo "Error al guardar el jugador.";
            }
        }
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
    

    public static function guardaDatosJugadorenEquipo($jugador){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $sql = "UPDATE equipos
        SET 
        MT = MT + {$jugador['segundosjugados']},
        MSMS = MSMS + ({$jugador['masmenos']}/5),
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

        // Ejecutar la consulta
        $resultado = $conn->query($sql);

        if (!$resultado) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        return $resultado;
    }

    public static function addpartidojugado($equipo){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE equipos SET PJ = PJ + 1 WHERE id_equipo = '%s'", $conn->real_escape_string($equipo));
        // Ejecutar la consulta
        $resultado = $conn->query($query);

        if (!$resultado) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        return $resultado;
    }

    public static function getNombreEquipo($idEquipoLocal){

        //Obtengo la conexión realizada
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

    public static function getidEquipo($equipo_id){

        //Obtengo la conexión realizada
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
    


    public static function getJugadoresEquipo($equipo_id){

        $id_equipo = self::getidEquipo($equipo_id);

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT user,nombre,apellido1,apellido2 
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
                        'apellido2' => $row['apellido2']
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



    public static function crearTablaTemporal($idEquipoLocal, $nombreEquipoVisitante, $jugadoresSeleccionadosLocal, $jugadoresVisitantes) {

        $result = true;

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

            // Creamos la tabla temporal
            $sql = "CREATE TABLE tmp_partido (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                equipo VARCHAR(50) NOT NULL,
                jugador VARCHAR(50) NOT NULL,
                nombrejugador VARCHAR(50) NOT NULL,
                numero INT(2) NULL,
                titular TINYINT(1) NOT NULL,
                en_juego TINYINT(1) NOT NULL,
                segundosjugados INT DEFAULT 0,
                masmenos INT DEFAULT 0,
                T2A INT DEFAULT 0,
                T2F INT DEFAULT 0,
                T3A INT DEFAULT 0,
                T3F INT DEFAULT 0,
                TLA INT DEFAULT 0,
                TLF INT DEFAULT 0,
                FLH INT DEFAULT 0,
                FLR INT DEFAULT 0,
                TEC INT DEFAULT 0,
                RBO INT DEFAULT 0,
                RBD INT DEFAULT 0,
                ROB INT DEFAULT 0,
                TAP INT DEFAULT 0,
                PRD INT DEFAULT 0,
                AST INT DEFAULT 0
            );";
            $result = $conn->query($sql);
        
            if (!$result) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        
            // Insertamos los jugadores locales seleccionados
            foreach ($jugadoresSeleccionadosLocal as $jugador) {
                $numero = self::getNumJugador($jugador);
                $nombrejugador = self::getnombreJugador($jugador);
                $sql = "INSERT INTO tmp_partido (equipo, jugador, nombrejugador, numero) VALUES ('$idEquipoLocal', '$jugador','$nombrejugador','$numero')";
                $result = $conn->query($sql);
        
                if (!$result) {
                    $result = false;
                    error_log("Error BD ({$conn->errno}): {$conn->error}");
                }
            }
        
            // Insertamos los jugadores visitantes

            for($i = 0; $i < count($jugadoresVisitantes);$i++){
                $sql = "INSERT INTO tmp_partido (equipo, jugador, nombrejugador, numero) VALUES ('$nombreEquipoVisitante', '{$jugadoresVisitantes[$i]['nombre']}', '{$jugadoresVisitantes[$i]['nombre']}', '{$jugadoresVisitantes[$i]['numero']}')";
                $result = $conn->query($sql);
                if (!$result) {
                    $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                }
            }
            
        return $result;
    }



    function updateScore() {

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();
      
        // Obtener los datos de la solicitud
        $player = $_GET['player'];
        $points = $_GET['points'];
      
        // Actualizar la puntuación del jugador
        $query = "UPDATE tmp_partido SET puntos = puntos + $points WHERE jugador = $player";
        $result = mysqli_query($conn, $query);
      
        // Devolver una respuesta
        if ($result) {
          echo "Puntuación actualizada con éxito";
        } else {
          echo "Error al actualizar la puntuación";
        }
    }
    





    public static function actualizarTablaPartido($equipo,$jugador,$accion){

        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partido SET $accion = $accion + 1 WHERE equipo = '$equipo' AND numero = '$jugador'");

        if ($conn->query($query) === false) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    }

    public static function actualizarmasmenos($puntos,$equipo){

        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partido SET masmenos = masmenos + $puntos WHERE equipo = '$equipo' AND en_juego = '1'");

        if ($conn->query($query) === false) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        $query = sprintf("UPDATE tmp_partido SET masmenos = masmenos - $puntos WHERE equipo <> '$equipo' AND en_juego = '1'");

        if ($conn->query($query) === false) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    }




    public static function actualizarTitulares($listaJugadores){
        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $result = true;

        foreach($listaJugadores as $jugador){

            $query = sprintf("UPDATE tmp_partido SET en_juego = 1,titular = 1 WHERE numero = '{$jugador['numero']}' AND jugador =  '{$jugador['jugador']}'");

            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        }

        // Devolver una respuesta
        if ($result) {
            echo "Puntuación actualizada con éxito";
        } else {
            echo "Error al actualizar la puntuación";
        }
    }

    public static function cambiojugador($listaJugadores){

        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $result = true;
        
        $jugador = $listaJugadores[0];

        $query = sprintf("UPDATE tmp_partido SET en_juego = 0 WHERE numero = '{$jugador['numero']}' AND jugador = '{$jugador['jugador']}'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        $jugador = $listaJugadores[1];

        $query = sprintf("UPDATE tmp_partido SET en_juego = 1 WHERE numero = '{$jugador['numero']}' AND jugador = '{$jugador['jugador']}'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        // Devolver una respuesta
        if ($result) {
            echo "Puntuación actualizada con éxito";
        } else {
            echo "Error al actualizar la puntuación";
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////

    //Sirve para saber los jugadores que están en pista para X equipo para asignar las acciones
    public static function getJugadoresJugando($equipo){

        //Obtengo la conexión realizada
            
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM tmp_partido WHERE equipo = '$equipo' AND en_juego = 1 ");

        $rs = $conn->query($query);

        $jugadores = array();

        if ($rs) {
            $i = 0;
            while ($row = $rs->fetch_assoc()) {
                $jugadores[$i] = $row;
                $i++;
            }
            $rs->free();
        } 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $jugadores;
    }

    //Sirve para obtener todos los jugadores de X equipo
    public static function getJugadoresEquipoPartido($equipo){

        //Obtengo la conexión realizada
            
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM tmp_partido WHERE equipo = '$equipo'");

        $rs = $conn->query($query);

        $jugadores = array();

        if ($rs) {
            $i = 0;
            while ($row = $rs->fetch_assoc()) {
                $jugadores[$i] = $row;
                $i++;
            }
            $rs->free();
        } 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $jugadores;
    }

    //Sirve para saber los jugadores que están en pista en los dos equipos

    public static function getJugadoresPista(){
        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM tmp_partido WHERE en_juego = '1'");

        $rs = $conn->query($query);

        $jugadores = array();

        if ($rs) {
            $i = 0;
            while ($row = $rs->fetch_assoc()) {
                $jugadores[$i] = $row;
                $i++;
            }
            $rs->free();
        } 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $jugadores;
    }

    public static function getJugadores(){
        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM tmp_partido");

        $rs = $conn->query($query);

        $jugadores = array();

        if ($rs) {
            $i = 0;
            while ($row = $rs->fetch_assoc()) {
                $jugadores[$i] = $row;
                $i++;
            }
            $rs->free();
        } 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $jugadores;
    }
///////////////////////////////////////////////////////////////////////////////
//OBTENER EL ENTRENADOR DE UN EQUIPO
public static function getEntrenadorEquipo($equipo){

        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT entrenador FROM equipos WHERE id_equipo = '$equipo'");

        $rs = $conn->query($query);

        if ($rs) {
            $row = $rs->fetch_assoc();
            $entrenador = $row['entrenador'];
            $rs->free();
        } 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $entrenador;
}
///////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

    public static function addsecondplayed(){
        //Obtengo la conexión realizada
            
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = sprintf("UPDATE tmp_partido SET segundosjugados = segundosjugados + 1 WHERE en_juego = '1' ");
    
        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    
    }

    public static function gettimeplayed(){
        //Obtengo la conexión realizada
            
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "SELECT SEC_TO_TIME(tiempo_jugado) AS tiempo_formato FROM tmp_partido";
        $rs = $conn->query($query);

        $jugadores = array();

        if ($rs) {
            $i = 0;
            while ($row = $rs->fetch_assoc()) {
                $jugadores[$i] = $row;
                $i++;
            }
            $rs->free();
        } 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $jugadores;
    
    }

    /////////////////////////////////////////////////

    public static function statsfromEquipo($equipo){

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

}   

/*
    function getJugadoresLocales(){

        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT jugador FROM tmp_partido WHERE equipo = 'Local'");

        $rs = $conn->query($query);

        $jugadores = array();
        if ($rs) {
            $i = 0;
            while ($row = $rs->fetch_assoc()) {
                $jugadores[$i] = $row['jugador'];
                $i++;
            }
            print_r($jugadores) ;
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        header('Content-Type: application/json');
        echo json_encode(array_values($jugadores));
    }
*/




?>

