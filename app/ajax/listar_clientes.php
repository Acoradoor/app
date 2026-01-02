<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Consulta para obtener clientes
$sql = "SELECT id_cliente, nombre_cliente, telefono_cliente, email_cliente, cif, status_cliente, date_added FROM clientes ORDER BY date_added DESC";
$query = $conn->query($sql);

$data1 = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
    $sub_array = array();
    $sub_array[] = $row['id_cliente'];
    $sub_array[] = $row['nombre_cliente'];
    $sub_array[] = $row['telefono_cliente'];
    $sub_array[] = $row['email_cliente'];
    $sub_array[] = $row['cif'];
    $sub_array[] = $row['status_cliente'] ? 'Activo' : 'Inactivo';
    $sub_array[] = date("d/m/Y H:i", strtotime($row['date_added']));
    $sub_array[] = '<button class="btn btn-sm btn-primary editar-cliente" data-id="' . $row['id_cliente'] . '">Editar</button>';
    $data1[] = $sub_array;
}

$new_array = array("data"=>$data1);
echo json_encode($new_array);
?>