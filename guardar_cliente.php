
<?php
include("conexion.php");

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

// Validar si cliente ya existe por Email o DNI
$check = $conexion->prepare("SELECT * FROM Cliente WHERE DNI = ? OR Email = ?");
$check->bind_param("ss", $dni, $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
  die("<div class='alert alert-danger'>El cliente con ese DNI o Email ya existe. <a href='cliente_mascota.php'>Volver</a></div>");
}

// Obtener último ID_Cliente
$ultimo_id_result = $conexion->query("SELECT MAX(ID_Cliente) AS max_id FROM Cliente");
$row = $ultimo_id_result->fetch_assoc();
$nuevo_id = $row['max_id'] + 1;

// Insertar cliente con nuevo ID
$insert = $conexion->prepare("INSERT INTO Cliente (ID_Cliente, Nombre, Apellido, DNI, Telefono, Email, Direccion, Fecha_nacimiento, Usuario, Password, ID_Rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$insert->bind_param("isssssssssi", $nuevo_id, $nombre, $apellido, $dni, $telefono, $email, $direccion, $fecha_nacimiento, $usuario, $password, $id_rol);
$insert->execute();

// Insertar mascotas
if (isset($_POST['mascotas']) && is_array($_POST['mascotas'])) {
  foreach ($_POST['mascotas'] as $mascota) {
    if (!empty($mascota['nombre'])) {
      $nombre_mascota = $mascota['nombre'];
      $fecha_mascota = $mascota['fecha_nacimiento'];
      $id_raza = $mascota['id_raza'];

      // Calcular siguiente ID_Mascota
      $queryMascota = $conexion->query("SELECT MAX(ID_Mascota) AS max_mascota FROM Mascota");
      $rowMascota = $queryMascota->fetch_assoc();
      $nuevo_id_mascota = $rowMascota['max_mascota'] + 1;

      $verificaMascota = $conexion->prepare("SELECT * FROM Mascota WHERE Nombre = ? AND ID_Cliente = ?");
      $verificaMascota->bind_param("si", $nombre_mascota, $nuevo_id);
      $verificaMascota->execute();
      $resMascota = $verificaMascota->get_result();

      if ($resMascota->num_rows === 0) {
        $insMascota = $conexion->prepare("INSERT INTO Mascota (ID_Mascota, Nombre, Fecha_Nacimiento, ID_Raza, ID_Cliente) VALUES (?, ?, ?, ?, ?)");
        $insMascota->bind_param("issii", $nuevo_id_mascota, $nombre_mascota, $fecha_mascota, $id_raza, $nuevo_id);
        $insMascota->execute();
      }
    }
  }
}

echo "<div class='alert alert-success'>Cliente y mascotas guardados correctamente. <a href='menu_rol.php'>Ir al menú principal</a></div>";
//echo "<div class='alert alert-success'>Cliente y mascotas guardados correctamente. <a href='menu_rol.php'>Ir al menú principal</a></div>";
//echo "<div class='alert alert-success'>Cliente y mascotas guardados correctamente. <a href='logout.php'>Salir e Ir al menú principal</a></div>";
?>



