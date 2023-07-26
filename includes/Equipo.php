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
    

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Obtener Información

    //Obtener los id_equipo(NacionalMasculino) de todos los equipos
    public static function getListadoEquipos(){
        // Array donde se almacenarán los resultados
        $equipos = array();

      //Obtengo la conexión realizada
      $conn = Aplicacion::getInstance()->getConexionBd();


        // Consulta SQL para obtener todos los registros de la columna id_equipo de la tabla equipos
        $sql = "SELECT id_equipo FROM equipos";

        // Ejecutar la consulta
        if ($resultado = $conn->query($sql)) {
            // Recorrer los resultados y guardarlos en el array $equipos
            while ($fila = $resultado->fetch_assoc()) {
                $equipos[] = $fila['id_equipo'];
            }

            // Liberar el resultado
            $resultado->free();
        }

        return $equipos;

    }

    //Obtener todos los datos de un equipo
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

    //Obtener el nombre completo de un equipo basado en su id_equipo(NacionalMasculino)
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

    //Obtener el id (1,2,3) de un equipo basado en su id_equipo(NacionalMasculino)
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
    
    //Obtener los equipos para un Id de Usuario (1,2,3)
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

//////////////////////////////////////////////////////////////////////////////////

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

    public static function addpartidoganado($equipo,$idPartido){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE equipos SET W = W + 1 WHERE id_equipo = '%s'", $conn->real_escape_string($equipo));
        // Ejecutar la consulta
        $resultado = $conn->query($query);

        if (!$resultado) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        $query = sprintf("UPDATE partidos SET WL = 1 WHERE id = '%s'", $conn->real_escape_string($idPartido));
        // Ejecutar la consulta
        $resultado = $conn->query($query);

        if (!$resultado) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        return $resultado;
    }

    public static function addpartidoperdido($equipo,$idPartido){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE equipos SET L = L + 1 WHERE id_equipo = '%s'", $conn->real_escape_string($equipo));
        // Ejecutar la consulta
        $resultado = $conn->query($query);

        if (!$resultado) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        $query = sprintf("UPDATE partidos SET WL = 1 WHERE id = '%s'", $conn->real_escape_string($idPartido));
        // Ejecutar la consulta
        $resultado = $conn->query($query);

        if (!$resultado) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            echo "La actualización se ha realizado correctamente.";
        }

        return $resultado;
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
                $numero = Jugador::getNumJugador($jugador);
                $nombrejugador = Jugador::getnombreJugador($jugador);
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

///////////////////////////////////////////////////////////////

//MOSTRAR:

public static function mostrarStatsEquipo($equipo){

    $statsequipo = self::statsfromEquipo($equipo);


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
            <td>{$estadisticas['q1']}</td>
            <td>{$estadisticas['q2']}</td>
            <td>{$estadisticas['q3']}</td>
            <td>{$estadisticas['q4']}</td>
            <td>{$estadisticas['extra']}</td>
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
            <th>Q1</th>
            <th>Q2</th>
            <th>Q3</th>
            <th>Q4</th>
            <th>Extra</th>
        </tr>";

    foreach ($estadisticas as $equipoStats) {
        $puntos = $equipoStats['q1'] + $equipoStats['q2'] + $equipoStats['q3'] + $equipoStats['q4'] + $equipoStats['extra'];
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
            <td>{$equipoStats['q1']}</td>
            <td>{$equipoStats['q2']}</td>
            <td>{$equipoStats['q3']}</td>
            <td>{$equipoStats['q4']}</td>
            <td>{$equipoStats['extra']}</td>
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
            <td>{$equipoStats['segundosjugados']}</td>
            <td>{$equipoStats['masmenos']}</td>
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
        <th>Q1</th>
        <th>Q2</th>
        <th>Q3</th>
        <th>Q4</th>
        <th>Extra</th>
    </tr>";

    foreach($partidos as $partido){

        //Necesito que me devuelva las estadisticas de ese jugador para ese partido si es que ha participado
        
        $estadisticas = Partido::getstatsPartido($partido['id']);
    
        //Ademas necesito los datos de ese partido, pero ya los he obtenido antes.

        //Ahora llamaría al metodo mostrar para que se muestre la fila entera de dichas estadisticas.

        $html .= self::mostrarStatsPartidoEquipo($partido,$estadisticas,$partido['id']);
    
    }
    $html .="</table>";

    return $html;
}



}
?>

