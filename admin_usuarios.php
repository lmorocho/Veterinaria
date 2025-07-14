<?php
// admin_usuarios.php
require("inc/auth_admin.php");
require("conexion.php");
require("inc/menu_admin.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';

// Obtener roles disponibles (Version Anterior)
//$roles = $conexion->query("SELECT ID_Rol, Nombre_Rol FROM Rol_Usuario")->fetch_all(MYSQLI_ASSOC);

// Consulta de roles para el select, excluyendo Proveedor (ID_Rol = 4) (Version Nueva)
$roles_result = $conexion->query("SELECT ID_Rol, Nombre_Rol FROM Rol_Usuario WHERE ID_Rol <> 4");
$roles = $roles_result->fetch_all(MYSQLI_ASSOC);

// Rol filtrado y datos iniciales
$filtroRol = $_GET['rol'] ?? '';
$datos = [];

if ($filtroRol !== '') {
    $idRol = intval($filtroRol);
    // Preparar consulta según rol
    switch ($idRol) {
        case 1: case 2:
            $sql = "SELECT e.ID_Empleado AS id, e.Nombre, e.Apellido, e.Email, r.Nombre_Rol, 0 AS Total_Mascotas"
            . " FROM Empleado e"
            . " INNER JOIN Usuario u ON e.ID_Usuario = u.ID_Usuario"
            . " INNER JOIN Rol_Usuario r ON u.ID_Rol = r.ID_Rol"
            . " WHERE u.ID_Rol = ?";
            break;
        case 3:
            $sql = "SELECT c.ID_Cliente AS id, c.Nombre, c.Apellido, c.Email, r.Nombre_Rol,"
            . " COUNT(m.ID_Mascota) AS Total_Mascotas"
            . " FROM Cliente c"
            . " INNER JOIN Usuario u ON c.ID_Usuario = u.ID_Usuario"
            . " INNER JOIN Rol_Usuario r ON u.ID_Rol = r.ID_Rol"
            . " LEFT JOIN Mascota m ON m.ID_Cliente = c.ID_Cliente"
            . " WHERE u.ID_Rol = ?"
            . " GROUP BY c.ID_Cliente, c.Nombre, c.Apellido, c.Email, r.Nombre_Rol";
            break;
        /*case 4: (Omitimos Proveedor en esta versión)
            $sql = "SELECT p.ID_Proveedor AS id, p.Nombre AS Nombre, p.Empresa AS Apellido, p.Email, r.Nombre_Rol"
                 . " FROM Proveedor p"
                 . " INNER JOIN Usuario u ON p.ID_Usuario = u.ID_Usuario"
                 . " INNER JOIN Rol_Usuario r ON u.ID_Rol = r.ID_Rol"
                 . " WHERE u.ID_Rol = ?";
            break;*/
        default:
            $sql = null;
    }
    if ($sql) {
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idRol);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $datos[] = $row;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
      <h4>Gestión General de Usuarios - <?= htmlspecialchars($usuario) ?></h4>
    </div>
  <div class="container mt-4">
    <form method="get" class="row g-3 mb-4">
      <div class="col-md-4">
        <label class="form-label"><b>Filtrar por Rol</b></label>
        <select name="rol" class="form-select" onchange="this.form.submit()">
          <option value="">-- Ninguno --</option>
          <?php foreach($roles as $rol): ?>
            <option value="<?= $rol['ID_Rol'] ?>" <?= $filtroRol==$rol['ID_Rol']?'selected':'' ?>>
              <?= htmlspecialchars($rol['Nombre_Rol']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </form>

    <?php if ($filtroRol && $datos): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <?php foreach(array_keys($datos[0]) as $col): ?>
                <th><?= htmlspecialchars($col) ?></th>
              <?php endforeach; ?>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($datos as $fila): ?>
              <tr>
                <?php foreach($fila as $val): ?>
                  <td><?= htmlspecialchars($val) ?></td>
                <?php endforeach; ?>
                <td>
                  <button type="button" class="btn btn-sm btn-primary btn-edit" data-rol="<?= $filtroRol ?>" data-id="<?= $fila['id'] ?>">
                    <i class="bi bi-pencil"></i> Editar
                  </button>
                  <button type="button" class="btn btn-sm btn-danger btn-delete" data-rol="<?= $filtroRol ?>" data-id="<?= $fila['id'] ?>">
                    <i class="bi bi-trash"></i> Eliminar
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- Modales de confirmación -->
      <div class="modal fade" id="modalConfirmEdit" tabindex="-1" aria-labelledby="modalConfirmEditLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-warning text-white">
              <h5 class="modal-title" id="modalConfirmEditLabel">Confirmar Edición</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <p>¿Está seguro que desea editar este registro?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" id="confirmEditBtn" class="btn btn-primary">Editar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modalConfirmDelete" tabindex="-1" aria-labelledby="modalConfirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h5 class="modal-title" id="modalConfirmDeleteLabel">Confirmar Eliminación</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <p>¿Está seguro que desea eliminar este registro?</p>
              <p>Recuerde que eliminará todas las mascotas asociadas a éste usuario!!</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Eliminar</button>
            </div>
          </div>
        </div>
      </div>
    <?php elseif($filtroRol): ?>
      <div class="alert alert-warning">No hay registros para el rol seleccionado.</div>
    <?php endif; ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      let selectedRol, selectedId;
      const editModal = new bootstrap.Modal(document.getElementById('modalConfirmEdit'));
      const deleteModal = new bootstrap.Modal(document.getElementById('modalConfirmDelete'));
      document.querySelectorAll('.btn-edit').forEach(btn => btn.addEventListener('click', () => {
        selectedRol = btn.dataset.rol;
        selectedId  = btn.dataset.id;
        editModal.show();
      }));
      document.getElementById('confirmEditBtn').addEventListener('click', () => {
        window.location.href = `admin_edit_usuarios.php?rol=${selectedRol}&id=${selectedId}`;
      });
      document.querySelectorAll('.btn-delete').forEach(btn => btn.addEventListener('click', () => {
        selectedRol = btn.dataset.rol;
        selectedId  = btn.dataset.id;
        deleteModal.show();
      }));
      document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
        window.location.href = `admin_delete_usuarios.php?rol=${selectedRol}&id=${selectedId}`;
      });
    });
  </script>
</body>
</html>
