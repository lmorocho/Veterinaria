<?php
session_start();
include('conexion.php');

// Verificar sesión y rol de cliente
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Cliente') {
  header("Location: login_cliente.php");
  exit;
}

$usuario = $_SESSION['usuario']['Nombre'] ?? 'Invitado';
$id_cliente = $_SESSION['usuario']['ID_Cliente'] ?? null;

// Filtros
$filtroEspecie = $_GET['especie'] ?? '';
$filtroRaza = $_GET['raza'] ?? '';

$where = ["m.ID_Cliente = " . intval($id_cliente)];
if ($filtroEspecie !== '') {
  $where[] = "e.ID_Especie = " . intval($filtroEspecie);
}
if ($filtroRaza !== '') {
  $where[] = "r.ID_Raza = " . intval($filtroRaza);
}
$whereSQL = "WHERE " . implode(" AND ", $where);

$query = "
SELECT 
  m.ID_Mascota, m.Nombre AS NombreMascota, m.Fecha_Nacimiento AS FechaMascota,
  r.Nombre_Raza, r.Color,
  e.Nombre_Especie
FROM Mascota m
JOIN Raza r ON m.ID_Raza = r.ID_Raza
JOIN Especie e ON r.ID_Especie = e.ID_Especie
$whereSQL
ORDER BY m.ID_Mascota";

$resultado = $conexion->query($query);

// Obtener especies y razas para los filtros
$especies = $conexion->query("SELECT ID_Especie, Nombre_Especie FROM Especie")->fetch_all(MYSQLI_ASSOC);
$razas = $conexion->query("SELECT ID_Raza, Nombre_Raza FROM Raza")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Mascotas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php require("inc/menu_cliente.php"); ?>
  <script>function imprimirReporte() { window.print(); }</script>
</head>
<body>
<?php menu_cliente(); ?>
<div class="alert alert-warning text-center fst-italic" role="alert">
  <h4>Mis Mascotas - <?= htmlspecialchars($usuario) ?></h4>
</div>

<!--<div class="container-fluid mt-5">-->
<div class="container mt-5">
  <div class="mb-3">
    <a href="#" onclick="imprimirReporte()" class="btn btn-outline-secondary">🖨️ Imprimir / Exportar PDF</a>
  </div>

  <form method="get" class="row g-3 mb-4">
    <div class="col-md-4">
      <label class="form-label">Especie</label>
      <select name="especie" class="form-select">
        <option value="">Todas</option>
        <?php foreach ($especies as $e): ?>
          <option value="<?= $e['ID_Especie'] ?>" <?= $filtroEspecie == $e['ID_Especie'] ? 'selected' : '' ?>>
            <?= $e['Nombre_Especie'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Raza</label>
      <select name="raza" class="form-select">
        <option value="">Todas</option>
        <?php foreach ($razas as $r): ?>
          <option value="<?= $r['ID_Raza'] ?>" <?= $filtroRaza == $r['ID_Raza'] ? 'selected' : '' ?>>
            <?= $r['Nombre_Raza'] ?>
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
        <th>ID Mascota</th><th>Nombre</th><th>Fecha Nac.</th><th>Raza</th><th>Color</th><th>Especie</th>
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
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
