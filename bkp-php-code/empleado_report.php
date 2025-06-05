<?php
require("inc/auth_empleado.php");
require("conexion.php");
require("inc/menu_empleado.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Empleado';

// Obtener clientes con sus datos
$consulta = $conexion->prepare("SELECT c.*, r.Nombre_Rol FROM Cliente c 
  INNER JOIN Usuario u ON c.ID_Usuario = u.ID_Usuario 
  INNER JOIN Rol_Usuario r ON u.ID_Rol = r.ID_Rol 
  WHERE u.ID_Rol = 3");
$consulta->execute();
$resultado = $consulta->get_result();
$clientes = [];
while ($fila = $resultado->fetch_assoc()) {
  $clientes[] = $fila;
}
$consulta->close();

// Obtener mascotas con raza y especie
$mascotas = [];
$consultaMascotas = $conexion->query("SELECT m.ID_Cliente, m.Nombre AS Nombre_Mascota, m.Fecha_Nacimiento AS Fecha_Mascota, 
  r.Nombre_Raza, e.Nombre_Especie 
  FROM Mascota m 
  INNER JOIN Raza r ON m.ID_Raza = r.ID_Raza 
  INNER JOIN Especie e ON r.ID_Especie = e.ID_Especie");
while ($fila = $consultaMascotas->fetch_assoc()) {
  $mascotas[$fila['ID_Cliente']][] = $fila;
}
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
  <div class="alert alert-info text-center fst-italic" role="alert"><!--Color cambiado a info-->
    <h4>Bienvenido <?= htmlspecialchars($usuario); ?> al Panel de Reporte de Clientes.</h4>
  </div>
  <div class="container mt-4">

    <h2 class="mb-4">Clientes Registrados</h2>

    <?php if ($clientes): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>DNI</th>
              <th>Email</th>
              <th>Teléfono</th>
              <th>Dirección</th>
              <th>Fecha Nacimiento</th>
              <th>Rol</th>
              <th>Nombre Mascota</th>
              <th>Especie</th>
              <th>Raza</th>
              <th>Fecha Nacimiento Mascota</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($clientes as $cliente): ?>
              <?php
                $id = $cliente['ID_Cliente'];
                $mascotasCliente = $mascotas[$id] ?? [null];
                foreach ($mascotasCliente as $mascota):
              ?>
              <tr>
                <td><?= htmlspecialchars($cliente['Nombre']) ?></td>
                <td><?= htmlspecialchars($cliente['Apellido']) ?></td>
                <td><?= htmlspecialchars($cliente['DNI']) ?></td>
                <td><?= htmlspecialchars($cliente['Email']) ?></td>
                <td><?= htmlspecialchars($cliente['Telefono']) ?></td>
                <td><?= htmlspecialchars($cliente['Direccion']) ?></td>
                <td><?= htmlspecialchars($cliente['Fecha_Nacimiento']) ?></td>
                <td><?= htmlspecialchars($cliente['Nombre_Rol']) ?></td>
                <td><?= htmlspecialchars($mascota['Nombre_Mascota'] ?? '-') ?></td>
                <td><?= htmlspecialchars($mascota['Nombre_Especie'] ?? '-') ?></td>
                <td><?= htmlspecialchars($mascota['Nombre_Raza'] ?? '-') ?></td>
                <td><?= htmlspecialchars($mascota['Fecha_Mascota'] ?? '-') ?></td>
              </tr>
              <?php endforeach; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-warning">No hay registros de clientes disponibles.</div>
    <?php endif; ?>
  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>