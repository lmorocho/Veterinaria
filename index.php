
<?php include('conexion.php'); ?>
<?php
/*session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conexion->prepare("SELECT * FROM cliente WHERE Email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $resultado = $stmt->get_result();

  if ($resultado->num_rows === 1) {
    $cliente = $resultado->fetch_assoc();
    if ($cliente['Password'] === $password) {
      $_SESSION['cliente'] = $cliente;
      header("Location: menu_rol.php");
      exit;
    } else {
      $error = "Contraseña incorrecta.";
    }
  } else {
    $error = "Este correo no está registrado. Solo se permite un registro por email.";
  }
}*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Menú Principal - Sistema Veterinaria - Grupo 2 - Instituto Rosello</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <?php
    require("inc/menu.php");
    require("inc/carrusel.php");
    require("inc/acerca_left.php");
    require("inc/acerca_top.php");
    require("inc/acerca_right.php");
    require("inc/chat_left.php");
    require("inc/banner1.php");
    //require("inc/dashboard_veterinaria.php")
  ?>

</head>
<body>
    <?php menu(); ?>
    <!--Título de la página-->
    <div class="alert alert-warning text-center fst-italic" role="alert">
        <h4>Bienvenido al Sistema de Veterinaria</h4>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <!--<form action="login_cliente.php" method="post">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>-->
    </div>

    <!--Banner Landing-->
    <div class="text-center">
        <!--Slides automaticos-->
        <?php carrusels(); ?>

        <div class="alert alert-secondary" role="alert">
            <!--<h5>Nosotros cuidamos tus mascotas!</h5>-->
            <div class="row">
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
    </div>

    <!-- Banner1 Veterinaria -->
    <?php bannerpet1(); ?>

    <script src="js/bootstrap.bundle.min.js"></script>
    <!--<script src="js/chatbot.js"></script>-->
    
</body>
</html>
