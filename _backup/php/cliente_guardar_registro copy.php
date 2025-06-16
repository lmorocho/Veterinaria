<?php
    session_start(); 
    include("conexion.php");

    // Validar sesión del cliente
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['ID_Rol'] != 3) {
    header("Location: login_cliente.php");
    exit;
    }

    $id_cliente = $_SESSION['usuario']['ID_Cliente'] ?? null;
    if (!$id_cliente) {
    echo "<div class='alert alert-danger'>No se pudo identificar al cliente en sesión.</div>";
    exit;
    }

    $modal_html = "";
    $mostrar_modal = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad_mascotas = intval($_POST['cantidad_mascotas'] ?? 0);

    if ($cantidad_mascotas <= 0 || empty($_POST['mascotas']) || !is_array($_POST['mascotas'])) {
        $modal_html = "<div class='alert alert-danger'>Datos de mascotas inválidos.</div>";
        $mostrar_modal = true;
    } else {
        $errores = [];
        foreach ($_POST['mascotas'] as $index => $mascota) {
        $nombre_mascota = $mascota['nombre'] ?? '';
        $fecha_nac_mascota = $mascota['fecha_nacimiento'] ?? '';
        $id_raza = $mascota['id_raza'] ?? '';

        if (!$nombre_mascota || !$fecha_nac_mascota || !$id_raza) {
            $errores[] = "Mascota #" . ($index + 1) . " tiene datos incompletos.";
            continue;
        }

        $stmtMascota = $conexion->prepare("INSERT INTO Mascota (ID_Cliente, Nombre, Fecha_Nacimiento, ID_Raza) VALUES (?, ?, ?, ?)");
        $stmtMascota->bind_param("issi", $id_cliente, $nombre_mascota, $fecha_nac_mascota, $id_raza);
        $stmtMascota->execute();
        }

        $mostrar_modal = true;
        if (empty($errores)) {
        $modal_html = "<div class='alert alert-success text-center'>Mascotas registradas correctamente.</div>";
        } else {
        $modal_html = "<div class='alert alert-warning'><strong>Algunas mascotas no se registraron:</strong><br>" . implode("<br>", $errores) . "</div>";
        }
    }
    } else {
    header("Location: cliente_registro.php");
    exit;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Mascotas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <?php if ($mostrar_modal): ?>
    <div class="modal fade show" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-modal="true" role="dialog" style="display: block;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Resultado del Registro</h1>
          </div>
          <div class="modal-body">
            <?= $modal_html ?>
          </div>
          <div class="modal-footer">
            <a href="cliente_registro.php" class="btn btn-primary">Volver</a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
