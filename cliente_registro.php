<?php
require("inc/auth_cliente.php");
require("conexion.php");
require("inc/menu_cliente.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Cliente';
$id_cliente = $_SESSION['usuario']['ID_Cliente'] ?? null;

$especies = $conexion->query("SELECT * FROM Especie")->fetch_all(MYSQLI_ASSOC);
$razas = $conexion->query("SELECT * FROM Raza")->fetch_all(MYSQLI_ASSOC);

$mensaje_modal = $_SESSION['modal_exito'] ?? null;
unset($_SESSION['modal_exito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Mascotas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php menu_cliente(); ?>
  <div class="alert alert-secondary text-center fst-italic mt-0" role="alert">
    <h4>Bienvenido <?= htmlspecialchars($usuario); ?> al Panel de Registro de Mascotas.</h4>
  </div>

  <div class="container mt-4">
    <h2 class="text-center mb-4">Registrar Mascotas</h2>
    <form action="cliente_guardar_registro.php" method="post">
      <div class="mb-3">
        <label>¿Cuántas mascotas desea registrar?</label>
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

  <!-- Modal estático Bootstrap -->
  <?php if ($mensaje_modal): ?>
  <div class="modal fade show" id="modalExito" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
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
    const razas = <?= json_encode($razas) ?>;

    function generarCamposMascotas() {
      const cantidad = document.getElementById('cantidad_mascotas').value;
      const contenedor = document.getElementById('mascotas-container');
      contenedor.innerHTML = '';
      for (let i = 0; i < cantidad; i++) {
        let especieOptions = '<option value="">Seleccione especie</option>';
        especies.forEach(e => especieOptions += `<option value="${e.ID_Especie}">${e.Nombre_Especie}</option>`);

        const div = document.createElement('div');
        div.className = 'mb-3 p-3 border rounded';
        div.innerHTML = `
          <h5>Mascota #${i + 1}</h5>
          <label>Nombre</label>
          <input type="text" name="mascotas[${i}][nombre]" class="form-control" required>
          <label>Fecha Nacimiento</label>
          <input type="date" name="mascotas[${i}][fecha_nacimiento]" class="form-control" required>
          <label>Especie</label>
          <select name="mascotas[${i}][especie]" id="especie_${i}" class="form-select" onchange="filtrarRazas(${i})" required>
            ${especieOptions}
          </select>
          <label>Raza</label>
          <select name="mascotas[${i}][id_raza]" id="raza_${i}" class="form-select" disabled required></select>
        `;
        contenedor.appendChild(div);
      }
    }

    function filtrarRazas(index) {
      const especieId = document.getElementById('especie_' + index).value;
      const razaSelect = document.getElementById('raza_' + index);
      razaSelect.innerHTML = '';
      razas.forEach(r => {
        if (r.ID_Especie == especieId) {
          const opt = document.createElement('option');
          opt.value = r.ID_Raza;
          opt.textContent = r.Nombre_Raza + ' - ' + r.Color;
          razaSelect.appendChild(opt);
        }
      });
      razaSelect.disabled = razaSelect.options.length === 0;
    }

    function cerrarModal() {
      const modal = document.getElementById('modalExito');
      modal.style.display = 'none';
      document.querySelector('.modal-backdrop').remove();
    }
  </script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
