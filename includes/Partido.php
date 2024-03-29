<?php
namespace es\ucm\fdi;

class Partido{

    protected $id;

    public function __construct($id){ //OK
        $this->id = $id;
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //TABLA PARTIDOS Y ELEMENTO PARTIDO:
    
    //Insertar un partido en la tabla PARTIDOS
    public static function insertarPartido($local, $visitante,$fecha,$hora){

        $result = true;

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

        $sql = "INSERT INTO partidos (local, visitante, fecha, hora) VALUES ('$local', '$visitante', '$fecha', '$hora')";

        $resultado = $conn->query($sql);

        if (!$resultado) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;

    }

    //Obtener un partido en función del local y visitante
    public static function getIdPartido($local,$visitante){

        $id = 0;

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

        $sql = "SELECT id FROM partidos WHERE local = '$local' AND visitante = '$visitante'";

        $resultado = $conn->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $id = $row['id'];
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $id;

    }

    //Obtener los partidos de un equipo del club
    public static function getpartidosfromEquipo($equipo){

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM partidos WHERE partidos.local = '%s'", $conn->real_escape_string($equipo));
  
        $rs = $conn->query($query);
        
        $result = false;
        $partidos = array();
  
        if ($rs) {
          while ($row = $rs->fetch_assoc()) {
              $partidos[] = $row;
          }
          $result = $partidos;
          $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //TABLAS TEMPORALES DE PARTIDOS

    //*******************************  GETTERS DE LAS TABLAS   ******************************************************** */

    //Obtener Stats de un jugador de un partido
    public static function getstatsUsuario($partido,$usuario){

        $resultArray = array();
        
        $conn = Aplicacion::getInstance()->getConexionBd();

        $tabla = "tmp_partido_" . $partido;

        $sql = "SELECT * FROM $tabla WHERE jugador = '$usuario'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultArray = $row;
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $resultArray;
    }

    //Obtener Stats de un partido de los equipos
    public static function getstatsPartidoEquipos($partidoId){

        $resultArray = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        $tabla = "tmp_partidoe_" . $partidoId;
    
        $sql = "SELECT * FROM $tabla";
    
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultArray[] = $row;
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    
        return $resultArray;
    }

    //Obtener Stats de un partido de los jugadores
    public static function getstatsPartidoJugadores($partidoId){

        $resultArray = array();
        
        $conn = Aplicacion::getInstance()->getConexionBd();

        $tabla = "tmp_partido_" . $partidoId;
    
        $sql = "SELECT * FROM $tabla";
    
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultArray[] = $row;
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    
        return $resultArray;
    }

    //*******************************  MANEJO DE LAS TABLAS   ******************************************************** */

    //Creación Tabla tmp_partidoe
    public static function crearTablaTemporalE($idEquipoLocal, $nombreEquipoVisitante) {

        $result = true;

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

        // Creamos la tabla temporal
        $sql = "CREATE TABLE tmp_partidoE (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            equipo VARCHAR(50) NOT NULL,
            lider TINYINT(1) NOT NULL,
            empate TINYINT(1) NOT NULL DEFAULT 1,
            timeouts INT DEFAULT 0,
            faltasbanquillo INT DEFAULT 0,
            alternancias INT DEFAULT 0,
            vecesempatados INT DEFAULT 0,
            veceslider INT DEFAULT 0,
            parcial_lastto INT DEFAULT 0,
            parcial_lastchange INT DEFAULT 0,
            parcial INT DEFAULT 0,
            mayorventaja INT DEFAULT 0,
            tiempolider INT DEFAULT 0,
            PPP INT DEFAULT 0,
            PPR INT DEFAULT 0,
            MT INT DEFAULT 0,
            MSMS INT DEFAULT 0,
            T2A INT DEFAULT 0,
            T2F INT DEFAULT 0,
            T3A INT DEFAULT 0, 
            T3F INT DEFAULT 0,
            TLA INT DEFAULT 0,
            TLF INT DEFAULT 0, 
            FLH INT DEFAULT 0,
            FLR INT DEFAULT 0,
            RBO INT DEFAULT 0,
            RBD INT DEFAULT 0,
            TEC INT DEFAULT 0, 
            ROB INT DEFAULT 0,
            TAP INT DEFAULT 0,
            PRD INT DEFAULT 0, 
            AST INT DEFAULT 0, 
            PTQ1 INT DEFAULT 0,
            PTQ2 INT DEFAULT 0,
            PTQ3 INT DEFAULT 0,
            PTQ4 INT DEFAULT 0,
            PTQE INT DEFAULT 0
        );";
        
        $result = $conn->query($sql);
    
        if (!$result) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");

        } else {
            // Insertar el equipo local en la tabla
            $sqlInsertLocal = "INSERT INTO tmp_partidoE (equipo) VALUES ('$idEquipoLocal')";
            $resultInsertLocal = $conn->query($sqlInsertLocal);
            if (!$resultInsertLocal) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            // Insertar el equipo visitante en la tabla
            $sqlInsertVisitante = "INSERT INTO tmp_partidoE (equipo) VALUES ('$nombreEquipoVisitante')";
            $resultInsertVisitante = $conn->query($sqlInsertVisitante);
            if (!$resultInsertVisitante) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        }
        
        return $result;
    }

    //Creación Tabla tmp_partido
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
                MT INT DEFAULT 0,
                MSMS INT DEFAULT 0,
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
                AST INT DEFAULT 0,
                PTQ1 INT DEFAULT 0,
                PTQ2 INT DEFAULT 0,
                PTQ3 INT DEFAULT 0,
                PTQ4 INT DEFAULT 0,
                PTQE INT DEFAULT 0
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

    //ACTUALIZAR Tabla tmp_partido CON LA ACCION
    public static function actualizarTablaPartido($equipo,$jugador,$accion){

        $result = true;

        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partido SET $accion = $accion + 1 WHERE equipo = '$equipo' AND numero = '$jugador'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    //ACTUALIZAR Tabla tmp_partido CON LA ACCION
    public static function actualizarTablaPartidoE($equipo,$accion){

        $result = true;

        //Obtengo la conexión realizada
            
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partidoe SET $accion = $accion + 1 WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    //ELIMINAR LA ACCION DE Tabla tmp_partido CON LA ACCION
    public static function removeactualizarTablaPartido($equipo,$jugador,$accion){

        $result = true;

        //Obtengo la conexión realizada
            
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partido SET $accion = $accion - 1 WHERE equipo = '$equipo' AND numero = '$jugador'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }
    
    //ELIMINAR LA ACCION DE Tabla tmp_partido CON LA ACCION
    public static function removeactualizarTablaPartidoE($equipo,$accion){

        $result = true;

        //Obtengo la conexión realizada
            
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partidoe SET $accion = $accion - 1 WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    //Actualizar el campo +/-
    public static function actualizarMSMS($puntos,$equipo){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partido SET MSMS = MSMS + $puntos WHERE equipo = '$equipo' AND en_juego = '1'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        $query = sprintf("UPDATE tmp_partido SET MSMS = MSMS - $puntos WHERE equipo <> '$equipo' AND en_juego = '1'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        $query = sprintf("UPDATE tmp_partidoe SET MSMS = MSMS + $puntos WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        $query = sprintf("UPDATE tmp_partidoe SET MSMS = MSMS - $puntos WHERE equipo <> '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    //Actualizar el campo titular
    public static function actualizarTitulares($listaJugadores){

        $result = true;
           
        $conn = Aplicacion::getInstance()->getConexionBd();

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

        return $result;
    }

    //Renombrar las 2 tablas cuando finaliza el partido
    public static function renombrartablas($id){

        $result = true;

        // Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        // Renombrar la tabla tmp_partido
        $renamedTablePartido = "tmp_partido_" . $id;

        $sqlRenamedTablePartido = "RENAME TABLE `ballint_bbdd`.`tmp_partido` TO `ballint_bbdd`.`$renamedTablePartido`";

        if ($conn->query($sqlRenamedTablePartido) === TRUE) {
            echo "La tabla tmp_partido se ha renombrado correctamente a " . $renamedTablePartido . ".";
        } else {
            $result = false;
            echo "Error al renombrar la tabla tmp_partido: " . $conn->error;
        }
        
        // Renombrar la tabla tmp_partidoe
        $renamedTablePartidoe = "tmp_partidoe_" . $id;

        $sqlRenamedTablePartidoe = "RENAME TABLE `ballint_bbdd`.`tmp_partidoe` TO `ballint_bbdd`.`$renamedTablePartidoe`";

        if ($conn->query($sqlRenamedTablePartidoe) === TRUE) {
            echo "La tabla tmp_partidoe se ha renombrado correctamente a " . $renamedTablePartidoe . ".";
        } else {
            $result = false;
            echo "Error al renombrar la tabla tmp_partidoe: " . $conn->error;
        }
        
        return $result;
    }  

    //*******************************  FUNCIONALIDAD TIEMPOS MUERTOS Y FALTAS BANQUILLOS ******************************************************** */

    //Añadir un TIMEOUT
    public static function addtimeout($equipo){

        $result = true;

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partidoE SET timeouts = timeouts + 1 WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }else{
            //Settear el parcial a 0 ya que ha habido un tiempo muerto
            $result = self::resetparcialTimeout();
        }

        return $result;
    }

    public static function addfaltabanquillo($equipo){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partidoE SET faltasbanquillo = faltasbanquillo + 1 WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
      
        return $result;  
    }

    //*******************************  FUNCIONALIDAD PARCIALES  ******************************************************** */

    //FUNCION GENERAL
    public static function parciales($puntos,$equipo){

        //1º PARCIAL: EL GENERAL

        $result = self::addPuntosParcialGeneral($puntos,$equipo);

        //Para chekear la mayor ventaja
        $result = self::checkParcial($equipo);

        //2º PARCIAL: TRAS EL ULTIMO CAMBIO

        $result = self::addPuntosParcialCambio($puntos,$equipo);

        //3º PARCIAL: TRAS EL ULTIMO TIME-OUT

        $result = self::addPuntosParcialTimeOut($puntos,$equipo);

        return $result;
    }

    //AÑADIR/RESTAR PUNTOS DE LAS DIFERENCIAS DE CADA UNO
    public static function addPuntosParcialGeneral($puntos,$equipo){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partidoE SET parcial = parcial + $puntos WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        $query = sprintf("UPDATE tmp_partidoE SET parcial = parcial - $puntos WHERE equipo <> '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    //COMPARAR EL PARCIAL Y LA VENTAJA PARA VER SI SE SUSTITUYE
    public static function checkParcial($equipo) {

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        //1º OBTENER EL PARCIAL
            $query = "SELECT parcial FROM tmp_partidoE WHERE equipo = '$equipo'";

            $rs = $conn->query($query);

            if ($rs && $rs->num_rows > 0) {
                $row = $rs->fetch_assoc();
                $parcial = $row['parcial'];

                //2º OBTENER LA MAYOR VENTAJA
                $query = "SELECT mayorventaja FROM tmp_partidoE WHERE equipo = '$equipo'";

                $rs = $conn->query($query);

                if ($rs && $rs->num_rows > 0) {
                    $row = $rs->fetch_assoc();
                    $mayorventaja = $row['mayorventaja'];

                    //3º COMPARAR AMBAS
                    if($parcial > $mayorventaja){

                        $query = "UPDATE tmp_partidoE SET mayorventaja = parcial WHERE equipo = '$equipo'";

                        if ($conn->query($query) === false) {
                            $result = false;
                            error_log("Error BD ({$conn->errno}): {$conn->error}");
                        }
                    }
                } else {
                    $result = false;
                    error_log("Error BD ({$conn->errno}): {$conn->error}");
                }
            } else {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        return $result;
    }

    //AÑADIR PUNTOS A LOS PARCIALES DE CAMBIO
    public static function addPuntosParcialCambio($puntos,$equipo){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partidoE SET parcial_lastchange = parcial_lastchange + $puntos WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    //AÑADIR PUNTOS A LOS PARCIALES DE TIMEOUT
    public static function addPuntosParcialTimeOut($puntos,$equipo){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partidoE SET parcial_lastto = parcial_lastto + $puntos WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    //GET PUNTOS DE PARCIAL DE CAMBIO
    public static function getParcialCambio(){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT parcial_lastchange FROM tmp_partidoE");

        $rs = $conn->query($query);

        $result = array();

        if ($rs) {
            $i = 0;
            while ($row = $rs->fetch_assoc()) {
                $result[$i] = $row['parcial_lastchange'];
                $i++;
            }
            $rs->free();
        } 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    //GET PUNTOS DE PARCIAL DE TIMEOUT
    public static function getParcialTO(){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT parcial_lastto FROM tmp_partidoE");

        $rs = $conn->query($query);

        $result = array();

        if ($rs) {
            $i = 0;
            while ($row = $rs->fetch_assoc()) {
                $result[$i] = $row['parcial_lastto'];
                $i++;
            }
            $rs->free();
        } 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }
    
    //Reset del parcial CAMBIO a 0
    public static function resetparcialCambio(){

        $result = true;
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partidoE SET parcial_lastchange = 0");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
      
        return $result;
    }

    //Reset del parcial TIMEOUT a 0
    public static function resetparcialTimeout(){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partidoE SET parcial_lastto = 0");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
    //*******************************  FUNCIONALIDAD GUARDAR PUNTOS TOTALES Y DE CUARTO  ******************************************************** */

    //GUARDAR PUNTOS TOTALES DE AMBOS EQUIPOS
    public static function guardarpuntos($local,$visitante,$puntoslocal,$puntosvisitante){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partidoE SET PPP = $puntoslocal WHERE equipo = '$local'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        $query = sprintf("UPDATE tmp_partidoE SET PPR = $puntosvisitante WHERE equipo = '$local'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        $query = sprintf("UPDATE tmp_partidoE SET PPP = $puntosvisitante WHERE equipo = '$visitante'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        $query = sprintf("UPDATE tmp_partidoE SET PPR = $puntoslocal WHERE equipo = '$visitante'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
      
        return $result;
    }

    //GUARDAR PUNTOS CUARTOS DE UN JUGADOR
    public static function guardarpuntoscuartoJugador($cuarto,$jugador,$puntos){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partido SET $cuarto =  $cuarto + $puntos WHERE jugador = '$jugador'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    //GUARDAR PUNTOS CUARTO DE LOS EQUIPOS
    public static function guardarpuntoscuarto($local,$visitante,$puntoslocal,$puntosvisitante,$periodo){

        $cuarto = "";

        switch($periodo){

            case 1:
                $cuarto = "PTQ1";
                break;

            case 2:
                $cuarto ="PTQ2";
                break;

            case 3:
                $cuarto = "PTQ3";
                break;

            case 4:
                $cuarto = "PTQ4";
                break;

            case 5:
                $cuarto = "PTQE";
            break;
        }

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        if($periodo === '1'){

            $query = sprintf("UPDATE tmp_partidoE SET $cuarto =  $puntoslocal WHERE equipo = '$local'");

            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            $query = sprintf("UPDATE tmp_partidoE SET $cuarto =  $puntosvisitante WHERE equipo = '$visitante'");
    
            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            self::guardarpuntos($local,$visitante,$puntoslocal,$puntosvisitante);

        }

        if($periodo === '2'){

            $query = sprintf("UPDATE tmp_partidoE SET $cuarto =  $puntoslocal - PTQ1 WHERE equipo = '$local'");

            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            $query = sprintf("UPDATE tmp_partidoE SET $cuarto =  $puntosvisitante - PTQ1 WHERE equipo = '$visitante'");
    
            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            self::guardarpuntos($local,$visitante,$puntoslocal,$puntosvisitante);

        }

        if($periodo === '3'){

            $query = sprintf("UPDATE tmp_partidoE SET $cuarto =  $puntoslocal - PTQ1 - PTQ2 WHERE equipo = '$local'");

            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            $query = sprintf("UPDATE tmp_partidoE SET $cuarto =  $puntosvisitante - PTQ1 - PTQ2 WHERE equipo = '$visitante'");
    
            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            self::guardarpuntos($local,$visitante,$puntoslocal,$puntosvisitante);

        }

        if($periodo === '4'){

            $query = sprintf("UPDATE tmp_partidoE SET $cuarto =  $puntoslocal - PTQ1 - PTQ2 - PTQ3 WHERE equipo = '$local'");

            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            $query = sprintf("UPDATE tmp_partidoE SET $cuarto =  $puntosvisitante - PTQ1 - PTQ2 - PTQ3 WHERE equipo = '$visitante'");
    
            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            self::guardarpuntos($local,$visitante,$puntoslocal,$puntosvisitante);

        }

        if($periodo === '5'){

            $query = sprintf("UPDATE tmp_partidoE SET $cuarto =  $puntoslocal - PTQ1 - PTQ2 - PTQ3 - PTQ4 WHERE equipo = '$local'");

            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            $query = sprintf("UPDATE tmp_partidoE SET $cuarto =  $puntosvisitante - PTQ1 - PTQ2 - PTQ3 - PTQ4 WHERE equipo = '$visitante'");
    
            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            self::guardarpuntos($local,$visitante,$puntoslocal,$puntosvisitante);

        }
        
        return $result;
    }
    
    
    //*******************************  FUNCIONALIDAD MARCADOR Y MÉTRICAS  ******************************************************** */

    //FUNCION GENERAL DE CHECKEAR EL MARCADOR
    public static function checkmarcador(){

        //1º Mirar si había empate, quiere decir que líder esta a 0
            //2º Si había empate, como hay una canasta, si el lider pasa a ser otro, hay una alternancia, y un cambio de líder, se pone empate a 0, si no hay cambio de lider, no hay alternancia.
        //3º Si no había empate, 
            //3.1 Hay que mirar si ahora hay empate, si es así se pone empate a 1 y lider al que estaba, no hay alternancia.
            //3.2 Si ahora no hay empate
                //3.2.1 Hay que mirar si sigue el mismo lider, si es así no pasa nada, 
                //3.2.2. Hay que mirar si es otro lider, si es así, hay una alternancia y cambio de lider.

        $conn = Aplicacion::getInstance()->getConexionBd();
        $resultado = true;

        //1º Mirar si el resultado está empatado.
        $queryempate = "SELECT COUNT(*) AS cantidad_empates FROM tmp_partidoe WHERE empate = 1";
        $resultado = $conn->query($queryempate);
        //Si la consulta es correcta
        if ($resultado !== false) {
            echo "La 1a Consulta es correcta\n";
            $row = $resultado->fetch_assoc();
            $cantidadEmpates = $row['cantidad_empates'];
            //Si estaban antes de la canasta empatados
            if ($cantidadEmpates > 0) {
                    echo "Hay filas de empate con el valor 1 en la columna empate";
                    // Por lo tanto HABÍA EMPATE
                    //Necesito saber quien era el lider antes de que se produjese el empate anterior, o quien llegó al empate siendo lider, si el 1 o el 2
                    $query = "SELECT id
                    FROM tmp_partidoe
                    WHERE lider = 1
                    LIMIT 1";
                
                    $resultado2 = $conn->query($query);
                //Si la consulta es correcta
                if ($resultado2 !== false) {
                    if ($resultado2->num_rows > 0) {
                        //Si el resultado no era 0-0, osea que había un líder, lo obtengo
                        $row = $resultado2->fetch_assoc();
                        $lideranterior = $row['id'];
                        echo "El lider previo al empate era: " . $lideranterior;

                        //Necesito saber quien es el lider nuevo saliendo del empate si 1 o 2
                        $lidernuevo = self::saberlider();
                        
                        //Si el lider nuevo es el mismo que el que había antes de llegar a ese empate no hay cambio de lider ni hay alternancia
                        if($lidernuevo === $lideranterior){
                            $result = self::desempatar();
                        }
                        else{//Si el lider nuevo no es el mismo que el anterior, hay cambio de lider y alternancia.

                            $result = self::cambiolider();
                            $result = self::desempatar();
                            $result = self::alternancias();

                        }
                    } else {
                        //El marcador era 0 a 0, no había ningun lider previo al empate
                        echo "No se encontraron filas en la consulta";
                        //Hay una alternancia y un cambio de lider al lider nuevo.
                        $lidernuevo = self::saberlider();

                        $query = "UPDATE tmp_partidoe 
                        SET lider = 1, 
                            veceslider = CASE
                                            WHEN id = 1 AND lider = 1 THEN veceslider + 1
                                            WHEN id = 2 AND lider = 1 THEN veceslider + 1
                                            ELSE veceslider
                                          END 
                        WHERE id = {$lidernuevo}";
            
                        if ($conn->query($query) === true) {
                            echo "Se ha actualizado el valor de la columna lider para el ID {$lidernuevo} a 1";
                        } else {
                            $result = false;
                            error_log("Error BD ({$conn->errno}): {$conn->error}");
                        }

                        //Añado una alternancia
                        $result = self::alternancias();
                        $result = self::desempatar();

                    }
                } else {
                    $result = false;
                    error_log("Error BD ({$conn->errno}): {$conn->error}");
                } 
                $resultado2->free();          
            } else {
                echo "No hay filas de empate con el valor 1 en la columna empate";
                // Por lo tanto NO HABIA EMPATE

                //3º Si no había empate, 
                    //3.1 Hay que mirar si ahora hay empate, si es así se pone empate a 1 y lider al que estaba, no hay alternancia.
                    //3.2 Si ahora no hay empate
                        //3.2.1 Hay que mirar si sigue el mismo lider, si es así no pasa nada, 
                        //3.2.2. Hay que mirar si es otro lider, si es así, hay una alternancia y cambio de lider.

                //3.1 Hay que mirar si ahora hay empate, si es así se pone empate a 1 y lider al que estaba, no hay alternancia.
                $queryempate = "SELECT COUNT(DISTINCT PPP) AS cantidad_valores FROM tmp_partidoe";
                $resultado3 = $conn->query($queryempate);

                if ($resultado3 !== false) {
                    $row = $resultado3->fetch_assoc();
                    $cantidadValores = $row['cantidad_valores'];
                    if ($cantidadValores == 1) {
                        // El valor es igual a 1, por lo tanto hay empate
                        echo "La consulta devolvió 1";
                        // Si es así se pone empate a 1 y lider al que estaba, no hay alternancia.
                        $result = self::empatar();
                    } else {
                        // El valor es diferente de 1 
                        //Por lo tanto no hay empate
                        echo "La consulta no devolvió 1";
                        //3.2 Si ahora no hay empate
                            //3.2.1 Hay que mirar si sigue el mismo lider, si es así no pasa nada, 
                            //3.2.2. Hay que mirar si es otro lider, si es así, hay una alternancia y cambio de lider.
                        //Necesito saber quien era el lider antes de que se produjese el empate anterior, o quien llegó al empate siendo lider, si el 1 o el 2

                        $query = "SELECT id
                        FROM tmp_partidoe
                        WHERE lider = 1
                        LIMIT 1";
                
                        $resultado4 = $conn->query($query);

                        if ($resultado4 !== false) {
                            if ($resultado4->num_rows > 0) {
                                $row = $resultado4->fetch_assoc();
                                $lideranterior = $row['id'];
                                echo "El lider previo al empate era: " . $lideranterior;

                                //Necesito saber quien es el lider nuevo si 1 o 2
                                $lidernuevo = self::saberlider();
                            
                                //Si el lider nuevo es el mismo que el anterior no hay cambio de lider ni hay alternancia
                                if($lidernuevo === $lideranterior){
                                    $result = self::desempatar();
                                }
                                else{//Si el lider nuevo no es el mismo que el anterior, hay cambio de lider y alternancia.

                                    $result = self::cambiolider();
                                    $result = self::desempatar();
                                    $result = self::alternancias();

                                }
                            } else {
                                echo "No se encontraron filas en la consulta";
                            } 
                        }else {
                            $result = false;
                            error_log("Error BD ({$conn->errno}): {$conn->error}");
                        }
                        $resultado4->free();
                    }
                }else {
                    $result = false;
                    error_log("Error BD ({$conn->errno}): {$conn->error}");
                }
                $resultado3->free();
            }
        }else{
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        $resultado->free();

        return $result;
    }

    //QUIERO SABER QUIEN ES EL LIDER
    public static function saberlider(){

        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "SELECT CASE
            WHEN puntos1 > puntos2 THEN 1
            WHEN puntos1 < puntos2 THEN 2
            ELSE NULL
            END AS resultado
        FROM (
            SELECT PPP AS puntos1
            FROM tmp_partidoe
            WHERE id = 1
        ) AS t1
            CROSS JOIN (
            SELECT PPP AS puntos2
            FROM tmp_partidoe
            WHERE id = 2
        ) AS t2";

        $resultado = $conn->query($query);

        if ($resultado !== false) {
            if ($resultado->num_rows === 1) {
                $row = $resultado->fetch_assoc();
                $lidernuevo = $row['resultado'];
                echo "El valor obtenido es: " . $lidernuevo;
            } else {
                echo "No se encontraron filas en la consulta";
            }
            $resultado->free();

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    
        return $lidernuevo;
    }

    //Se añade 1 a la columna que cuenta los cambios de líder
    public static function alternancias(){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "UPDATE tmp_partidoe SET alternancias = alternancias + 1";

        if ($conn->query($query) === true) {
            echo "Se ha incrementado en 1 el valor de la columna alternancias para ambas filas";
        } else {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    //HAY UN CAMBIO DE LIDER
    public static function cambiolider(){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "UPDATE tmp_partidoe
        SET lider = CASE
            WHEN id = 1 AND lider = 1 THEN 0
            WHEN id = 1 AND lider = 0 THEN 1
            WHEN id = 2 AND lider = 1 THEN 0
            WHEN id = 2 AND lider = 0 THEN 1
            ELSE lider
            END,
            veceslider = CASE
            WHEN id = 1 AND lider = 1 THEN veceslider + 1
            WHEN id = 2 AND lider = 1 THEN veceslider + 1
            ELSE veceslider
        END";

        if ($conn->query($query) === true) {
            echo "Los valores de lider y veceslider se han actualizado correctamente";
        } else {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;

    }

    //Cambiar el valor de la columna EMPATE a 1 --> EMPATADOS
    public static function empatar(){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();
  
        $query = "UPDATE tmp_partidoe SET empate = 1 WHERE empate = 0";
  
        if($conn->query($query) === true) {
            echo "Se han actualizado los empates de 0 a 1 en la columna empate";

            //Añadir un empate a veces empatados
            $result = self::vecesempatados();
        } else {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
  
        return $result;
    }

    //Añadir 1 a la columna veces empatados
    public static function vecesempatados(){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "UPDATE tmp_partidoe SET vecesempatados = vecesempatados + 1";
    
        if ($conn->query($query) === true) {
            echo "Se han sumado 1 empate";
        } else {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    
        return $result;
    }

    //Cambiar el valor de la columna EMPATE a 0 --> NO EMPATADOS
    public static function desempatar(){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();
  
        $query = "UPDATE tmp_partidoe SET empate = 0 WHERE empate = 1";

        if ($conn->query($query) === true) {
            echo "Se han actualizado los empates de 1 a 0 en la columna empate";
        } else {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
  
        return $result;
    }
        
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    public static function saveplayers($equipo,$ganador,$idPartido) {

        $listajugadores = Partido::getJugadores();

        $equipos = Partido::getEquipos();

        $resultado = Equipo::addpartidojugado($equipo);

        if($ganador == 1){
            $resultado = Equipo::addpartidoganado($equipo,$idPartido);
        }
        else{
            $resultado = Equipo::addpartidoperdido($equipo,$idPartido);
        }

        // Iterar sobre cada jugador
        foreach ($listajugadores as $jugador) {

            // Llamar a la función guardaDatosJugador y almacenar el resultado en una variable
            $resultado = Jugador::guardaDatosJugador($jugador);

        }

        $resultado = Equipo::guardaDatosEquipo($equipos[0]);

        // Controlar el resultado
        if ($resultado) {
            echo "El jugador {$jugador['id']} se ha guardado correctamente.";
        } else {
            echo "Error al guardar el jugador.";
        }
    }

    public static function cambiojugador($listaJugadores){

        $result = true;
          
        $conn = Aplicacion::getInstance()->getConexionBd();

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

        if ($result) {
            $result = Partido::resetparcialCambio();
            echo "Puntuación actualizada con éxito";
        } else {
            echo "Error al actualizar la puntuación";
        }

        return $result;
    }

    //Sirve para saber los jugadores que están en pista para X equipo para asignar las acciones
    public static function getJugadoresJugando($equipo){
            
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
    public static function getJugadoresEquipoPartidoJSON($equipo){

        $equipoTrue = json_decode($equipo, true);
            
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM tmp_partido WHERE equipo = '$equipoTrue'");

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

    public static function getJugadoresEquipoPartido($equipo){
            
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

    public static function getFecha($partido_id) {
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = sprintf("SELECT fecha FROM partidos WHERE id = %d", $partido_id);
    
        $rs = $conn->query($query);
    
        $fecha = null;
    
        if ($rs) {
            $row = $rs->fetch_assoc();
            if ($row) {
                $fecha = $row['fecha'];
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    
        return $fecha;
    }
    
    public static function getEquipos(){
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM tmp_partidoe");

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

    public static function getJugadoresLocal($equipo){
           
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

    public static function getJugadoresporFactor($factor,$equipo){
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT numero, jugador, nombrejugador, $factor FROM tmp_partido WHERE equipo = '$equipo'");

        $rs = $conn->query($query);

        $jugadores = array();

        if ($rs) {
            $i = 0;
            while ($row = $rs->fetch_assoc()) {

                //Quiero tambien obtener el valor de su historico
                $historico = self::getHistoricoJugador($row['jugador'],$factor);

                $jugadores[$i] = array(
                    'numero' => $row['numero'],
                    'nombrejugador' => $row['nombrejugador'],
                    'factor' => $row[$factor], 
                    'historico' => $historico,
                );
                $i++;
            }
            $rs->free();
        } 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $jugadores;
    }

    public static function getJugadoresporFactorAvanzado($factor,$equipo){
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        //1º Necesito los jugadores, luego sacar su estadistica avanzada y luego ver lo que necesito

        $players = Partido::getJugadoresEquipoPartido($equipo);

        $jugadores = array();

        $i = 0;

        foreach($players as $jugador){

            $usuario = Usuario::getDatosPerfilJugador($jugador['jugador']);

            //Necesito obtener tambien la linea de estadistica del equipo de la tabla equipo o de la tabla tmp_partidoe?

            $player = Jugador::statsfromJugador($usuario);

            $valor = $player[$factor];

            $query = sprintf("SELECT numero, nombrejugador FROM tmp_partido WHERE equipo = '%s' AND jugador = '%s'", $equipo, $jugador['jugador']);

            $rs = $conn->query($query);

            if ($rs) {

                while ($row = $rs->fetch_assoc()) {

                    $jugadores[$i] = array(
                        'numero' => $row['numero'],
                        'nombrejugador' => $row['nombrejugador'],
                        'factor' => 0, 
                        'historico' => $valor,
                    );
                    $i++;
                }
                $rs->free();
            } 
            else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }

        }

        return $jugadores;
    }

    public static function getEvaluacionJugador($jugador){

        $evaluaciones = array();

        $jugadorArray = json_decode($jugador, true);

        $usuario = Usuario::getDatosPerfilJugador($jugadorArray['jugador']);

        $historico = Jugador::statsfromJugador($usuario);

        //Tengo por un lado la fila de la tabla tmp_partido.

        //Tengo por otro lado las stats del jugador 

        $variables = array(
            'MT', 'MSMS', 'T2A', 'T2F', 'T3A', 'T3F', 'TLA', 'TLF', 'FLH', 'FLR',
            'TEC', 'RBO', 'RBD', 'ROB', 'TAP', 'PRD', 'AST', 'PTQ1', 'PTQ2', 'PTQ3', 'PTQ4', 'PTQE'
        );
        
        foreach ($variables as $variable) {
            if ($historico['PJ'] != 0) {
                if ($jugadorArray[$variable] >= ($historico[$variable] / $historico['PJ'])) {
                    $evaluaciones[$variable] = "1";
                } else {
                    $evaluaciones[$variable] = "0";
                }
            } else {
                $evaluaciones[$variable] = "1"; 
            }
        }
        

        return  $evaluaciones;
    }

    public static function getEvaluacionEquipo($equipo){

        $evaluaciones = array();

        $equipoArray = json_decode($equipo, true);

        $team = Equipo::datosfromEquipo($equipoArray['equipo']);

        $historico = Equipo::statsfromEquipo($team);

        //Tengo por un lado la fila de la tabla tmp_partido.

        //Tengo por otro lado las stats del jugador 

        $variables = array(
            'MT', 'MSMS', 'T2A', 'T2F', 'T3A', 'T3F', 'TLA', 'TLF', 'FLH', 'FLR',
            'TEC', 'RBO', 'RBD', 'ROB', 'TAP', 'PRD', 'AST', 'PTQ1', 'PTQ2', 'PTQ3', 'PTQ4', 'PTQE'
        );
        
        foreach ($variables as $variable) {
            if ($historico['PJ'] != 0) {
                if ($equipoArray[$variable] >= ($historico[$variable] / $historico['PJ'])) {
                    $evaluaciones[$variable] = "1";
                } else {
                    $evaluaciones[$variable] = "0";
                }
            } else {
                $evaluaciones[$variable] = "1"; 
            }
        }
        

        return  $evaluaciones;
    }

    public static function getHistoricoJugador($jugador, $factor){

        $historico = 0;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT $factor FROM jugadores WHERE user = '$jugador'");

        $rs = $conn->query($query);

        if ($rs && $rs->num_rows > 0) {
            $row = $rs->fetch_assoc();
            $historico = $row[$factor];
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $historico;



    }
    
    public static function addsecondplayed(){

        $result = true;
            
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = sprintf("UPDATE tmp_partido SET MT = MT + 1 WHERE en_juego = '1' ");
    
        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        $query = sprintf("UPDATE tmp_partidoe SET MT = MT + 1");
    
        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    
    }

    public static function addtiempolider($ganador){

        $conn = Aplicacion::getInstance()->getConexionBd();

        switch($ganador){

            case 0:
                $query = sprintf("UPDATE tmp_partidoe SET tiempolider = tiempolider + 1 WHERE id =  2 ");
    
                if ($conn->query($query) === false) {
                    error_log("Error BD ({$conn->errno}): {$conn->error}");
                }
            break;
            case 1:
                $query = sprintf("UPDATE tmp_partidoe SET tiempolider = tiempolider + 1 WHERE id =  1 ");
    
                if ($conn->query($query) === false) {
                    error_log("Error BD ({$conn->errno}): {$conn->error}");
                }
            break;
            case 2:
            break;
        }    
    }

    public static function gettimeplayed(){
            
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

}