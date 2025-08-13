<?php
require("inc/auth_admin.php");
require("conexion.php");
require("inc/menu_admin.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';

// Filtros
$filtroEspecie = $_GET['especie'] ?? '';
$filtroRaza    = $_GET['raza']    ?? '';
$where = [];
if ($filtroEspecie !== '') {
    $where[] = "e.ID_Especie = " . intval($filtroEspecie);
}
if ($filtroRaza !== '') {
    $where[] = "r.ID_Raza = " . intval($filtroRaza);
}
$whereSQL = $where ? "WHERE " . implode(" AND ", $where) : '';

// Consulta principal con datos de cliente y usuario
$query = "
SELECT
  m.ID_Mascota,
  m.Nombre AS NombreMascota,
  m.Fecha_Nacimiento AS FechaMascota,
  r.Nombre_Raza,
  r.Color,
  e.Nombre_Especie,
  c.ID_Cliente,
  u.Nombre_Usuario AS Usuario,
  c.Nombre AS NombreCliente
FROM Mascota m
JOIN Raza r     ON m.ID_Raza    = r.ID_Raza
JOIN Especie e  ON r.ID_Especie = e.ID_Especie
JOIN Cliente c  ON m.ID_Cliente = c.ID_Cliente
JOIN Usuario u  ON c.ID_Usuario = u.ID_Usuario
{$whereSQL}
ORDER BY c.ID_Cliente, m.ID_Mascota";
$resultado = $conexion->query($query);

// Obtener opciones de filtro
$especies = $conexion->query("SELECT ID_Especie, Nombre_Especie FROM Especie")->fetch_all(MYSQLI_ASSOC);
$razas    = $conexion->query("SELECT ID_Raza, Nombre_Raza FROM Raza")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reporte de Mascotas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>function imprimirReporte() { window.print(); }</script>
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
    <h4>Reporte de Mascotas - <?= htmlspecialchars($usuario) ?></h4>
  </div>

  <div class="container mt-4">
    <div class="mb-3">
      <button onclick="imprimirReporte()" class="btn btn-outline-secondary">🖨️ Imprimir / Exportar PDF</button>
    </div>
    <form method="get" class="row g-3 mb-4">
      <div class="col-md-4">
        <label class="form-label">Especie</label>
        <select name="especie" class="form-select">
          <option value="">Todas</option>
          <?php foreach ($especies as $e): ?>
            <option value="<?= $e['ID_Especie'] ?>" <?= $filtroEspecie == $e['ID_Especie'] ? 'selected' : ''?>>
              <?= htmlspecialchars($e['Nombre_Especie']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Raza</label>
        <select name="raza" class="form-select">
          <option value="">Todas</option>
          <?php foreach ($razas as $r): ?>
            <option value="<?= $r['ID_Raza'] ?>" <?= $filtroRaza == $r['ID_Raza'] ? 'selected' : ''?>>
              <?= htmlspecialchars($r['Nombre_Raza']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4 align-self-end">
        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
      </div>
    </form>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID Mascota</th>
          <th>Nombre Mascota</th>
          <th>Fecha Nac.</th>
          <th>Raza</th>
          <th>Color</th>
          <th>Especie</th>
          <th>ID Cliente</th>
          <th>Usuario</th>
          <th>Nombre Cliente</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?= $fila['ID_Mascota'] ?></td>
          <td><?= htmlspecialchars($fila['NombreMascota']) ?></td>
          <td><?= htmlspecialchars($fila['FechaMascota']) ?></td>
          <td><?= htmlspecialchars($fila['Nombre_Raza']) ?></td>
          <td><?= htmlspecialchars($fila['Color']) ?></td>
          <td><?= htmlspecialchars($fila['Nombre_Especie']) ?></td>
          <td><?= $fila['ID_Cliente'] ?></td>
          <td><?= htmlspecialchars($fila['Usuario']) ?></td>
          <td><?= htmlspecialchars($fila['NombreCliente']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
