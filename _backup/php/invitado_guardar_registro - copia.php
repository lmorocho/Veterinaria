<?php
// invitado_guardar_registro.php
// Procesa el registro de un usuario invitado como Cliente y muestra modal de éxito

// Inicialización segura de sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("conexion.php");

// Recoger datos del formulario
$nombre           = trim($_POST['nombre'] ?? '');
$apellido         = trim($_POST['apellido'] ?? '');
$dni              = trim($_POST['dni'] ?? '');
$email            = trim($_POST['email'] ?? '');
$telefono         = trim($_POST['telefono'] ?? '');
$direccion        = trim($_POST['direccion'] ?? '');
$fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');
$usuario          = trim($_POST['usuario'] ?? '');
$password_plain   = trim($_POST['password'] ?? '');
$id_rol           = 3; // Cliente fijo

// Validar datos obligatorios
if (!$nombre || !$apellido || !$dni || !$email || !$usuario || !$password_plain) {
    die("<div class='alert alert-danger'>Faltan datos obligatorios. <a href='invitado.php'>Volver</a></div>");
}

// Verificar duplicado de nombre de usuario
$check = $conexion->prepare("SELECT 1 FROM Usuario WHERE Nombre_Usuario = ?");
$check->bind_param("s", $usuario);
$check->execute();
if ($check->get_result()->num_rows > 0) {
    die("<div class='alert alert-danger'>El nombre de usuario ya existe. <a href='invitado.php'>Volver</a></div>");
}
$check->close();

// Insertar en Usuario (contraseña en texto plano)
$stmtU = $conexion->prepare("INSERT INTO Usuario (Nombre_Usuario, Password, ID_Rol) VALUES (?, ?, ?)");
$stmtU->bind_param("ssi", $usuario, $password_plain, $id_rol);
$stmtU->execute();
$id_usuario = $conexion->insert_id;
$stmtU->close();

// Insertar en Cliente
$stmtC = $conexion->prepare(
    "INSERT INTO Cliente (ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);
$stmtC->bind_param("isssssss", $id_usuario, $nombre, $apellido, $dni, $email, $telefono, $direccion, $fecha_nacimiento);
$stmtC->execute();
$id_cliente = $conexion->insert_id;
$stmtC->close();

// Configurar mensaje de éxito para mostrar modal en invitado.php
$_SESSION['modal_invitado'] = 'Los datos del cliente se han guardado satisfactoriamente.';

// Redirigir de vuelta a invitado.php para mostrar modal
header('Location: invitado.php');
exit;
