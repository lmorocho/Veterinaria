<?php
// menu.php
//define('ROOT', __DIR__ . '/../../');
function menu_invitado(){
    // Asume que session_start() ya fue llamado antes
    // Nombre de usuario y rol, si existen
    $nombreUsuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Invitado';
    $tieneSesion   = isset($_SESSION['usuario']);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="img/Log_PetHOUSE.png" alt="Logo" width="34" height="32" class="d-inline-block align-text-top">
      <b>Veterinaria</b>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
      </ul>
      <div class="d-flex align-items-center">
        <?php if (!$tieneSesion): ?>
          <!-- Estado Invitado -->
          <span class="navbar-text text-light me-3">
            Usuario: <strong><?= htmlspecialchars($nombreUsuario) ?></strong>
          </span>
        <?php else: ?>
          <!-- Usuario autenticado -->
          <span class="navbar-text text-light me-3">
            Usuario: <strong><?= htmlspecialchars($nombreUsuario) ?></strong>
          </span>
          <a href="logout.php" class="btn btn-outline-warning">Cerrar sesión</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<?php
}
?>
