<?php
    require_once __DIR__.'/includes/config.php';

    $form = new es\ucm\fdi\FormularioLogin();
    $htmlFormLogin = $form->gestiona();

    $tituloPagina = 'Iniciar Sesión';

    $contenidoPrincipal = <<<EOS
        <div class=pantallaLogin>
            <div class="carrusel-contenido">
                <div class="carrusel-caja">
                    <div class="carrusel-elemento">
                        <img class="imagenes" src="./imgs/imagen1.jpg" >
                    </div>
                    <div class="carrusel-elemento">   
                        <img class="imagenes" src="./imgs/imagen2.jpg">
                    </div>
                    <div class="carrusel-elemento">   
                        <img class="imagenes" src="./imgs/imagen3.jpg">                        
                    </div>
                </div>
            </div>
            <div class="initBox">
                $htmlFormLogin  
            </div>
        </div>
    EOS;

    require __DIR__.'/includes/vistas/plantillalog.php';

?>
