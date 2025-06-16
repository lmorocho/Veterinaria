<?php
// get_mascotas.php
// Devuelve en JSON las mascotas de un cliente dado

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();

include('conexion.php');

// Validar parámetro cliente
if (!isset($_GET['cliente']) || !is_numeric($_GET['cliente'])) {
    echo json_encode([]);
    exit;
}

$id_cliente = intval($_GET['cliente']);

// Preparar y ejecutar consulta
$stmt = $conexion->prepare(
    "SELECT ID_Mascota, Nombre AS Nombre_Mascota 
     FROM Mascota 
     WHERE ID_Cliente = ?"
);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();

$mascotas = [];
while ($row = $result->fetch_assoc()) {
    $mascotas[] = $row;
}
$stmt->close();

// Retornar JSON
echo json_encode($mascotas);
