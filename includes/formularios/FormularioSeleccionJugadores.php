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
    
        // Obtenemos la lista de equipos desde la clase Equipo
    
        $jugadores = Equipo::getJugadoresEquipo($this->idEquipo);
        $jugador = '';
    
        $html .= <<<EOF
        <div class="seleccionDatosPartido">
            <h1>Datos del Partido</h1>
            <div>
                <label for="seleccion_fecha">Fecha:</label>
                <input type="date" id="seleccion_fecha" name="seleccion_fecha">
                <label for="seleccion_hora">Hora:</label>
                <input type="time" id="seleccion_hora" name="seleccion_hora">
            </div>
        </div>
            <div class="seleccionJugadores">
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
                    </div>
                EOF;
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

        $errores = array();

        // Obtenemos FECHA
        $fecha= $datos['seleccion_fecha'] ?? [];

        if (empty($fecha)) {
            $errores['seleccion_fecha'] = "Debes seleccionar una fecha";
        }

        // Obtenemos HORA
        $hora = $datos['seleccion_hora'] ?? [];

        if (empty($hora)) {
            $errores['seleccion_hora'] = "Debes seleccionar una hora";
        }

        // Obtenemos entrenador
       // $entrenador = Equipo::getEntrenadorEquipo($this->idEquipo);
        
        // Comprobamos que se ha seleccionado un equipo
        $idEquipo = $datos['idEquipo'] ?? null;
       
        if (empty($idEquipo)) {
            $errores['equipo'] = "Debes seleccionar un equipo";
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
            }
        }

        // Comprobamos que hay al menos un jugador local y visitante seleccionado
        if (count($jugadoresSeleccionados) < 5 || count($jugadoresVisitantes)<5) {
            $errores['jugadores'] = "Debes seleccionar al menos 5 jugadores de cada equipo";
        }
    
        // Obtenemos el nombre del equipo rival
        $nombreRival = str_replace(' ', '', $datos['equipo_rival'] ?? null);

        if (empty($nombreRival)) {
            $errores['equipo_rival'] = "Debes introducir el nombre del equipo rival";
        }
    
        // Si hay errores, los guardamos en el objeto
        if (count($errores) > 0) {
            $this->errores = $errores;
            return false;
        }
        
        // Si todo está correcto, llamamos a la función para crear la tabla temporal
        //$nombresJugadoresVisitantes = array_values($jugadoresVisitantes);
        $tablaTemporalCreada = Partido::crearTablaTemporal($idEquipo, $nombreRival, $jugadoresSeleccionados, $jugadoresVisitantes);
        $tablaTemporalCreada2 = Partido::crearTablaTemporalE($idEquipo, $nombreRival);
        $tablapartidosactualizada = Partido::insertarPartido($idEquipo, $nombreRival,$fecha,$hora);

        if ($tablaTemporalCreada &&  $tablaTemporalCreada2 && $tablapartidosactualizada) {

           // Redirigimos al usuario a la página analizador.php con el idEquipo como parámetro GET
            $url = $this->urlRedireccion . '?idEquipo=' . $idEquipo .'&idEquipoVisit=' . $nombreRival;
            header("Location: $url");
            exit();
        } else {
            $this->errores['general'] = "Ha habido un error al crear la tabla temporal";
            return false;
        }
    }
    
        
}