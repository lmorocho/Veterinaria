<?php
    require("inc/auth_cliente.php");
    require("conexion.php");
    require("inc/menu_cliente.php");

    $usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Cliente';
    $id_cliente = $_SESSION['usuario']['ID_Cliente'] ?? null;

    $especies = $conexion->query("SELECT * FROM Especie")->fetch_all(MYSQLI_ASSOC);
    $razas = $conexion->query("SELECT * FROM Raza")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Mascotas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php menu_cliente(); ?>
  <div class="alert alert-secondary text-center fst-italic mt-0" role="alert">
    <h4>Bienvenido <?= htmlspecialchars($usuario); ?> al Panel de Registro de Mascotas.</h4>
  </div>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Registrar Nueva Mascota</h2>

    <form action="cliente_guardar_registro.php" method="post">
      <input type="hidden" name="id_cliente" value="<?= $id_cliente ?>">

      <div class="mb-3">
        <label>¿Cuántas mascotas desea registrar?</label>
        <select name="cantidad_mascotas" id="cantidad_mascotas" class="form-select" onchange="generarCamposMascotas()" required>
          <option value="">Seleccione</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
      </div>

      <div id="mascotas-container" class="mt-4"></div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">Guardar Mascota(s)</button>
        <a href="cliente_dashboard.php" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>

  <script>
    const especies = <?= json_encode($especies); ?>;
    const razas = <?= json_encode($razas); ?>;

    function generarCamposMascotas() {
      const cantidad = document.getElementById('cantidad_mascotas').value;
      const contenedor = document.getElementById('mascotas-container');
      contenedor.innerHTML = '';
      for (let i = 0; i < cantidad; i++) {
        const div = document.createElement('div');
        div.className = 'mb-3 p-3 border rounded';
        let especieOptions = '<option value="">Seleccione especie</option>';
        especies.forEach(e => especieOptions += `<option value="${e.ID_Especie}">${e.Nombre_Especie}</option>`);

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
  </script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
