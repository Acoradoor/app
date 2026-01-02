<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Consulta para obtener productos
$sql = "SELECT id_producto, codigo_producto, nombre_producto, categoria, cantidad, status_producto, precio_producto, date_added FROM products ORDER BY date_added DESC";
$query = $conn->query($sql);

$data1 = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
    $sub_array = array();
    $sub_array[] = $row['id_producto'];
    $sub_array[] = $row['codigo_producto'];
    $sub_array[] = $row['nombre_producto'];
    $sub_array[] = $row['categoria'];
    $sub_array[] = $row['cantidad'];
    $sub_array[] = $row['precio_producto'];
    $sub_array[] = $row['status_producto'] ? 'Activo' : 'Inactivo';
    $sub_array[] = date("d/m/Y H:i", strtotime($row['date_added']));
    $sub_array[] = '<button class="btn btn-sm btn-primary editar-producto" data-id="' . $row['id_producto'] . '">Editar</button>';
    $data1[] = $sub_array;
}

$new_array = array("data"=>$data1);
echo json_encode($new_array);
?>