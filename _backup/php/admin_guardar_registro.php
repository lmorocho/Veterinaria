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
    die("<div class='alert alert-danger'>Faltan datos obligatorios. <a href='admin_registro.php'>Volver</a></div>");
  }

  // Verifica si ya existe el usuario
  $checkUsuario = $conexion->prepare("SELECT * FROM Usuario WHERE Nombre_Usuario = ?");
  $checkUsuario->bind_param("s", $usuario);
  $checkUsuario->execute();
  $resUsuario = $checkUsuario->get_result();

  if ($resUsuario->num_rows > 0) {
    die("<div class='alert alert-danger'>El nombre de usuario ya existe. <a href='admin_registro.php'>Volver</a></div>");
  }

  // Inserta en tabla Usuario
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $stmtUsuario = $conexion->prepare("INSERT INTO Usuario (Nombre_Usuario, Password, ID_Rol) VALUES (?, ?, ?)");
  $stmtUsuario->bind_param("ssi", $usuario, $hashedPassword, $id_rol);
  $stmtUsuario->execute();
  $id_usuario = $stmtUsuario->insert_id;

  // Insertar en la tabla correspondiente
  switch ($id_rol) {
    case 1: // Administrador
      $tabla = "Administrador";
      $campos = "(ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento)";
      $valores = "(?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conexion->prepare("INSERT INTO $tabla $campos VALUES $valores");
      $stmt->bind_param("isssssss", $id_usuario, $nombre, $apellido, $dni, $email, $telefono, $direccion, $fecha_nacimiento);
      break;
    case 2: // Empleado
      $tabla = "Empleado";
      $stmt = $conexion->prepare("INSERT INTO Empleado (ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isssssss", $id_usuario, $nombre, $apellido, $dni, $email, $telefono, $direccion, $fecha_nacimiento);
      break;
    case 3: // Cliente
      $tabla = "Cliente";
      $stmt = $conexion->prepare("INSERT INTO Cliente (ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isssssss", $id_usuario, $nombre, $apellido, $dni, $email, $telefono, $direccion, $fecha_nacimiento);
      break;
    case 4: // Proveedor
      $tabla = "Proveedor";
      $stmt = $conexion->prepare("INSERT INTO Proveedor (ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isssssss", $id_usuario, $nombre, $apellido, $dni, $email, $telefono, $direccion, $fecha_nacimiento);
      break;
    default:
      die("<div class='alert alert-danger'>Rol no válido.</div>");
  }

  if ($stmt->execute()) {
    echo "<div class='alert alert-success'>Usuario registrado correctamente. <a href='admin_registro.php'>Registrar otro</a></div>";
  } else {
    echo "<div class='alert alert-danger'>Error al registrar el usuario. <a href='admin_registro.php'>Intentar nuevamente</a></div>";
  }
} else {
  header("Location: admin_registro.php");
  exit;
}
?>
