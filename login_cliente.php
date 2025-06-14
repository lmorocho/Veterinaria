<?php
include("conexion.php");
session_start();

// Validación del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = $_POST['usuario'];
  $password = $_POST['password'];

  // Buscar usuario en la tabla Usuario
  $stmt = $conexion->prepare("SELECT u.ID_Usuario, u.Nombre_Usuario, u.Password, u.ID_Rol, r.Nombre_Rol 
                              FROM Usuario u 
                              JOIN Rol_Usuario r ON u.ID_Rol = r.ID_Rol 
                              WHERE u.Nombre_Usuario = ?");
  $stmt->bind_param("s", $usuario);
  $stmt->execute();
  $resultado = $stmt->get_result();

  if ($resultado->num_rows === 1) {
    $usuarioDatos = $resultado->fetch_assoc();

    // Comparar directamente texto plano (sin password_verify aún)
    if ($password === $usuarioDatos['Password']) {
      $_SESSION['usuario'] = [
        'ID_Usuario' => $usuarioDatos['ID_Usuario'],
        'Nombre_Usuario' => $usuarioDatos['Nombre_Usuario'],
        'ID_Rol' => $usuarioDatos['ID_Rol'],
        'Nombre_Rol' => $usuarioDatos['Nombre_Rol']
      ];
      $_SESSION['rol'] = $usuarioDatos['Nombre_Rol'];

      // Obtener datos adicionales del rol
      switch ($usuarioDatos['ID_Rol']) {
        case 2: // Empleado
          $query = $conexion->prepare("SELECT * FROM Empleado WHERE ID_Usuario = ?");
          break;
        case 3: // Cliente
          $query = $conexion->prepare("SELECT * FROM Cliente WHERE ID_Usuario = ?");
          break;
        case 4: // Proveedor
          $query = $conexion->prepare("SELECT * FROM Proveedor WHERE ID_Usuario = ?");
          break;
        default:
          $query = null;
      }

      if (isset($query)) {
        $query->bind_param("i", $usuarioDatos['ID_Usuario']);
        $query->execute();
        $extra = $query->get_result();
        if ($extra->num_rows === 1) {
          $_SESSION['usuario'] = array_merge($_SESSION['usuario'], $extra->fetch_assoc());
        }
      }

      // Redirigir según el rol
      switch ($usuarioDatos['ID_Rol']) {
        case 1:
          header("Location: admin_dashboard.php"); break;
        case 2:
          header("Location: empleado_dashboard.php"); break;
        case 3:
          header("Location: cliente_dashboard.php"); break;
        case 4:
          header("Location: proveedor_dashboard.php"); break;
        default:
          header("Location: index.php"); break;
      }
      exit;
    } else {
      $error = "Contraseña incorrecta.";
    }
  } else {
    $error = "Usuario no registrado.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Font Awesome Free -->
  <link   rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!--<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">-->
  <link href="css/custom.css" rel="stylesheet">
  <?php  
    require("inc/chat_bot.php");
    require("inc/menu.php"); 
  ?>
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
          <?php if (isset($error)): ?>
            <div class="alert alert-danger"> <?= $error ?> </div>
          <?php endif; ?>

          <form method="post">
            <div class="mb-3">
              <label for="usuario" class="form-label">Nombre de Usuario</label>
              <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
            <!--<p class="mt-3 text-center">¿No tienes cuenta? <a href="cliente_mascota.php">Registrarse</a></p>-->
            <p class="mt-3 text-center">¿No tienes cuenta? <a href="invitado.php">Registrarse</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
