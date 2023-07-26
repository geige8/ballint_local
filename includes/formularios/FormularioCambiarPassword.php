<?php

namespace es\ucm\fdi;

class FormularioCambiarPassword extends Formulario
{

    public function __construct() {
        parent::__construct('formCambioContraseña', ['urlRedireccion' => 'perfil.php']);
     }
     
     protected function generaCamposFormulario(&$datos)
     {
         $password = $datos['password'] ?? '';
         $password2 = $datos['password2'] ?? '';
          
         // Se generan los mensajes de error si existen.
         $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
         $erroresCampos = self::generaErroresCampos(['password', 'password2'], $this->errores, 'span', array('class' => 'error'));
 
         $html = <<<EOF
            <div class="datos">
                <div class="columna">
                    <div class="columna-centrada">
                        $htmlErroresGlobales   
                        <div class="password">
                           <p>Nueva contraseña: <input type="password" name="password" value="$password" required/>{$erroresCampos['password']}</p>
                        </div>
                        <div class="password">
                            <p>Repita la nueva contraseña: <input type="password" name="password2" value="$password2" required/>{$erroresCampos['password2']}</p>
                        </div>
                        <div class="botonEditar">
                            <button type="submit" name="actualizar">Cambiar Password</button>
                        </div>
                    </div>
                </div>
            </div>
         EOF;
         return $html;
     }
     
 
     protected function procesaFormulario(&$datos)
     {
         $this->errores = [];
         $hoy = date('Y-m-d');

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
            $pss=Usuario::cambiarPassword($password, $password2);
            if(!$pss){
                $this->errores[]= "No se ha podido cambiar la contraseña";
            }
         }
        
        
    }

    
}