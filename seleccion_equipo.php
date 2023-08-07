<?php

    require_once __DIR__.'/includes/config.php';

    $tituloPagina = 'Selección Equipo';

    $contenidoPrincipal = '';

    $formulario = new es\ucm\fdi\FormularioSeleccionEquipos();
    $htmlFormularioSeleccionEquipos = $formulario->gestiona();

    $contenidoPrincipal .= <<<EOS
        $htmlFormularioSeleccionEquipos
    EOS;

    require __DIR__.'/includes/vistas/plantilla.php';

?>