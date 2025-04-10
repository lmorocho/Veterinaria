


<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Baja de Usuario</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">

  </head>
<body class="container">
    <?php
   // tomo los datos del GET

   $usuario = $_GET['usuario'];
   $clave = $_GET['clave'];
   $rol = $_GET['rol'];

    ?>

    <!-- Titulo de página -->
    <div class="alert alert-primary text-center fst-italic" role="alert">
        <h4>Baja de Usuario</h4>
    </div>
    
    <!-- FORMULARIO -->

    <div class="container">
        <div class="row">
           <div class="col-3"></div>
           <div class="col-6">
            <form action="baja_usuario_sql.PHP" method="post">
                <div class="form-group">
                    <label for="usuario" style="color:green" class="font-weight-bold">Usuario</label>
                    <input readonly value=<?php echo $usuario;?> type="text" id="usuario" name="usuario" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="clave" style="color:green" class="font-weight-bold">Clave</label>
                    <input readonly value=<?php echo $clave;?> type="text" id="clave" name="clave" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="rol" style="color:green" class="font-weight-bold">Rol</label>
                    <input readonly value=<?php echo $rol;?> type="text" id="rol" name="rol" class="form-control">
                </div>

                <br>
                <div class="row">
                    <div class="col-6">
                    <button name="boton" value="1" type="submit" class="btn btn-secondary container-fluid">Dar de Baja</button>
                    </div>
                    <div class="col-6">
                    <button name="boton" value="0" type="submit" class="btn btn-danger container-fluid">Cancelar</button>
                
                    </div>
                </div>
            </form>
            </div>
           
            </div>
        </div>
<br>
       
    

</div>

    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>