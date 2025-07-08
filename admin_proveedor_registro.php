<?php
// admin_proveedor_guardar_registro.php
require("inc/auth_admin.php");
require("conexion.php");
require("inc/menu_admin.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Proveedor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
  <style>
    body { background-image: url('img/paws_background.png'); background-repeat: repeat; background-attachment: fixed; }
    body::before { content: ""; position: fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(255,255,255,0.5); pointer-events:none; z-index:-1; }
  </style>
</head>
<body>
  <?php menu_admin(); ?>
  <div class="alert alert-warning text-center fst-italic" role="alert">
    <h4>Registro y Alta de Proveedores</h4>
  </div>
  <div class="container mt-4">
    <h2 class="text mb-4">Datos del Proveedor</h2>

    <?php if (isset($_SESSION['modal_exito'])): ?>
      <div class="modal fade show" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" style="display:block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-dark text-white">
              <h5 class="modal-title">Registro Exitoso</h5>
            </div>
            <div class="modal-body">
              <?= htmlspecialchars($_SESSION['modal_exito']); unset($_SESSION['modal_exito']); ?>
            </div>
            <div class="modal-footer">
              <a href="admin_proveedor_registro.php" class="btn btn-primary">Registrar otro</a>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-backdrop fade show"></div>
    <?php endif; ?>

    <form action="admin_proveedor_guardar_registro.php" method="post">
      <!-- Forzamos id_rol = 4 -->
      <input type="hidden" name="id_rol" value="4">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" id="apellido" name="apellido" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="empresa" class="form-label">Empresa</label>
            <input type="text" id="empresa" name="empresa" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" id="dni" name="dni" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" id="telefono" name="telefono" class="form-control">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" id="direccion" name="direccion" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="nombre_usuario" class="form-label">Usuario</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Tipo de Rol</label>
            <select class="form-select" disabled>
              <option selected>Proveedor</option>
            </select>
          </div>
        </div>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-primary">Guardar Proveedor</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
