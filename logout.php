<?php
require_once __DIR__.'/includes/config.php';


$tituloPagina = 'Logout';

//Doble seguridad: unset + destroy

    if(isset($_SESSION['login'])){

        unset($_SESSION['login']);
        unset($_SESSION['esAdmin']);
        unset($_SESSION['nombre']);
        unset($_SESSION['tipo_usuario']);


        session_destroy();
    }
    
    header('Location: index.php');

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
