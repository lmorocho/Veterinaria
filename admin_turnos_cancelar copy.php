<?php
// admin_turnos_cancelar.php
require("inc/auth_admin.php");
require("conexion.php");
require("inc/menu_admin.php");

// Solo Admin (1) o Empleado (2)
$idRol = $_SESSION['usuario']['ID_Rol'] ?? null;
if (!in_array($idRol, [1, 2])) {
    header('Location: login_admin.php');
    exit;
}

// Obtener lista de clientes con turnos asignados
$clientes = $conexion->query(
    "SELECT DISTINCT c.ID_Cliente,
        CONCAT(c.Nombre, ' ', c.Apellido) AS ClienteNombre
     FROM Turno t
     JOIN Mascota m ON t.ID_Mascota = m.ID_Mascota
     JOIN Cliente c ON m.ID_Cliente = c.ID_Cliente"
)->fetch_all(MYSQLI_ASSOC);

// Capturar selección de cliente
$idCliente = intval(
  isset($_GET['cliente']) ? $_GET['cliente'] : 0
);

// Procesar cancelación de turno via POST (desde modal)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelar_turno'])) {
  $idTurno = intval($_POST['cancelar_turno']);
  $stmtDel = $conexion->prepare("DELETE FROM Turno WHERE ID_Turno = ?");
  $stmtDel->bind_param("i", $idTurno);
  $stmtDel->execute();
  $stmtDel->close();
  // Redirigir conservando el cliente seleccionado
  header('Location: admin_turnos_cancelar.php?cliente=' . $idCliente);
  exit;
}

// Si se seleccionó un cliente obtendremos sus turnos
$turnos = [];
if ($idCliente) {
    $stmt = $conexion->prepare(
        "SELECT t.ID_Turno,
                c.ID_Cliente,
                t.ID_Mascota,
                t.Fecha,
                t.Hora,
                tt.Nombre_Tipo_Turno AS Tipo,
                m.Nombre AS Mascota
         FROM Turno t
         JOIN tipo_turno tt ON t.ID_Tipo_Turno = tt.ID_Tipo_Turno
         JOIN Mascota m ON t.ID_Mascota = m.ID_Mascota
         JOIN Cliente c ON m.ID_Cliente = c.ID_Cliente
         WHERE c.ID_Cliente = ?
         ORDER BY t.Fecha ASC, t.Hora DESC"
    );
    $stmt->bind_param("i", $idCliente);
    $stmt->execute();
    $turnos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cancelar Turnos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
  <div class="alert alert-warning text-center fst-italic mt-0" role="alert">
    <h4>Cancelar Turnos de Mascotas</h4>
  </div>
  <div class="container mt-4">
    <form method="get" class="mb-4">
      <label for="selectCliente" class="form-label">Seleccione Cliente</label>
      <select name="cliente" id="selectCliente" class="form-select w-50" onchange="this.form.submit()">
        <option value="">-- Elija cliente --</option>
        <?php foreach ($clientes as $c): ?>
          <option value="<?= $c['ID_Cliente'] ?>" <?= $c['ID_Cliente'] === $idCliente ? 'selected' : '' ?> >
            <?= htmlspecialchars($c['ClienteNombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>

    <?php if ($idCliente): ?>
      <?php if ($turnos): ?>
        <table class="table table-bordered">
          <thead class="table-dark">
            <tr>
              <th>ID Turno</th>
              <th>ID Cliente</th>
              <th>ID Mascota</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Tipo de Turno</th>
              <th>Mascota</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($turnos as $t): ?>
              <tr>
                <td><?= $t['ID_Turno'] ?></td>
                <td><?= $t['ID_Cliente'] ?></td>
                <td><?= $t['ID_Mascota'] ?></td>
                <td><?= htmlspecialchars($t['Fecha']) ?></td>
                <td><?= htmlspecialchars($t['Hora']) ?></td>
                <td><?= htmlspecialchars($t['Tipo']) ?></td>
                <td><?= htmlspecialchars($t['Mascota']) ?></td>
                <td>
                  <button class="btn btn-sm btn-danger btn-cancel" 
                          data-turno="<?= $t['ID_Turno'] ?>">
                    Cancelar Turno
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <div class="alert alert-info">No hay turnos asignados para este cliente.</div>
      <?php endif; ?>
    <?php endif; ?>
  </div>

   <!-- Modal Confirmación de Cancelación -->
   <div class="modal fade" id="modalConfirmCancel" tabindex="-1" aria-labelledby="modalConfirmCancelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="modalConfirmCancelLabel">Confirmar Cancelación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p>¿Está seguro que desea cancelar este turno?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <form method="post" id="formCancelTurno">
            <input type="hidden" name="cancelar_turno" id="cancelarTurnoId">
            <button type="submit" class="btn btn-danger">Sí, cancelar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const modal = new bootstrap.Modal(document.getElementById('modalConfirmCancel'));
      document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', () => {
          const id = btn.getAttribute('data-turno');
          document.getElementById('cancelarTurnoId').value = id;
          modal.show();
        });
      });
    });
  </script>
</body>
</html>