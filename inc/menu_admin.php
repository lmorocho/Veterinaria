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
        <!--<li class="nav-item"><a class="nav-link" href="admin_registro.php">Registro General</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_report.php">Reporte Cliente & Mascotas</a></li>-->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="registroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gestion de Usuarios
          </a>
          <!--<ul class="dropdown-menu" aria-labelledby="registroDropdown">-->
          <ul class="dropdown-menu dropdown-menu-dark bg-dark" aria-labelledby="registroDropdown">
            <li><a class="dropdown-item" href="admin_registro.php">Altas y Registros Usuarios</a></li>
            <li><a class="dropdown-item" href="admin_usuarios.php">Edición o Borrado de Usuarios</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="admin_proveedor_registro.php">Altas de Proveedores</a></li>
            <li><a class="dropdown-item" href="admin_proveedor_registro.php">Edición o Borrado de Proveedores</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="registroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gestión Mascotas
          </a>
          <!--<ul class="dropdown-menu" aria-labelledby="registroDropdown">-->
          <ul class="dropdown-menu dropdown-menu-dark bg-dark" aria-labelledby="registroDropdown">
            <li><a class="dropdown-item" href="admin_registro_mascota.php">Altas de Mascotas</a></li>
            <!--<li><a class="dropdown-item" href="admin_usuarios.php">Edición o Borrado de Usuarios</a></li>-->
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="registroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gestión Reportes
          </a>
          <!--<ul class="dropdown-menu" aria-labelledby="registroDropdown">-->
          <ul class="dropdown-menu dropdown-menu-dark bg-dark" aria-labelledby="registroDropdown">
            <li><a class="dropdown-item" href="admin_report.php">Reporte Usuarios</a></li>
            <li><a class="dropdown-item" href="admin_report_mascotas.php">Reporte Mascotas</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="admin_report_backup.php">Reporte Backup de Usuario & Mascotas</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="registroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gestión de Turnos
          </a>
          <!--<ul class="dropdown-menu" aria-labelledby="registroDropdown">-->
          <ul class="dropdown-menu dropdown-menu-dark bg-dark" aria-labelledby="registroDropdown">
            <li><a class="dropdown-item" href="admin_turnos.php">Alta Turnos</a></li>
            <li><a class="dropdown-item" href="agenda_turno_clientes.php">Cancelación Turnos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agenda_turno_clientes.php">Agenda de Turnos</a></li>
          </ul>
        </li>
        <!--<li class="nav-item"><a class="nav-link" href="empleado_dashboard.php">Empleado</a></li>
        <li class="nav-item"><a class="nav-link" href="cliente_dashboard.php">Cliente</a></li>
        <li class="nav-item"><a class="nav-link" href="proveedor_dashboard.php">Proveedor</a></li>-->
        <!--<li class="nav-item"><a class="nav-link" href="admin_turnos.php">Gestión de Turnos</a></li>
        <li class="nav-item"><a class="nav-link" href="agenda_turno_clientes.php">Agenda</a></li>-->
        <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Historial Médico</a></li>
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
