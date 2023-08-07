<?php
    require_once __DIR__.'/includes/config.php';

    $tituloPagina = 'Glosario';
    $rutaApp = RUTA_APP;
    $contenidoPrincipal = '';
    $rutaImgs=RUTA_IMGS;

        $contenidoPrincipal .= <<<EOS
            <h1>GLOSARIO DE TERMINOS SOBRE LA PÁGINA:</h1>
            <p>La definición de roles es la siguiente:</p>
            <p>- Entrenador: Tiene Index, Mi Perfil, Mis Equipos, My Liceo y Glosario</p>
            <p>- Jugador: Tiene Index, Mi Perfil, Mis Equipos y Glosario</p>
            <p>- Director T&eacute;cnico: Tiene Index, Mi Perfil, Mis Equipos, My Liceo y Glosario</p>
        EOS;



    require __DIR__.'/includes/vistas/plantilla.php';
?>