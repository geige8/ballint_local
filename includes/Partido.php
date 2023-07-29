<?php
namespace es\ucm\fdi;

class Partido{

    protected $id;

    public function __construct($id){ //OK
        $this->id = $id;
    }

    public static function saveplayers($equipo,$ganador,$idPartido) {

        // Obtener todos los jugadores
        $listajugadores = Equipo::getJugadores();

        //
        $resultado = Equipo::addpartidojugado($equipo);

        if($ganador){
            $resultado = Equipo::addpartidoganado($equipo,$idPartido);
        }
        else{
            $resultado = Equipo::addpartidoperdido($equipo,$idPartido);
        }


        // Iterar sobre cada jugador
        foreach ($listajugadores as $jugador) {

            // Llamar a la función guardaDatosJugador y almacenar el resultado en una variable
            $resultado = Jugador::guardaDatosJugador($jugador);
            $resultado = Equipo::guardaDatosJugadorenEquipo($jugador);

            // Controlar el resultado
            if ($resultado) {
                echo "El jugador {$jugador['id']} se ha guardado correctamente.";
            } else {
                echo "Error al guardar el jugador.";
            }
        }
    }


    public static function crearTablaTemporal($idEquipoLocal, $nombreEquipoVisitante) {

        $result = true;

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

            // Creamos la tabla temporal
            $sql = "CREATE TABLE tmp_partidoE (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                equipo VARCHAR(50) NOT NULL,
                timeouts INT DEFAULT 0,
                faltasbanquillo INT DEFAULT 0,
                puntos INT DEFAULT 0,
                lider TINYINT(1) NOT NULL,
                empate TINYINT(1) NOT NULL DEFAULT 1,
                alternancias INT DEFAULT 0,
                vecesempatados INT DEFAULT 0,
                veceslider INT DEFAULT 0,
                q1 INT DEFAULT 0,
                q2 INT DEFAULT 0,
                q3 INT DEFAULT 0,
                q4 INT DEFAULT 0,
                extra INT DEFAULT 0
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

    public static function actualizarentrada($local, $visitante,$fecha,$hora){


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


    public static function getIdPartido($local,$visitante){

        $id = 0;

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

        $sql = "SELECT id FROM partidos WHERE local = '$local' AND visitante = '$visitante'";

        $resultado = $conn->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            // Obtener el primer resultado (asumiendo que solo hay una fila coincidente)
            $row = $resultado->fetch_assoc();
            $id = $row['id'];
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $id;

    }

    public static function getpartidosfromEquipo($equipo){


        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM partidos
        WHERE partidos.local = '%s'", $conn->real_escape_string($equipo));
  
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

    public static function getstatsUsuario($partido,$usuario){

        $resultArray = array();
        
        $conn = Aplicacion::getInstance()->getConexionBd();

        $tabla = "tmp_partido_" . $partido;

    // Consulta SQL
    $sql = "SELECT * FROM $tabla WHERE jugador = '$usuario'";

        // Ejecutar la consulta
        $result = $conn->query($sql);

        // Verificar si se encontraron resultados
        if ($result->num_rows > 0) {
            // Almacenar los resultados en un arreglo
            while ($row = $result->fetch_assoc()) {
                $resultArray = $row;
            }
        }

        return $resultArray;
    }

    public static function getstatsPartido($partidoId){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $tabla = "tmp_partidoe_" . $partidoId;
    
        // Consulta SQL
        $sql = "SELECT * FROM $tabla";
    
        // Ejecutar la consulta
        $result = $conn->query($sql);
    
        // Verificar si se encontraron resultados
        if ($result->num_rows > 0) {
            // Almacenar los resultados en un arreglo multidimensional
            $resultArray = array();
            while ($row = $result->fetch_assoc()) {
                $resultArray = $row;
            }
        } else {
            echo "No se encontraron resultados.";
        }
    
        return $resultArray;
    }

    public static function getstatsPartidoEquipos($partidoId){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $tabla = "tmp_partidoe_" . $partidoId;
    
        // Consulta SQL
        $sql = "SELECT * FROM $tabla";
    
        // Ejecutar la consulta
        $result = $conn->query($sql);
    
        // Verificar si se encontraron resultados
        if ($result->num_rows > 0) {
            // Almacenar los resultados en un arreglo multidimensional
            $resultArray = array();
            while ($row = $result->fetch_assoc()) {
                $resultArray[] = $row;
            }
        } else {
            echo "No se encontraron resultados.";
        }
    
        return $resultArray;
    }
    

    public static function getstatsPartidoJugadores($partidoId){
        
        $conn = Aplicacion::getInstance()->getConexionBd();
        $tabla = "tmp_partido_" . $partidoId;
    
        // Consulta SQL
        $sql = "SELECT * FROM $tabla";
    
        // Ejecutar la consulta
        $result = $conn->query($sql);
    
        // Verificar si se encontraron resultados
        if ($result->num_rows > 0) {
            // Almacenar los resultados en un arreglo multidimensional
            $resultArray = array();
            while ($row = $result->fetch_assoc()) {
                $resultArray[] = $row;
            }
        } else {
            echo "No se encontraron resultados.";
        }
    
        return $resultArray;
    }

    public static function actualizarTablaPartido($equipo,$jugador,$accion){

        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("UPDATE tmp_partido SET $accion = $accion + 1 WHERE equipo = '$equipo' AND numero = '$jugador'");

        if ($conn->query($query) === false) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    }

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

    public static function addtimeout($equipo){
        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $result = true;

        $query = sprintf("UPDATE tmp_partidoE SET timeouts = timeouts + 1 WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = self::parcialTimeout();
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
      
        return $result;
    }

    public static function parcialTimeout(){
        //Obtengo la conexión realizada
           
        $conn = Aplicacion::getInstance()->getConexionBd();

        $result = true;

        $query = sprintf("UPDATE tmp_partidoE SET parcial_lastto = 0");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
      
        return $result;
    }

    public static function addfaltabanquillo($equipo){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $result = true;

        $query = sprintf("UPDATE tmp_partidoE SET faltasbanquillo = faltasbanquillo + 1 WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
      
        return $result;

        
    }



    public static function parciales($puntos,$equipo){


        //1º PARCIAL: EL GENERAL

        $result = self::addPuntosParcialGeneral($puntos,$equipo);
        //$result = self::checkParcial($puntos,$equipo);


        //2º PARCIAL: TRAS EL ULTIMO CAMBIO

        $result = self::addPuntosParcialCambio($puntos,$equipo);

        //3º PARCIAL: TRAS EL ULTIMO TIME-OUT

        $result = self::addPuntosParcialTimeOut($puntos,$equipo);


        return $result;
    }

    public static function addPuntosParcialGeneral($puntos,$equipo){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $result = true;

        $query = sprintf("UPDATE tmp_partidoE SET parcial = parcial + $puntos WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    public static function addPuntosParcialCambio($puntos,$equipo){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $result = true;

        $query = sprintf("UPDATE tmp_partidoE SET parcial_lastchange = parcial_lastchange + $puntos WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    public static function addPuntosParcialTimeOut($puntos,$equipo){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $result = true;

        $query = sprintf("UPDATE tmp_partidoE SET parcial_lastto = parcial_lastto + $puntos WHERE equipo = '$equipo'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }



    public static function guardarpuntos($local,$visitante,$puntoslocal,$puntosvisitante){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $result = true;

        $query = sprintf("UPDATE tmp_partidoE SET puntos = $puntoslocal WHERE equipo = '$local'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        $query = sprintf("UPDATE tmp_partidoE SET puntos = $puntosvisitante WHERE equipo = '$visitante'");

        if ($conn->query($query) === false) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
      
        return $result;
    }

    public static function guardarpuntoscuarto($local,$visitante,$puntoslocal,$puntosvisitante,$periodo){

        $cuarto = "";

        switch($periodo){

            case 1:
                $cuarto = "q1";
                break;

            case 2:
                $cuarto ="q2";
                break;

            case 3:
                $cuarto = "q3";
                break;

            case 4:
                $cuarto = "q4";
                break;

            default:
                $cuarto = "extra";
            break;
        }

        $conn = Aplicacion::getInstance()->getConexionBd();
        $result = true;

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

        }else{

            $query = sprintf("UPDATE tmp_partidoE SET $cuarto =  $puntoslocal - puntos WHERE equipo = '$local'");

            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            $query = sprintf("UPDATE tmp_partidoE SET $cuarto =  $puntosvisitante - puntos WHERE equipo = '$visitante'");
    
            if ($conn->query($query) === false) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
    
            self::guardarpuntos($local,$visitante,$puntoslocal,$puntosvisitante);
        }

        return $result;
    }


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
                $queryempate = "SELECT COUNT(DISTINCT puntos) AS cantidad_valores FROM tmp_partidoe";

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




    public static function saberlider(){

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "SELECT CASE
            WHEN puntos1 > puntos2 THEN 1
            WHEN puntos1 < puntos2 THEN 2
            ELSE NULL
            END AS resultado
        FROM (
            SELECT puntos AS puntos1
            FROM tmp_partidoe
            WHERE id = 1
        ) AS t1
            CROSS JOIN (
            SELECT puntos AS puntos2
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

    public static function alternancias(){

      //Obtengo la conexión realizada
      $conn = Aplicacion::getInstance()->getConexionBd();

      $result = true;

      $query = "UPDATE tmp_partidoe SET alternancias = alternancias + 1";

      if ($conn->query($query) === true) {
          echo "Se ha incrementado en 1 el valor de la columna alternancias para ambas filas";
      } else {
          $result = false;
          error_log("Error BD ({$conn->errno}): {$conn->error}");
      }

      return $result;
    }

    

    public static function cambiolider(){

      //Obtengo la conexión realizada
      $conn = Aplicacion::getInstance()->getConexionBd();

      $result = true;

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


    public static function empatar(){

      //Obtengo la conexión realizada
      $conn = Aplicacion::getInstance()->getConexionBd();

      $result = true;
        $query = "UPDATE tmp_partidoe SET empate = 1 WHERE empate = 0";

        if ($conn->query($query) === true) {
            echo "Se han actualizado los empates de 0 a 1 en la columna empate";
            $result = self::vecesempatados();
        } else {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    public static function vecesempatados(){

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();
  
        $result = true;
          $query = "UPDATE tmp_partidoe SET vecesempatados = vecesempatados + 1";
  
          if ($conn->query($query) === true) {
              echo "Se han sumado 1 empate";
          } else {
              $result = false;
              error_log("Error BD ({$conn->errno}): {$conn->error}");
          }
  
          return $result;
      }

    public static function desempatar(){

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();
  
        $result = true;
          $query = "UPDATE tmp_partidoe SET empate = 0 WHERE empate = 1";
  
          if ($conn->query($query) === true) {
              echo "Se han actualizado los empates de 1 a 0 en la columna empate";
          } else {
              $result = false;
              error_log("Error BD ({$conn->errno}): {$conn->error}");
          }
  
          return $result;
      }
        
    


}