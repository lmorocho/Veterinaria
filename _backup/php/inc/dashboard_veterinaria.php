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
        <br>
        <div class="row text-center">
            <!-- Clientes -->
            <div class="col-3">
                <div class="d-flex justify-content-center">
                    <div class="card mb-3" style="width: 22rem;">
                        <div class="card-header bg-dark text-white">
                            <i class="bi bi-people-fill me-2"></i>
                            <h6>Total Clientes</h6>
                        </div>
                        <div class="card-body bg-warning text-dark">
                            <h2><?= $totalClientes ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mascotas -->
            <div class="col-3">
                <div class="d-flex justify-content-center">
                    <div class="card mb-3" style="width: 22rem;">
                        <div class="card-header bg-dark text-white">
                            <i class="fa fa-paw me-2"></i>
                            <h6>Total Mascotas</h6>
                        </div>
                        <div class="card-body bg-warning text-dark">
                            <h2><?= $totalMascotas ?></h2>
                        </div>
                    </div>
                </div>
            </div>
          <!-- Perros -->
            <div class="col-3">
                <div class="d-flex justify-content-center">
                    <div class="card mb-3" style="width: 22rem;">
                        <div class="card-header bg-dark text-white">
                            <i class="fa fa-paw me-2"></i>
                            <h6>Total Perros</h6>
                        </div>
                        <div class="card-body bg-warning text-dark">
                            <h2><?= $totalPerros ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Gatos -->
            <div class="col-3">
                <div class="d-flex justify-content-center">
                    <div class="card mb-3" style="width: 22rem;">
                        <div class="card-header bg-dark text-white">
                            <i class="fa fa-paw me-2"></i>
                            <h6>Total Gatos</h6>
                        </div>
                        <div class="card-body bg-warning text-dark">
                            <h2><?= $totalGatos ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
<?php
}  // fin de dashboard()
?>
