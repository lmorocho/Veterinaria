<?php
include("conexion.php");
session_start();

// Verifica que haya sesión activa y que el rol sea Cliente
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Cliente') {
  header("Location: login_cliente.php");
  exit;
}

$usuario = $_SESSION['usuario']['Nombre'] ?? 'Usuario';
$rol_nombre = $_SESSION['rol'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php require("inc/auth_cliente.php"); ?>
  <?php require("inc/menu_cliente.php"); ?>
</head>
<body>

<!-- Barra de navegación -->
<?php menu_cliente(); ?> 
<!--<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Veterinaria</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item text-light nav-link">
          <?php echo 'Usuario: <strong>' . htmlspecialchars($usuario) . '</strong>'; ?>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-light ms-2" href="logout.php">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>-->

<!-- Contenido principal -->
<!--<div class="container mt-4">
</div>-->
<div class="alert alert-warning text-center fst-italic" role="alert">
    <h4>Bienvenido <?php echo htmlspecialchars($usuario); ?> al Sistema de Veterinaria.</h4>
    <p>Este es el panel de <strong><?php echo htmlspecialchars($rol_nombre); ?></strong>.</p>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
