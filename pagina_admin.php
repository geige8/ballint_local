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

<!-- Botón para Eliminar Usuarios -->
<a href="eliminar_usuarios.php">
  <button>Eliminar Usuarios</button>
</a>

<!-- Botón para Registrar Equipos -->
<a href="registrar_equipos.php">
  <button>Registrar Equipos</button>
</a>

<!-- Botón para Eliminar Equipos -->
<a href="eliminar_equipos.php">
  <button>Eliminar Equipos</button>
</a>

<!-- Botón para Añadir Jugadores/Entrenadores a Equipos -->
<a href="addUsuarioTeam.php">
  <button>Añadir Jugadores/Entrenadores a Equipos</button>
</a>

<!-- Botón para Eliminar Jugadores/Entrenadores a Equipos -->
<a href="eliminar_UsuarioTeam.php">
  <button>Eliminar Jugadores/Entrenadores a Equipos</button>
</a>

EOS;

require __DIR__.'/includes/vistas/plantilla.php';
?>
