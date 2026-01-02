<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

try {
    // Consulta para obtener clientes
    $sql = "SELECT id_cliente, nombre_cliente FROM clientes WHERE status_cliente = 1 ORDER BY nombre_cliente";
    $query = $conn->query($sql);
    
    $clientes = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $clientes[] = $row;
    }
    
    echo json_encode(array(
        "success" => true,
        "clientes" => $clientes
    ));
} catch (Exception $e) {
    echo json_encode(array(
        "success" => false,
        "message" => $e->getMessage()
    ));
}
?>
