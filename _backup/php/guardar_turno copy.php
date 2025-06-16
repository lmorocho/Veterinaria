<?php
// guardar_turno.php
// Endpoint que recibe datos de un turno y lo guarda en la tabla Turno

header('Content-Type: application/json');
// Iniciar sesión
session_start();
// Incluir conexión a la base de datos
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

// Mapear día en español a fecha de la semana actual
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

// Calcular fecha correspondiente de la semana en curso
$fecha = date('Y-m-d', strtotime('this ' . $mapaDias[$dia]));
// Formatear hora a HH:MM:SS para SQL
$horaSql = sprintf('%02d:00:00', intval($hora));

// Obtener ID_Empleado desde la tabla Empleado según el ID_Usuario en sesión
$idUsuario = $_SESSION['usuario']['ID_Usuario'];
$stmtEmp = $conexion->prepare("SELECT ID_Empleado FROM Empleado WHERE ID_Usuario = ?");
$stmtEmp->bind_param("i", $idUsuario);
$stmtEmp->execute();
$resultEmp = $stmtEmp->get_result();
if ($row = $resultEmp->fetch_assoc()) {
    $idEmpleado = intval($row['ID_Empleado']);
} else {
    // Si no existe registro en Empleado, usar el usuario mismo
    $idEmpleado = $idUsuario;
}
$stmtEmp->close();

// Preparar y ejecutar la inserción en la tabla Turno
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
