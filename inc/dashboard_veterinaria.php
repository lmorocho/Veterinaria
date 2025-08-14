<?php
//Declaramos la función
//require("conexion.php");
//require("inc/menu.php");
// 1. Incluimos conexión.php
require_once("conexion.php");

function dashboard(){
    global $conexion;
    //require_once("conexion.php");

    // 2. Ejecuta las consultas y guardamos los totales
    // Total Clientes
    $res = $conexion->query("SELECT COUNT(*) AS total FROM Cliente");
    $totalClientes = $res->fetch_assoc()['total'] ?? 0;

    // Total Mascotas
    $res = $conexion->query("SELECT COUNT(*) AS total FROM Mascota");
    $totalMascotas = $res->fetch_assoc()['total'] ?? 0;

    // Total Perros
    $res = $conexion->query("
        SELECT COUNT(*) AS total 
        FROM Mascota m
        INNER JOIN Raza r ON m.ID_Raza = r.ID_Raza
        INNER JOIN Especie e ON r.ID_Especie = e.ID_Especie
        WHERE e.Nombre_Especie = 'Perro'
    ");
    $totalPerros = $res->fetch_assoc()['total'] ?? 0;

    // Total Gatos
    $res = $conexion->query("
        SELECT COUNT(*) AS total 
        FROM Mascota m
        INNER JOIN Raza r ON m.ID_Raza = r.ID_Raza
        INNER JOIN Especie e ON r.ID_Especie = e.ID_Especie
        WHERE e.Nombre_Especie = 'Gato'
    ");
    $totalGatos = $res->fetch_assoc()['total'] ?? 0;
?>
    <div class="numbers">
        <div class="text-bg-secondary p-3">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 text-center">

            <!-- Clientes -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                <div class="card-header bg-dark text-white d-flex align-items-center justify-content-center">
                    <i class="bi bi-people-fill me-2"></i>
                    <h6 class="mb-0">Total Clientes</h6>
                </div>
                <div class="card-body bg-warning text-dark d-flex align-items-center justify-content-center">
                    <div class="display-5 fw-bold"><?= number_format($totalClientes) ?></div>
                </div>
                </div>
            </div>

            <!-- Mascotas -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                <div class="card-header bg-dark text-white d-flex align-items-center justify-content-center">
                    <i class="fa fa-paw me-2"></i>
                    <h6 class="mb-0">Total Mascotas</h6>
                </div>
                <div class="card-body bg-warning text-dark d-flex align-items-center justify-content-center">
                    <div class="display-5 fw-bold"><?= number_format($totalMascotas) ?></div>
                </div>
                </div>
            </div>

            <!-- Perros -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                <div class="card-header bg-dark text-white d-flex align-items-center justify-content-center">
                    <i class="fa fa-paw me-2"></i>
                    <h6 class="mb-0">Total Perros</h6>
                </div>
                <div class="card-body bg-warning text-dark d-flex align-items-center justify-content-center">
                    <div class="display-5 fw-bold"><?= number_format($totalPerros) ?></div>
                </div>
                </div>
            </div>

            <!-- Gatos -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                <div class="card-header bg-dark text-white d-flex align-items-center justify-content-center">
                    <i class="fa fa-paw me-2"></i>
                    <h6 class="mb-0">Total Gatos</h6>
                </div>
                <div class="card-body bg-warning text-dark d-flex align-items-center justify-content-center">
                    <div class="display-5 fw-bold"><?= number_format($totalGatos) ?></div>
                </div>
                </div>
            </div>

            </div>
        </div>
    </div>

<?php
}  // fin de dashboard()
?>
