<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Consulta para obtener productos
$sql = "SELECT id_producto, nombre_producto, precio_producto FROM products ORDER BY nombre_producto";
$query = $conn->query($sql);

$productos = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
    $productos[] = $row;
}

header('Content-Type: application/json');
echo json_encode($productos);
?>
