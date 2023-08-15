<?php
namespace es\ucm\fdi;


class FormularioEliminarUsuarios extends Formulario{

    public function __construct() {
        parent::__construct('formEliminarUser', ['urlRedireccion' => 'eliminar_usuarios.php']);
    }
    
    protected function generaCamposFormulario(&$datos){
 
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['usuarioEliminar'], $this->errores, 'span', array('class' => 'error'));
            
            $html = <<<EOF
                <div class="seleccion">
                    $htmlErroresGlobales
                    <label for="usuarioEliminar">Escribe el Usuario:</label>
                    <input type="text" id="usuarioEliminar" name="usuarioEliminar" required>
                    {$erroresCampos['usuarioEliminar']}
                    <button type="submit" name="registro">Eliminar Usuario</button>
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
            
            try {
                $usuarioEliminado = Usuario::eliminarUsuario($usuarioEliminar);
                $this->errores['usuarioEliminar'] = '¡Usuario Eliminado!';
            } catch (\Exception $e) {
                $this->errores[] = $e->getMessage(); // Agregar el mensaje de error a los errores
            }
        }
    }
}