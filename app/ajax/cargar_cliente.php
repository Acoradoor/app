<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Verificar si se pasa un ID específico
$id_cliente = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_cliente > 0) {
    // Consulta para obtener el cliente
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
    $stmt->execute([$id_cliente]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($cliente);
} else {
    header('Content-Type: application/json');
    echo json_encode(null);
}
?>