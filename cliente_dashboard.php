<?php
  require("inc/auth_cliente.php"); // Validación segura para rol Cliente
  require("conexion.php");
  require("inc/menu_cliente.php");

  $usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Cliente';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Font Awesome Free -->
  <link   rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!--<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">-->
  <link href="css/custom.css" rel="stylesheet">
  <?php  
    require("inc/chat_bot.php");
  ?>
</head>
<body>

    <?php menu_cliente(); ?>

    <div class="alert alert-secondary text-center fst-italic mt-0" role="alert"><!--Color cambiado a info-->
      <h4>Bienvenido <?= htmlspecialchars($usuario); ?> al Panel de Cliente del Sistema de Veterinaria.</h4>
    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php chatbot(); ?>

    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>