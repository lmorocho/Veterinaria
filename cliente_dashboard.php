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
</head>
<body>

    <?php menu_cliente(); ?>

    <div class="alert alert-secondary text-center fst-italic mt-0" role="alert"><!--Color cambiado a info-->
      <h4>Bienvenido <?= htmlspecialchars($usuario); ?> al Panel de Cliente del Sistema de Veterinaria.</h4>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>