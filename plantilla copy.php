<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Plantilla base</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <?php
        require("inc/menu.php")
        include('inc/conexion.PHP');
    ?>
     </head>
     <body class ="container">
    <!-- Barra de navegación -->  
    <?php menu(); ?>
        <!-- Título de la página -->
    <div class="alert alert-primary text-center fst-italic" role="alert">
        <h4>Título de la página.</h4>
    </div>

    <div class="row">
      <div class="col-4"></div>
      <div class="col-4"></div>
      <div class="col-4"></div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
