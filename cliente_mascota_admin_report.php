<?php
session_start();
include('conexion.php');

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

// Filtros
$filtroEspecie = $_GET['especie'] ?? '';
$filtroRaza = $_GET['raza'] ?? '';
$filtroDNI = $_GET['dni'] ?? '';

$where = [];
if ($filtroEspecie !== '') {
  $where[] = "e.ID_Especie = " . intval($filtroEspecie);
}
if ($filtroRaza !== '') {
  $where[] = "r.ID_Raza = " . intval($filtroRaza);
}
if ($filtroDNI !== '') {
  $where[] = "c.DNI LIKE '%" . $conexion->real_escape_string($filtroDNI) . "%'";
}
$whereSQL = $where ? "WHERE " . implode(" AND ", $where) : '';

$query = "
SELECT 
  c.ID_Cliente, c.Nombre AS NombreCliente, c.Apellido, c.DNI, c.Email, c.Telefono, c.Direccion, c.Fecha_Nacimiento,
  c.ID_Rol, ru.Nombre_Rol,
  (SELECT COUNT(*) FROM Mascota m2 WHERE m2.ID_Cliente = c.ID_Cliente) AS CantidadMascotas,
  m.ID_Mascota, m.Nombre AS NombreMascota, m.Fecha_Nacimiento AS FechaMascota,
  r.ID_Raza, r.Nombre_Raza, r.Color,
  e.ID_Especie, e.Nombre_Especie
FROM Cliente c
LEFT JOIN Rol_Usuario ru ON c.ID_Rol = ru.ID_Rol
LEFT JOIN Mascota m ON c.ID_Cliente = m.ID_Cliente
LEFT JOIN Raza r ON m.ID_Raza = r.ID_Raza
LEFT JOIN Especie e ON r.ID_Especie = e.ID_Especie
$whereSQL
ORDER BY c.ID_Cliente, m.ID_Mascota";

$resultado = $conexion->query($query);

// Obtener especies y razas para filtros
$especies = $conexion->query("SELECT ID_Especie, Nombre_Especie FROM Especie")->fetch_all(MYSQLI_ASSOC);
$razas = $conexion->query("SELECT ID_Raza, Nombre_Raza FROM Raza")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reporte de Clientes y Mascotas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <?php
    require("inc/menu_admin.php");
  ?>

  <script>
    function imprimirReporte() {
        window.print();
      }
  </script>
</head>
<body>
    <?php menu_admin(); ?>
    <div class="alert alert-warning text-center fst-italic" role="alert">
        <h2>Reporte de Clientes y sus Mascotas</h2>
    </div>

    <div class="container-fluid mt-5"> <!--Para que abaque el ancho de la pagina-->
      <div class="mb-3">
        <a href="#" onclick="imprimirReporte()" class="btn btn-outline-secondary">🖨️ Imprimir / Exportar PDF</a>
      </div>
        <form method="get" class="row g-3 mb-4">
            <div class="col-md-3">
              <label class="form-label">Especie</label>
              <select name="especie" class="form-select">
                  <option value="">Todas</option>
                  <?php foreach ($especies as $e): ?>
                  <option value="<?= $e['ID_Especie'] ?>" <?= $filtroEspecie == $e['ID_Especie'] ? 'selected' : '' ?>><?= $e['Nombre_Especie'] ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-3">
            <label class="form-label">Raza</label>
            <select name="raza" class="form-select">
                <option value="">Todas</option>
                <?php foreach ($razas as $r): ?>
                <option value="<?= $r['ID_Raza'] ?>" <?= $filtroRaza == $r['ID_Raza'] ? 'selected' : '' ?>><?= $r['Nombre_Raza'] ?></option>
                <?php endforeach; ?>
            </select>
            </div>
            <div class="col-md-3">
            <label class="form-label">DNI Cliente</label>
            <input type="text" name="dni" value="<?= htmlspecialchars($filtroDNI) ?>" class="form-control">
            </div>
            <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
              <tr>
                  <th>ID Cliente</th><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Email</th><th>Teléfono</th><th>Dirección</th><th>Fecha Nac.</th><th>Tipo de Rol</th><th>Cant. Mascotas</th>
                  <th>ID Mascota</th><th>Nombre Mascota</th><th>Fecha Mascota</th><th>Raza</th><th>Color</th><th>Especie</th>
              </tr>
            </thead>
            <tbody>
              <?php while($fila = $resultado->fetch_assoc()): ?>
                  <tr>
                  <td><?= $fila['ID_Cliente'] ?></td>
                  <td><?= $fila['NombreCliente'] ?></td>
                  <td><?= $fila['Apellido'] ?></td>
                  <td><?= $fila['DNI'] ?></td>
                  <td><?= $fila['Email'] ?></td>
                  <td><?= $fila['Telefono'] ?></td>
                  <td><?= $fila['Direccion'] ?></td>
                  <td><?= $fila['Fecha_Nacimiento'] ?></td>
                  <td><?= $fila['Nombre_Rol'] ?></td>
                  <td><?= $fila['CantidadMascotas'] ?></td>
                  <td><?= $fila['ID_Mascota'] ?></td>
                  <td><?= $fila['NombreMascota'] ?></td>
                  <td><?= $fila['FechaMascota'] ?></td>
                  <td><?= $fila['Nombre_Raza'] ?></td>
                  <td><?= $fila['Color'] ?></td>
                  <td><?= $fila['Nombre_Especie'] ?></td>
                  </tr>
              <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
