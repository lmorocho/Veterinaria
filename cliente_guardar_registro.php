<?php
/*session_start();*/
require("inc/auth_cliente.php");
require("conexion.php");

// Validar sesión del cliente
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['ID_Rol'] != 3) {
  header("Location: login_cliente.php");
  exit;
}

$id_cliente = $_SESSION['usuario']['ID_Cliente'] ?? null;
if (!$id_cliente) {
  header("Location: cliente_registro.php?error=session");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cantidad_mascotas = intval($_POST['cantidad_mascotas'] ?? 0);

  if ($cantidad_mascotas > 0 && !empty($_POST['mascotas']) && is_array($_POST['mascotas'])) {
    foreach ($_POST['mascotas'] as $mascota) {
      $nombre_mascota = $mascota['nombre'] ?? '';
      $fecha_nac_mascota = $mascota['fecha_nacimiento'] ?? '';
      $id_raza = $mascota['id_raza'] ?? '';

      if ($nombre_mascota && $fecha_nac_mascota && $id_raza) {
        $stmtMascota = $conexion->prepare("INSERT INTO Mascota (ID_Cliente, Nombre, Fecha_Nacimiento, ID_Raza) VALUES (?, ?, ?, ?)");
        $stmtMascota->bind_param("issi", $id_cliente, $nombre_mascota, $fecha_nac_mascota, $id_raza);
        $stmtMascota->execute();
      }
    }
    $_SESSION['modal_exito'] = "Mascotas registradas correctamente.";
  } else {
    $_SESSION['modal_exito'] = "Error: Datos incompletos para registrar mascotas.";
  }
}

header("Location: cliente_registro.php");
exit;
