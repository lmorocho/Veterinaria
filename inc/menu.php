<?php
    //Declaramos la función
    function menu(){   
?>

    <!--<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-body">-->
    <nav class="navbar bg-dark navbar-expand navbar-dark" data-bs-theme="dark">        
        <!--<nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark bg-dark">-->
            <!--Primer DIV-->
            <div class="container-fluid">
                <a class="navbar-brand" href="https://demo.templatemonster.com/es/demo/342435.html?_gl=1*1h969di*_gcl_au*MTI5MzAzOTAzOS4xNzQzMjE0MTg1*_ga*MTM0MTIzOTcxNC4xNzQzMjE0MTgx*_ga_FTPYEGT5LY*MTc0MzIxNDE4MC4xLjEuMTc0MzIxNDI1OS41My4wLjA"><b>PET HOUSE</b></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!--Segundo DIV-->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-disabled="true" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <!--<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
                            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Gestión & Administración
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Agenda de Turnos inteligente</a></li>
                                <li><a class="dropdown-item" href="#">Historial médico digital</a></li>
                                <li><a class="dropdown-item" href="#">Ficha completa de clientes y mascotas</a></li>
                                <li><a class="dropdown-item" href="#">Control de stock</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Facturación y pagos integrados</a></li>
                            </ul>
                            
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link active" aria-disabled="true" href="formulario.php">Gestión Clientes</a>
                        </li>-->
                        <li class="nav-item dropdown">
                            <!--<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
                            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Gestión Clientes
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Perfil de usuario</a></li>
                                <li><a class="dropdown-item" href="#">Sistema de seguimiento post-atención</a></li>
                                <li><a class="dropdown-item" href="#">Chat con la veterinaria</a></li>
                                <li><a class="dropdown-item" href="#">Programa de fidelización</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Acceso a consejos y blog</a></li>
                            </ul>
                            
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link active" aria-disabled="true" href="bdd.php">Práctica ABM</a>
                        </li>-->
                        
                        <li class="nav-item dropdown">
                            <!--<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
                            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Expansión & Nuevas Funcionalidades
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Venta online de productos</a></li>
                                <li><a class="dropdown-item" href="#">Módulo de Emergencias</a></li>
                                <li><a class="dropdown-item" href="#">Gestión de adopciones</a></li>
                                <li><a class="dropdown-item" href="#">Notificaciones y alertas personalizadas</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Integración con Redes Sociales</a></li>
                            </ul>
                            
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Buscar contenido" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button> 
                    </form>
                </div>    
            </div>
        </nav>


<?php
    }
?>