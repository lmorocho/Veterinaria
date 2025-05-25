<?php 
session_start();
include('conexion.php');

// Verifica si hay sesión activa
$usuario = $_SESSION['usuario']['Nombre'] ?? 'Invitado';
$rol = $_SESSION['rol'] ?? null;
$id_cliente = $_SESSION['usuario']['ID_Cliente'] ?? null;

// Consultar especies
$especies_result = $conexion->query("SELECT ID_Especie, Nombre_Especie FROM Especie");
$especies = $especies_result ? $especies_result->fetch_all(MYSQLI_ASSOC) : [];

// Consultar razas
$razas_result = $conexion->query("SELECT ID_Raza, Nombre_Raza, ID_Especie, Color FROM Raza");
$razas = $razas_result ? $razas_result->fetch_all(MYSQLI_ASSOC) : [];

// Consultar mascotas si es cliente
$mascotas = [];
if ($rol === 'Cliente' && $id_cliente) {
  $mascotas_query = $conexion->prepare("SELECT m.Nombre, m.Fecha_Nacimiento, r.Nombre_Raza, r.Color, e.Nombre_Especie FROM Mascota m 
    JOIN Raza r ON m.ID_Raza = r.ID_Raza 
    JOIN Especie e ON r.ID_Especie = e.ID_Especie 
    WHERE m.ID_Cliente = ?");
  $mascotas_query->bind_param("i", $id_cliente);
  $mascotas_query->execute();
  $result = $mascotas_query->get_result();
  $mascotas = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ingreso de Cliente y Mascotas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php
    require("inc/menu_cliente.php");
    menu_cliente();
  ?>
  <script>
    function filtrarRazas(index) {
      const especieId = document.getElementById('especie_' + index).value;
      const razas = JSON.parse(document.getElementById('razas-data').textContent);
      const razaSelect = document.getElementById('raza_' + index);
      razaSelect.innerHTML = '';
      razas.forEach(raza => {
        if (raza.ID_Especie == especieId) {
          const opt = document.createElement('option');
          opt.value = raza.ID_Raza;
          opt.textContent = raza.Nombre_Raza + ' - ' + raza.Color;
          razaSelect.appendChild(opt);
        }
      });
      razaSelect.disabled = razaSelect.options.length === 0;
    }

    function generarCamposMascotas() {
      const cantidad = document.getElementById('cantidad_mascotas').value;
      const contenedor = document.getElementById('mascotas-container');
      const especies = JSON.parse(document.getElementById('especies-data').textContent);
      contenedor.innerHTML = '';
      for (let i = 0; i < cantidad; i++) {
        const div = document.createElement('div');
        div.className = 'mb-3 p-3 border rounded';
        let especieOptions = '<option value="">Seleccione especie</option>';
        especies.forEach(esp => {
          especieOptions += `<option value="${esp.ID_Especie}">${esp.Nombre_Especie}</option>`;
        });
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
  </script>
</head>
<body>
  <div class="alert alert-warning text-center fst-italic">
    <h4>Alta de Cliente y Mascotas</h4>
  </div>
  <div class="container mt-5">
    
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <?php if ($rol === 'Cliente'): ?>
      <div class="alert alert-info">
        Ya estás registrado como cliente. Puedes añadir más mascotas.
      </div>
      <?php if (!empty($mascotas)): ?>
        <div class="mb-3">
          <h5>Mascotas registradas:</h5>
          <div class="row">
            <?php foreach ($mascotas as $m): ?>
              <div class="col-md-4">
                <div class="card mb-2">
                  <div class="card-body">
                    <strong><?= htmlspecialchars($m['Nombre']) ?></strong><br>
                    <?= htmlspecialchars($m['Nombre_Especie']) ?> - <?= htmlspecialchars($m['Nombre_Raza']) ?><br>
                    Color: <?= htmlspecialchars($m['Color']) ?><br>
                    Nac.: <?= htmlspecialchars($m['Fecha_Nacimiento']) ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <div class="card shadow">
      <div class="card-header bg-dark text-white">
        <?= $rol === 'Cliente' ? 'Añadir Mascotas' : 'Datos Cliente y Mascotas' ?>
      </div>
      <div class="card-body">
        <form action="guardar_cliente.php" method="post">
          <?php if ($rol !== 'Cliente'): ?>
            <div class="mb-2"><label>Nombre</label><input type="text" name="nombre" class="form-control" required></div>
            <div class="mb-2"><label>Apellido</label><input type="text" name="apellido" class="form-control" required></div>
            <div class="mb-2"><label>DNI</label><input type="text" name="dni" class="form-control" required></div>
            <div class="mb-2"><label>Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="mb-2"><label>Teléfono</label><input type="text" name="telefono" class="form-control"></div>
            <div class="mb-2"><label>Dirección</label><input type="text" name="direccion" class="form-control"></div>
            <div class="mb-2"><label>Fecha Nacimiento</label><input type="date" name="fecha_nacimiento" class="form-control"></div>
            <div class="mb-2"><label>Usuario</label><input type="text" name="usuario" class="form-control" required></div>
            <div class="mb-2"><label>Contraseña</label><input type="password" name="password" class="form-control" required></div>
            <div class="mb-2">
              <label>Tipo de Rol</label>
              <select name="id_rol" class="form-select" required>
                <option value="3" selected>Cliente</option>
              </select>
            </div>
          <?php endif; ?>
          <hr>
          <h5>Datos de Mascotas</h5>
          <div class="mb-2">
            <label>Cantidad de Mascotas</label>
            <select id="cantidad_mascotas" class="form-select" onchange="generarCamposMascotas()">
              <option value="" selected>Seleccione</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>
          <div id="mascotas-container"></div>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>

    <script type="application/json" id="especies-data"><?php echo json_encode($especies); ?></script>
    <script type="application/json" id="razas-data"><?php echo json_encode($razas); ?></script>
  </div>
</body>
</html>
