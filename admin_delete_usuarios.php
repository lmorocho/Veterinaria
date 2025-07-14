<?php
// admin_delete_usuarios.php
require("inc/auth_admin.php");
require("conexion.php");

// Parámetros recibidos
$rol = intval(
    isset($_GET['rol']) ? $_GET['rol'] : 0
);
$idOriginal = intval(
    isset($_GET['id']) ? $_GET['id'] : 0
);

if (!$rol || !$idOriginal) {
    header('Location: admin_usuarios.php');
    exit;
}

// Validación previa para clientes con turnos asignados
if ($rol === 3) {
    $stmtChk = $conexion->prepare(
        "SELECT COUNT(*) FROM Turno t
         JOIN Mascota m ON t.ID_Mascota = m.ID_Mascota
         WHERE m.ID_Cliente = ?"
    );
    $stmtChk->bind_param("i", $idOriginal);
    $stmtChk->execute();
    $stmtChk->bind_result($count);
    $stmtChk->fetch();
    $stmtChk->close();

    if ($count > 0) {
        // No eliminar hasta cancelar turnos
        header('Location: admin_usuarios.php?rol=3&error=hasTurns');
        exit;
    }
}

try {
    // Iniciar transacción
    $conexion->begin_transaction();

    switch ($rol) {
        case 1: // Administrador (Empleado)
        case 2: // Empleado
            // 1. Backup Empleado + Usuario
            $sql = "
                INSERT INTO backup_usuarios (
                    Tipo_Perfil, ID_Original, ID_Usuario, Nombre, Apellido, DNI,
                    Fecha_Nacimiento, Email, Telefono, Direccion,
                    Nombre_Usuario, Password, ID_Rol
                )
                SELECT
                    'Empleado', e.ID_Empleado, e.ID_Usuario, e.Nombre, e.Apellido, e.DNI,
                    e.Fecha_Nacimiento, e.Email, e.Telefono, e.Direccion,
                    u.Nombre_Usuario, u.Password, u.ID_Rol
                FROM Empleado e
                JOIN Usuario u ON e.ID_Usuario = u.ID_Usuario
                WHERE e.ID_Empleado = ?
            ";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $idOriginal);
            $stmt->execute();
            $stmt->close();

            // 2. Eliminar Empleado
            $delEmp = $conexion->prepare("DELETE FROM Empleado WHERE ID_Empleado = ?");
            $delEmp->bind_param("i", $idOriginal);
            $delEmp->execute();
            $delEmp->close();

            // 3. Eliminar Usuario
            $delUser = $conexion->prepare(
                "DELETE u FROM Usuario u
                 JOIN backup_usuarios b ON u.ID_Usuario = b.ID_Usuario
                 WHERE b.Tipo_Perfil = 'Empleado' AND b.ID_Original = ?"
            );
            $delUser->bind_param("i", $idOriginal);
            $delUser->execute();
            $delUser->close();
            break;

        case 3: // Cliente
            // 1. Backup Cliente + Usuario
            $sql = "
                INSERT INTO backup_usuarios (
                    Tipo_Perfil, ID_Original, ID_Usuario, Nombre, Apellido, DNI,
                    Fecha_Nacimiento, Email, Telefono, Direccion,
                    Nombre_Usuario, Password, ID_Rol
                )
                SELECT
                    'Cliente', c.ID_Cliente, c.ID_Usuario, c.Nombre, c.Apellido, c.DNI,
                    c.Fecha_Nacimiento, c.Email, c.Telefono, c.Direccion,
                    u.Nombre_Usuario, u.Password, u.ID_Rol
                FROM Cliente c
                JOIN Usuario u ON c.ID_Usuario = u.ID_Usuario
                WHERE c.ID_Cliente = ?
            ";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $idOriginal);
            $stmt->execute();
            $stmt->close();

            // 2. Backup Mascotas del Cliente (solo claves y relaciones)
            $sqlM = "
                INSERT INTO backup_mascotas (
                    ID_Mascota, ID_Cliente, Nombre_Mascota, Fecha_Nacimiento,
                    ID_Raza, ID_Especie
                )
                SELECT
                    m.ID_Mascota, m.ID_Cliente, m.Nombre, m.Fecha_Nacimiento,
                    r.ID_Raza, e.ID_Especie
                FROM Mascota m
                JOIN Raza r ON m.ID_Raza = r.ID_Raza
                JOIN Especie e ON r.ID_Especie = e.ID_Especie
                WHERE m.ID_Cliente = ?
            ";
            $stmtM = $conexion->prepare($sqlM);
            $stmtM->bind_param("i", $idOriginal);
            $stmtM->execute();
            $stmtM->close();

            // 3. Eliminar Mascotas
            $delMas = $conexion->prepare("DELETE FROM Mascota WHERE ID_Cliente = ?");
            $delMas->bind_param("i", $idOriginal);
            $delMas->execute();
            $delMas->close();

            // 4. Eliminar Cliente
            $delCli = $conexion->prepare("DELETE FROM Cliente WHERE ID_Cliente = ?");
            $delCli->bind_param("i", $idOriginal);
            $delCli->execute();
            $delCli->close();

            // 5. Eliminar Usuario
            $delUser = $conexion->prepare(
                "DELETE u FROM Usuario u
                 JOIN backup_usuarios b ON u.ID_Usuario = b.ID_Usuario
                 WHERE b.Tipo_Perfil = 'Cliente' AND b.ID_Original = ?"
            );
            $delUser->bind_param("i", $idOriginal);
            $delUser->execute();
            $delUser->close();
            break;

        case 4: // Proveedor
            // 1. Backup Proveedor + Usuario
            $sql = "
                INSERT INTO backup_usuarios (
                    Tipo_Perfil, ID_Original, ID_Usuario, Nombre, Apellido, DNI,
                    Fecha_Nacimiento, Email, Telefono, Direccion,
                    Nombre_Usuario, Password, ID_Rol
                )
                SELECT
                    'Proveedor', p.ID_Proveedor, p.ID_Usuario, p.Razon_Social, '' AS Apellido, '' AS DNI,
                    NULL AS Fecha_Nacimiento, p.Email, p.Telefono, p.Direccion,
                    u.Nombre_Usuario, u.Password, u.ID_Rol
                FROM Proveedor p
                JOIN Usuario u ON p.ID_Usuario = u.ID_Usuario
                WHERE p.ID_Proveedor = ?
            ";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $idOriginal);
            $stmt->execute();
            $stmt->close();

            // 2. Eliminar Proveedor
            $delProv = $conexion->prepare("DELETE FROM Proveedor WHERE ID_Proveedor = ?");
            $delProv->bind_param("i", $idOriginal);
            $delProv->execute();
            $delProv->close();

            // 3. Eliminar Usuario
            $delUser = $conexion->prepare(
                "DELETE u FROM Usuario u
                 JOIN backup_usuarios b ON u.ID_Usuario = b.ID_Usuario
                 WHERE b.Tipo_Perfil = 'Proveedor' AND b.ID_Original = ?"
            );
            $delUser->bind_param("i", $idOriginal);
            $delUser->execute();
            $delUser->close();
            break;
    }

    // Confirmar transacción
    $conexion->commit();
} catch (Exception $e) {
    $conexion->rollback();
    // Aquí podrías registrar $e->getMessage() en un log
}

// Redirigir de vuelta al listado
header('Location: admin_usuarios.php?rol=' . $rol);
exit;
