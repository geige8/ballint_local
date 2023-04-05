<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Perfil';
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';
$rutaImgs=RUTA_IMGS;


$nombreUsuario = es\ucm\fdi\Usuario::getnombreCompleto($_SESSION['nombre']);

//Instancio y llamo a la funcion correspondiente
$form = new es\ucm\fdi\FormularioCambiarPassword();
$htmlcambiarPasswordForm = $form->gestiona();

//Obtengo los datos del perfil en cuestión
$usuario = es\ucm\fdi\Usuario::getDatosPerfil($_SESSION['nombre']);

$htmlEquiposfromUser = es\ucm\fdi\Equipo::equiposfromUserId($usuario['id']);

$contenidoPrincipal .= <<<EOS
    <div class="perfil">
        <div class="perfilCabecera">
            <div class="tituloCabecera">
                <img src="{$rutaImgs}/{$usuario['user']}.jpg" alt="imagen">
                <p>{$nombreUsuario}</p>
                <p>{$usuario['id']}</p>
                <p>{$usuario['user']}</p>
                <p>{$usuario['nombre']}</p>
                <p>{$usuario['apellido1']}</p>
                <p>{$usuario['apellido2']}</p>
                <p>{$usuario['nacimiento']}</p>
            </div>
            <div class="cambiarPassword">
                <button onclick='mostrarVentanaCambioPass(`{$htmlcambiarPasswordForm}`)'>Cambiar contraseña</button>
            </div>  
        </div>
        <div class="perfilEquipos">
            <h1>Equipos a los que pertenece</h1>
            $htmlEquiposfromUser
        </div>
    </div>
EOS;




require __DIR__.'/includes/vistas/plantilla.php';