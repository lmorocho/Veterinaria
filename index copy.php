<?php
  session_start();
  //verificar si esta creada una vez que está logeado
  if(!isset($_SESSION['autorizado'])){
    //Con isset para verifcar al cominezo del documento, sino existe la creamos
    $_SESSION['autorizado']='no';
}
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plantilla Base</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <?php
        require("inc/menu.php")
    ?>
  </head>
  <body class="container">
    <!-- Barra de navegación -->
    <?php menu(); ?>
    <!-- Título de la página -->
    <div class="alert alert-primary text-center fst-italic" role="alert">
        <h4>Título de la página.</h4>
    </div> 
    <!-- Fila 1 -->
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
        <!-- IF -->
        
        <?php
        if($_SESSION['autorizado']=='no'){
            // Acá va el formulario
        ?>

        <legend>Formulario de ingreso</legend>
        <form action ="login.php" method="POST">
            <div class="form-group">
                <label for="user">Ingrese su usuario</label>
                <input type="text" id="user" name="user" class="form-control" placeholder="Usuario">
            </div>
            <div class="form-group">
                <label for="pass">Ingrese su clave</label>
                <input type="password" id="pass" name="user" class="form-control" placeholder="Clave">
            </div>
            <br>
            <button class="btn btn-primary container-fluid">Ingresar</button>
            <br>

            <div clas="row">
                <div class="col-6 text-center">
                    <a href="#">Registrarse</a>
                </div>
                <div class="col-6 text-center">
                    <a href="#">Olvidé mi clave</a>
                </div>
            </div>
        </form>

        <?php
        }else {
          echo 'Bienvenido a la aplicación';}
        ?>
        </div>
        <div class="col-4"></div>
      </div>
      

    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>