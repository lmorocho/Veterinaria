<?php
//admin_registro.php
require("inc/auth_admin.php");
require("conexion.php");
require("inc/menu_admin.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';

// Consulta de roles para el select
$roles_result = $conexion->query("SELECT ID_Rol, Nombre_Rol FROM Rol_Usuario");
$roles = $roles_result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
  <style>
    body {
      background-image: url('img/paws_background.png');
      background-repeat: repeat;
      background-attachment: fixed;
    }
    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      background: rgba(255,255,255,0.5);
      pointer-events: none;
      z-index: -1;
    }
  </style>
</head>
<body>
  <?php menu_admin(); ?>
  <div class="alert alert-warning text-center fst-italic" role="alert">
  <h4>Registro y Alta de Usuarios</h4>
  
  </div>
  <div class="container mt-4">
    <h2 class="text mb-4">Datos del Usuario</h2>

    <?php if (isset($_SESSION['modal_exito'])): ?>
    <div class="modal fade show" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display:block; background: rgba(0,0,0,0.5);">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-dark text-white">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro exitoso</h1>
          </div>
          <div class="modal-body">
            <?= htmlspecialchars($_SESSION['modal_exito']); unset($_SESSION['modal_exito']); ?>
          </div>
          <div class="modal-footer">
            <a href="admin_registro.php" class="btn btn-primary">Registrar otro</a>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <form action="admin_guardar_registro.php" method="post">
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
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control">
          </div>
          <div class="mb-3">
            <label>Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control">
          </div>
          <div class="mb-3">
            <label>Nombre de Usuario</label>
            <input type="text" name="usuario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Tipo de Rol</label>
            <select name="id_rol" class="form-select" required>
              <option value="" selected disabled>Seleccione un rol</option>
              <?php foreach ($roles as $rol): ?>
              <option value="<?= $rol['ID_Rol'] ?>"><?= htmlspecialchars($rol['Nombre_Rol']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>