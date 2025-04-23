<!doctype html>
<html lang="es">
<title>Sistema de Veterinaria - Grupo 2 - Instituto Roselllo</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <?php
        require("inc/menu.php")        
    ?>
</head>
<!--<body class="container">--> <!--Contenido dentro del container--> 
<body class="index-page"> <!--Contenido dentro de toda la pagina-->
    <!--Barra de navegación-->
    <?php menu(); ?>
    <!--Título de la página-->
    <div class="alert alert-primary text-center fst-italic" role="alert">
        <h4>Alta Cliente & Mascota</h4>
    </div>
    <!-- 1. Ingreso de Cliente y Mascotas -->
    <!-- FORMULARIO-->
    <div class="row">
        <div class="col-2"></div>
        <div class="col-4">
            <form action="alta_cliente_destino.php" method="get">
                <br><label><h4>Ingreso Cliente</h4></label>
                <!-- Línea -->
                <!--<hr size="2px" color="black">-->
                <!-- Alta Dueño-->
                <div class="mb-3">
                    <!--<label for="basic-url" class="form-label">Nombre:</label>-->
                    <label for="basic-url" class="form-label"></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">Nombre:</span>
                        <input type="text" class="form-control" placeholder="Escriba el Nombre" aria-label="nombrecliente" required>
                    </div>
                    <!--<label for="basic-url" class="form-label">Apellido:</label>-->
                    <label for="basic-url" class="form-label"></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">Apellido:</span>
                        <input type="text" class="form-control" placeholder="Escriba el Apellido" aria-label="apellidocliente" required>
                    </div>
                    <!--<label for="basic-url" class="form-label">DNI:</label>-->
                    <label for="basic-url" class="form-label"></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">DNI:</span>
                        <input type="number" class="form-control" placeholder="Escriba el DNI" aria-label="dnicliente" required>
                    </div>
                    <!--<label for="basic-url" class="form-label">Teléfono:</label>-->
                    <label for="basic-url" class="form-label"></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">Teléfono:</span>
                        <input type="number" class="form-control" placeholder="Escriba el Teléfono" aria-label="telefonocliente" required>
                    </div>
                    <!--<label for="basic-url" class="form-label">Email:</label>-->
                    <label for="basic-url" class="form-label"></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">Email:</span>
                        <input type="text" class="form-control" placeholder="nombre@ejemplo.com" aria-label="emailcliente" required>
                    </div>
                    <!--<label for="basic-url" class="form-label">Dirección:</label>-->
                    <label for="basic-url" class="form-label"></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">Dirección:</span>
                        <input type="text" class="form-control" placeholder="Escriba la Dirección" aria-label="direccioncliente" required>
                    </div>
                    <!--<label for="basic-url" class="form-label">Fecha Nacimiento:</label>-->
                    <label for="basic-url" class="form-label"></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">Fecha de Nacimiento:</span>
                        <input type="date" class="form-control" placeholder="Escriba la Fecha de Nacimiento" aria-label="fecnaccliente" required>
                    </div>
                </div> 
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="subtmit">Registrar Cliente</button><br>
                </div>
            </form> 
        </div>
        <div class="col-4">
            <form action="alta_cliente_destino.php" method="get">
                <br><label><h4>Ingreso Mascota</h4></label>
                <!-- Línea -->
                <!--<hr size="2px" color="black">-->
                <div class="mb-3">
                    <label for="basic-url" class="form-label"></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">Nombre Mascota:</span>
                        <input type="text" class="form-control" placeholder="Escriba la Dirección" aria-label="nombremascota" required>
                    </div>
                    <label for="basic-url" class="form-label"></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">Fecha de Nacimiento Mascota:</span>
                        <input type="date" class="form-control" placeholder="Escriba la Fecha de Nacimiento Mascota" aria-label="fecnacmascota" required>
                    </div>
                    <label for="basic-url" class="form-label"></label>
                    <div class="form-floating">
                        <select class="form-select" aria-label="Default select example" id="floatingSelectGrid">
                            <option selected>Seleccione..</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                        </select>
                        <label for="floatingSelectGrid">Tipo de Mascota</label>
                    </div>
                    <label for="basic-url" class="form-label"></label>
                    <div class="form-floating">
                        <select class="form-select" aria-label="Default select example" id="floatingSelectGrid">
                            <option selected>Seleccione..</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                        </select>
                        <label for="floatingSelectGrid">Raza de la Mascota</label>
                    </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit">Registrar Mascota</button><br>
                </div>
            </form>  
        </div>
        <div class="col-2"></div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>