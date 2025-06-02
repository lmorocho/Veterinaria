<?php
require("inc/auth_empleado.php"); // Validación segura para rol Empleado
require("conexion.php");
require("inc/menu_empleado.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Empleado';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Empleado</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <?php menu_empleado(); ?>

  <div class="alert alert-info text-center fst-italic mt-0" role="alert">
    <h4>Bienvenido <?= htmlspecialchars($usuario); ?> al Panel de Empleado del Sistema de Veterinaria.</h4>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>