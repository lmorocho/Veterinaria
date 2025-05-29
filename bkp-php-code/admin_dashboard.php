<?php
require("inc/auth_admin.php"); // Validación segura para rol Administrador
require("conexion.php");
require("inc/menu_admin.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <?php menu_admin(); ?>

  <div class="alert alert-warning text-center fst-italic mt-0" role="alert">
    <h4>Bienvenido <?= htmlspecialchars($usuario); ?> al Panel de Administración del Sistema de Veterinaria.</h4>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
