<?php
// admin_edit_usuarios.php
require("inc/auth_admin.php");
require("conexion.php");
require("inc/menu_admin.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';

// Obtener roles para el select
$roles = $conexion->query("SELECT ID_Rol, Nombre_Rol FROM Rol_Usuario")->fetch_all(MYSQLI_ASSOC);

// Parámetros recibidos
$rol = intval($_GET['rol'] ?? 0);
$idOriginal = intval($_GET['id'] ?? 0);

if (!$rol || !$idOriginal) {
    header('Location: admin_usuarios.php');
    exit;
}

// Variables para precarga
$nombre = $apellido = $dni = $email = $telefono = $direccion = $fecha_nac = '';
$idUsuario = 0;
$nombreUsuario = '';

// Consultar datos según rol
switch ($rol) {
    case 1: case 2: // Empleado
        $stmt = $conexion->prepare(
            "SELECT e.Nombre, e.Apellido, e.DNI, e.Fecha_Nacimiento, e.Email, e.Telefono, e.Direccion, e.ID_Usuario
             FROM Empleado e
             WHERE e.ID_Empleado = ?"
        );
        break;
    case 3: // Cliente
        $stmt = $conexion->prepare(
            "SELECT c.Nombre, c.Apellido, c.DNI, c.Fecha_Nacimiento, c.Email, c.Telefono, c.Direccion, c.ID_Usuario
             FROM Cliente c
             WHERE c.ID_Cliente = ?"
        );
        break;
    case 4: // Proveedor
        $stmt = $conexion->prepare(
            "SELECT p.Nombre AS Nombre, p.Empresa AS Apellido, '' AS DNI, NULL AS Fecha_Nacimiento,
                    p.Email, p.Telefono, p.Direccion, p.ID_Usuario
             FROM Proveedor p
             WHERE p.ID_Proveedor = ?"
        );
        break;
    default:
        $stmt = null;
}

if ($stmt) {
    $stmt->bind_param("i", $idOriginal);
    $stmt->execute();
    $stmt->bind_result($nombre, $apellido, $dni, $fecha_nac, $email, $telefono, $direccion, $idUsuario);
    $stmt->fetch();
    $stmt->close();
    
    // Consultar datos de usuario
    $uStmt = $conexion->prepare(
        "SELECT Nombre_Usuario, Password, ID_Rol FROM Usuario WHERE ID_Usuario = ?"
    );
    $uStmt->bind_param("i", $idUsuario);
    $uStmt->execute();
    $uStmt->bind_result($nombreUsuario, $passwordHash, $rolUsuario);
    $uStmt->fetch();
    $uStmt->close();
} else {
    header('Location: admin_usuarios.php?rol=' . $rol);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Usuario</title>
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
    <h4>Edición de Usuario - <?= htmlspecialchars($usuario) ?></h4>
  </div>
  <div class="container mt-4">
    <form action="admin_guardar_registro.php" method="post">
      <input type="hidden" name="rol" value="<?= $rol ?>">
      <input type="hidden" name="id_original" value="<?= $idOriginal ?>">
      <input type="hidden" name="id_usuario" value="<?= $idUsuario ?>">

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($nombre) ?>" required>
          </div>
          <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($apellido) ?>" required>
          </div>
          <div class="mb-3">
            <label>DNI</label>
            <input type="text" name="dni" class="form-control" value="<?= htmlspecialchars($dni) ?>" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
          </div>
          <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($telefono) ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control" value="<?= htmlspecialchars($direccion) ?>">
          </div>
          <div class="mb-3">
            <label>Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" value="<?= htmlspecialchars($fecha_nac) ?>">
          </div>
          <div class="mb-3">
            <label>Nombre de Usuario</label>
            <input type="text" name="nombre_usuario" class="form-control" value="<?= htmlspecialchars($nombreUsuario) ?>" required>
          </div>
          <div class="mb-3">
            <label>Contraseña (dejar en blanco para no cambiar)</label>
            <input type="password" name="password" class="form-control" placeholder="Nueva contraseña">
          </div>
          <div class="mb-3">
            <label>Tipo de Rol</label>
            <select name="id_rol" class="form-select" required>
              <?php foreach ($roles as $r): ?>
                <option value="<?= $r['ID_Rol'] ?>" <?= $r['ID_Rol']==$rolUsuario?'selected':'' ?>>
                  <?= htmlspecialchars($r['Nombre_Rol']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="admin_usuarios.php?rol=<?= $rol ?>" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
