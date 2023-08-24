<?php
    require_once __DIR__.'/includes/config.php';

    $tituloPagina = 'Cambiar Contraseña';
    $rutaApp = RUTA_APP;
    $contenidoPrincipal = '';

  //Instancio y llamo a la funcion correspondiente
  $form = new es\ucm\fdi\FormularioCambiarPasswordUser();
  $contenidoPrincipal .= $form->gestiona();


    require __DIR__.'/includes/vistas/plantilla.php';
?>