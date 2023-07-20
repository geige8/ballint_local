<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Panel de Control';
$rutaApp = RUTA_APP;
$contenidoPrincipal = '';
$rutaImgs = RUTA_IMGS;

$contenidoPrincipal .= <<<EOS
<h1> Bienvenido al panel de control del administrador </h1>

<!-- Botón para Registrar Usuarios -->
<a href="registrar_usuarios.php">
  <button>Registrar Usuarios</button>
</a>

<!-- Botón para Registrar Equipos -->
<a href="pagina_registrar_equipos.php">
  <button>Registrar Equipos</button>
</a>

<!-- Botón para Añadir Jugadores/Entrenadores a Equipos -->
<a href="pagina_anadir_jugadores_entrenadores.php">
  <button>Añadir Jugadores/Entrenadores a Equipos</button>
</a>

EOS;

require __DIR__.'/includes/vistas/plantilla.php';
?>
