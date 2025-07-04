<?php
// admin_guardar_registro.php
require("inc/auth_admin.php");
require("conexion.php");

// Solo admin (ID_Rol = 1) puede ejecutar
/*if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['ID_Rol'] != 1) {
    header('Location: index.php');
    exit;
}*/

// Validar sesión del Admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['ID_Rol'] != 1) {
  header("Location: login_cliente.php");
  exit;
}


// Recoger parámetros
$id_cliente = intval(
    $_POST['id_cliente'] ?? 0
);
$cantidad   = intval(
    $_POST['cantidad'] ?? 0
);
$mascotas   = $_POST['mascotas'] ?? [];

if (!$id_cliente) {
    $_SESSION['modal_exito'] = 'Error: Cliente no seleccionado.';
    header("Location: admin_registro_mascota.php");
    exit;
}

// Validación básica
if ($cantidad > 0 && is_array($mascotas) && count($mascotas) === $cantidad) {
    $stmt = $conexion->prepare(
        "INSERT INTO Mascota (ID_Cliente, Nombre, Fecha_Nacimiento, ID_Raza)
         VALUES (?, ?, ?, ?)"
    );
    foreach ($mascotas as $m) {
        $nombre = trim($m['nombre']   ?? '');
        $fecha  = trim($m['fecha']    ?? '');
        $raza   = intval($m['raza']   ?? 0);
        if ($nombre && $fecha && $raza) {
            $stmt->bind_param("issi", $id_cliente, $nombre, $fecha, $raza);
            $stmt->execute();
        }
    }
    $stmt->close();
    $_SESSION['modal_exito'] = "Las mascotas han sido registradas correctamente.";
} else {
    $_SESSION['modal_exito'] = "Error: Datos incompletos o cantidad inválida.";
}

// Redirigir de vuelta al registro de mascotas
header("Location: admin_registro_mascota.php?cliente={$id_cliente}");
exit;
