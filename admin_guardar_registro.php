<?php
//session_start();
require("inc/auth_admin.php");
include("conexion.php");

// Verificar sesión y rol de Administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: login_cliente.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre             = $_POST['nombre']             ?? '';
    $apellido           = $_POST['apellido']           ?? '';
    $dni                = $_POST['dni']                ?? '';
    $email              = $_POST['email']              ?? '';
    $telefono           = $_POST['telefono']           ?? '';
    $direccion          = $_POST['direccion']          ?? '';
    $fecha_nacimiento   = $_POST['fecha_nacimiento']   ?? '';
    $usuario            = $_POST['usuario']            ?? '';
    $password           = $_POST['password']           ?? '';
    $id_rol             = intval($_POST['id_rol']      ?? 0);

    // Validar campos obligatorios
    if (!$nombre || !$apellido || !$dni || !$email || !$usuario || !$password || !$id_rol) {
        $_SESSION['modal_error'] = "Faltan datos obligatorios.";
        header("Location: admin_registro.php");
        exit;
    }

    // Verificar nombre de usuario único
    $checkUsuario = $conexion->prepare("SELECT 1 FROM Usuario WHERE Nombre_Usuario = ?");
    $checkUsuario->bind_param("s", $usuario);
    $checkUsuario->execute();
    $resUsuario = $checkUsuario->get_result();
    if ($resUsuario->num_rows > 0) {
        $_SESSION['modal_error'] = "El nombre de usuario ya existe.";
        header("Location: admin_registro.php");
        exit;
    }

    // Insertar en Usuario (texto plano, solo desarrollo)
    $stmtUser = $conexion->prepare(
        "INSERT INTO Usuario (Nombre_Usuario, Password, ID_Rol) VALUES (?, ?, ?)"
    );
    $stmtUser->bind_param("ssi", $usuario, $password, $id_rol);
    $stmtUser->execute();
    $id_usuario = $stmtUser->insert_id;

    // Insertar datos según rol
    switch ($id_rol) {
        case 1: // Administrador -> Empleado
        case 2: // Empleado
            $stmt = $conexion->prepare(
                "INSERT INTO Empleado (ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            break;
        case 3: // Cliente
            $stmt = $conexion->prepare(
                "INSERT INTO Cliente  (ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            break;
        case 4: // Proveedor
            $stmt = $conexion->prepare(
                "INSERT INTO Proveedor (ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            break;
        default:
            $_SESSION['modal_error'] = "Rol no válido.";
            header("Location: admin_registro.php");
            exit;
    }
    $stmt->bind_param(
        "isssssss",
        $id_usuario,
        $nombre,
        $apellido,
        $dni,
        $email,
        $telefono,
        $direccion,
        $fecha_nacimiento
    );
    $stmt->execute();

    // Si es Cliente, registrar mascotas
    if ($id_rol === 3 && !empty($_POST['mascotas']) && is_array($_POST['mascotas'])) {
        $id_cliente = $stmt->insert_id;
        $stmtMasc = $conexion->prepare(
            "INSERT INTO Mascota (ID_Cliente, Nombre, Fecha_Nacimiento, ID_Raza) VALUES (?, ?, ?, ?)"
        );
        foreach ($_POST['mascotas'] as $m) {
            $nomM  = trim($m['nombre'] ?? '');
            $fecM  = trim($m['fecha_nacimiento'] ?? '');
            $razaM = intval($m['id_raza'] ?? 0);
            if ($nomM && $fecM && $razaM > 0) {
                $stmtMasc->bind_param("issi", $id_cliente, $nomM, $fecM, $razaM);
                $stmtMasc->execute();
            }
        }
    }

    // Mensaje de éxito y redirección
    $_SESSION['modal_exito'] = "Usuario registrado correctamente.";
    header("Location: admin_registro.php");
    exit;
} else {
    header("Location: admin_registro.php");
    exit;
}
?>