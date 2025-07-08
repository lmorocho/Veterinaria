<?php
// admin_proveedor_guardar_registro.php
require("inc/auth_admin.php");
require("conexion.php");

// Solo Administrador (ID_Rol = 1)
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['ID_Rol'] != 1) {
    header("Location: login_admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $nombre      = trim($_POST['nombre'] ?? '');
    $apellido    = trim($_POST['apellido'] ?? '');
    $empresa     = trim($_POST['empresa'] ?? '');
    $dni         = trim($_POST['dni'] ?? '');
    $telefono    = trim($_POST['telefono'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $direccion   = trim($_POST['direccion'] ?? '');
    $userName    = trim($_POST['nombre_usuario'] ?? '');
    $password    = trim($_POST['password'] ?? '');
    $idRol       = intval($_POST['id_rol'] ?? 0); // debe ser 4

    // Validar campos obligatorios
    if (!$nombre || !$apellido || !$empresa || !$dni || !$email || !$userName || !$password || $idRol !== 4) {
        $_SESSION['modal_error'] = "Faltan datos obligatorios o rol inválido.";
        header('Location: admin_proveedor_registro.php');
        exit;
    }

    // Verificar nombre de usuario único
    $stmt = $conexion->prepare("SELECT 1 FROM Usuario WHERE Nombre_Usuario = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['modal_error'] = "El nombre de usuario ya existe.";
        $stmt->close();
        header('Location: admin_proveedor_registro.php');
        exit;
    }
    $stmt->close();

    // Insertar en Usuario (texto plano)
    $stmt = $conexion->prepare(
        "INSERT INTO Usuario (Nombre_Usuario, Password, ID_Rol) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("ssi", $userName, $password, $idRol);
    $stmt->execute();
    $idUsuario = $stmt->insert_id;
    $stmt->close();

    // Insertar en Proveedor
    $stmt = $conexion->prepare(
        "INSERT INTO Proveedor (ID_Usuario, Nombre, Apellido, Empresa, DNI, Email, Telefono, Direccion)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "isssssss",
        $idUsuario,
        $nombre,
        $apellido,
        $empresa,
        $dni,
        $email,
        $telefono,
        $direccion
    );
    $stmt->execute();
    $stmt->close();

    // Éxito
    $_SESSION['modal_exito'] = "Proveedor registrado correctamente.";
    header('Location: admin_proveedor_registro.php');
    exit;
}

// Si no es POST, redirigimos
header('Location: admin_proveedor_registro.php');
exit;
?>
