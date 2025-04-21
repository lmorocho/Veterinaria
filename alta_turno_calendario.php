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
        <h4>Calendario de Turnos</h4>
    </div>
    <!-- 2. Calendario de Turnos -->
    <!-- FORMULARIO-->
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
            <form action="#" method="get">
                <br><label><h4>Agenda</h4></label>
                <!-- Línea -->
                <!--<hr size="2px" color="black">-->
                <div class="mb-3">
                    <!--<label for="basic-url" class="form-label">DNI:</label>-->
                    <label for="basic-url" class="form-label"></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">DNI:</span>
                        <input type="text" class="form-control" placeholder="Escriba el DNI" aria-label="dnicliente" required>
                    </div>
                    <!--<label for="basic-url" class="form-label">Fecha Nacimiento:</label>-->
                    <label for="basic-url" class="form-label"></label>
                    <div class="input-group">
                        <span class="input-group-text" id="fecha-turno">Fecha de Turno:</span>
                        <input type="date" class="form-control" placeholder="Seleccione una fecha" aria-label="fecturnoconsulta" required>
                    </div>
                    <div id="calendario-turnos" class="mt-3 p-3 border rounded">Seleccione una fecha para ver turnos.</div>                    
                    <script>
                    // Ejemplo simple de interactividad para mostrar mensaje en calendario
                        document.getElementById('fecha-turno').addEventListener('change', function () {
                            const calendario = document.getElementById('calendario-turnos');
                            calendario.innerHTML = `Turnos para el ${this.value}:<br>- 10:00 - Firulais<br>- 12:30 - Luna`;
                        });
                    </script>
                </div>
                <section>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="subtmit">Consultar</button><br>
                </div>
            </form> 
        </div>
        <div class="col-4"></div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>