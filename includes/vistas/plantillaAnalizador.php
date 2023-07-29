<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $tituloPagina ?></title>
        <link rel="icon" href="<?= RUTA_IMGS . '/icono_club.png' ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/automatizacion.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/sidebarDer.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/cabecera.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estilosjs.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/analizadorstyles.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/perfil.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/misequipos.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/login.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/sidebarIzq.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/main.css" />

        <script src="<?= RUTA_JS ?>/functions.js"> </script>
        <script src="<?= RUTA_JS ?>/ajax.js"> </script>
        <script src="<?= RUTA_JS ?>/estilos.js"> </script>

    </head>
</html> 

<?php
            require('./includes/vistas/cabecera.php');

    ?>
<body>
    <?php
            require('./includes/vistas/sidebarIzq.php');
            require('./includes/vistas/main.php');
            require('./includes/vistas/sidebarDer.php');
            require('./includes/vistas/pie.php');

    ?>
</body>
       
       