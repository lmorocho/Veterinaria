<?php
// admin_edit_usuarios_guardar_registro.php
require("inc/auth_admin.php");
require("conexion.php");

// Solo Administrador (ID_Rol=1)
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['ID_Rol'] != 1) {
    header("Location: login_admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin_usuarios.php');
    exit;
}

// Recoger datos del formulario
$rol         = intval($_POST['rol'] ?? 0);
$idOriginal  = intval($_POST['id_original'] ?? 0);
$idUsuario   = intval($_POST['id_usuario'] ?? 0);
$nombre      = trim($_POST['nombre'] ?? '');
$apellido    = trim($_POST['apellido'] ?? '');
$dni         = trim($_POST['dni'] ?? '');
$email       = trim($_POST['email'] ?? '');
$telefono    = trim($_POST['telefono'] ?? '');
$direccion   = trim($_POST['direccion'] ?? '');
$fecha_nac   = $_POST['fecha_nacimiento'] ?? null;\$nombreU     = trim($_POST['nombre_usuario'] ?? '');
$password    = trim($_POST['password'] ?? '');
$idRol       = intval($_POST['id_rol'] ?? 0);

// Validar obligatorios
if (!$rol || !$idOriginal || !$idUsuario || !$nombre || (!$rol===4 && !$apellido) || !$dni || !$email || !$nombreU || !$idRol) {
    $_SESSION['modal_error'] = "Faltan datos obligatorios.";
    header("Location: admin_edit_user.php?rol={$rol}&id={$idOriginal}");
    exit;
}

// Iniciar transacción
$conexion->begin_transaction();
try {
    // 1. Actualizar Usuario
    // Verificar usuario único (si cambió)
    $stmt = $conexion->prepare("SELECT ID_Usuario FROM Usuario WHERE Nombre_Usuario=? AND ID_Usuario<>?");
    $stmt->bind_param("si", $nombreU, $idUsuario);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        throw new Exception('Nombre de usuario ya existe.');
    }
    $stmt->close();

    // Actualizar campo Usuario y Rol
    if ($password !== '') {
        $passHash = password_hash($password, PASSWORD_DEFAULT);
        $sqlU = "UPDATE Usuario SET Nombre_Usuario=?, Password=?, ID_Rol=? WHERE ID_Usuario=?";
        $stmt = $conexion->prepare($sqlU);
        $stmt->bind_param("ssii", $nombreU, $passHash, $idRol, $idUsuario);
    } else {
        $sqlU = "UPDATE Usuario SET Nombre_Usuario=?, ID_Rol=? WHERE ID_Usuario=?";
        $stmt = $conexion->prepare($sqlU);
        $stmt->bind_param("sii", $nombreU, $idRol, $idUsuario);
    }
    $stmt->execute();
    $stmt->close();

    // 2. Actualizar datos en tabla correspondiente
    switch ($rol) {
        case 1: case 2: // Empleado
            $sql = "UPDATE Empleado SET Nombre=?, Apellido=?, DNI=?, Email=?, Telefono=?, Direccion=?, Fecha_Nacimiento=? WHERE ID_Empleado=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssssssi", $nombre, $apellido, $dni, $email, $telefono, $direccion, $fecha_nac, $idOriginal);
            break;
        case 3: // Cliente
            $sql = "UPDATE Cliente SET Nombre=?, Apellido=?, DNI=?, Email=?, Telefono=?, Direccion=?, Fecha_Nacimiento=? WHERE ID_Cliente=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssssssi", $nombre, $apellido, $dni, $email, $telefono, $direccion, $fecha_nac, $idOriginal);
            break;
        case 4: // Proveedor
            $sql = "UPDATE Proveedor SET Nombre=?, Empresa=?, Email=?, Telefono=?, Direccion=? WHERE ID_Proveedor=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssssi", $nombre, $email, $telefono, $direccion, $idOriginal);
            break;
        default:
            throw new Exception('Rol no válido.');
    }
    $stmt->execute();
    $stmt->close();

    // Confirmar transacción
    $conexion->commit();
    $_SESSION['modal_exito'] = "Usuario actualizado correctamente.";
    header("Location: admin_usuarios.php?rol={$rol}");
    exit;
} catch (Exception $e) {
    $conexion->rollback();
    $_SESSION['modal_error'] = $e->getMessage();
    header("Location: admin_edit_user.php?rol={$rol}&id={$idOriginal}");
    exit;
}
?>