<?php
require("inc/auth_admin.php");
require("conexion.php");
require("inc/menu_admin.php");

$roles = $conexion->query("SELECT ID_Rol, Nombre_Rol FROM Rol_Usuario")->fetch_all(MYSQLI_ASSOC);

$filtroRol = $_GET['rol'] ?? '';
$datos = [];

if ($filtroRol !== '') {
  $idRol = intval($filtroRol);

  switch ($idRol) {
    case 1: // Administrador (desde tabla Empleado con ID_Usuario vinculado a Rol 1)
    case 2: // Empleado (desde tabla Empleado con ID_Usuario vinculado a Rol 2)
      $consulta = $conexion->prepare("SELECT e.*, r.Nombre_Rol FROM Empleado e INNER JOIN Usuario u ON e.ID_Usuario = u.ID_Usuario INNER JOIN Rol_Usuario r ON u.ID_Rol = r.ID_Rol WHERE u.ID_Rol = ?");
      $consulta->bind_param("i", $idRol);
      break;
    case 3: // Cliente
      $consulta = $conexion->prepare("SELECT c.*, r.Nombre_Rol FROM Cliente c INNER JOIN Usuario u ON c.ID_Usuario = u.ID_Usuario INNER JOIN Rol_Usuario r ON u.ID_Rol = r.ID_Rol WHERE u.ID_Rol = ?");
      $consulta->bind_param("i", $idRol);
      break;
    case 4: // Proveedor
      $consulta = $conexion->prepare("SELECT p.*, r.Nombre_Rol FROM Proveedor p INNER JOIN Usuario u ON p.ID_Usuario = u.ID_Usuario INNER JOIN Rol_Usuario r ON u.ID_Rol = r.ID_Rol WHERE u.ID_Rol = ?");
      $consulta->bind_param("i", $idRol);
      break;
    default:
      $consulta = null;
  }

  if ($consulta) {
    $consulta->execute();
    $resultado = $consulta->get_result();
    while ($fila = $resultado->fetch_assoc()) {
      $datos[] = $fila;
    }
    $consulta->close();
  }
}

$mascotas = $conexion->query("SELECT * FROM Mascota")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reporte General por Rol</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php menu_admin(); ?>
  <div class="alert alert-warning text-center fst-italic" role="alert">
    <h4>Bienvenido <?= htmlspecialchars($_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador'); ?> al Panel de Administración del Sistema de Veterinaria.</h4>
  </div>
  <div class="container mt-4">
    
    <h2 class="mb-4">Reporte General</h2>

    <form method="get" class="row g-3 mb-4">
      <div class="col-md-4">
        <label class="form-label">Filtrar por Rol</label>
        <select name="rol" class="form-select" onchange="this.form.submit()">
          <option value="">Todos</option>
          <?php foreach ($roles as $rol): ?>
            <option value="<?= $rol['ID_Rol'] ?>" <?= $filtroRol == $rol['ID_Rol'] ? 'selected' : '' ?>>
              <?= $rol['Nombre_Rol'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </form>

    <?php if ($filtroRol && $datos): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <?php foreach (array_keys($datos[0]) as $col): ?>
                <th><?= htmlspecialchars($col) ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($datos as $fila): ?>
              <tr>
                <?php foreach ($fila as $valor): ?>
                  <td><?= htmlspecialchars($valor) ?></td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php elseif ($filtroRol): ?>
      <div class="alert alert-warning">No hay registros para el rol seleccionado.</div>
    <?php endif; ?>

    <h4 class="mt-5">Total de Mascotas Registradas: <?= count($mascotas) ?></h4>
  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
