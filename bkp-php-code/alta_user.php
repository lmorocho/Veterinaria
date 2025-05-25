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
        <h4>Alta Usuario & Mascota</h4>
    </div>
    <!-- FORMULARIO-->
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form action="pagina_destino.php" method="get">
                <br><label><h4>Formulario de Ingreso</h4></label>
                <!-- Línea -->
                <!--<hr size="2px" color="black">-->
                <!-- Alta Dueño-->
                <div class="mb-3">
                    <label for="basic-url" class="form-label">Ingrese el Nombre del dueño</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">nombre_dueno:</span>
                        <!--<input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">-->
                        <input type="text" class="form-control" placeholder="Escriba el nombre" aria-label="username">
                    </div>
                    <!--<div class="form-text" id="basic-addon4">Example help text goes outside the input group.</div>-->
                </div>
                
                <!-- Alta NombreMascota & Raza-->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="basic-url" class="form-label">Ingrese el Nombre de la mascota</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">nombre_mascota:</span>
                                <!--<input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">-->
                                <input type="text" class="form-control" placeholder="Escriba el nombre" aria-label="namepet">
                            </div>
                            <!--<div class="form-text" id="basic-addon4">Example help text goes outside the input group.</div>-->
                        </div>
                        <div class="col-6">
                            <label for="basic-url" class="form-label">Ingrese el tipo de la mascota</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">tipo_mascota:</span>
                                <!--<input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">-->
                                <!--<input type="text" class="form-control" placeholder="Escriba el nombre" aria-label="razatypepet">-->
                                <select class="form-select" aria-label="razatypopet">
                                    <option selected>Seleccione el tipo</option>
                                    <option value="1">Perro</option>
                                    <option value="2">Gato</option>
                                    <!--<option value="3">Three</option>-->
                                </select>
                            </div>
                            <!--<div class="form-group">
                                <label for="selector1">Ingrese el tipo de la mascota</label>
                                <select name="selector1" id="selector1">
                                    <option value="<Perro">Perro</option>
                                    <option value="Gato">Gato</option>
                                    <option value="Queja">Queja</option>
                                </select>
                            </div>-->
                           
                        </div>
                    </div>    
                </div>
                <!-- Alta Edad & Peso-->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="basic-url" class="form-label">Ingrese la Edad de la mascota</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">edad_mascota:</span>
                                <!--<input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">-->
                                <input type="text" class="form-control" placeholder="Escriba el nombre" aria-label="edadpet">
                            </div>
                            <!--<div class="form-text" id="basic-addon4">Example help text goes outside the input group.</div>-->
                        </div>
                        <div class="col-6">
                            <label for="basic-url" class="form-label">Ingrese el Peso tentativo de la mascota</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">peso_mascota:</span>
                                <!--<input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">-->
                                <input type="text" class="form-control" placeholder="Escriba el nombre" aria-label="weightpet">
                            </div>
                        </div>
                    </div>    
                </div>
                
                <!-- Alta Password
                <div class="mb-3">
                    <label for="basic-url" class="form-label">Ingrese su password</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">password:</span>
                        #Comentado# <input type="password" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
                        <input type="password" class="form-control" placeholder="Escriba su clave registrada" aria-label="password">
                    </div>
                </div>-->
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="button">Registrar</button><br>
                </div>
                <!--<div class="alert alert-warning text-center" role="alert">        
                    Ingrese los nuevos datos
                </div>-->
                <!-- <div class="row">  Agregamos las subcolumnas sobre la columna '6' del centro
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-link">Registrarse</button>
                    </div>
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-link">Olvidé mi Clave</button>
                    </div>
                </div>-->
            </form>
        </div>
        <div class="col-3"></div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>