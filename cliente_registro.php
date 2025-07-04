<?php
require("inc/auth_cliente.php");
require("conexion.php");
require("inc/menu_cliente.php");

$usuario    = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Cliente';
$id_cliente = $_SESSION['usuario']['ID_Cliente'] ?? null;

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

// Mensaje de registro exitoso
$mensaje_modal = $_SESSION['modal_exito'] ?? null;
unset($_SESSION['modal_exito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Mascotas</title>
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
  <?php menu_cliente(); ?>

  <div class="alert alert-secondary text-center fst-italic mt-0" role="alert">
    <h4>Panel Registro de Mascotas - <?= htmlspecialchars($usuario); ?></h4>
  </div>

  <div class="container mt-4">
    <!-- Mostrar mascotas existentes o alerta -->
    <?php if (!empty($mascotas)): ?>
      <h5 class="mb-3">Tus Mascotas Registradas</h5>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Fecha Nacimiento</th>
            <th>Especie</th>
            <th>Raza</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($mascotas as $m): ?>
            <tr>
              <td><?= htmlspecialchars($m['Nombre']); ?></td>
              <td><?= htmlspecialchars($m['Fecha_Nacimiento']); ?></td>
              <td><?= htmlspecialchars($m['Nombre_Especie']); ?></td>
              <td><?= htmlspecialchars($m['Nombre_Raza']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="alert alert-warning" role="alert">
        No tienes mascotas ingresadas.
      </div>
    <?php endif; ?>

    <h2 class="text-center mb-4 mt-5">Registrar Nuevas Mascotas</h2>
    <form action="cliente_guardar_registro.php" method="post">
      <div class="mb-3">
        <label>¿Cuántas mascotas deseas registrar?</label>
        <select name="cantidad_mascotas" id="cantidad_mascotas" class="form-select" onchange="generarCamposMascotas()" required>
          <option value="">Seleccione</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
      </div>
      <div id="mascotas-container" class="mt-3"></div>
      <div class="text-end">
        <button type="submit" class="btn btn-primary">Guardar Mascotas</button>
        <a href="cliente_dashboard.php" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>

  <!-- Modal de éxito -->
  <?php if ($mensaje_modal): ?>
    <div class="modal fade show" id="modalExito" tabindex="-1" style="display:block;" aria-modal="true" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title">Registro Exitoso</h5>
            <button type="button" class="btn-close" onclick="cerrarModal()"></button>
          </div>
          <div class="modal-body">
            <?= htmlspecialchars($mensaje_modal); ?>
          </div>
          <div class="modal-footer">
            <a href="cliente_registro.php" class="btn btn-primary">Aceptar</a>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show"></div>
  <?php endif; ?>

  <script>
    const especies = <?= json_encode($especies) ?>;
    const razas    = <?= json_encode($razas) ?>;

    function generarCamposMascotas() {
      const cantidad = document.getElementById('cantidad_mascotas').value;
      const cont = document.getElementById('mascotas-container');
      cont.innerHTML = '';
      for (let i = 0; i < cantidad; i++) {
        let espOpts = '<option value="">Seleccione especie</option>';
        especies.forEach(e => espOpts += `<option value="${e.ID_Especie}">${e.Nombre_Especie}</option>`);
        const div = document.createElement('div');
        div.className = 'mb-3 p-3 border rounded';
        div.innerHTML = `
          <h5>Mascota #${i+1}</h5>
          <label>Nombre</label>
          <input type="text" name="mascotas[${i}][nombre]" class="form-control" required>
          <label>Fecha Nacimiento</label>
          <input type="date" name="mascotas[${i}][fecha_nacimiento]" class="form-control" required>
          <label>Especie</label>
          <select name="mascotas[${i}][especie]" id="especie_${i}" class="form-select" onchange="filtrarRazas(${i})" required>
            ${espOpts}
          </select>
          <label>Raza</label>
          <select name="mascotas[${i}][id_raza]" id="raza_${i}" class="form-select" disabled required></select>
        `;
        cont.appendChild(div);
      }
    }

    function filtrarRazas(i) {
      const esp = document.getElementById('especie_' + i).value;
      const sel = document.getElementById('raza_' + i);
      sel.innerHTML = '';
      razas.forEach(r => {
        if (r.ID_Especie == esp) {
          sel.innerHTML += `<option value="${r.ID_Raza}">${r.Nombre_Raza} - ${r.Color}</option>`;
        }
      });
      sel.disabled = sel.options.length === 0;
    }

    function cerrarModal() {
      document.getElementById('modalExito').style.display = 'none';
      document.querySelector('.modal-backdrop').remove();
    }
  </script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
