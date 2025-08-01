<?php
  session_start();
  include("conexion.php");

  // Validar sesión del empleado
  if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['ID_Rol'] != 2) {
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
    $cantidad_mascotas = intval($_POST['cantidad_mascotas'] ?? 0);

    if (!$nombre || !$apellido || !$dni || !$email || !$usuario || !$password || $cantidad_mascotas <= 0) {
      die("<div class='alert alert-danger'>Faltan datos obligatorios. <a href='empleado_registro.php'>Volver</a></div>");
    }

    // Validar si el usuario ya existe
    $checkUsuario = $conexion->prepare("SELECT * FROM Usuario WHERE Nombre_Usuario = ?");
    $checkUsuario->bind_param("s", $usuario);
    $checkUsuario->execute();
    $resUsuario = $checkUsuario->get_result();
    if ($resUsuario->num_rows > 0) {
      die("<div class='alert alert-danger'>El nombre de usuario ya existe. <a href='empleado_registro.php'>Volver</a></div>");
    }

    // Insertar en Usuario (ID_Rol = 3 para Cliente)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmtUsuario = $conexion->prepare("INSERT INTO Usuario (Nombre_Usuario, Password, ID_Rol) VALUES (?, ?, 3)");
    $stmtUsuario->bind_param("ss", $usuario, $hashedPassword);
    $stmtUsuario->execute();
    $id_usuario = $stmtUsuario->insert_id;

    // Insertar en Cliente
    $stmtCliente = $conexion->prepare("INSERT INTO Cliente (ID_Usuario, Nombre, Apellido, DNI, Email, Telefono, Direccion, Fecha_Nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtCliente->bind_param("isssssss", $id_usuario, $nombre, $apellido, $dni, $email, $telefono, $direccion, $fecha_nacimiento);
    $stmtCliente->execute();
    $id_cliente = $stmtCliente->insert_id;

    // Insertar mascotas (desde array asociativo)
    if (!empty($_POST['mascotas']) && is_array($_POST['mascotas'])) {
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
    }

    echo "<div class='alert alert-success'>Cliente y mascotas registradas correctamente. <a href='empleado_registro.php'>Registrar otro</a></div>";

  } else {
    header("Location: empleado_registro.php");
    exit;
  }
?>