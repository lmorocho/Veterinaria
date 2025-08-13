<?php
  //admin_report.php
  require("inc/auth_admin.php");
  require("conexion.php");
  require("inc/menu_admin.php");

  $usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';

  // Roles disponibles
  $roles_rs = $conexion->query("SELECT ID_Rol, Nombre_Rol FROM Rol_Usuario");
  $roles = $roles_rs ? $roles_rs->fetch_all(MYSQLI_ASSOC) : [];

  // Filtros
  $filtroRol = isset($_GET['rol']) ? intval($_GET['rol']) : 0; // 0 = sin selección
  $apellido  = isset($_GET['apellido']) ? trim($_GET['apellido']) : '';
  $dniFiltro = isset($_GET['dni']) ? trim($_GET['dni']) : '';
  $partial   = isset($_GET['partial']) && $_GET['partial'] == '1';

  // Mostrar filtro DNI sólo para roles que tienen columna DNI (1=Admin,2=Empleado,3=Cliente)
  $tieneDNI = in_array($filtroRol, [1,2,3], true);

  $query = '';
  $params = [];
  $types  = '';

  if ($filtroRol === 1 || $filtroRol === 2) {
    // Administrador/Empleado (tabla Empleado según ID_Rol)
    $query = "SELECT 
                e.ID_Empleado AS ID,
                e.Nombre,
                e.Apellido,
                e.Email,
                e.DNI,
                u.Nombre_Usuario,
                r.Nombre_Rol,
                COALESCE((
                  SELECT COUNT(*)
                  FROM Mascota m
                  INNER JOIN Cliente c2 ON c2.ID_Cliente = m.ID_Cliente
                  WHERE c2.ID_Usuario = u.ID_Usuario
                ), 0) AS Total_Mascotas
              FROM Empleado e
              INNER JOIN Usuario u ON e.ID_Usuario = u.ID_Usuario
              INNER JOIN Rol_Usuario r ON u.ID_Rol = r.ID_Rol
              WHERE u.ID_Rol = ?";
    $params[] = $filtroRol; $types .= 'i';

    if ($apellido !== '') { $query .= ' AND e.Apellido LIKE ?'; $params[] = "%$apellido%"; $types .= 's'; }
    if ($tieneDNI && $dniFiltro !== '') {
      if (preg_match('/^\d+$/', $dniFiltro)) { $query .= ' AND e.DNI = ?'; $params[] = $dniFiltro; }
      else { $query .= ' AND e.DNI LIKE ?'; $params[] = "%$dniFiltro%"; }
      $types .= 's';
    }
    $query .= ' ORDER BY e.Apellido, e.Nombre';
  }
  elseif ($filtroRol === 3) {
    // Cliente con conteo de mascotas
    $query = "SELECT 
                c.ID_Cliente AS ID,
                c.Nombre,
                c.Apellido,
                c.Email,
                c.DNI,
                u.Nombre_Usuario,
                COALESCE(COUNT(m.ID_Mascota),0) AS Total_Mascotas
              FROM Cliente c
              INNER JOIN Usuario u ON c.ID_Usuario = u.ID_Usuario
              LEFT JOIN Mascota m ON m.ID_Cliente = c.ID_Cliente
              WHERE 1=1";
    if ($apellido !== '') { $query .= ' AND c.Apellido LIKE ?'; $params[] = "%$apellido%"; $types .= 's'; }
    if ($tieneDNI && $dniFiltro !== '') {
      if (preg_match('/^\d+$/', $dniFiltro)) { $query .= ' AND c.DNI = ?'; $params[] = $dniFiltro; }
      else { $query .= ' AND c.DNI LIKE ?'; $params[] = "%$dniFiltro%"; }
      $types .= 's';
    }
    $query .= " GROUP BY c.ID_Cliente, c.Nombre, c.Apellido, c.Email, c.DNI, u.Nombre_Usuario
                ORDER BY c.Apellido, c.Nombre";
  }
  elseif ($filtroRol === 4) {
    // Proveedor (no asumimos DNI; filtramos por Apellido/Empresa/Nombre)
    $query = "SELECT 
                p.ID_Proveedor AS ID,
                p.Nombre,
                p.Apellido,
                p.Email,
                u.Nombre_Usuario,
                r.Nombre_Rol
              FROM Proveedor p
              INNER JOIN Usuario u ON p.ID_Usuario = u.ID_Usuario
              INNER JOIN Rol_Usuario r ON u.ID_Rol = r.ID_Rol
              WHERE u.ID_Rol = 4";
    if ($apellido !== '') {
      // Tolerante a esquemas: busca en Apellido, Empresa (si existe) y Nombre
      $query .= ' AND (p.Apellido LIKE ? OR p.Nombre LIKE ? OR ';
      $query .= 'IFNULL(p.Empresa, "") LIKE ?)';
      $like = "%$apellido%";
      $params[] = $like; $types .= 's';
      $params[] = $like; $types .= 's';
      $params[] = $like; $types .= 's';
    }
    $query .= ' ORDER BY p.Apellido, p.Nombre';
  }

  $resultado = null;
  if ($query !== '') {
    $stmt = $conexion->prepare($query);
    if ($stmt) {
      if (!empty($params)) { $stmt->bind_param($types, ...$params); }
      $stmt->execute();
      $resultado = $stmt->get_result();
    }
  }

  function renderResultados($resultado, $filtroRol) {
    if ($resultado && $resultado->num_rows > 0) {
      echo '<div class="table-responsive">';
      echo '<table class="table table-bordered table-striped align-middle">';
      echo '<thead class="table-dark"><tr>';
      $first = $resultado->fetch_assoc();
      foreach (array_keys($first) as $col) { echo '<th>'.htmlspecialchars($col).'</th>'; }
      // volver al inicio para iterar filas
      $resultado->data_seek(0);
      echo '</tr></thead><tbody>';
      while ($fila = $resultado->fetch_assoc()) {
        echo '<tr>';
        foreach ($fila as $val) {
          echo '<td>'.htmlspecialchars((string)$val).'</td>';
        }
        echo '</tr>';
      }
      echo '</tbody></table></div>';
    } elseif ($filtroRol > 0) {
      echo '<div class="alert alert-warning">No hay datos para los filtros seleccionados.</div>';
    }
  }

  // Si es solicitud parcial (AJAX), devolver solo la tabla/alert y salir
  if ($partial) {
    renderResultados($resultado, $filtroRol);
    exit;
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reporte por Rol</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script>function imprimirReporte() { window.print(); }</script>
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
  <?php menu_admin(); ?>
  <div class="alert alert-warning text-center fst-italic" role="alert">
    <h4>Reporte de General de Usuarios - <?= htmlspecialchars($usuario) ?></h4>
  </div>
  <div class="container mt-4">
    
    <div class="mb-3">
      <a href="#" onclick="imprimirReporte()" class="btn btn-outline-secondary">🖨️ Imprimir / Exportar PDF</a>
    </div>

    <!-- Selección de Rol -->
    <form id="filtrosForm" method="get" class="row g-3 mb-3">
      <div class="col-md-4">
        <label class="form-label">Rol</label>
        <select name="rol" id="rol" class="form-select">
          <option value="0" selected disabled>Seleccione un rol</option>
          <option value="1" <?= $filtroRol===1?'selected':'' ?>>Administrador</option>
          <option value="2" <?= $filtroRol===2?'selected':'' ?>>Empleado</option>
          <option value="3" <?= $filtroRol===3?'selected':'' ?>>Cliente</option>
          <option value="4" <?= $filtroRol===4?'selected':'' ?>>Proveedor</option>
        </select>
      </div>

      <?php if ($filtroRol > 0): ?>
        <!-- Filtros genéricos que aparecen según el rol -->
        <div class="col-md-4">
          <label class="form-label">Apellido</label>
          <input type="text" name="apellido" id="apellido" value="<?= htmlspecialchars($apellido) ?>" class="form-control" placeholder="Filtrar por apellido (min. 2 letras)">
        </div>
        <?php if ($tieneDNI): ?>
        <div class="col-md-4">
          <label class="form-label">DNI</label>
          <input type="text" name="dni" id="dni" value="<?= htmlspecialchars($dniFiltro) ?>" class="form-control" inputmode="numeric" pattern="\d*" placeholder="Filtrar por DNI completo">
        </div>
        <?php endif; ?>
      <?php endif; ?>
    </form>

    <div id="results">
      <?php renderResultados($resultado, $filtroRol); ?>
    </div>
  </div>

  <script>
    (function(){
      const form     = document.getElementById('filtrosForm');
      const rolSel   = document.getElementById('rol');
      const apellido = document.getElementById('apellido');
      const dni      = document.getElementById('dni');
      const results  = document.getElementById('results');
      let timer;

      function buildQuery() {
        const params = new URLSearchParams();
        const rol = rolSel ? rolSel.value : '0';
        params.set('rol', rol || '0');
        if (apellido && apellido.value.trim() !== '') params.set('apellido', apellido.value.trim());
        if (dni && dni.value.trim() !== '') params.set('dni', dni.value.trim());
        params.set('partial','1');
        return params.toString();
      }

      function fetchResults() {
        const qs = buildQuery();
        if (!qs.includes('rol=') || (rolSel && (rolSel.value === '0' || rolSel.value === ''))) {
          results.innerHTML = '';
          return;
        }
        const url = 'admin_report.php?' + qs;
        results.setAttribute('aria-busy','true');
        fetch(url, { headers: { 'X-Requested-With':'XMLHttpRequest' }})
          .then(r => r.text())
          .then(html => { results.innerHTML = html; })
          .catch(() => { results.innerHTML = '<div class="alert alert-danger">Error cargando resultados.</div>'; })
          .finally(() => { results.removeAttribute('aria-busy'); });
      }

      function debounceFetch(){
        clearTimeout(timer);
        timer = setTimeout(fetchResults, 300);
      }

      // Cambiar rol recarga filtros visibles y resultados
      if (rolSel) {
        rolSel.addEventListener('change', () => {
          const v = rolSel.value || '0';
          const url = new URL(window.location.href);
          url.searchParams.set('rol', v);
          url.searchParams.delete('apellido');
          url.searchParams.delete('dni');
          window.location.href = url.toString();
        });
      }

      // Búsqueda dinámica en keypress/keyup/input
      if (apellido) {
        apellido.addEventListener('input', debounceFetch);
        apellido.addEventListener('keyup', debounceFetch);
      }
      if (dni) {
        dni.addEventListener('input', debounceFetch);
        dni.addEventListener('keyup', debounceFetch);
      }
    })();
  </script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>