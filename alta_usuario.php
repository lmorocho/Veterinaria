


<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Alta Usuario</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class ="container">
    <?php
        // require("inc/menu.php")

        // Mensaje 
        $mensaje = 'Ingrese los nuevos datos';
        if(isset($_GET['mensaje'])){
            if($_GET['mensaje']=='uno'){$mensaje = 'El usuario ya existe en la base';}
        }
    ?>
    <!-- Título de la página -->
    <div class="alert alert-primary text-center fst-italic" role="alert">
        <h4>Alta de usuario nuevo.</h4>
    </div>
    
    <!-- Grilla Formulario -->
    <div class="row">
      <div class="col-4"></div>
      <div class="col-4">
        <!-- Formulario -->
        <form action="alta_usuario_sql.php" method="POST">
            <div class="form-group">
                <label for="usuario">Ingrese el usuario</label>
                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Ingrese el usuario">
            </div>
            <br>
            <div class="form-group">
                <label for="clave">Ingrese la clave</label>
                <input type="text" id="clave" name="clave" class="form-control" placeholder="Ingrese la clave">
            </div>
            <br>
            <div class="form-group">
                <label for="perfil">Ingrese el perfil</label>
                <input type="text" id="perfil" name="perfil" class="form-control" placeholder="Ingrese el perfil">
            </div>
            <br>
            <!-- Botón  -->
                <button type="submit" class="btn btn-primary container-fluid">Enviar</button> 

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
