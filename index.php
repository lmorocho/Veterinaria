<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Veterinaria - Grupo 2 - Instituto Roselllo</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <?php
        require("inc/menu.php");
        require("inc/acerca.php");
        require("inc/carrusel.php")
    ?>
</head>
<!--<body class="container">--> <!--Contenido dentro del container--> 
<body class="index-page"> <!--Contenido dentro de toda la pagina-->
    <!--Barra de navegación-->
    <?php menu(); ?>
    <!--Título de la página-->
    <div class="alert alert-warning text-center fst-italic" role="alert">
        <h4>Bienvenido al Sistema de Veterinaria</h4>
    </div>
   
    <div class="text-center">
        <!--Slides automaticos-->
        <?php carrusels(); ?>
        <!--<img src="img/dog.png" class="img-fluid" alt="...">-->
        <!--<img src="img/russian.jpg" class="img-fluid" alt="...">-->
      
        <div class="alert alert-secondary" role="alert">
            <!--<h5>Nosotros cuidamos tus mascotas!</h5>-->
            <div class="row">
                <!--<div class="col-12">
                    <link href="css/style.css" rel="stylesheet">
                </div>-->
                <div class="col-4">
                    <button class="btn btn-link" type="button">Link1</button>
                </div>
                <div class="col-4">
                    <button class="btn btn-link" type="button">Link2</button>
                </div>
                <div class="col-4">
                    <!--Barra lateral izquierda navegación-->
                    <?php acercade(); ?>
                </div>
            </div>  
        </div>
        <div class="alert alert-dark" role="alert">
                Texto Ejemplo
        </div>
    </div>
    
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>