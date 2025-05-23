<?php include('conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php
    require("inc/menu.php");
  ?>
</head>
<body>
<?php menu(); ?>
  <div class="container mt-5">
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <!--<h2 class="mb-4">Acceso para Usuarios</h2>-->
    <div class="row justify-content-center">
      <div class="col-md-6">
      <h2 class="mb-4">Acceso para Usuarios</h2>
        <div class="card shadow">
          <div class="card-header bg-dark text-white">Iniciar Sesión</div>
            <div class="card-body">
              <form action="login_cliente.php" method="post">
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
  
    <!--Corroborando acceso del usuario con la tabla cliente-->
    <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conexion->prepare("SELECT * FROM cliente WHERE Email = ? AND Password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
          session_start();
          $cliente = $resultado->fetch_assoc();
          $_SESSION['cliente'] = $cliente;

          echo '<div class="alert alert-success mt-3">Acceso correcto. Redirigiendo...</div>';

          if ($cliente['ID_Rol'] == 1) {
            echo '<script>setTimeout(() => { window.location.href = "admin_dashboard.php"; }, 1500);</script>';
          } elseif ($cliente['ID_Rol'] == 2) {
            echo '<script>setTimeout(() => { window.location.href = "empleado_dashboard.php"; }, 1500);</script>';
          } elseif ($cliente['ID_Rol'] == 3) {
            echo '<script>setTimeout(() => { window.location.href = "cliente_dashboard.php"; }, 1500);</script>';
          } elseif ($cliente['ID_Rol'] == 4) {
            echo '<script>setTimeout(() => { window.location.href = "proveedor_dashboard.php"; }, 1500);</script>';
          } else {
            echo '<div class="alert alert-warning mt-3">Rol no reconocido.</div>';
          }
        } else {
          echo '<div class="alert alert-danger mt-3">Email o contraseña incorrectos.</div>';
        }
      }
    ?>
  </div>
  <script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
