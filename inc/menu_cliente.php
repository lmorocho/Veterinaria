<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

function menu_cliente() {
  $usuario = $_SESSION['usuario']['Nombre'] ?? 'Invitado';
  ?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="cliente_dashboard.php">
        <img src="img/Log_PetHOUSE.png" alt="Logo" width="34" height="32" class="d-inline-block align-text-top">
        <b>Veterinaria</b>
      </a>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="cliente_dashboard.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="cliente_mascota.php">Registrar Mascotas</a></li>
          <li class="nav-item"><a class="nav-link" href="cliente_mascota_report.php">Mis Mascotas</a></li>
        </ul>

        <ul class="navbar-nav ms-auto">
          <li class="nav-item text-light nav-link">
            Usuario: <strong><?= htmlspecialchars($usuario) ?></strong>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-light ms-2" href="logout.php">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <?php
}
?>
