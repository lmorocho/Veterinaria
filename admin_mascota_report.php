<?php

require("inc/auth_cliente.php");
require("conexion.php");
require("inc/menu_cliente.php");

$usuario    = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Cliente';
$id_cliente = $_SESSION['usuario']['ID_Cliente'] ?? null;

// Verificar sesión y rol de cliente
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Cliente') {
  header("Location: login_cliente.php");
  exit;
}

// Mensaje de registro exitoso
$mensaje_modal = $_SESSION['modal_exito'] ?? null;
unset($_SESSION['modal_exito']);


// Obtener especies y razas
$especies = $conexion->query("SELECT * FROM Especie")->fetch_all(MYSQLI_ASSOC);
$razas    = $conexion->query("SELECT * FROM Raza")->fetch_all(MYSQLI_ASSOC);

// Obtener mascotas del cliente
$mascotas = [];
if ($id_cliente) {
    $stmt = $conexion->prepare(
        "SELECT m.Nombre, m.Fecha_Nacimiento, r.Nombre_Raza, e.Nombre_Especie
         FROM Mascota m
         JOIN Raza r ON m.ID_Raza = r.ID_Raza
         JOIN Especie e ON r.ID_Especie = e.ID_Especie
         WHERE m.ID_Cliente = ?"
    );
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $mascotas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}


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
  <title>Reporte - Mis Mascotas</title>
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
  <?php menu_cliente(); ?>
  <div class="alert alert-secondary text-center fst-italic" role="alert">
    <h4>Reporte de Mis Mascotas - <?= htmlspecialchars($usuario) ?></h4>
  </div>

  <!--<div class="container-fluid mt-5">-->
  <div class="container mt-4">
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
