<?php
// admin_report_backup.php
require("inc/auth_admin.php");
require("conexion.php");
require("inc/menu_admin.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';

// Filtros
$filtroEspecie = $_GET['especie'] ?? '';
$filtroRaza    = $_GET['raza']    ?? '';
$where = [];
if ($filtroEspecie !== '') {
    $where[] = "bm.ID_Especie = " . intval($filtroEspecie);
}
if ($filtroRaza !== '') {
    $where[] = "bm.ID_Raza = " . intval($filtroRaza);
}
$whereSQL = $where ? "WHERE " . implode(" AND ", $where) : '';

// Consulta principal
$query = "
SELECT
  bu.Tipo_Perfil,
  bu.ID_Original,
  bu.ID_Usuario,
  bu.Nombre         AS NombreCliente,
  bu.Apellido,
  bu.DNI,
  bu.Fecha_Nacimiento AS FechaCliente,
  bu.Email,
  bu.Telefono,
  bu.Direccion,
  bu.Nombre_Usuario,
  bu.ID_Rol,
  bm.ID_Mascota,
  bm.Nombre_Mascota,
  bm.Fecha_Nacimiento AS FechaMascota,
  r.Nombre_Raza,
  e.Nombre_Especie
FROM backup_usuarios bu
LEFT JOIN backup_mascotas bm ON bu.ID_Original = bm.ID_Cliente
LEFT JOIN Raza r       ON bm.ID_Raza    = r.ID_Raza
LEFT JOIN Especie e    ON bm.ID_Especie = e.ID_Especie
{$whereSQL}
ORDER BY bu.Tipo_Perfil, bu.ID_Original, bm.ID_Mascota";
$resultado = $conexion->query($query);

// Obtener opciones de filtro de las tablas reales
$especies = $conexion->query("SELECT ID_Especie, Nombre_Especie FROM Especie")->fetch_all(MYSQLI_ASSOC);
$razas    = $conexion->query("SELECT ID_Raza, Nombre_Raza FROM Raza")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reporte Backup de Usuarios y Mascotas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>function imprimirReporte(){ window.print(); }</script>
  <style>
    body { background-image: url('img/paws_background.png'); background-repeat: repeat; background-attachment: fixed; }
    body::before { content:""; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(255,255,255,0.5); pointer-events:none; z-index:-1; }
  </style>
</head>
<body>
  <?php menu_admin(); ?>
  <div class="alert alert-warning text-center fst-italic" role="alert">
    <h4>Reporte Backup - <?= htmlspecialchars($usuario) ?></h4>
  </div>
  <div class="container-fluid mt-4">
    <div class="mb-3">
      <button onclick="imprimirReporte()" class="btn btn-outline-secondary">🖨️ Imprimir / Exportar PDF</button>
    </div>
    <form method="get" class="row g-3 mb-4">
      <div class="col-md-4">
        <label class="form-label">Especie</label>
        <select name="especie" class="form-select">
          <option value="">Todas</option>
          <?php foreach($especies as $e): ?>
            <option value="<?= $e['ID_Especie'] ?>" <?= $filtroEspecie==$e['ID_Especie']?'selected':''?>>
              <?= htmlspecialchars($e['Nombre_Especie']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Raza</label>
        <select name="raza" class="form-select">
          <option value="">Todas</option>
          <?php foreach($razas as $r): ?>
            <option value="<?= $r['ID_Raza'] ?>" <?= $filtroRaza==$r['ID_Raza']?'selected':''?>>
              <?= htmlspecialchars($r['Nombre_Raza']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4 align-self-end">
        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
      </div>
    </form>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>Perfil</th><th>ID_Original</th><th>ID_Usuario</th><th>Cliente</th><th>Apellido</th><th>DNI</th>
            <th>Fec. Nac. Cliente</th><th>Email</th><th>Teléfono</th><th>Dirección</th>
            <th>Usuario</th><th>ID_Rol</th><th>ID_Mascota</th><th>Mascota</th><th>Fec. Nac. Masc.</th>
            <th>Raza</th><th>Especie</th>
          </tr>
        </thead>
        <tbody>
          <?php while($fila = $resultado->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($fila['Tipo_Perfil']) ?></td>
            <td><?= $fila['ID_Original'] ?></td>
            <td><?= $fila['ID_Usuario'] ?></td>
            <td><?= htmlspecialchars($fila['NombreCliente']) ?></td>
            <td><?= htmlspecialchars($fila['Apellido']) ?></td>
            <td><?= htmlspecialchars($fila['DNI']) ?></td>
            <td><?= htmlspecialchars($fila['FechaCliente']) ?></td>
            <td><?= htmlspecialchars($fila['Email']) ?></td>
            <td><?= htmlspecialchars($fila['Telefono']) ?></td>
            <td><?= htmlspecialchars($fila['Direccion']) ?></td>
            <td><?= htmlspecialchars($fila['Nombre_Usuario']) ?></td>
            <td><?= $fila['ID_Rol'] ?></td>
            <td><?= $fila['ID_Mascota'] ?></td>
            <td><?= htmlspecialchars($fila['Nombre_Mascota']) ?></td>
            <td><?= htmlspecialchars($fila['FechaMascota']) ?></td>
            <td><?= htmlspecialchars($fila['Nombre_Raza']) ?></td>
            <td><?= htmlspecialchars($fila['Nombre_Especie']) ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
