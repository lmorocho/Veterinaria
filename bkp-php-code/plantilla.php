<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plantilla Base - 20240923</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <?php
        require("inc/menu.php")
    ?>
</head>
<body class="container">
    <!--Barra de navegación-->
    <?php menu(); ?>
    <!--Título de la página-->
    <div class="alert alert-primary text-center fst-italic" role="alert">
        <h4>Título de la página.</h4>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>