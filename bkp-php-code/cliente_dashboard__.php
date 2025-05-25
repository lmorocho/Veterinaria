<?php
include("conexion.php");
session_start();

// Verificar si hay sesión activa y que el rol sea Cliente
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Cliente') {
  header("Location: login_cliente.php");
  exit;
}

$usuario = $_SESSION['usuario']['Nombre'];
$rol_nombre = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php require("inc/menu_cliente.php"); ?>
</head>
<body>

  <?php menu_cliente(); ?>

  <!--<div class="container mt-4">-->
    <div class="alert alert-warning text-center fst-italic" role="alert">
      <h4>Bienvenido <?php echo htmlspecialchars($usuario); ?> al Sistema de Veterinaria.</h4>
      <p>Este es el panel de <strong><?php echo htmlspecialchars($rol_nombre); ?></strong>.</p>
    </div>
  <!--</div>-->

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>