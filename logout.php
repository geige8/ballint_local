<?php
    require_once __DIR__.'/includes/config.php';

    //Doble seguridad: unset + destroy

        if(isset($_SESSION['login'])){

            unset($_SESSION['login']);
            unset($_SESSION['id']);
            unset($_SESSION['nombre']);
            unset($_SESSION['roles']);


            session_destroy();
        }
        
        header('Location: index.php');

    require __DIR__.'/includes/vistas/plantillas/plantilla.php';

?>