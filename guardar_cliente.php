<?php
session_start();
include("conexion.php");

// Verificar si hay sesión y es cliente
$isLoggedClient = isset($_SESSION['usuario']) && $_SESSION['rol'] === 'Cliente';
$id_cliente = $isLoggedClient ? $_SESSION['usuario']['ID_Cliente'] : null;

// Si no está logueado, registramos al nuevo cliente
if (!$isLoggedClient) {
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $dni = $_POST['dni'];
  $email = $_POST['email'];
  $telefono = $_POST['telefono'];
  $direccion = $_POST['direccion'];
  $fecha_nacimiento = $_POST['fecha_nacimiento'];
  $usuario = $_POST['usuario'];
  $password = $_POST['password'];
  $id_rol = $_POST['id_rol'];

  // Validar duplicado
  $check = $conexion->prepare("SELECT * FROM Cliente WHERE DNI = ? OR Email = ?");
  $check->bind_param("ss", $dni, $email);
  $check->execute();
  $res = $check->get_result();
  if ($res->num_rows > 0) {
    die("<div class='alert alert-danger'>Ya existe un cliente con ese DNI o Email. <a href='cliente_mascota.php'>Volver</a></div>");
  }

  // Generar nuevo ID_Cliente
  $res_id = $conexion->query("SELECT MAX(ID_Cliente) AS max_id FROM Cliente");
  $nuevo_id = ($res_id->fetch_assoc()['max_id'] ?? 0) + 1;

  $stmt = $conexion->prepare("INSERT INTO Cliente (ID_Cliente, Nombre, Apellido, DNI, Telefono, Email, Direccion, Fecha_nacimiento, Usuario, Password, ID_Rol) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("isssssssssi", $nuevo_id, $nombre, $apellido, $dni, $telefono, $email, $direccion, $fecha_nacimiento, $usuario, $password, $id_rol);
  $stmt->execute();

  $id_cliente = $nuevo_id;
}

// Registrar mascotas
if (isset($_POST['mascotas']) && is_array($_POST['mascotas'])) {
  foreach ($_POST['mascotas'] as $mascota) {
    if (!empty($mascota['nombre'])) {
      $nombre_mascota = $mascota['nombre'];
      $fecha_mascota = $mascota['fecha_nacimiento'];
      $id_raza = $mascota['id_raza'];

      // Verifica si ya existe
      $verif = $conexion->prepare("SELECT * FROM Mascota WHERE Nombre = ? AND ID_Cliente = ?");
      $verif->bind_param("si", $nombre_mascota, $id_cliente);
      $verif->execute();
      if ($verif->get_result()->num_rows === 0) {
        $maxMascota = $conexion->query("SELECT MAX(ID_Mascota) AS max FROM Mascota")->fetch_assoc();
        $id_mascota = ($maxMascota['max'] ?? 0) + 1;

        $ins = $conexion->prepare("INSERT INTO Mascota (ID_Mascota, Nombre, Fecha_Nacimiento, ID_Raza, ID_Cliente)
          VALUES (?, ?, ?, ?, ?)");
        $ins->bind_param("issii", $id_mascota, $nombre_mascota, $fecha_mascota, $id_raza, $id_cliente);
        $ins->execute();
      }
    }
  }
}

echo "<div class='alert alert-success'>Los datos fueron guardados correctamente. <a href='cliente_dashboard.php'>Ir al menú principal</a></div>";
?>
