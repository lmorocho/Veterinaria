<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Veterinaria - Grupo 2 - Instituto Roselllo</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <?php
        require("inc/menu.php");
        require("inc/carrusel.php");
        require("inc/acerca_left.php");
        require("inc/acerca_top.php");
        require("inc/acerca_right.php");
        require("inc/chat_left.php");
        require("inc/banner1.php");
        require("inc/dashboard_veterinaria.php")
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
        <br>
        <div class="alert alert-secondary" role="alert">
            <!--<h5>Nosotros cuidamos tus mascotas!</h5>-->
            <div class="row">
                <!--<div class="col-12">
                    <link href="css/style.css" rel="stylesheet">
                </div>-->
                <div class="col-3 flexbox">
                    <!--<button class="btn btn-link" type="button">Link1</button>-->
                    <!--Barra lateral izquierda navegación-->
                    <?php acercaderight(); ?>
                </div>
                <div class="col-3 flexbox">
                    <!--<button class="btn btn-link" type="button">Link2</button>-->
                    <?php acercadetop(); ?>
                </div>
                <div class="col-3 flexbox">
                    <!--Barra lateral izquierda navegación-->
                    <?php acercadeleft(); ?>
                </div>
                <div class="col-3 flexbox">
                    <!--<button class="btn btn-link" type="button">Chat Veterinaria</button>-->
                    <?php chatbot(); ?>
                </div>
            </div>  
        </div>
        <!--<div class="alert alert-dark" role="alert">
            Texto Ejemplo
        </div>-->
    </div>
    <!-- Banner1 Veterinaria -->
    <?php bannerpet1(); ?>
    <!-- Dashboard Veterinaria -->
    <?php dashboard(); ?>

    <div class="container text-center">
        <!-- Stack the columns on mobile by making one full-width and the other half-width -->
        <div class="row">
            <div class="col-md-8">.col-md-8</div>
            <div class="col-6 col-md-4">.col-6 .col-md-4</div>
        </div>

        <!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->
        <div class="row">
            <div class="col-6 col-md-4">.col-6 .col-md-4</div>
            <div class="col-6 col-md-4">.col-6 .col-md-4</div>
            <div class="col-6 col-md-4">.col-6 .col-md-4</div>
        </div>

        <!-- Columns are always 50% wide, on mobile and desktop -->
        <div class="row">
            <div class="col-6">.col-6</div>
            <div class="col-6">.col-6</div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
    <!--<script src="js/chatbot.js"></script>-->
</body>
</html>