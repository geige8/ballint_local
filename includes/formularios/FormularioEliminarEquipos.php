<?php
namespace es\ucm\fdi;


class FormularioEliminarEquipos extends Formulario{

    public function __construct() {
        parent::__construct('formEliminarTeam', ['urlRedireccion' => 'eliminar_equipos.php']);
    }
    
    protected function generaCamposFormulario(&$datos){

        $opcionesEquipos = '';
        $arrayEquiposExistentes = Equipo::getListadoEquipos();

        for ($i = 1; $i <= sizeof($arrayEquiposExistentes); $i++) {
            $opcionesEquipos .= '<option value="' . $arrayEquiposExistentes[$i-1] . '">' . $arrayEquiposExistentes[$i-1] . '</option>';

        }
 
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['equipo_usuario'], $this->errores, 'span', array('class' => 'error'));
            
            $html = <<<EOF
            $htmlErroresGlobales
                <div id="camposJugadores">
                    <fieldset> 
                    <label for="equipo_usuario">Selecciona el equipo del usuario:</label>
                    <select id="equipo_usuario" name="equipo_usuario">
                        $opcionesEquipos
                    </select>
                    {$erroresCampos['equipo_usuario']}
                        <button type="submit" name="registro">Eliminar Equipo</button>
                    </fieldset>
                </div>            
            EOF;
        return $html;
    }            
                 
    protected function procesaFormulario(&$datos){

        $this->errores = [];

        $equipoUsuario = trim($datos['equipo_usuario'] ?? '');
        $equipoUsuario = filter_var($equipoUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$equipoUsuario || empty($equipoUsuario)){
            $this->errores['equipo_usuario'] = 'Debes seleccionar el equipo para el jugador';
        }

        if (count($this->errores) === 0) {
            try {
                $equipoEliminado = Equipo::eliminarEquipo($equipoUsuario);
            } catch (\Exception $e) {
                $this->errores[] = $e->getMessage(); // Agregar el mensaje de error a los errores
            }
        }
    }
}