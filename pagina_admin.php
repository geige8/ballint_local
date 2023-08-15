<?php
  require_once __DIR__.'/includes/config.php';

  $tituloPagina = 'Panel de Control';
  $rutaApp = RUTA_APP;
  $contenidoPrincipal = '';
  $rutaImgs = RUTA_IMGS;

  $contenidoPrincipal .= <<<EOS
    <h1> Panel de Control del Administrador</h1>
    <div class="botonesAdmin">
      <!-- Botón para Registrar Usuarios -->
          <a class="adminButton" href="registrar_usuarios.php">
            Registrar Usuarios
          </a>
      
      <!-- Botón para Eliminar Usuarios -->
          <a class="adminButton" href="eliminar_usuarios.php">
            Eliminar Usuarios
          </a>

      <!-- Botón para Registrar Equipos -->
          <a class="adminButton" href="registrar_equipos.php">
            Registrar Equipos
          </a>

      <!-- Botón para Eliminar Equipos -->
          <a class="adminButton" href="eliminar_equipos.php">
            Eliminar Equipos
          </a>

      <!-- Botón para Añadir Jugadores/Entrenadores a Equipos -->
          <a class="adminButton" href="addUsuarioTeam.php">
              Añadir Usuarios a Equipos
          </a>

      <!-- Botón para Eliminar Jugadores/Entrenadores a Equipos -->
          <a class="adminButton" href="eliminar_UsuarioTeam.php">
            Eliminar Usuarios de Equipos        
          </a>
    </div>
  EOS;

  require __DIR__.'/includes/vistas/plantilla.php';
?>
