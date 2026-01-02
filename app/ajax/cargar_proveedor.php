<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Verificar si se pasa un ID específico
$id_proveedor = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_proveedor > 0) {
    // Consulta para obtener el proveedor
    $stmt = $conn->prepare("SELECT * FROM proveedores WHERE id_proveedor = ?");
    $stmt->execute([$id_proveedor]);
    $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($proveedor);
} else {
    header('Content-Type: application/json');
    echo json_encode(null);
}
?>