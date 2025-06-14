<?php
// invitado.php
// Pantalla de registro para invitado con modal de éxito
if (session_status() === PHP_SESSION_NONE) session_start();
include('conexion.php');

// Capturar mensaje de éxito si existe
$mensaje_exito = $_SESSION['modal_invitado'] ?? null;
unset($_SESSION['modal_invitado']);

// Redirigir usuarios autenticados
if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
    header('Location: ' . strtolower($_SESSION['rol']) . '_dashboard.php');
    exit;
}

require('inc/menu_invitado.php');
$nombreUsuario = 'Invitado';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - Invitado</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/custom.css">
</head>
<body>
  <?php menu_invitado(); ?>
  <div class="alert alert-primary text-center fst-italic mt-0" role="alert">
    <h4>Bienvenido <?= htmlspecialchars($nombreUsuario) ?> al Registro de Clientes.</h4>
  </div>

  <div class="container mt-5">
  <div class="alert alert-danger text-center mt-0" role="alert">
    <p><b>Recuerde:</b> El alta por 1ra vez de Mascotas se realizará en nuestra Veterinaria con asistencia de nuestro personal calificado.</p>
  </div>
    <form action="invitado_guardar_registro.php" method="post">
      <div class="row">
        <div class="col-md-6">
          <!-- Campos personales -->
          <div class="mb-3"><label>Nombre</label><input type="text" name="nombre" class="form-control" required></div>
          <div class="mb-3"><label>Apellido</label><input type="text" name="apellido" class="form-control" required></div>
          <div class="mb-3"><label>DNI</label><input type="text" name="dni" class="form-control" required></div>
          <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
          <div class="mb-3"><label>Teléfono</label><input type="text" name="telefono" class="form-control"></div>
          <div class="mb-3"><label>Dirección</label><input type="text" name="direccion" class="form-control"></div>
          <div class="mb-3"><label>Fecha de Nacimiento</label><input type="date" name="fecha_nacimiento" class="form-control"></div>
        </div>
        <div class="col-md-6">
          <!-- Credenciales y rol -->
          <div class="mb-3"><label>Nombre de Usuario</label><input type="text" name="usuario" class="form-control" required></div>
          <div class="mb-3"><label>Contraseña</label><input type="password" name="password" class="form-control" required></div>
          <div class="mb-3">
            <label>Rol</label>
            <select name="id_rol" class="form-select" disabled><option value="3" selected>Cliente</option></select>
            <input type="hidden" name="id_rol" value="3">
          </div>
        </div>
      </div>
      <div class="text-end mt-4">
        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="index.php" class="btn btn-secondary ms-2">Cancelar</a>
      </div>
    </form>
  </div>

  <!-- Modal de éxito -->
  <?php if ($mensaje_exito): ?>
    <div class="modal fade" id="modalExito" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title" id="modalLabel">Registro Exitoso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <?= htmlspecialchars($mensaje_exito) ?>
          </div>
          <div class="modal-footer">
            <a href="login_cliente.php" class="btn btn-primary">Ir al login</a>
          </div>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('modalExito'));
        modal.show();
      });
    </script>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
