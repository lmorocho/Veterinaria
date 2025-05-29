<?php
session_start();
include('conexion.php');

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Invitado';
$rol = $_SESSION['rol'] ?? null;

// Consultar especies y razas
$especies = $conexion->query("SELECT ID_Especie, Nombre_Especie FROM Especie")->fetch_all(MYSQLI_ASSOC);
$razas = $conexion->query("SELECT ID_Raza, Nombre_Raza, ID_Especie, Color FROM Raza")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro Usuario y Mascotas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php require("inc/menu.php"); ?>
</head>
<body>
<?php menu(); ?>
<div class="container mt-5">
  <h2 class="mb-4 text-center">Registro de Usuario</h2>
  <form action="guardar_cliente.php" method="post">
    <div class="row">
      <div class="col-md-6">
        <div class="mb-2"><label>Nombre</label><input type="text" name="nombre" class="form-control" required></div>
        <div class="mb-2"><label>Apellido</label><input type="text" name="apellido" class="form-control" required></div>
        <div class="mb-2"><label>DNI</label><input type="text" name="dni" class="form-control" required></div>
        <div class="mb-2"><label>Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-2"><label>Teléfono</label><input type="text" name="telefono" class="form-control"></div>
        <div class="mb-2"><label>Dirección</label><input type="text" name="direccion" class="form-control"></div>
        <div class="mb-2"><label>Fecha Nacimiento</label><input type="date" name="fecha_nacimiento" class="form-control"></div>
      </div>
      <div class="col-md-6">
        <div class="mb-2"><label>Nombre de Usuario</label><input type="text" name="usuario" class="form-control" required></div>
        <div class="mb-2"><label>Contraseña</label><input type="password" name="password" class="form-control" required></div>
        <div class="mb-2">
          <label>Tipo de Rol</label>
          <select name="id_rol" class="form-select" required>
            <option value="3" selected>Cliente</option>
            <option value="2">Empleado</option>
            <option value="4">Proveedor</option>
          </select>
        </div>
      </div>
    </div>

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
    <a href="<?php echo isset($_SESSION['usuario']) ? strtolower($_SESSION['rol']) . '_dashboard.php' : 'index.php'; ?>" class="btn btn-danger ms-2">Salir</a>
  </form>

  <script>
    function generarCamposMascotas() {
      const cantidad = document.getElementById('cantidad_mascotas').value;
      const contenedor = document.getElementById('mascotas-container');
      const especies = <?php echo json_encode($especies); ?>;
      const razas = <?php echo json_encode($razas); ?>;

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
      const razas = <?php echo json_encode($razas); ?>;
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
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
