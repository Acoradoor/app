<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

try {
    // Consulta para obtener proveedores
    $sql = "SELECT id_proveedor, nombre_proveedor FROM proveedores WHERE status_proveedor = 1 ORDER BY nombre_proveedor";
    $query = $conn->query($sql);
    
    $proveedores = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $proveedores[] = $row;
    }
    
    echo json_encode(array(
        "success" => true,
        "proveedores" => $proveedores
    ));
} catch (Exception $e) {
    echo json_encode(array(
        "success" => false,
        "message" => $e->getMessage()
    ));
}
?>
