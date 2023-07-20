<?php
namespace es\ucm\fdi;


class FormularioRegistroUsuarios extends Formulario{

    

    public function __construct() {
        parent::__construct('formRegister', ['urlRedireccion' => 'paneldeControl.php']);
    }
    
    protected function generaCamposFormulario(&$datos){
 
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'password'], $this->errores, 'span', array('class' => 'error'));
            
            $html = <<<EOF
            $htmlErroresGlobales
                <fieldset>
                    <label for="tipo_usuario">Selecciona el tipo de usuario:</label>
                    <select id="tipo_usuario" name="tipo_usuario">
                        <option value="entrenador">Entrenador</option>
                        <option value="jugador">Jugador</option>
                        <option value="director_tecnico">Director Técnico</option>
                    </select>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                    <label for="nombre">Apellido 1:</label>
                    <input type="text" id="apellido1" name="apellido1" required>
                    <label for="nombre">Apellido 2:</label>
                    <input type="text" id="apellido2" name="apellido2" required>
                    <!-- Botón (+) para añadir nuevos campos -->
                    <button type="button" id="agregarJugador">+</button>
                </fieldset>
                    <!-- Los nuevos campos de jugadores se añadirán aquí mediante JavaScript -->
                <div id="camposJugadores">

                </div>
            
            <script>
                // Script para controlar la creación de nuevos campos de jugadores
                const agregarJugadorBtn = document.getElementById('agregarJugador');
                const camposJugadoresDiv = document.getElementById('camposJugadores');
            
                let contadorJugadores = 0;
            
                agregarJugadorBtn.addEventListener('click', () => {
                    contadorJugadores++;
            
                    // Crear los nuevos campos para el jugador
                    const nuevoCampo = '<fieldset>' +
                        '<label for="tipo_usuario">Selecciona el tipo de usuario:</label>' +
                        '<select id="tipo_usuario' + contadorJugadores + '" name="tipo_usuario' + contadorJugadores + '">' +
                        '<option value="entrenador">Entrenador</option>' +
                        '<option value="jugador">Jugador</option>' +
                        '<option value="director_tecnico">Director Técnico</option>' +
                        '</select>' +
                        '<label for="nombre' + contadorJugadores + '">Nombre Jugador ' + contadorJugadores + ':</label>' +
                        '<input type="text" id="nombre' + contadorJugadores + '" name="nombre' + contadorJugadores + '" required>' +
                        '<label for="apellido1' + contadorJugadores + '">Apellido 1 Jugador ' + contadorJugadores + ':</label>' +
                        '<input type="text" id="apellido1' + contadorJugadores + '" name="apellido1' + contadorJugadores + '" required>' +
                        '<label for="apellido2' + contadorJugadores + '">Apellido 2 Jugador ' + contadorJugadores + ':</label>' +
                        '<input type="text" id="apellido2' + contadorJugadores + '" name="apellido2' + contadorJugadores + '" required>' +
                        '<button type="button" onclick="eliminarJugador(' + contadorJugadores + ')">-</button>' +
                        '</fieldset>';
            
                        camposJugadoresDiv.insertAdjacentHTML('beforeend', nuevoCampo);
                    });
            </script>
            
            <input type="submit" value="Crear o añadir usuarios">
            EOF;
            
                return $html;
            }            
            
               
    protected function procesaFormulario(&$datos){

        $this->errores = [];
        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreUsuario || empty($nombreUsuario) ) {
            $this->errores['nombreUsuario'] = 'El nombre de usuario no puede estar vacío';
        }
        
        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || empty($password) ) {
            $this->errores['password'] = 'El password no puede estar vacío.';
        }
        
        if (count($this->errores) === 0) {
            
            $usuario = Usuario::login($nombreUsuario, $password);
        
            if (!$usuario) {
                $this->errores[] = "El usuario o el password no coinciden";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $usuario->getNombreUsuario();
                $_SESSION['id'] = $usuario->getIdUsuario();
                $_SESSION['roles'] = implode($usuario->getRoles($usuario->getNombreUsuario()));
                //$_SESSION['esAdmin'] = $usuario->tieneRol(Usuario::ADMIN_ROLE);
            }
           
        }
    }
}