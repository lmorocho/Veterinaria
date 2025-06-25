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
      <!--<button id="prevWeek" class="btn btn-outline-primary">&laquo; Semana previa</button>-->
      <button id="prevWeek" class="btn btn-warning">&laquo; Semana previa</button>
      <span class="fw-bold">Semana de <?= htmlspecialchars($weekDays[0]['dateISO']) ?> a <?= htmlspecialchars(end($weekDays)['dateISO']) ?></span>
      <!--<button id="nextWeek" class="btn btn-outline-primary">Semana siguiente &raquo;</button>--->
      <button id="nextWeek" class="btn btn-warning">Semana siguiente &raquo;</button>
    </div>
    <!-- Selección de tipo de turno -->
    <div class="mb-3 no-print">
      <label for="tipoTurno" class="form-label fw-bold">Tipo de Turno</label>
      <select id="tipoTurno" class="form-select w-50">
        <option value="">Seleccione el tipo</option>
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

    <!-- Modal para crear turno -->
    <div class="modal fade" id="modalTurno" tabindex="-1" aria-labelledby="modalTurnoLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title" id="modalTurnoLabel">Asignar Turno</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <form id="formTurno">
              <input type="hidden" id="turnoDia" name="dia">
              <input type="hidden" id="turnoHora" name="hora">
              <input type="hidden" id="turnoTipoId" name="tipo_id">
              <div class="mb-3">
                <label for="inputCliente" class="form-label">Cliente</label>
                <select id="inputCliente" name="cliente" class="form-select" required>
                  <option value="">Seleccione cliente</option>
                  <?php foreach($clientes as $c): ?>
                    <option value="<?= $c['ID_Cliente'] ?>"><?= htmlspecialchars($c['Nombre'].' '.$c['Apellido']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="inputMascota" class="form-label">Mascota</label>
                <select id="inputMascota" name="mascota" class="form-select" required>
                  <option value="">Seleccione mascota</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="inputTipo" class="form-label">Tipo de Turno</label>
                <input type="text" id="inputTipo" class="form-control" readonly>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" id="btnGuardarTurno" class="btn btn-primary">Guardar Turno</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal de alerta Seleccione un tipo de turno -->
    <div class="modal fade" id="modalAlertaTipo" tabindex="-1" aria-labelledby="modalAlertaTipoLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning text-white">
            <h5 class="modal-title" id="modalAlertaTipoLabel">Tipo de Turno</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <p>Seleccione primero un tipo de turno.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Entendido</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de alerta de turno ocupado -->
    <div class="modal fade" id="modalAlerta" tabindex="-1" aria-labelledby="modalAlertaLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="modalAlertaLabel">Turno Ocupado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <p>El turno seleccionado ya está ocupado.</p>
            <p>Por favor, elija otro horario.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Entendido</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de éxito con detalles -->
    <div class="modal fade" id="modalExito" tabindex="-1" aria-labelledby="modalExitoLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="modalExitoLabel">Turno Asignado Correctamente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <p id="detalleExito"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const offset = <?= $offsetWeeks ?>;
    document.getElementById('prevWeek').onclick = () => location.search = '?offset=' + (offset - 1);
    document.getElementById('nextWeek').onclick = () => location.search = '?offset=' + (offset + 1);
  
    document.addEventListener('DOMContentLoaded', () => {
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

      slots.forEach(cell => {
          cell.addEventListener('click', () => {
            if (!tipoSelect.value) {
              /*alert('Seleccione primero el tipo de turno.');*/
              const modal = new bootstrap.Modal(document.getElementById('modalAlertaTipo'));
              modal.show();
              return;
            }
            if (cell.textContent.trim() === '✔️') {
              const modal = new bootstrap.Modal(document.getElementById('modalAlerta'));
              modal.show();
              return;
            }

            const diaKey = cell.dataset.day;
            const horaVal = cell.dataset.hour;
            const tipoId = tipoSelect.value;
            const tipoLabel = tipoSelect.selectedOptions[0].text;

            document.getElementById('turnoDia').value = diaKey;
            document.getElementById('turnoHora').value = horaVal;
            document.getElementById('turnoTipoId').value = tipoId;
            document.getElementById('inputTipo').value = tipoLabel;
            document.getElementById('inputCliente').value = '';
            document.getElementById('inputMascota').innerHTML = '<option value="">Seleccione mascota</option>';

            new bootstrap.Modal(document.getElementById('modalTurno')).show();
          });
        });

        // Cargar mascotas según cliente
        document.getElementById('inputCliente').addEventListener('change', function() {
          const clienteId = this.value;
          const selectMasc = document.getElementById('inputMascota');
          selectMasc.innerHTML = '<option value="">Cargando...</option>';
          fetch(`get_mascotas.php?cliente=${clienteId}`)
            .then(res => res.json())
            .then(data => {
              selectMasc.innerHTML = '<option value="">Seleccione mascota</option>';
              data.forEach(m => {
                const opt = document.createElement('option'); opt.value = m.ID_Mascota; opt.textContent = m.Nombre_Mascota;
                selectMasc.appendChild(opt);
              });
            })
            .catch(err => { console.error('Error al cargar mascotas:', err); selectMasc.innerHTML = '<option value="">Error cargando</option>'; });
        });

        document.getElementById('btnGuardarTurno').addEventListener('click', () => {
          const formElem = document.getElementById('formTurno');
          const data = new FormData(formElem);
          fetch('guardar_turno.php', { method:'POST', body: data })
            .then(res => res.json())
            .then(resp => {
              if (resp.success) {
                const diaKey = data.get('dia'); const horaStr = data.get('hora');
                const tipoNombre = document.getElementById('inputTipo').value;
                const clienteNombre = document.getElementById('inputCliente').selectedOptions[0].text;
                const mascotaNombre = document.getElementById('inputMascota').selectedOptions[0].text;
                const diaNombre = weekDays.find(w => w.dayKey === diaKey)?.name ?? diaKey;
                document.getElementById('detalleExito').innerHTML = `
                  <strong>Cliente:</strong> ${clienteNombre}<br>
                  <strong>Mascota:</strong> ${mascotaNombre}<br>
                  <strong>Día:</strong> ${diaNombre}<br>
                  <strong>Hora:</strong> ${horaStr}:00<br>
                  <strong>Tipo:</strong> ${tipoNombre}`;
                const wdNew = weekDays.find(w => w.dayKey === diaKey);
                existingTurnos.push({ Fecha: wdNew.dateISO, Hora: `${horaStr}:00`, ID_Tipo_Turno: parseInt(data.get('tipo_id'),10) });
                marcarSlots();
                bootstrap.Modal.getInstance(document.getElementById('modalTurno')).hide();
                new bootstrap.Modal(document.getElementById('modalExito')).show();
              } else {
                alert('Error: ' + resp.message);
              }
            })
            .catch(err => alert('Solicitud fallida: ' + err));
        });
    });
  </script>
</body>
</html>
