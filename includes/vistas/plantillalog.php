<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $tituloPagina ?></title>
        <link rel="icon" href="<?= RUTA_IMGS . '/icono_club.png' ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/automatizacion.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/sidebarDer.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/cabecera.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/cambioPass.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/analizadorstyles.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/perfil.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/login.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/main.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/footer.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/body.css" />



        <script src="<?= RUTA_JS ?>/functions.js"> </script>
        <script src="<?= RUTA_JS ?>/ajax.js"> </script>
    </head>
</html> 

    <body>
    <?php
            require('./includes/vistas/cabecera.php');
            require('./includes/vistas/noLog.php');
            require('./includes/vistas/pie.php');
    ?>
</body>
</html>
