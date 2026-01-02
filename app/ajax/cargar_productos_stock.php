<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}



// Consulta para obtener productos 
$sql100 = "SELECT  *  FROM products ORDER BY nombre_producto";
$query100 = $conn->query($sql100);

$data100 = array();
while ($row100 = $query100->fetch(PDO::FETCH_ASSOC)){
    $sub_array100 = array();
    $sub_array100[] = $row100['id_producto'];
    $sub_array100[] = $row100['codigo_producto'];
    $sub_array100[] = $row100['categoria'];
    $sub_array100[] = $row100['nombre_producto'];
    $sub_array100[] = $row100['cantidad'];
    $sub_array100[] = '€' . number_format($row100['precio_producto'], 2);
    $sub_array100[] = $row100['status_producto'];
    $data100[] = $sub_array100;
}

$new_array100 = array("data"=>$data100);
echo json_encode($new_array100);

?>
