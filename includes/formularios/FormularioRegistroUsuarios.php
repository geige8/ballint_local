<?php
namespace es\ucm\fdi;


class FormularioRegistroUsuarios extends Formulario{

    

    public function __construct() {
        parent::__construct('formRegisterUser', ['urlRedireccion' => 'pagina_admin.php']);
    }
    
    protected function generaCamposFormulario(&$datos){

            $opcionesEquipos = '';
            $arrayEquiposExistentes = Equipo::getListadoEquipos();

            for ($i = 1; $i <= sizeof($arrayEquiposExistentes); $i++) {
                $opcionesEquipos .= '<option value="' . $arrayEquiposExistentes[$i-1] . '">' . $arrayEquiposExistentes[$i-1] . '</option>';

            }
 
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['tipo_usuario', 'equipo_usuario','nombre','apellido1','apellido2','numero'], $this->errores, 'span', array('class' => 'error'));
            
            $html = <<<EOF
            $htmlErroresGlobales
                <div id="camposJugadores">
                    <fieldset> 
                        <label for="tipo_usuario">Selecciona el tipo de usuario:</label>
                        <select id="tipo_usuario" name="tipo_usuario">
                            <option value="E">Entrenador</option>
                            <option value="J">Jugador</option>
                            <option value="DT">Director Técnico</option>
                        </select>
                        {$erroresCampos['tipo_usuario']}
                        <label for="equipo_usuario">Selecciona el equipo del usuario:</label>
                        <select id="equipo_usuario" name="equipo_usuario">
                            $opcionesEquipos
                        </select>
                        {$erroresCampos['equipo_usuario']}
                        <label for="nombre">Nombre Jugador:</label>
                            <input type="text" id="nombre" name="nombre" required>
                            {$erroresCampos['nombre']}
                        <label for="apellido1">1er Apellido</label>
                            <input type="text" id="apellido1" name="apellido1" required>
                            {$erroresCampos['apellido1']}
                        <label for="apellido2">2do Apellido</label>
                            <input type="text" id="apellido2" name="apellido2" required>
                            {$erroresCampos['apellido2']}
                        <label for="numero">Número (0-99)</label>
                            <input type="number" id="numero" name="numero" min="0" max="99" required>
                            {$erroresCampos['numero']}                            
                        <button type="submit" name="registro">RegistrarUsuario</button>
                    </fieldset>
                </div>            
            EOF;
        return $html;
    }            
                 
    protected function procesaFormulario(&$datos){

        $this->errores = [];

        $nombreJugador = trim($datos['nombre'] ?? '');
        $nombreJugador = filter_var($nombreJugador, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombreJugador || empty($nombreJugador)) {
            $this->errores['nombre'] = 'El nombre del jugador no puede estar vacío';
        }

        $apellido1Jugador = trim($datos['apellido1'] ?? '');
        $apellido1Jugador = filter_var($apellido1Jugador, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$apellido1Jugador || empty($apellido1Jugador)) {
            $this->errores['apellido1'] = 'El apellido 1 del jugador no puede estar vacío';
        }

        $apellido2Jugador = trim($datos['apellido2'] ?? '');
        $apellido2Jugador = filter_var($apellido2Jugador, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$apellido2Jugador || empty($apellido2Jugador)) {
            $this->errores['apellido2'] = 'El apellido 2 del jugador no puede estar vacío';
        }

        // Validar campo "tipo_usuario" para cada jugador
        $tipoUsuario = trim($datos['tipo_usuario'] ?? '');
        $tipoUsuario = filter_var($tipoUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$tipoUsuario || empty($tipoUsuario)) {
            $this->errores['tipo_usuario'] = 'Debes seleccionar el tipo de usuario para el jugador';
        }
        // Validar campo "tipo_usuario" para cada jugador
        $equipoUsuario = trim($datos['equipo_usuario'] ?? '');
        $equipoUsuario = filter_var($equipoUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$equipoUsuario || empty($equipoUsuario)){
            $this->errores['equipo_usuario'] = 'Debes seleccionar el equipo para el jugador';
        }

        // Validar campo "numero" para cada jugador
        $numero = trim($datos['numero'] ?? '');

        // Verificar si el campo está vacío o no es un número
        if (!$numero || !is_numeric($numero)) {
            $this->errores['numero'] = 'Debes seleccionar un número válido entre 0 y 99.';
        } else {
            // Convertir el valor del campo a un entero
            $numero = intval($numero);

            // Verificar si el número está dentro del rango permitido (0-99)
            if ($numero < 0 || $numero > 99) {
                $this->errores['numero'] = 'El número debe estar entre 0 y 99.';
            }
        }


        if (count($this->errores) === 0) {

            //Si no hay errores, quiero que añada todos los usuarios creados

            // Obtener las dos primeras letras de apellido1Jugador
            $primeras_letras_apellido1 = substr($apellido1Jugador, 0, 2);

            // Obtener las dos últimas letras de apellido2Jugador
            $ultimas_letras_apellido2 = substr($apellido2Jugador, -2);

            // Combinar todas las partes para formar el nombre de usuario
            $usuarionombre = $nombreJugador . $primeras_letras_apellido1 . $ultimas_letras_apellido2 . $tipoUsuario . $numero;

            $usuarioregistrado = Usuario::registrarUsuario($usuarionombre,$nombreJugador,$apellido1Jugador,$apellido2Jugador,$tipoUsuario,$equipoUsuario,$numero);
        
            if (!$usuarioregistrado) {
                $this->errores[] = "El usuario no se ha creado correctamente";
            } else {
            }  
        }
    }
}