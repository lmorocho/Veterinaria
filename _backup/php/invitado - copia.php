<?php
// Inicialización segura de sesión
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include('conexion.php');

// Redirigir usuarios autenticados para evitar bucles
if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
  $rol = strtolower($_SESSION['rol']);
  header("Location: {$rol}_dashboard.php");
  exit;
}

//require('inc/menu_invitado.php');

// Si hay sesión activa, redirige al dashboard
if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
    header('Location: ' . strtolower($_SESSION['rol']) . '_dashboard.php');
    exit;
}

// Usuario invitado temporal
$nombreUsuario = 'Invitado';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - Invitado</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/custom.css">
  <?php 
    require 'inc/menu_invitado.php'; 
  ?>
</head>
<body>
  <!-- Menú con usuario invitado -->
  <?php menu_invitado(); ?>

  <div class="alert alert-primary text-center fst-italic mt-0" role="alert">
    <h4>Bienvenido <?= htmlspecialchars($nombreUsuario); ?> al Registo de Clientes del Sistema de Veterinaria.</h4>
  </div>

  <div class="container mt-5">
    <!--<h2 class="mb-4 text-center">Registro de Usuario</h2>-->
    <form action="invitado_guardar_registro.php" method="post">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>DNI</label>
            <input type="text" name="dni" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control">
          </div>
          <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control">
          </div>
          <div class="mb-3">
            <label>Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label>Nombre de Usuario</label>
            <input type="text" name="usuario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <!-- Campo de rol fijo: Cliente Select de rol deshabilitado -->
          <div class="mb-3">
            <label>Rol</label>
            <select name="id_rol" class="form-select" disabled>
              <option value="3" selected>Cliente</option>
            </select>
          </div>
        </div>
      </div>

      <div class="text-end mt-4">
        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="index.php" class="btn btn-secondary ms-2">Cancelar</a>
      </div>
    </form>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
