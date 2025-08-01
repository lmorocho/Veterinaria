<?php
function menu_admin() {
  //verificar si la sesión está iniciada y el usuario es administrador
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['ID_Rol'] != 1) {
    header("Location: login_cliente.php");
    exit;
  }

  $nombreUsuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="img/Log_PetHOUSE.png" alt="Logo" width="34" height="32" class="d-inline-block align-text-top">
      <b>Veterinaria</b>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_registro.php">Registro General</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_report.php">Reporte Cliente & Mascotas</a></li>
        <!--<li class="nav-item"><a class="nav-link" href="empleado_dashboard.php">Empleado</a></li>
        <li class="nav-item"><a class="nav-link" href="cliente_dashboard.php">Cliente</a></li>
        <li class="nav-item"><a class="nav-link" href="proveedor_dashboard.php">Proveedor</a></li>-->
      </ul>

      <span class="navbar-text text-light me-3">
        Usuario: <strong><?= htmlspecialchars($nombreUsuario) ?></strong>
      </span>
      <a href="logout.php" class="btn btn-outline-light">Cerrar sesión</a>
    </div>
  </div>
</nav>
<?php
}
?>
