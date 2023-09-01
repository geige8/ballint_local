<?php
namespace es\ucm\fdi;


class FormularioSeleccionJugadores extends Formulario{

    private $idEquipo;

    public function __construct($idEquipo) {
        parent::__construct('formseleccionequipos', ['urlRedireccion' => 'analizador.php']);
        $this->idEquipo = $idEquipo;
    }

    protected function generaCamposFormulario(&$datos){
    
        $html = "";
    

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['seleccion_fecha', 'seleccion_hora','equipo_rival','numero','nombre'], $this->errores, 'span', array('class' => 'error'));
        
    
        $jugadores = Equipo::getJugadoresEquipo($this->idEquipo);
        $jugador = '';
    
        $html .= <<<EOF
        <div class="seleccionDatosPartido">
            <h1>Datos del Partido</h1>
            <div>
                <label for="seleccion_fecha">Fecha:</label>
                <input type="date" id="seleccion_fecha" name="seleccion_fecha">
                {$erroresCampos['seleccion_fecha']}

                <label for="seleccion_hora">Hora:</label>
                <input type="time" id="seleccion_hora" name="seleccion_hora">
                {$erroresCampos['seleccion_hora']}
            </div>
        </div>
            <div class="seleccionJugadores">
            $htmlErroresGlobales
                <h1>Selección de Jugadores</h1>
                <div class="columna-izquierda">
                    <h2>$this->idEquipo</h2>
                    <table>
                        <tbody>
        EOF;
                    
                    $contador = 1;
                    foreach ($jugadores as $jugador) {
                        $html .= "<tr>";
                        $html .= "<td>";
                        $html .= "<div class='jugador-caja'>";
                        $html .= "<input type='checkbox' name='seleccionados[]' value='" . $jugador['user']. "' id='jugador_$contador'>";
                        $html .= "<label class='jugador-label' for='jugador_$contador'>";
                        $html .= $jugador['nombre'] . " " . $jugador['apellido1'] . " " .  $jugador['apellido2'] . " #" .  $jugador['numero'];
                        $html .= "</label>";
                        $html .= "</div>";
                        $html .= "</td>";
                        $html .= "</tr>";
                        $contador++; 
                    }
                
                    $html .= <<<EOF
                        </tbody>
                    </table>
                </div>
                <div class="columna-derecha">
                    <div class="equipoRival">
                        <label for="equipo_rival">Equipo Rival:</label>
                        <input type="text" id="equipo_rival" name="equipo_rival">
                        {$erroresCampos['equipo_rival']}

                    </div>
                EOF;

                
                $html .="{$erroresCampos['numero']}";
                $html .="{$erroresCampos['nombre']}";

                for ($i = 0; $i < 12; $i++) {
                    $html .= "<div class='playerVisit'>";
                    
                    // Input para el número
                    $html .= "<div class='input-block'>";
                    $html .= "<label for='numero$i'>Nº:</label>";
                    $html .= "<input type='text' name='numero$i' id='numero$i'>";
                    $html .= "</div>";
                    
                    // Input para el nombre
                    $html .= "<div class='input-block'>";
                    $html .= "<label for='nombre$i'>Nombre:</label>";
                    $html .= "<input type='text' name='nombre$i' id='nombre$i'>";
                    $html .= "</div>";
                    
                    $html .= "</div>";
                }

                // Agregamos el campo oculto con el valor de $idEquipo
                $html .= "<input type='hidden' name='idEquipo' value='" . $this->idEquipo . "'>";
            
                $html .= <<<EOF
            </div>

        </div>
            <button class="aceptarJugadores" type="submit" name="aceptar">Confirmar Jugadores</button>
        EOF;
    
        return $html;
    }
    

  

    protected function procesaFormulario(&$datos){
        
        $this->errores = [];

        // Obtenemos FECHA
        $fecha= $datos['seleccion_fecha'] ?? [];

        if (empty($fecha)) {
            $this->errores['seleccion_fecha'] = "Debes seleccionar una fecha";
        }

        // Obtenemos HORA
        $hora = $datos['seleccion_hora'] ?? [];

        if (empty($hora)) {
            $this->errores['seleccion_hora'] = "Debes seleccionar una hora";
        }
       
        // Comprobamos que se ha seleccionado un equipo
        $idEquipo = $datos['idEquipo'] ?? null;
       
        if (empty($idEquipo)) {
            $this->errores[] = "Debes seleccionar un equipo";
        }
    
        // Obtenemos los datos de los jugadores seleccionados
        $jugadoresSeleccionados = $datos['seleccionados'] ?? [];


        $jugadoresVisitantes = array();

        for ($i = 0; $i < 12; $i++) {
            $numero = $datos["numero$i"] ?? '';
            $nombre = $datos["nombre$i"] ?? '';
            if ($numero && $nombre) {
                $jugadoresVisitantes[$i] = array(
                    'numero' => $numero,
                    'nombre' => $nombre
                );
            }else{
                if(($numero && !$nombre) || (!$numero && $nombre)){
                    if (empty($numero)) {
                        $this->errores['numero'] = "Debes rellenar también el nombre";
                    }

                    if (empty($nombre)) {
                        $this->errores['nombre'] = "Debes rellenar también el numero";
                    }
                }
            }
        }

        // Comprobamos que hay al menos un jugador local y visitante seleccionado
        if (count($jugadoresSeleccionados) < 5 || count($jugadoresVisitantes)<5) {
            $this->errores[] = "Debes seleccionar al menos 5 jugadores de cada equipo";
        }

        if(count($jugadoresSeleccionados) > 12 ){

            $this->errores[] = "Debes seleccionar máximo 12 jugadores de cada equipo";

        }
    
        $nombreRival = str_replace(' ', '', $datos['equipo_rival'] ?? null);

        if (empty($nombreRival)) {
            $this->errores['equipo_rival'] = "Debes introducir el nombre del equipo rival";
        }
    
        if (count($this->errores) === 0) {

            $tablaTemporalCreada = Partido::crearTablaTemporal($idEquipo, $nombreRival, $jugadoresSeleccionados, $jugadoresVisitantes);
            $tablaTemporalCreada2 = Partido::crearTablaTemporalE($idEquipo, $nombreRival);
            $tablapartidosactualizada = Partido::insertarPartido($idEquipo, $nombreRival,$fecha,$hora);

            if ($tablaTemporalCreada &&  $tablaTemporalCreada2 && $tablapartidosactualizada) {

                $url = $this->urlRedireccion . '?idEquipo=' . $idEquipo .'&idEquipoVisit=' . $nombreRival;
                header("Location: $url");
                exit();
            } else {
                $this->errores[] = "Ha habido un error al crear la tabla temporal";
            }
        }
        

    }
    
        
}