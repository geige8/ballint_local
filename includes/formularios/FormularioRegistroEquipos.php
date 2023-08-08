<?php
namespace es\ucm\fdi;


class FormularioRegistroEquipos extends Formulario{

    public function __construct() {
        parent::__construct('formRegisterTeam', ['urlRedireccion' => 'registrar_equipos.php']);
    }
    
    protected function generaCamposFormulario(&$datos){
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['categoria_equipo', 'seccion_equipo','letra_equipo'], $this->errores, 'span', array('class' => 'error'));
            
            $html = <<<EOF
            $htmlErroresGlobales
                <div id="camposEquipos">
                    <fieldset> 
                        <label for="categoria_equipo">Selecciona la categoria del equipo:</label>
                        <select id="categoria_equipo" name="categoria_equipo">
                            <option value="Nacional">Nacional</option>
                            <option value="PrimeraAutonomica">Primera Autonómica</option>
                            <option value="SegundaAutonomica">Segunda Autonómica</option>
                            <option value="Sub22">Sub22</option>
                            <option value="Junior">Junior</option>
                            <option value="Cadete">Cadete</option>
                            <option value="Infantil">Infantil</option>
                        </select>
                        {$erroresCampos['categoria_equipo']}
                        <label for="seccion_equipo">Selecciona si es masculino o femenino:</label>
                        <select id="seccion_equipo" name="seccion_equipo">
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                        {$erroresCampos['seccion_equipo']}
                        <label for="letra_equipo">Letra del Equipo (1):</label>
                        <input type="text" id="letra_equipo" name="letra_equipo" required>
                        {$erroresCampos['letra_equipo']}
                        <button type="submit" name="registro">Registrar Equipo</button>
                    </fieldset>
                </div>            
            EOF;
        return $html;
    }            
                 
    protected function procesaFormulario(&$datos){

        $this->errores = [];

        // Validar campo "tipo_usuario" para cada jugador
        $categoria_equipo = trim($datos['categoria_equipo'] ?? '');
        $categoria_equipo = filter_var($categoria_equipo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$categoria_equipo || empty($categoria_equipo)) {
            $this->errores['categoria_equipo'] = 'Debes seleccionar la categoria del equipo';
        }
        // Validar campo "tipo_usuario" para cada jugador
        $seccion_equipo = trim($datos['seccion_equipo'] ?? '');
        $seccion_equipo = filter_var($seccion_equipo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (empty($seccion_equipo)){
            $this->errores['seccion_equipo'] = 'Debes seleccionar la seccion del equipo';
        }
        $letra_equipo = trim($datos['letra_equipo'] ?? '');
        if (empty($letra_equipo) || strlen($letra_equipo) !== 1 || !ctype_alpha($letra_equipo)) {
            $this->errores['letra_equipo'] = 'La letra debe ser un único carácter alfabético';
        }
        
        if (count($this->errores) === 0) {
            try {
                $equipoRegistrado = Equipo::registrarEquipo($categoria_equipo,$seccion_equipo,$letra_equipo);
                // Si no hay excepción, continuas con el flujo normal
            } catch (\Exception $e) {
                $this->errores[] = $e->getMessage(); // Agregar el mensaje de error a los errores
            }
        }
    }
}