<?php
// admin_registro_mascotas.php
require("inc/auth_admin.php");
require("conexion.php");
require("inc/menu_admin.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';

// Listado de clientes para selección
$clientes = $conexion->query("SELECT ID_Cliente, Nombre, Apellido FROM Cliente")->fetch_all(MYSQLI_ASSOC);

// Obtener client seleccionado (vía GET)
$id_cliente = intval($_GET['cliente'] ?? 0);

// Obtener especies y razas
$especies = $conexion->query("SELECT ID_Especie, Nombre_Especie FROM Especie")->fetch_all(MYSQLI_ASSOC);
$razas    = $conexion->query("SELECT ID_Raza, ID_Especie, Nombre_Raza, Color FROM Raza")->fetch_all(MYSQLI_ASSOC);

// Mascotas existentes del cliente
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

// Mensaje de éxito tras guardar
$mensaje_modal = $_SESSION['modal_exito'] ?? null;
unset($_SESSION['modal_exito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Mascotas (Admin)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
  <style>
    body { background-image: url('img/paws_background.png'); background-repeat: repeat; background-attachment: fixed; }
    body::before { content: ""; position: fixed; top:0; left:0; width:100vw; height:100vh; background: rgba(255,255,255,0.5); pointer-events:none; z-index:-1; }
  </style>
</head>
<body>
  <?php menu_admin(); ?>
  <div class="alert alert-warning text-center fst-italic" role="alert">
      <h4>Registro de Mascotas (Admin) - <?= htmlspecialchars($usuario) ?></h4>
    </div>
  <div class="container mt-4">

    <!-- Selección de cliente -->
    <div class="mb-4">
      <label for="selectCliente" class="form-label fw-bold">Seleccione Cliente</label>
      <select id="selectCliente" class="form-select w-50">
        <option value="">-- Elija Cliente --</option>
        <?php foreach($clientes as $c): ?>
          <option value="<?= $c['ID_Cliente'] ?>" <?= $id_cliente== $c['ID_Cliente']?'selected':'' ?>>
            <?= htmlspecialchars($c['Nombre'].' '.$c['Apellido']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <?php if ($id_cliente): ?>
      <!-- Mostrar mascotas actuales -->
      <?php if(!empty($mascotas)): ?>
        <h5 class="mb-3">Mascotas Registradas del Cliente</h5>
        <table class="table table-striped">
          <thead>
            <tr><th>Nombre</th><th>Fecha Nac.</th><th>Especie</th><th>Raza</th></tr>
          </thead>
          <tbody>
            <?php foreach($mascotas as $m): ?>
              <tr>
                <td><?= htmlspecialchars($m['Nombre']) ?></td>
                <td><?= htmlspecialchars($m['Fecha_Nacimiento']) ?></td>
                <td><?= htmlspecialchars($m['Nombre_Especie']) ?></td>
                <td><?= htmlspecialchars($m['Nombre_Raza']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <div class="alert alert-warning">Este cliente aún no tiene mascotas registradas.</div>
      <?php endif; ?>

      <!-- Formulario para nuevas mascotas -->
      <h5 class="mt-4 mb-3">Registrar Nuevas Mascotas</h5>
      <form action="admin_guardar_registro_mascota.php" method="post">
        <input type="hidden" name="id_cliente" value="<?= $id_cliente ?>">
        <div class="mb-3">
          <label class="form-label">¿Cuántas mascotas?</label>
          <select name="cantidad" id="cantidad" class="form-select w-25" onchange="generarCampos()" required>
            <option value="">Seleccione</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </div>
        <div id="container" class="mb-4"></div>
        <button type="submit" class="btn btn-primary">Guardar Mascotas</button>
      </form>
    <?php endif; ?>

    <!-- Modal de éxito -->
    <?php if ($mensaje_modal): ?>
      <div class="modal fade show" id="modalExito" tabindex="-1" style="display:block;" aria-modal="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-success text-white">
              <h5 class="modal-title">Éxito</h5>
              <button type="button" class="btn-close" onclick="cerrarModal()"></button>
            </div>
            <div class="modal-body"><?= htmlspecialchars($mensaje_modal) ?></div>
            <div class="modal-footer">
              <button class="btn btn-success" onclick="cerrarModal()">Aceptar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-backdrop fade show"></div>
    <?php endif; ?>

  </div>
  <script>
    const especies = <?= json_encode($especies) ?>;
    const razas    = <?= json_encode($razas) ?>;
    document.getElementById('selectCliente').onchange = function(){
      const id = this.value;
      window.location.href = id ? `?cliente=${id}` : 'admin_registro_mascota.php';
    };

    function generarCampos(){
      const cont = document.getElementById('container');
      const n = parseInt(document.getElementById('cantidad').value,10);
      cont.innerHTML = '';
      for(let i=0;i<n;i++){
        let html = `<div class="p-3 mb-3 border rounded">
          <h6>Mascota #${i+1}</h6>
          <label>Nombre</label>
          <input type="text" name="mascotas[${i}][nombre]" class="form-control" required>
          <label>Fecha Nacimiento</label>
          <input type="date" name="mascotas[${i}][fecha]" class="form-control" required>
          <label>Especie</label>
          <select name="mascotas[${i}][especie]" class="form-select" onchange="filtrar(${i})" required>
            <option value="">Seleccione especie</option>
            ${especies.map(e=>`<option value="${e.ID_Especie}">${e.Nombre_Especie}</option>`).join('')}
          </select>
          <label>Raza</label>
          <select name="mascotas[${i}][raza]" id="raza_${i}" class="form-select" disabled required></select>
        </div>`;
        cont.insertAdjacentHTML('beforeend',html);
      }
    }
    function filtrar(i){
      const idEsp = document.getElementsByName(`mascotas[${i}][especie]`)[0].value;
      const sel   = document.getElementById(`raza_${i}`);
      sel.innerHTML='';
      razas.forEach(r=>{
        if(r.ID_Especie==idEsp) sel.insertAdjacentHTML('beforeend',`<option value="${r.ID_Raza}">${r.Nombre_Raza} (${r.Color})</option>`);
      });
      sel.disabled = sel.options.length===0;
    }
    function cerrarModal(){
      document.getElementById('modalExito').style.display='none';
      document.querySelector('.modal-backdrop').remove();
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
