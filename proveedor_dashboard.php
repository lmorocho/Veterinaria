<?php
  require("inc/auth_proveedor.php"); // Validación segura para rol Proveedor
  require("conexion.php");
  require("inc/menu_proveedor.php");

  $usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Proveedor';
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Proveedor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

  <?php menu_proveedor(); ?>

  <div class="alert alert-warning text-center fst-italic mt-0" role="alert"><!--Color cambiado a warning-->
    <h4>Bienvenido <?= htmlspecialchars($usuario); ?> al Panel de Proveedor del Sistema de Veterinaria.</h4>
  </div>

  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <?php chatbot(); ?>

  <script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
