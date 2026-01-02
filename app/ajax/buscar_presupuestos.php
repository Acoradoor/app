<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Consulta para obtener presupuestos
$sql = "SELECT p.id_presupuesto, c.nombre_cliente, p.fecha_presupuesto, p.total, p.estado
        FROM presupuestos p
        JOIN clientes c ON p.id_cliente = c.id_cliente
        ORDER BY p.fecha_presupuesto DESC";
$query = $conn->query($sql);

$data1 = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
    $sub_array = array();
    $sub_array[] = $row['id_presupuesto'];
    $sub_array[] = $row['nombre_cliente'];
    $sub_array[] = date("d/m/Y", strtotime($row['fecha_presupuesto']));
    $sub_array[] = $row['total'];
    $sub_array[] = $row['estado'];
    // Añadir botón de PDF
    $sub_array[] = '<button class="btn btn-sm btn-primary verPresupuesto" data-id="' . $row['id_presupuesto'] . '">Ver</button>' .
                   '<button class="btn btn-sm btn-success generar-pdf-presupuesto" data-id="' . $row['id_presupuesto'] . '">PDF</button>';
    $data1[] = $sub_array;
}

$new_array = array("data"=>$data1);
echo json_encode($new_array);
?>