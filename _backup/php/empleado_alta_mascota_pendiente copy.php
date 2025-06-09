<?php
    require("inc/auth_empleado.php");
    require("conexion.php");
    require("inc/menu_empleado.php");

    $usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Empleado';

    $clientes = $conexion->query("SELECT ID_Cliente, Nombre, Apellido, Email FROM Cliente")->fetch_all(MYSQLI_ASSOC);
    $especies = $conexion->query("SELECT * FROM Especie")->fetch_all(MYSQLI_ASSOC);
    $razas = $conexion->query("SELECT * FROM Raza")->fetch_all(MYSQLI_ASSOC);
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Alta de Mascotas Pendientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php menu_empleado(); ?>
    <div class="alert alert-info text-center fst-italic mt-0" role="alert">
    <h4>Bienvenido <?= htmlspecialchars($usuario); ?> al Panel de Alta de Mascotas Pendientes.</h4>
    </div>
    <div class="container mt-4">
    <h2 class="text-center mb-4">Asociar Nuevas Mascotas a Cliente</h2>

    <form action="empleado_guardar_mascotas.php" method="post" id="form-mascotas">
        <div class="mb-3">
        <label for="cliente_id" class="form-label">Seleccione Cliente por ID</label>
        <select name="id_cliente" id="cliente_id" class="form-select" onchange="mostrarDatosCliente()" required>
            <option value="">Seleccione...</option>
                <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['ID_Cliente'] ?>"
                        data-nombre="<?= $c['Nombre'] ?>"
                        data-apellido="<?= $c['Apellido'] ?>"
                        data-email="<?= $c['Email'] ?>">
                    <?= $c['ID_Cliente'] ?> - <?= $c['Nombre'] ?> <?= $c['Apellido'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        </div>

        <div id="datos-cliente" class="mb-4" style="display: none;">
        <p><strong>Nombre:</strong> <span id="nombre_cliente"></span></p>
        <p><strong>Apellido:</strong> <span id="apellido_cliente"></span></p>
        <p><strong>Email:</strong> <span id="email_cliente"></span></p>
        <p><strong>Tiene Mascotas:</strong> <span id="mascotas_cliente"></span></p>
        </div>

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
        <a href="empleado_dashboard.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
    </div>

    <script>
    const especies = <?= json_encode($especies) ?>;
    const razas = <?= json_encode($razas) ?>;

    function mostrarDatosCliente() {
        const select = document.getElementById('cliente_id');
        const option = select.options[select.selectedIndex];
        document.getElementById('nombre_cliente').textContent = option.getAttribute('data-nombre');
        document.getElementById('apellido_cliente').textContent = option.getAttribute('data-apellido');
        document.getElementById('email_cliente').textContent = option.getAttribute('data-email');
        document.getElementById('datos-cliente').style.display = 'block';

        const idCliente = select.value;
        fetch("empleado_verificar_mascota.php?cliente_id=" + idCliente)
            .then(res => res.text())
            .then(data => {
                document.getElementById("mascotas_cliente").innerText = data == '1'
                ? "Tiene mascotas registradas"
                : "No tiene mascotas registradas";
            });
    }

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