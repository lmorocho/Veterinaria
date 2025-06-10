<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Administrador') {
  header("Location: login_cliente.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'] ?? '';
  $apellido = $_POST['apellido'] ?? '';
  $dni = $_POST['dni'] ?? '';
  $email = $_POST['email'] ?? '';
  $telefono = $_POST['telefono'] ?? '';
  $direccion = $_POST['direccion'] ?? '';
  $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
  $usuario = $_POST['usuario'] ?? '';
  $password = $_POST['password'] ?? '';
  $id_rol = $_POST['id_rol'] ?? '';

  if (!$nombre || !$apellido || !$dni || !$email || !$usuario || !$password || !$id_rol) {
    $_SESSION['modal_error'] = "Faltan datos obligatorios.";
    header("Location: admin_registro.php");
    exit;
  }

  $checkUsuario = $conexion->prepare("SELECT * FROM Usuario WHERE Nombre_Usuario = ?");
  $checkUsuario->bind_param("s", $usuario);
  $checkUsuario->execute();
  $resUsuario = $checkUsuario->get_result();

  if ($resUsuario->num_rows > 0) {
    $_SESSION['modal_error'] = "El nombre de usuario ya existe.";
    header("Location: admin_registro.php");
    exit;
  }

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $stmtUsuario = $conexion->prepare("INSERT INTO Usuario (Nombre_Usuario, Password, ID_Rol) VALUES (?, ?, ?)");
  $stmtUsuario->bind_param("ssi", $usuario, $hashedPassword, $id_rol);
  $stmtUsuario->execute();
  $id_usuario = $stmtUsuario->insert_id;

  switch ($id_rol) {
    case 1:
      $stmt = $conexion->prepare("INSERT INTO Administrador (ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      break;
    case 2:
      $stmt = $conexion->prepare("INSERT INTO Empleado (ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      break;
    case 3:
      $stmt = $conexion->prepare("INSERT INTO Cliente (ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      break;
    case 4:
      $stmt = $conexion->prepare("INSERT INTO Proveedor (ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      break;
    default:
      $_SESSION['modal_error'] = "Rol no válido.";
      header("Location: admin_registro.php");
      exit;
  }

  $stmt->bind_param("isssssss", $id_usuario, $nombre, $apellido, $dni, $email, $telefono, $direccion, $fecha_nacimiento);

  if ($stmt->execute()) {
    $_SESSION['modal_exito'] = "Usuario registrado correctamente.";
  } else {
    $_SESSION['modal_error'] = "Error al registrar el usuario.";
  }

  header("Location: admin_registro.php");
  exit;

} else {
  header("Location: admin_registro.php");
  exit;
}
?>
