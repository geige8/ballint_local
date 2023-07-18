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

        echo "Nombre que llega: $nombreUsuario";
        echo "Pass que llega: $password1";
        //Quiero obtener la password del nombre de usuario que me la devolvera en el caso de que exista
        $usuario = self::buscaUsuario($nombreUsuario);
        echo "Nombre que llega 2: $usuario->nombreUsuario";
        echo "Pass que llega 2: $usuario->password ";

        /*
        //Si me devuelve algo Y las passwords introducidas y obtenidas son iguales, es que hay acceso
        if ($usuario && $usuario->compruebaPassword($password1,$usuario->password)) {

            //$_SESSION['tipo_usuario']= $usuario->tipoUser;            
            return true;
        }
        */
        if ($password1 == $usuario->password) {

            //$_SESSION['tipo_usuario']= $usuario->tipoUser;            
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

    /*
    public function compruebaPassword($password1,$password2)
    {
        return password_verify($password1,$password2);
    }
    */








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
    


    



}

?>