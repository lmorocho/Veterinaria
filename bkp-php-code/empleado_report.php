<?php
require("inc/auth_empleado.php");
require("conexion.php");
require("inc/menu_empleado.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Empleado';

// Solo cargamos clientes (ID_Rol = 3)
$consulta = $conexion->prepare("SELECT c.*, r.Nombre_Rol FROM Cliente c INNER JOIN Usuario u ON c.ID_Usuario = u.ID_Usuario INNER JOIN Rol_Usuario r ON u.ID_Rol = r.ID_Rol WHERE u.ID_Rol = 3");
$consulta->execute();
$resultado = $consulta->get_result();
$datos = [];
while ($fila = $resultado->fetch_assoc()) {
  $datos[] = $fila;
}
$consulta->close();

$mascotas = $conexion->query("SELECT * FROM Mascota")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reporte de Clientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php menu_empleado(); ?>
  <div class="alert alert-warning text-center fst-italic" role="alert">
    <h4>Bienvenido <?= htmlspecialchars($usuario); ?> al Panel de Reporte de Clientes.</h4>
  </div>
  <div class="container mt-4">
    
    <h2 class="mb-4">Clientes Registrados</h2>

    <?php if ($datos): ?>
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
    <?php else: ?>
      <div class="alert alert-warning">No hay registros de clientes disponibles.</div>
    <?php endif; ?>

    <h4 class="mt-5">Total de Mascotas Registradas: <?= count($mascotas) ?></h4>
  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>