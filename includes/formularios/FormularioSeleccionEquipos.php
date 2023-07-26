<?php
namespace es\ucm\fdi;


class FormularioSeleccionEquipos extends Formulario{

    public function __construct() {
        parent::__construct('formseleccionequipos', ['urlRedireccion' => 'seleccion_jugadores.php']);
    }

    protected function generaCamposFormulario(&$datos){
        
        $html = "";
        $opcionesEquipos = '';
        $arrayEquiposExistentes = Equipo::getListadoEquipos();

        for ($i = 1; $i <= sizeof($arrayEquiposExistentes); $i++) {
            $opcionesEquipos .= '<option value="' . $arrayEquiposExistentes[$i-1] . '">' . $arrayEquiposExistentes[$i-1] . '</option>';

        }

        // Generamos el HTML para los campos del formulario
        $html .= <<<EOF
        <div>
            <label for="idEquipo">Selecciona un equipo:</label>
            <select id="idEquipo" name="idEquipo">
                <option value="">Selecciona un equipo</option>
                $opcionesEquipos
            </select>
        </div>
        EOF;

        // Generamos el botón de submit
        $html .= "<button type=\"submit\" name=\"siguiente\">Siguiente</button>";

        return $html;
    }

  

    protected function procesaFormulario(&$datos){
        $errores = array();

        // Comprobamos que se ha seleccionado un equipo
        $idEquipo = $datos['idEquipo'] ?? null;

        if (empty($idEquipo)) {
            $errores['equipo'] = "Debes seleccionar un equipo";
        }

        // Si hay errores, los guardamos en el objeto
        if (count($errores) > 0) {
            $this->errores = $errores;
            return false;
        }

        // Si todo está correcto, redirigimos al usuario a la página analizador.php con el idEquipo como parámetro GET
        $url = $this->urlRedireccion . '?idEquipo=' . $idEquipo;
        header("Location: $url");
        exit();
    }

}