<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Consulta para obtener movimientos de stock
$sql = "SELECT ms.id_movimiento, p.nombre_producto, ms.tipo_movimiento, ms.cantidad, ms.referencia, 
               ms.fecha_movimiento, u.usuario as usuario_movimiento, ms.descripcion
        FROM movimientos_stock ms
        JOIN products p ON ms.id_producto = p.id_producto
        JOIN usuarios u ON ms.usuario = u.id
        ORDER BY ms.fecha_movimiento DESC
        LIMIT 50";
$query = $conn->query($sql);

$data1 = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
    $sub_array = array();
    $sub_array[] = $row['id_movimiento'];
    $sub_array[] = $row['nombre_producto'];
    $sub_array[] = $row['tipo_movimiento'] == 'entrada' ? '<span class="badge bg-success">Entrada</span>' : '<span class="badge bg-danger">Salida</span>';
    $sub_array[] = $row['cantidad'];
    $sub_array[] = $row['referencia'];
    $sub_array[] = date("d/m/Y H:i", strtotime($row['fecha_movimiento']));
    $sub_array[] = $row['usuario_movimiento'];
    $sub_array[] = $row['descripcion'];
    $data1[] = $sub_array;
}

$new_array = array("data"=>$data1);
echo json_encode($new_array);
?>
