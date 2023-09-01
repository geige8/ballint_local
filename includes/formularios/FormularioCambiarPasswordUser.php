<?php

namespace es\ucm\fdi;

class FormularioCambiarPasswordUser extends Formulario
{

    public function __construct() {
        parent::__construct('formCambioContraseñaUser', ['urlRedireccion' => 'cambiar_passUser.php']);
     }
     
     protected function generaCamposFormulario(&$datos)
     {
         $password = $datos['password'] ?? '';
         $password2 = $datos['password2'] ?? '';
          
         // Se generan los mensajes de error si existen.
         $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
         $erroresCampos = self::generaErroresCampos(['usuariocambiar','password', 'password2'], $this->errores, 'span', array('class' => 'error'));
 
         $html = <<<EOF
                <div class="seleccion">
                        <label for="usuariocambiar">Escribe el Usuario:</label>
                        <input type="text" id="usuariocambiar" name="usuariocambiar" required>
                        {$erroresCampos['usuariocambiar']}
                        <div class="password">
                            {$erroresCampos['password']}
                            <label for="password">Escribe la contraseña:</label>
                            <input type="password" name="password" value="$password" required/>
                        </div>
                        <div class="password">
                            {$erroresCampos['password2']}
                            <label for="password2">Repite la contraseña:</label>
                            <input type="password" name="password2" value="$password2" required/>
                            </div>
                        $htmlErroresGlobales   
                        <div class="botonEditar">
                            <button type="submit" name="actualizar">Cambiar Password</button>
                        </div>
            </div>
         EOF;
         return $html;
     }
     
 
     protected function procesaFormulario(&$datos)
     {
        $this->errores = [];

        $usuariocambiar = trim($datos['usuariocambiar'] ?? '');
        $usuariocambiar = filter_var($usuariocambiar, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$usuariocambiar || empty($usuariocambiar)) {
            $this->errores['usuariocambiar'] = 'El nombre del jugador no puede estar vacío';
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || mb_strlen($password) < 5 || mb_strlen($password) > 20) {
            $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
        }

        $password2 = trim($datos['password2'] ?? '');
        $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password2 || $password != $password2 ) {
            $this->errores['password2'] = 'Los passwords deben coincidir';
        }
        
        if (count($this->errores) === 0) {
            $pss=Usuario::cambiarPasswordUser($password, $password2,$usuariocambiar);
            if($pss != 1){
                switch($pss){
                    case 2:
                        $this->errores[]= "Debe rellenar las dos contraseñas";
                    break;
                    case 3:
                        $this->errores[]= "Las contraseñas no coinciden";
                    break;
                    case 4:
                        $this->errores[]= "Contraseña muy corta o muy larga";
                    break;
                    default:
                    $this->errores[]= "No se ha podido cambiar la contraseña";
                    break;
                }
            }
        }
          
    } 
}