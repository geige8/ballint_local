<?php
namespace es\ucm\fdi;

class Usuario{

    //Como las herederas tienen que tener esas variables, se pone protected
    protected $nombreUsuario;

    protected $password;

    protected $idUsuario;

    public function __construct($nombreUsuario, $password, $id){ //OK
        $this->nombreUsuario = $nombreUsuario;
        $this->password = $password;
        $this->idUsuario = $id;
    }

    public function getNombreUsuario(){

        return $this->nombreUsuario;
    }

    public function getIdUsuario(){

        return $this->idUsuario;
    }

    public static function login($nombreUsuario, $password1){ //OK

        //Quiero obtener la password del nombre de usuario que me la devolvera en el caso de que exista
        $usuario = self::buscaUsuario($nombreUsuario);

        //Si me devuelve algo Y las passwords introducidas y obtenidas son iguales, es que hay acceso
        if ($usuario && $usuario->compruebaPassword($password1,$usuario->password)) {

            return $usuario;
        }

        return false;
    }

    public static function buscaUsuario($nombreUsuario){ //OK

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM credenciales WHERE user='%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;

        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['user'], $fila['password'], $fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    
    public function compruebaPassword($password1,$password2){

        return password_verify($password1,$password2);
    }
    








    //Métodos Static
    
    public static function cambiarPassword($password1, $password2){

        $usuario = $_SESSION['nombre'];

        if($password1 === $password2 && $password1 !== ''){
            $passwordAux = trim($password1);
            $passwordAux = filter_var($passwordAux, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (mb_strlen($passwordAux) < 5 || mb_strlen($passwordAux) > 20) {
                $result = 4;
            } else {
                $passwordAux = password_hash($passwordAux, PASSWORD_DEFAULT);

                $connection  = Aplicacion::getInstance()->getConexionBd();
                $query = "UPDATE credenciales SET password = '" . $passwordAux . "' WHERE user = '" . $usuario . "'";
                $result = $connection->query($query);
                $result = 1;
            }

        } else if($password1 === '' || $password2 === ''){
            $result = 2;
        } else{
            $result = 3;
        }

        return $result;
    }

    public static function getDatosPerfilJugador($nombreUsuario){

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM jugadores WHERE user='%s'", $conn->real_escape_string($nombreUsuario));
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

    public static function getDatosPerfilEntrenador($nombreUsuario){

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM entrenadores WHERE user='%s'", $conn->real_escape_string($nombreUsuario));
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




    public static function getRoles($user){
        // Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = sprintf("SELECT DISTINCT rol FROM credenciales WHERE user='%s'", $conn->real_escape_string($user));
        $rs = $conn->query($query);
        $result = array();
    
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = $fila['rol'];
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
///////////////////////////////////////////////////////////////
//Registro

    public static function registrarUsuario($usuarionombre,$nombre,$apellido1,$apellido2,$tipoUsuario,$equipoUsuario,$numero){
        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $passwordAux = password_hash('12345', PASSWORD_DEFAULT);

        $query = "INSERT INTO credenciales (user,password,rol)  VALUES ('$usuarionombre', '$passwordAux', '$tipoUsuario')"; 

        $rs = $conn->query($query);

        if (!$rs) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        else{
             // Obtener el ID de la fila insertada

            //En función de su rol lo meto a jugadores o entrenadores

            switch($tipoUsuario){

                case 'E':
                    $insertedId = $conn->insert_id;
                    $result = self::insertarUsuarioEquipo($insertedId, $equipoUsuario);
                    $result = self::insertaEntrenadorEquipo($usuarionombre,$nombre,$apellido1,$apellido2);
                break;

                case 'J':
                    $insertedId = $conn->insert_id;
                    $result = self::insertarUsuarioEquipo($insertedId, $equipoUsuario);
                    $result = self::insertarJugadorEquipo($usuarionombre,$nombre,$apellido1,$apellido2,$numero);
                break;

                case 'DT':
                    $insertedId = $conn->insert_id;
                    $result = self::insertarDTEquipo($insertedId);
                    $result = self::insertaDirectorTecnicoEquipo($usuarionombre,$nombre,$apellido1,$apellido2);
                break;

                default:
                break;
            }

        }

        return $result;
    }

    public static function eliminarUsuario($usuarioEliminar) {

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();
    
        // Preparar la consulta SQL
        $query = "DELETE FROM credenciales WHERE user = '$usuarioEliminar'";

        $rs = $conn->query($query);

        if (!$rs) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;

    }
    

    public static function insertaEntrenadorEquipo($usuarionombre,$nombreent,$apellidoent1,$apellidoent2){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "INSERT INTO entrenadores (user,nombre,apellido1,apellido2) VALUES ('$usuarionombre','$nombreent','$apellidoent1','$apellidoent2')"; 

        $rs = $conn->query($query);

        if (!$rs) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    public static function insertaDirectorTecnicoEquipo($usuarionombre,$nombreent,$apellidoent1,$apellidoent2){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "INSERT INTO directorestecnicos (user,nombre,apellido1,apellido2) VALUES ('$usuarionombre','$nombreent','$apellidoent1','$apellidoent2')"; 

        $rs = $conn->query($query);

        if (!$rs) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    public static function insertarJugadorEquipo($usuarionombre,$nombrej,$apellido1j,$apellido2j,$numero){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "INSERT INTO jugadores (user,nombre,apellido1,apellido2,numero) VALUES ('$usuarionombre','$nombrej','$apellido1j','$apellido2j','$numero')"; 

        $rs = $conn->query($query);

        if (!$rs) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    public static function insertarUsuarioEquipo($idUsuario, $equipoUsuario){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $idEquipoUsuario = Equipo::getidEquipo($equipoUsuario);

        $query = "INSERT INTO usuarios_equipos (equipo_id,usuario_id)  VALUES ($idEquipoUsuario,$idUsuario)"; 

        $rs = $conn->query($query);

        if (!$rs) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    public static function insertarDTEquipo($idUsuario){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $equiposClub = Equipo::getListadoEquipos();

        foreach($equiposClub as $equipo){

            $idEquipoUsuario = Equipo::getidEquipo($equipo);

            $query = "INSERT INTO usuarios_equipos (equipo_id,usuario_id)  VALUES ($idEquipoUsuario,$idUsuario)"; 

            $rs = $conn->query($query);
    
            if (!$rs) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }

        }

        return $result;
    }


    public static function addUsuarioaEquipo($usuarioaequipo,$equipoausuario){

        $result = true;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $idUsuario = self::getidNombreUser($usuarioaequipo);

        $idEquipoUsuario = Equipo::getidEquipo($equipoausuario);

        echo $idUsuario;
        
        $query = "INSERT INTO usuarios_equipos (equipo_id,usuario_id)  VALUES ($idEquipoUsuario,$idUsuario)"; 

        $rs = $conn->query($query);

        if (!$rs) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    public static function eliminarUsuarioEquipo($usuarioaequipo, $equipoausuario){
        $result = true;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $idUsuario = self::getidNombreUser($usuarioaequipo);
        $idEquipoUsuario = Equipo::getidEquipo($equipoausuario);
    
        echo $idUsuario;
        
        // Modificamos la consulta para eliminar la fila que coincide con los valores proporcionados
        $query = "DELETE FROM usuarios_equipos WHERE equipo_id = $idEquipoUsuario AND usuario_id = $idUsuario"; 
    
        $rs = $conn->query($query);
    
        if (!$rs) {
            $result = false;
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    
        return $result;
    }
    

    public static function getidNombreUser($usuario){

        //Obtengo la conexión realizada
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT id FROM credenciales WHERE user = '%s'", $conn->real_escape_string($usuario));

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

}

?>