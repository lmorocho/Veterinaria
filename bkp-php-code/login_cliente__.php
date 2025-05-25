<?php include('conexion.php'); session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php require("inc/menu.php"); ?>
</head>
<body>
<?php menu(); ?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h2 class="mb-4">Acceso para Usuarios</h2>
      <div class="card shadow">
        <div class="card-header bg-dark text-white">Iniciar Sesión</div>
        <div class="card-body">
          <form method="post">
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Contraseña</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
            <p class="mt-3">¿No tienes cuenta? <a href="cliente_mascota.php">Registrarse</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $tablas = [
    'cliente' => 'Cliente',
    'empleado' => 'Empleado',
    'proveedor' => 'Proveedor'
  ];

  $usuario_encontrado = false;

  foreach ($tablas as $tipo => $tabla) {
    $stmt = $conexion->prepare("
      SELECT t.*, r.Nombre_Rol FROM $tabla t
      JOIN Rol_Usuario r ON t.ID_Rol = r.ID_Rol
      WHERE t.Email = ? AND t.Password = ?
    ");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
      $usuario = $res->fetch_assoc();
      $_SESSION['usuario'] = $usuario;
      $_SESSION['rol'] = $usuario['Nombre_Rol'];
      $usuario_encontrado = true;

      echo "<div class='alert alert-success mt-3'>Acceso correcto como {$usuario['Nombre_Rol']}. Redirigiendo...</div>";

      $dashboard = strtolower($usuario['Nombre_Rol']) . "_dashboard.php";
      echo "<script>setTimeout(() => { window.location.href = '$dashboard'; }, 1500);</script>";
      break;
    }
  }

  if (!$usuario_encontrado) {
    echo '<div class="alert alert-danger mt-3">Email o contraseña incorrectos.</div>';
  }
}
?>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
