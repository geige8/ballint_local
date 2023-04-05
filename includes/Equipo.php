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

    public static function mostrarCajaEquipo($equipo){

        $datosEquipo = self::getDatosEquipo($equipo);
        $html = '';

        $html .= <<<EOS
            <div class="equipo">
                <h1>{$datosEquipo['id_equipo']}</h1>
                <h1>{$datosEquipo['nombre_equipo']}</h1>
                <h1>{$datosEquipo['seccion']}</h1>
            </div>
        EOS;

        return $html;
    }

    public static function mostrarListadoEquipos($arrayEquipos){
        $html = '';
        foreach ($arrayEquipos as $equipo) {
            $html .= self::mostrarCajaEquipo($equipo);
        }

        return $html;
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
    
    public static function equiposfromUserId($idUser){

        //Lo primero que tengo que obtener son los equipos de ese Id

        $equipos = self::getEquiposfromUserId($idUser);

        return self::mostrarListadoEquipos($equipos);

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
        $query = "SELECT numero FROM usuarios WHERE user = '$jugador'";

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

    


    public static function getJugadoresEquipo($equipo_id){

        $id_equipo = self::getidEquipo($equipo_id);

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT user,nombre,apellido1,apellido2 
        FROM usuarios 
        INNER JOIN usuarios_equipos 
        ON usuarios.id = usuarios_equipos.usuario_id  
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
                numero INT(2) NULL,
                T2A INT DEFAULT 0,
                T2F INT DEFAULT 0,
                T3A INT DEFAULT 0,
                T3F INT DEFAULT 0,
                TLA INT DEFAULT 0,
                TLF INT DEFAULT 0,
                FAL INT DEFAULT 0,
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
                $sql = "INSERT INTO tmp_partido (equipo, jugador, numero) VALUES ('$idEquipoLocal', '$jugador','$numero')";
                $result = $conn->query($sql);
        
                if (!$result) {
                    $result = false;
                    error_log("Error BD ({$conn->errno}): {$conn->error}");
                }
            }
        
            // Insertamos los jugadores visitantes

            for($i = 0; $i < count($jugadoresVisitantes);$i++){
                $sql = "INSERT INTO tmp_partido (equipo, jugador, numero) VALUES ('$nombreEquipoVisitante', '{$jugadoresVisitantes[$i]['nombre']}', '{$jugadoresVisitantes[$i]['numero']}')";
                $result = $conn->query($sql);
                if (!$result) {
                    $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                }
            }
            
        return $result;
    }


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
    
    public static function getJugadoresPartido($equipo){

        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT numero FROM tmp_partido WHERE equipo = '$equipo'");

        $rs = $conn->query($query);

        $jugadores = array();
        if ($rs) {
            $i = 0;
            while ($row = $rs->fetch_assoc()) {
                $jugadores[$i] = $row['numero'];
                $i++;
            }

            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $jugadores;
    }



    public static function actualizarTablaPartido($equipo,$jugador,$accion){

        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partido SET $accion = $accion + 1 WHERE equipo = '$equipo' AND numero = '$jugador'");

        if ($conn->query($query) === false) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    }
}   
?>