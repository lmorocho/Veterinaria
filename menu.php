<?php
  function menu(){
?>
<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-body">
      <!-- Primer DIV -->
      <div class="container-fluid">
        <a class="navbar-brand" href="http://www.arufe.com.ar/">Autor</a>
        <button class= "navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button> 
    <!-- Segundo DIV -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="formulario_destino.php">Formulario</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="bdd.php">ABM</a>
      </li>
      <li class= "nav-item dropdown">
        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Opciones
        </a>
      <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="#">Sub-opción A</a><li>
      <li><a class="dropdown-item" href="#">Sub-opción B</a><li>
      <li><hr class="dropdown-divider"><li>
      <li><a class="dropdown-item" href="#">Sub-opción C</a><li>
      </ul>
    </div>
    <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Buscar contenido" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
      </form>
<div>
</nav>

<?php
    }
?>