<?php
namespace es\ucm\fdi;


class FormularioEliminarUsuarios extends Formulario{

    public function __construct() {
        parent::__construct('formEliminarUser', ['urlRedireccion' => 'pagina_admin.php']);
    }
    
    protected function generaCamposFormulario(&$datos){
 
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['usuarioEliminar'], $this->errores, 'span', array('class' => 'error'));
            
            $html = <<<EOF
            $htmlErroresGlobales
                <div id="camposJugadores">
                    <fieldset> 
                    <label for="usuarioEliminar">Escribe el Usuario:</label>
                    <input type="text" id="usuarioEliminar" name="usuarioEliminar" required>
                    {$erroresCampos['usuarioEliminar']}
                        <button type="submit" name="registro">Eliminar Usuario</button>
                    </fieldset>
                </div>            
            EOF;
        return $html;
    }            
                 
    protected function procesaFormulario(&$datos){

        $this->errores = [];

        $usuarioEliminar = trim($datos['usuarioEliminar'] ?? '');
        $usuarioEliminar = filter_var($usuarioEliminar, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$usuarioEliminar || empty($usuarioEliminar)) {
            $this->errores['usuarioEliminar'] = 'El nombre del jugador no puede estar vacío';
        }
        if (count($this->errores) === 0) {

            $usuarioEliminado = Usuario::eliminarUsuario($usuarioEliminar);
        
            if (!$usuarioEliminado) {
                $this->errores[] = "El usuario no se ha eliminado correctamente correctamente";
            } else {
            }  
        }
    }
}