<?php
namespace es\ucm\fdi;

class FormularioAccionPartido extends Formulario{

    private $idEquipo;

    public function __construct($idEquipo) {
        parent::__construct('formaccionJugador', ['urlRedireccion' => 'analizador.php']);
        $this->idEquipo = $idEquipo;
    }

    protected function generaCamposFormulario(&$datos){
        $html = "";

        // Obtenemos la lista de jugadores desde la clase Equipo
        $jugadores = Equipo::getJugadoresPartido($this->idEquipo);

        // Generamos los botones para seleccionar los jugadores
        $html .= '<div>';
        foreach ($jugadores as $jugador) {
            $html .= '<button type="submit" value="' . $jugador . '">' . $jugador . '</button>';
        }
        $html .= '</div>';

        // Agregamos el campo oculto con el valor de $idEquipo
        $html .= '<input type="hidden" name="idEquipo" value="' . $this->idEquipo . '">';

        return $html;
    }

    protected function procesaFormulario(&$datos){
        $resultado = array();
        $resultado['errores'] = array();
        $resultado['datos'] = array();



        echo "TOMAAAA";

        // Aquí podrías hacer algo con los datos recibidos, como actualizar la base de datos o mostrar un mensaje de éxito.

        return $resultado;
    }
}