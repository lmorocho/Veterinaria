<?php
// admin_turnos.php
require("inc/auth_admin.php");
require("conexion.php");
require("inc/menu_admin.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';

// Offset de semanas via GET para navegación (semana actual = 0)
$offsetWeeks = intval($_GET['offset'] ?? 0);
// Calcular inicio de la semana ajustado por offset
$inicioSemana = strtotime("{$offsetWeeks} weeks monday this week");
// Generar arrays de días
$weekDays = [];
$dayKeys  = ['lunes','martes','miercoles','jueves','viernes'];
$daysNames= ['Lunes','Martes','Miércoles','Jueves','Viernes'];
for ($i = 0; $i < 5; $i++) {
    $ts = $inicioSemana + 86400 * $i;
    $weekDays[] = [
        'dayKey'  => $dayKeys[$i],
        'name'    => $daysNames[$i],
        'date'    => date('d/m', $ts),
        'dateISO' => date('Y-m-d', $ts)
    ];
}

// Consultas base
$clientes = $conexion->query("SELECT ID_Cliente, Nombre, Apellido FROM Cliente")->fetch_all(MYSQLI_ASSOC);
$tipos    = $conexion->query("SELECT ID_Tipo_Turno, Nombre_Tipo_Turno FROM tipo_turno")->fetch_all(MYSQLI_ASSOC);
$turnosExistentes = $conexion->query("SELECT Fecha, Hora, ID_Tipo_Turno FROM Turno")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Turnos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    th, td { vertical-align: middle !important; }
    .fw-bold { font-weight: bold; }
  </style>
</head>
<body>
  <?php menu_admin(); ?>
  <div class="alert alert-warning text-center fst-italic mt-0" role="alert">
      <h4>Gestión de Turnos de Mascotas - <?= htmlspecialchars($usuario) ?></h4>
    </div>
  <div class="container mt-4">
    <!-- Navegación de semanas -->
    <div class="d-flex justify-content-between align-items-center mb-3 no-print">
      <button id="prevWeek" class="btn btn-outline-primary">&laquo; Semana previa</button>
      <span class="fw-bold">Semana de <?= htmlspecialchars($weekDays[0]['dateISO']) ?> a <?= htmlspecialchars(end($weekDays)['dateISO']) ?></span>
      <button id="nextWeek" class="btn btn-outline-primary">Semana siguiente &raquo;</button>
    </div>
    <!-- Selección de tipo de turno -->
    <div class="mb-3 no-print">
      <label for="tipoTurno" class="form-label fw-bold">Tipo de Turno</label>
      <select id="tipoTurno" class="form-select w-50">
        <option value="">Seleccione tipo</option>
        <?php foreach ($tipos as $t): ?>
          <option value="<?= $t['ID_Tipo_Turno'] ?>"><?= htmlspecialchars($t['Nombre_Tipo_Turno']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <!-- Calendario semanal -->
    <div class="table-responsive">
      <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th class="fw-bold">Hora</th>
            <?php foreach ($weekDays as $wd): ?>
              <th class="fw-bold"><?= htmlspecialchars($wd['name']) ?><br><small><?= htmlspecialchars($wd['date']) ?></small></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php for ($hour = 9; $hour <= 17; $hour++): ?>
            <tr>
              <td class="fw-bold"><?= sprintf('%02d:00 - %02d:00', $hour, $hour+1) ?></td>
              <?php foreach ($dayKeys as $day): ?>
                <td class="td-slot" data-day="<?= $day ?>" data-hour="<?= $hour ?>">&nbsp;</td>
              <?php endforeach; ?>
            </tr>
          <?php endfor; ?>
        </tbody>
      </table>
    </div>

    <!-- Modales omitidos para brevedad, iguales a versiones previas -->
    <!-- modalTurno, modalAlerta, modalExito -->
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const offset = <?= $offsetWeeks ?>;
    document.getElementById('prevWeek').onclick = () => location.search = '?offset=' + (offset - 1);
    document.getElementById('nextWeek').onclick = () => location.search = '?offset=' + (offset + 1);

    const existingTurnos = <?= json_encode($turnosExistentes) ?>;
    const weekDays = <?= json_encode($weekDays) ?>;
    const slots = document.querySelectorAll('.td-slot');
    const tipoSelect = document.getElementById('tipoTurno');

    function marcarSlots() {
      slots.forEach(cell => cell.textContent = '');
      const tipoId = tipoSelect.value;
      existingTurnos.forEach(t => {
        if (tipoId && t.ID_Tipo_Turno != tipoId) return;
        const wd = weekDays.find(w => w.dateISO === t.Fecha);
        if (!wd) return;
        const horaVal = parseInt(t.Hora.split(':')[0], 10);
        const cell = document.querySelector(`.td-slot[data-day="${wd.dayKey}"][data-hour="${horaVal}"]`);
        if (cell) cell.textContent = '✔️';
      });
    }
    tipoSelect.addEventListener('change', marcarSlots);
    marcarSlots();

    // Validación y modalTurno similar a versión anterior, omitido por brevedad
  </script>
</body>
</html>
