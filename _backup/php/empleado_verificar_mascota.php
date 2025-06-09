<?php
    require("conexion.php");

    if (!isset($_GET['id_cliente'])) {
        http_response_code(400);
        echo "Falta el parámetro id_cliente";
        exit;
    }

    $id_cliente = intval($_GET['id_cliente']);

    // Verificar si el cliente tiene mascotas
    $query = $conexion->prepare("SELECT COUNT(*) as total FROM Mascota WHERE ID_Cliente = ?");
    $query->bind_param("i", $id_cliente);
    $query->execute();
    $result = $query->get_result();
    $data = $result->fetch_assoc();

    echo $data['total'] > 0 ? '1' : '0';
?>
