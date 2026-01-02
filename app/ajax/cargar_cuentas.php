<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

try {
    // Consulta para obtener cuentas contables
    $sql = "SELECT id_cuenta, codigo_cuenta, nombre_cuenta 
            FROM cuentas_contables 
            WHERE activo = 1 
            ORDER BY codigo_cuenta";
    $query = $conn->query($sql);
    
    $cuentas = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $cuentas[] = $row;
    }
    
    echo json_encode(array(
        "success" => true,
        "cuentas" => $cuentas
    ));
} catch (Exception $e) {
    echo json_encode(array(
        "success" => false,
        "message" => $e->getMessage()
    ));
}
?>