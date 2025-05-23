
<?php
session_start();
if (!isset($_SESSION['cliente'])) {
  header("Location: login_cliente.php");
  exit;
}

$usuario = $_SESSION['cliente']['Nombre'];
$rol = $_SESSION['cliente']['ID_Rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Menú Principal - Sistema Veterinaria</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="menu_rol.php">Sistema Veterinaria</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="menu_rol.php">Menú</a></li>
      </ul>
      <span class="navbar-text text-light me-3">
        Usuario: <?php echo $_SESSION['cliente']['Nombre']; ?>
      </span>
      <a href="logout.php" class="btn btn-outline-light">Cerrar sesión</a>
    </div>
  </div>
</nav>

  <h2>Bienvenido, <?php echo $usuario; ?>!</h2>

  <?php if ($rol == 1): ?>
    <h4>Rol: Administrador</h4>
    <ul>
      <li><a href="admin_dashboard.php">Panel de Administración</a></li>
      <li><a href="cliente_mascota.php">Gestión de Clientes y Mascotas</a></li>
      <li><a href="gestion_empleados.php">Gestión de Empleados</a></li>
      <li><a href="gestion_inventario.php">Inventario</a></li>
    </ul>
  <?php elseif ($rol == 2): ?>
    <h4>Rol: Empleado</h4>
    <ul>
      <li><a href="calendario_turnos.php">Turnos</a></li>
      <li><a href="historial_medico.php">Historial Médico</a></li>
    </ul>
  <?php elseif ($rol == 3): ?>
    <h4>Rol: Cliente</h4>
    <ul>
      <li><a href="ver_mascotas.php">Mis Mascotas</a></li>
      <li><a href="solicitar_turno.php">Solicitar Turno</a></li>
    </ul>
  <?php elseif ($rol == 4): ?>
    <h4>Rol: Proveedor</h4>
    <ul>
      <li><a href="proveedor_panel.php">Gestión de Proveedor</a></li>
      <li><a href="productos_ofrecidos.php">Productos</a></li>
    </ul>
  <?php else: ?>
    <p class="text-danger">Rol no reconocido.</p>
  <?php endif; ?>

  <a href="logout.php" class="btn btn-danger mt-4">Cerrar Sesión</a>
</body>
</html>