<!doctype html>
<html lang="es">
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
    <div class="alert alert-primary text-center fst-italic" role="alert">
        <h4>Agenda Veterinaria</h4>
    </div>
    <!-- FORMULARIO-->
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form action="pagina_destino.php" method="get">
                <br><label><h4>Formulario de Ingreso</h4></label>
                <div class="mb-3">
                    <label for="basic-url" class="form-label">Ingrese el nombre del dueño</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">nombre_dueno:</span>
                        <!--<input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">-->
                        <input type="text" class="form-control" placeholder="Escriba el nombre" aria-label="username">
                    </div>
                    <!--<div class="form-text" id="basic-addon4">Example help text goes outside the input group.</div>-->
                </div>
                <div class="mb-3">
                    <label for="basic-url" class="form-label">Ingrese su password</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">password:</span>
                        <!--<input type="password" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">-->
                        <input type="password" class="form-control" placeholder="Escriba su clave registrada" aria-label="password">
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="button">Agendar</button><br>
                </div>
                <div class="alert alert-warning text-center" role="alert">        
                    Ingrese los nuevos datos
                </div>
                <div class="row"> <!-- Agregamos las subcolumnas sobre la columna '6' del centro-->
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-link">Registrarse</button>
                    </div>
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-link">Olvidé mi Clave</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>