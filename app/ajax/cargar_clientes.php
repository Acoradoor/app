<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Consulta para obtener clientes
$sql = "SELECT id_cliente, nombre_cliente FROM clientes ORDER BY nombre_cliente";
$query = $conn->query($sql);

$clientes = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
    $clientes[] = $row;
}

header('Content-Type: application/json');
echo json_encode($clientes);
?>