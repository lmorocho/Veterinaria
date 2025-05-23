<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Empleado</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <?php
    require("inc/menu_empleado.php");
    require("inc/carrusel.php");
  ?>

</head>
<body>

  <?php
  session_start();
  include("conexion.php");

  if (!isset($_SESSION['cliente'])) {
    header("Location: login_cliente.php");
    exit;
  }

  $usuario = $_SESSION['cliente']['Nombre'];
  $id_rol = $_SESSION['cliente']['ID_Rol'];

  // Obtener el nombre del rol desde la base de datos
  $rol_nombre = '';
  $rol_stmt = $conexion->prepare("SELECT Nombre_Rol FROM Rol_Usuario WHERE ID_Rol = ?");
  $rol_stmt->bind_param("i", $id_rol);
  $rol_stmt->execute();
  $rol_result = $rol_stmt->get_result();
  if ($rol_result->num_rows === 1) {
    $row = $rol_result->fetch_assoc();
    $rol_nombre = $row['Nombre_Rol'];
  }
  ?>

  <?php menu_empleado(); ?>

  <div class="alert alert-warning text-center fst-italic" role="alert">
        <h4>Bienvenido <?php echo $usuario; ?>, al Sistema de Veterinaria.</h4>
        <p>Este es el panel de <?php echo $rol_nombre; ?>.</p>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
