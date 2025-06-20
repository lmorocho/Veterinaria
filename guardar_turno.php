<?php
// guardar_turno.php
header('Content-Type: application/json');
session_start();
include('conexion.php');

// Sólo Admin (ID_Rol = 1) o Empleado (ID_Rol = 2) pueden asignar turnos
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['ID_Rol'], [1, 2])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Recoger y validar parámetros del formulario
$dia       = $_POST['dia']       ?? '';
$hora      = $_POST['hora']      ?? '';
$idMascota = intval($_POST['mascota']   ?? 0);
$idTipo    = intval($_POST['tipo_id']   ?? 0);

if (!$dia || $hora === '' || !$idMascota || !$idTipo) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
    exit;
}

// Mapear día en español a inglés
$mapaDias = [
    'lunes'     => 'Monday',
    'martes'    => 'Tuesday',
    'miercoles' => 'Wednesday',
    'jueves'    => 'Thursday',
    'viernes'   => 'Friday'
];
if (!isset($mapaDias[$dia])) {
    echo json_encode(['success' => false, 'message' => 'Día inválido']);
    exit;
}

$fecha   = date('Y-m-d', strtotime($mapaDias[$dia] . ' this week'));
$horaSql = sprintf('%02d:00:00', intval($hora));

// Obtener ID_Empleado desde tabla Empleado o usar fallback
$idUsuario = $_SESSION['usuario']['ID_Usuario'];
$stmtEmp = $conexion->prepare("SELECT ID_Empleado FROM Empleado WHERE ID_Usuario = ?");
$stmtEmp->bind_param("i", $idUsuario);
$stmtEmp->execute();
$resultEmp = $stmtEmp->get_result();
$idEmpleado = ($row = $resultEmp->fetch_assoc()) ? intval($row['ID_Empleado']) : $idUsuario;
$stmtEmp->close();

// Validamos si la mascota ya tiene turno en esa fecha y hora
$stmtCheck = $conexion->prepare(
    "SELECT 1 FROM Turno WHERE Fecha = ? AND Hora = ? AND ID_Mascota = ?"
);
$stmtCheck->bind_param("ssi", $fecha, $horaSql, $idMascota);
$stmtCheck->execute();
$stmtCheck->store_result();

if ($stmtCheck->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'La mascota ya tiene un turno asignado en ese horario.']);
    $stmtCheck->close();
    exit;
}
$stmtCheck->close();

// Insertar turno
$stmt = $conexion->prepare(
    "INSERT INTO Turno (Fecha, Hora, ID_Mascota, ID_Empleado, ID_Tipo_Turno) VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param("ssiii", $fecha, $horaSql, $idMascota, $idEmpleado, $idTipo);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
$stmt->close();
?>
