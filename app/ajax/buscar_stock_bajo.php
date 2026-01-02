<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Consulta para obtener productos con stock bajo
$sql = "SELECT p.id_producto, p.nombre_producto, p.cantidad, p.precio_producto
        FROM products p 
        WHERE p.cantidad < 10
        ORDER BY p.cantidad ASC";
$query = $conn->query($sql);

$data1 = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
    $sub_array = array();
    $sub_array[] = $row['id_producto'];
    $sub_array[] = $row['nombre_producto'];
    $sub_array[] = $row['cantidad'];
    $sub_array[] = '€' . number_format($row['precio_producto'], 2);
    $data1[] = $sub_array;
}

$new_array = array("data"=>$data1);
echo json_encode($new_array);
?>