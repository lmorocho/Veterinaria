<?php 
include('conexion.php');
session_start();

// Obtener especies
$especies_result = $conexion->query("SELECT ID_Especie, Nombre_Especie FROM Especie");
$especies = $especies_result->fetch_all(MYSQLI_ASSOC);

// Obtener razas
$razas_result = $conexion->query("SELECT ID_Raza, Nombre_Raza, ID_Especie, Color FROM Raza");
$razas = $razas_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ingreso de Cliente y Mascotas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <?php
    require("inc/menu.php");
    require("inc/menu_cliente.php");
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


 <!-- <script>
    const razaColorMap = {
      1: 'Dorado',
      2: 'Blanco con negro',
      3: 'Dorado claro',
      4: 'Negro y marrón',
      5: 'Blanco',
      6: 'Blanco',
      7: 'Beige con marrón',
      8: 'Gris atigrado',
      9: 'Moteado marrón y dorado',
      10: 'Blanco con gris'
    };

    function generarMascotas() {
      const cantidad = document.getElementById('cantidadMascotas').value;
      const container = document.getElementById('mascotasContainer');
      container.innerHTML = '';
      for (let i = 1; i <= cantidad; i++) {
        container.innerHTML += `
          <div class="card p-3 mb-3">
            <h5>Mascota ${i}</h5>
            <div class="mb-3">
              <label>Nombre</label>
              <input type="text" name="mascotas[${i}][nombre]" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Fecha de Nacimiento</label>
              <input type="date" name="mascotas[${i}][fecha_nacimiento]" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Tipo de Mascota</label>
              <select name="mascotas[${i}][tipo]" class="form-select" onchange="actualizarRazas(this, ${i})" required>
                <option value="">Seleccione</option>
                <option value="1">1. Perro</option>
                <option value="2">2. Gato</option>
              </select>
            </div>
            <div class="mb-3">
              <label>Tipo de Raza</label>
              <select name="mascotas[${i}][id_raza]" class="form-select raza-select" id="raza-${i}" onchange="actualizarColor(${i})" required>
                <option value="">Seleccione tipo primero</option>
              </select>
            </div>
            <div class="mb-3">
              <label>Color</label>
              <input type="text" name="mascotas[${i}][color]" id="color-${i}" class="form-control" readonly>
            </div>
          </div>`;
      }
    }

    function actualizarRazas(selectTipo, index) {
      const razaSelect = document.getElementById(`raza-${index}`);
      const tipo = selectTipo.value;
      let opcionesRaza = '';

      if (tipo === '1') {
        opcionesRaza = `
          <option value="1">Labrador Retriever</option>
          <option value="2">Bulldog Francés</option>
          <option value="3">Golden Retriever</option>
          <option value="4">Pastor Alemán</option>
          <option value="5">Poodle</option>`;
      } else if (tipo === '2') {
        opcionesRaza = `
          <option value="6">Persa</option>
          <option value="7">Siamés</option>
          <option value="8">Maine Coon</option>
          <option value="9">Bengala</option>
          <option value="10">Ragdoll</option>`;
      } else {
        opcionesRaza = '<option value="">Seleccione tipo primero</option>';
      }
      razaSelect.innerHTML = opcionesRaza;
      actualizarColor(index);
    }

    function actualizarColor(index) {
      const razaSelect = document.getElementById(`raza-${index}`);
      const colorInput = document.getElementById(`color-${index}`);
      const idRaza = parseInt(razaSelect.value);
      colorInput.value = razaColorMap[idRaza] || '';
    }
  </script>-->


</head>
<body>
  <?php
    // Incluir menú según tipo de rol
    if (isset($_SESSION['cliente']) && $_SESSION['cliente']['ID_Rol'] == 3) {
      //include('menu_cliente.php');
      menu_cliente();
    } else {
      //include('menu.php');
      menu();
    }
  ?>
  
  <div class="container mt-5">  
    <!--<h2>Alta de Cliente y Mascotas</h2>-->
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    
    <div class="row justify-content-center">
      <div class="col-md-12">
        <h2 class="mb-4">Alta de Cliente y Mascotas</h2>
        <div class="card shadow">
          <div class="card-header bg-dark text-white">Datos Cliente</div>
            <div class="card-body">
              <form action="guardar_cliente.php" method="post">
                <!--<h4>Datos del Cliente</h4>-->
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
                    <!--<option value="">Seleccione</option>-->
                    <!--<option value="1">Administrador</option>
                    <option value="2">Empleado</option>-->
                    <option value="3" selected>Cliente</option>
                    <!--<option value="4">Proveedor</option>-->
                  </select>
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
                    <!--<option value="4">4</option>-->
                  </select>
                </div>
                <div id="mascotas-container"></div>
                <button type="submit" class="btn btn-primary">Guardar Cliente</button>
              </form>
                      
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <script type="application/json" id="especies-data"><?php echo json_encode($especies); ?></script>
    <script type="application/json" id="razas-data"><?php echo json_encode($razas); ?></script>

  </div>
</body>
</html>