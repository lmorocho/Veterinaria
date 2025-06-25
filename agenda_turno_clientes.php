<?php
// agenda_turno_clientes.php
require('inc/auth_admin.php');
require('conexion.php');
require('inc/menu_admin.php');

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';

$sql = "
SELECT
  t.ID_Turno,
  t.Fecha,
  t.Hora,
  m.Nombre AS Nombre_Mascota,
  e.Nombre_Especie,
  r.Nombre_Raza,
  tt.Nombre_Tipo_Turno AS Nombre_Tipo_Turno,
  c.ID_Cliente,
  CONCAT(c.Nombre, ' ', c.Apellido) AS Nombre_Cliente
FROM Turno t
  JOIN Mascota m ON t.ID_Mascota = m.ID_Mascota
  JOIN Raza r ON m.ID_Raza = r.ID_Raza
  JOIN Especie e ON r.ID_Especie = e.ID_Especie
  JOIN tipo_turno tt ON t.ID_Tipo_Turno = tt.ID_Tipo_Turno
  JOIN Cliente c ON m.ID_Cliente = c.ID_Cliente
ORDER BY t.Fecha DESC, t.Hora ASC, t.ID_turno
";
$result = $conexion->query($sql);
$turnos = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

$filtrosEspecie = [];
$filtrosTipos = [];
$filtrosClientes = [];
foreach ($turnos as $t) {
    $filtrosEspecie[] = $t['Nombre_Especie'];
    $filtrosTipos[] = $t['Nombre_Tipo_Turno'];
    $filtrosClientes[] = $t['Nombre_Cliente'];
}
$filtrosEspecie = array_unique($filtrosEspecie);
$filtrosTipos = array_unique($filtrosTipos);
$filtrosClientes = array_unique($filtrosClientes);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agenda de Turnos - <?= htmlspecialchars($usuario) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @media print { .no-print { display: none; } }
  </style>
</head>
<body>
  <?php menu_admin(); ?>
  <div class="alert alert-warning text-center fst-italic mt-0 no-print" role="alert">
    <h4>Agenda de Clientes - <?= htmlspecialchars($usuario) ?></h4>
  </div>
  <div class="container mt-5">
    <div class="row mb-3 no-print">
      <div class="col-md-4">
        <label>Tipo de Turno</label>
        <select id="filterTipo" class="form-select">
          <option value="">Todos</option>
          <?php foreach ($filtrosTipos as $tipo): ?>
            <option><?= htmlspecialchars($tipo) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label>Cliente</label>
        <select id="filterCliente" class="form-select">
          <option value="">Todos</option>
          <?php foreach ($filtrosClientes as $cli): ?>
            <option><?= htmlspecialchars($cli) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label>Tipo de Mascota</label>
        <select id="filterEspecie" class="form-select">
          <option value="">Todos</option>
          <?php foreach ($filtrosEspecie as $esp): ?>
            <option><?= htmlspecialchars($esp) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="text-end mb-3 no-print">
      <button onclick="window.print()" class="btn btn-secondary">Imprimir PDF</button>
    </div>

    <?php if (empty($turnos)): ?>
      <div class="alert alert-info">No hay turnos agendados.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table id="turnosTable" class="table table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <th>ID Turno</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Mascota</th>
              <th>Especie</th>
              <th>Raza</th>
              <th>Tipo de Turno</th>
              <th>ID Cliente</th>
              <th>Cliente</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($turnos as $t): ?>
              <tr>
                <td><?= htmlspecialchars($t['ID_Turno']) ?></td>
                <td><?= htmlspecialchars($t['Fecha']) ?></td>
                <td><?= htmlspecialchars(substr($t['Hora'], 0, 5)) ?></td>
                <td><?= htmlspecialchars($t['Nombre_Mascota']) ?></td>
                <td><?= htmlspecialchars($t['Nombre_Especie']) ?></td>
                <td><?= htmlspecialchars($t['Nombre_Raza']) ?></td>
                <td><?= htmlspecialchars($t['Nombre_Tipo_Turno']) ?></td>
                <td><?= htmlspecialchars($t['ID_Cliente']) ?></td>
                <td><?= htmlspecialchars($t['Nombre_Cliente']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function filterTable() {
      const tipo = document.getElementById('filterTipo').value.toLowerCase();
      const cliente = document.getElementById('filterCliente').value.toLowerCase();
      const especie = document.getElementById('filterEspecie').value.toLowerCase();
      document.querySelectorAll('#turnosTable tbody tr').forEach(row => {
        const cells = row.cells;
        const match =
          (!tipo    || cells[6].textContent.toLowerCase() === tipo) &&
          (!cliente || cells[8].textContent.toLowerCase() === cliente) &&
          (!especie || cells[4].textContent.toLowerCase() === especie);
        row.style.display = match ? '' : 'none';
      });
    }
    document.getElementById('filterTipo').addEventListener('change', filterTable);
    document.getElementById('filterCliente').addEventListener('change', filterTable);
    document.getElementById('filterEspecie').addEventListener('change', filterTable);
  </script>
</body>
</html>
