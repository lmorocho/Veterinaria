
<?php
    //Declaramos la función
    function menu_admin(){   
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
        <li class="nav-item"><a class="nav-link" href="cliente_mascota_admin.php">Registro General</a></li>
        <li class="nav-item"><a class="nav-link" href="cliente_mascota_admin_report.php">Reporte de Cliente & Mascotas</a></li>
        <li class="nav-item"><a class="nav-link" href="empleado_dashboard.php">Empleado</a></li>
        <li class="nav-item"><a class="nav-link" href="cliente_dashboard.php">Cliente</a></li>
        <li class="nav-item"><a class="nav-link" href="proveedor_dashboard.php">Proveedor</a></li>
      </ul>
      <?php if (isset($_SESSION['cliente'])): ?>
        <span class="navbar-text text-light me-3">
          Usuario: <?php echo $_SESSION['cliente']['Nombre']; ?>
        </span>
        <a href="logout.php" class="btn btn-outline-light">Cerrar sesión</a>
      <?php else: ?>
        <a href="login_cliente.php" class="btn btn-outline-light">Iniciar Sesión</a>
      <?php endif; ?>

    </div>
  </div>
</nav>

<?php
    }
?>