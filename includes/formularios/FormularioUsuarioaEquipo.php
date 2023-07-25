<?php
namespace es\ucm\fdi;


class FormularioUsuarioaEquipo extends Formulario{

    public function __construct() {
        parent::__construct('formadduserTeam', ['urlRedireccion' => 'paneldeControl.php']);
    }
    
    protected function generaCamposFormulario(&$datos){

        $opcionesEquipos = '';
        $arrayEquiposExistentes = Equipo::obtenerlistadoEquipos();

        for ($i = 1; $i <= sizeof($arrayEquiposExistentes); $i++) {
            $opcionesEquipos .= '<option value="' . $arrayEquiposExistentes[$i-1] . '">' . $arrayEquiposExistentes[$i-1] . '</option>';

        }
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['usuarioaequipo', 'equipoausuario'], $this->errores, 'span', array('class' => 'error'));
            
            $html = <<<EOF
            $htmlErroresGlobales
                <div id="camposEquipos">
                    <fieldset> 
                        <label for="usuarioaequipo">Escribe el Usuario:</label>
                        <input type="text" id="usuarioaequipo" name="usuarioaequipo" required>
                        {$erroresCampos['usuarioaequipo']}
                        <label for="equipoausuario">Selecciona el equipo del usuario:</label>
                        <select id="equipoausuario" name="equipoausuario">
                            $opcionesEquipos
                        </select>
                        {$erroresCampos['equipoausuario']}
                        <button type="submit" name="registro">Registrar Equipo</button>
                    </fieldset>
                </div>            
            EOF;
        return $html;
    }            
                 
    protected function procesaFormulario(&$datos){

        $this->errores = [];

        $usuarioaequipo = trim($datos['usuarioaequipo'] ?? '');
        $usuarioaequipo = filter_var($usuarioaequipo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$usuarioaequipo || empty($usuarioaequipo)) {
            $this->errores['usuarioaequipo'] = 'El nombre del jugador no puede estar vacío';
        }

        // Validar campo "tipo_usuario" para cada jugador
        $equipoausuario = trim($datos['equipoausuario'] ?? '');
        $equipoausuario = filter_var($equipoausuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$equipoausuario || empty($equipoausuario)){
            $this->errores['equipoausuario'] = 'Debes seleccionar el equipo para el jugador';
        }
        
        if (count($this->errores) === 0) {

            $equipoRegistrado = Usuario::addUsuarioaEquipo($usuarioaequipo,$equipoausuario);
        
            if (!$equipoRegistrado) {
                $this->errores[] = "El usuario no se ha añadido correctamente correctamente";
            } else {
            }  
        }
    }
}