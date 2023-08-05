<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'BallInt';

$rutaApp = RUTA_APP;
$contenidoPrincipal = '';
$rutaImgs=RUTA_IMGS;


$htmlEquiposClub = es\ucm\fdi\Equipo::mostrarEquipos();  

//1º PASO DIFERENCIAR LOGEADO O NO
if (isset($_SESSION["login"])) {

    $roles = es\ucm\fdi\Usuario::getRoles($_SESSION['nombre']);

    // Verificar si el conjunto de roles contiene un rol específico
    if (in_array('A', $roles)){ //Es administrador

        header('Location: pagina_admin.php');

    }else{
        $contenidoPrincipal .= <<<EOS
        $htmlEquiposClub        
        EOS;  
    }

} else {
    header('Location: login.php');
}




require __DIR__.'/includes/vistas/plantilla.php';