<?php
/* Parámetros de conexión a la BD */
define('BD_HOST', 'localhost');
define('BD_NAME', 'ballint_bbdd');
define('BD_USER', 'root');
define('BD_PASS', '');

/*Parámetros de configuración utilizados para generar las URLs y las rutas a ficheros en la aplicación*/

define('RAIZ_APP', __DIR__);
define('RUTA_APP', '/BALLINT/ballint_local');
define('RUTA_IMGS', RUTA_APP.'/imgs');
define('RUTA_CSS', RUTA_APP.'/styles');
define('RUTA_JS', RUTA_APP.'/js');


/*Parámetros de configuración utilizados para el equipos*/

define('TEAM_APP', 'LICEO FRANCÉS');
define('TEAM_URL', 'https://www.fbm.es/resultados-club-6291/liceo-frances');



/*Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria */

ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

spl_autoload_register(function ($class) {
    // project-specific namespace prefix
    $prefix = 'es\\ucm\\fdi\\';
    
    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/';
    
    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }
    
    // get the relative class name
    $relative_class = substr($class, $len);
    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php

    if(substr($relative_class,0,10) == 'Formulario'){

        $file = $base_dir . 'formularios/' . str_replace('\\', '/', $relative_class) . '.php';
        // if the file exists, require it
        if (file_exists($file)) {
            require $file;
        }

    }
    if(substr($relative_class,0,7) == 'Usuario'){

        $file = $base_dir . 'usuarios/' . str_replace('\\', '/', $relative_class) . '.php';
        // if the file exists, require it
        if (file_exists($file)) {
            require $file;
        }

    }

    else{

        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        // if the file exists, require it
        if (file_exists($file)) {
            require $file;
        }
    }

});

// Inicializa la aplicación
$app = es\ucm\fdi\Aplicacion::getInstance();
$app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));

register_shutdown_function([$app, 'shutdown']);

?>