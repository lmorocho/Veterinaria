<?php
session_start();
include("conexion.php");

// Verificar si hay sesión y es cliente
$isLoggedClient = isset($_SESSION['usuario']) && $_SESSION['rol'] === 'Cliente';
$id_cliente = $isLoggedClient ? ($_SESSION['usuario']['ID_Cliente'] ?? null) : null;

// Si no está logueado, registramos al nuevo usuario y su tipo
if (!$isLoggedClient) {
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $dni = $_POST['dni'];
  $email = $_POST['email'];
  $telefono = $_POST['telefono'];
  $direccion = $_POST['direccion'];
  $fecha_nacimiento = $_POST['fecha_nacimiento'];
  $usuario = $_POST['usuario'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash seguro
  $id_rol = intval($_POST['id_rol']);

  // Validar duplicados
  $check = $conexion->prepare("SELECT 1 FROM Usuario WHERE Nombre_Usuario = ?");
  $check->bind_param("s", $usuario);
  $check->execute();
  if ($check->get_result()->num_rows > 0) {
    die("<div class='alert alert-danger'>Ya existe un usuario con ese nombre. <a href='cliente_mascota.php'>Volver</a></div>");
  }

  // Insertar en tabla Usuario
  $stmtUsuario = $conexion->prepare("INSERT INTO Usuario (Nombre_Usuario, Password, ID_Rol) VALUES (?, ?, ?)");
  $stmtUsuario->bind_param("ssi", $usuario, $password, $id_rol);
  $stmtUsuario->execute();
  $id_usuario = $conexion->insert_id;

  // Insertar en Cliente / Empleado / Proveedor
  switch ($id_rol) {
    case 1: // Admin (no se maneja desde aquí)
      break;
    case 2: // Empleado
      $tabla = "Empleado";
      break;
    case 3: // Cliente
      $tabla = "Cliente";
      break;
    case 4: // Proveedor
      $tabla = "Proveedor";
      break;
    default:
      die("<div class='alert alert-danger'>Rol inválido.</div>");
  }

  // Insertar datos personales en la tabla correspondiente
  $stmtPersona = $conexion->prepare("INSERT INTO $tabla (Nombre, Apellido, DNI, Telefono, Email, Direccion, Fecha_Nacimiento, ID_Usuario, ID_Rol)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmtPersona->bind_param("sssssssii", $nombre, $apellido, $dni, $telefono, $email, $direccion, $fecha_nacimiento, $id_usuario, $id_rol);
  $stmtPersona->execute();

  if ($tabla === "Cliente") {
    $id_cliente = $conexion->insert_id;
  }
}

// Registrar mascotas si es cliente
if ($id_cliente && isset($_POST['mascotas']) && is_array($_POST['mascotas'])) {
  foreach ($_POST['mascotas'] as $mascota) {
    if (!empty($mascota['nombre'])) {
      $nombre_mascota = $mascota['nombre'];
      $fecha_mascota = $mascota['fecha_nacimiento'];
      $id_raza = intval($mascota['id_raza']);

      // Verifica si ya existe
      $verif = $conexion->prepare("SELECT 1 FROM Mascota WHERE Nombre = ? AND ID_Cliente = ?");
      $verif->bind_param("si", $nombre_mascota, $id_cliente);
      $verif->execute();
      if ($verif->get_result()->num_rows === 0) {
        $stmtMascota = $conexion->prepare("INSERT INTO Mascota (Nombre, Fecha_Nacimiento, ID_Raza, ID_Cliente) VALUES (?, ?, ?, ?)");
        $stmtMascota->bind_param("ssii", $nombre_mascota, $fecha_mascota, $id_raza, $id_cliente);
        $stmtMascota->execute();
      }
    }
  }
}

$destino = $isLoggedClient ? 'cliente_dashboard.php' : 'login_cliente.php';
echo "<div class='alert alert-success'>Los datos fueron guardados correctamente. <a href='$destino'>Ir al menú principal</a></div>";
?>
