<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Verificar si se pasa un ID específico
$id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_producto > 0) {
    // Consulta para obtener el producto
    $stmt = $conn->prepare("SELECT * FROM products WHERE id_producto = ?");
    $stmt->execute([$id_producto]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($producto);
} else {
    header('Content-Type: application/json');
    echo json_encode(null);
}
?>