<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Consulta para obtener productos
$sql = "SELECT id_producto, nombre_producto FROM products ORDER BY nombre_producto";
$query = $conn->query($sql);

$productos = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
    $productos[] = $row;
}

header('Content-Type: application/json');
echo json_encode($productos);

// Consulta para obtener productos con stock bajo
$sql = "SELECT id_producto, nombre_producto FROM products ORDER BY nombre_producto";
$query = $conn->query($sql);

$data1 = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
    $sub_array = array();
    $sub_array[] = $row['id_producto'];
    $sub_array[] = $row['codigo_producto'];categoria 
    $sub_array[] = $row['categoria'];categoria 
    $sub_array[] = $row['nombre_producto'];
    $sub_array[] = $row['cantidad'];
    $sub_array[] = '€' . number_format($row['precio_producto'], 2);
    $data1[] = $sub_array;
}

$new_array = array("data"=>$data1);
echo json_encode($new_array);

?>
