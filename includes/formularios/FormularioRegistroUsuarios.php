<?php
namespace es\ucm\fdi;


class FormularioRegistroUsuarios extends Formulario{

    

    public function __construct() {
        parent::__construct('formRegisterUser', ['urlRedireccion' => 'registrar_usuarios.php']);
    }
    
    protected function generaCamposFormulario(&$datos){

            $opcionesEquipos = '';
            $arrayEquiposExistentes = Equipo::getListadoEquipos();

            for ($i = 1; $i <= sizeof($arrayEquiposExistentes); $i++) {
                $opcionesEquipos .= '<option value="' . $arrayEquiposExistentes[$i-1] . '">' . $arrayEquiposExistentes[$i-1] . '</option>';

            }
 
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['tipo_usuario', 'equipo_usuario','nombre','apellido1','apellido2','numero','imagen'], $this->errores, 'span', array('class' => 'error'));
            
            $html = <<<EOF
                <div class="seleccion"> 
                    $htmlErroresGlobales
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
                    <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                        {$erroresCampos['nombre']}
                    <label for="apellido1">1er Apellido</label>
                        <input type="text" id="apellido1" name="apellido1" required>
                        {$erroresCampos['apellido1']}
                    <label for="apellido2">2do Apellido</label>
                        <input type="text" id="apellido2" name="apellido2" required>
                        {$erroresCampos['apellido2']}
                    <label for="numero">Número (0-99)</label>
                        <input type="number" id="numero" name="numero" min="-1" max="99" required>
                        {$erroresCampos['numero']}
                    <label for="imagen">Imagen</label>
                        <input type="file" class="custom-file-input" name="imagen" id="imagen" required/></label>
                        {$erroresCampos['imagen']}
                    <button type="submit" name="registro">Registrar Usuario</button>
                </div>            
            EOF;
        return $html;
    }            
                 
    protected function procesaFormulario(&$datos){

        $this->errores = [];

        function quitarTildes($cadena) {
            $acentos = array(
                'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
                'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U'
            );
            return strtr($cadena, $acentos);
        }
        
        $nombreJugador = trim($datos['nombre'] ?? '');
        $nombreJugador = quitarTildes($nombreJugador);
        if (!$nombreJugador || empty($nombreJugador)) {
            $this->errores['nombre'] = 'El nombre del jugador no puede estar vacío';
        }
        
        $apellido1Jugador = trim($datos['apellido1'] ?? '');
        $apellido1Jugador = quitarTildes($apellido1Jugador);
        if (!$apellido1Jugador || empty($apellido1Jugador)) {
            $this->errores['apellido1'] = 'El apellido 1 del jugador no puede estar vacío';
        }
        
        $apellido2Jugador = trim($datos['apellido2'] ?? '');
        $apellido2Jugador = quitarTildes($apellido2Jugador);
        if (!$apellido2Jugador || empty($apellido2Jugador)) {
            $this->errores['apellido2'] = 'El apellido 2 del jugador no puede estar vacío';
        }
        

        $tipoUsuario = trim($datos['tipo_usuario'] ?? '');
        $tipoUsuario = filter_var($tipoUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$tipoUsuario || empty($tipoUsuario)) {
            $this->errores['tipo_usuario'] = 'Debes seleccionar el tipo de usuario para el jugador';
        }

        $equipoUsuario = trim($datos['equipo_usuario'] ?? '');
        $equipoUsuario = filter_var($equipoUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$equipoUsuario || empty($equipoUsuario)){
            $this->errores['equipo_usuario'] = 'Debes seleccionar el equipo para el jugador';
        }

        $numero = trim($datos['numero'] ?? '');

        // Verificar si el campo está vacío o no es un número
        if (!isset($numero) || !is_numeric($numero)) {
            $this->errores['numero'] = 'Debes seleccionar un número válido entre 0 y 99.';
        } else {
            // Convertir el valor del campo a un entero
            $numero = intval($numero);

            // Verificar si el número está dentro del rango permitido (0-99)
            if ($numero < 0 || $numero > 99) {
                $this->errores['numero'] = 'El número debe estar entre 0 y 99.';
            }
        }

        $extensiones = array('image/jpg', 'image/jpeg', 'image/png');
        $max_tamanyo = 1024 * 1024 * 8; // 8 MB

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            if (!in_array($_FILES['imagen']['type'], $extensiones)) {
                $this->errores['imagen'] = 'Es una imagen';
                if ($_FILES['imagen']['size'] > $max_tamanyo) {
                    $this->errores['imagen'] = 'La imagen excede el tamaño máximo';
                }
            }
        } else {
            $this->errores['imagen'] = 'Hubo un problema al subir la imagen';
        }


        
        

        if (count($this->errores) === 0) {
            // Obtener las dos primeras letras de apellido1Jugador
            $primeras_letras_apellido1 = substr($apellido1Jugador, 0, 1);
        
            // Obtener las dos últimas letras de apellido2Jugador
            $ultimas_letras_apellido2 = substr($apellido2Jugador, -1);
        
            // Generar un número aleatorio de 1 a 999 (puedes ajustar el rango según tus necesidades)
            $numero_aleatorio = mt_rand(1, 99);

            $numero_nuevo = ($numero + 1) * $numero_aleatorio;

        
            // Combinar todas las partes para formar el nombre de usuario, incluyendo el número aleatorio
            $usuarionombre = $nombreJugador . $primeras_letras_apellido1 . $ultimas_letras_apellido2 . $tipoUsuario .  $numero_nuevo;

            try {

                $usuarioregistrado = Usuario::registrarUsuario($usuarionombre,$nombreJugador,$apellido1Jugador,$apellido2Jugador,$tipoUsuario,$equipoUsuario,$numero);
                // Si no hay excepción, continúas con el flujo normal
                $ruta_fichero_origen = $_FILES['imagen']['tmp_name'];
                $ruta_nuevo_destino = 'C:/xampp/htdocs/BALLINT/ballint_local/imgs/' . $usuarionombre . '.jpg'; // Cambia 'holaaa' por el nombre de archivo que quieras
                
                if (move_uploaded_file($ruta_fichero_origen, $ruta_nuevo_destino)) {
                    // El archivo se ha movido exitosamente
                } else {
                    $this->errores['imagen'] = 'Hubo un problema al subir la imagen';
                }

            } catch (\Exception $e) {
                $this->errores[] = $e->getMessage(); // Agregar el mensaje de error a los errores
            }
        }
        
    }
}