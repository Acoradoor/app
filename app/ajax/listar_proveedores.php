<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Consulta para obtener proveedores
$sql = "SELECT id_proveedor, nombre_proveedor, telefono_proveedor, email_proveedor, cif, status_proveedor, date_added FROM proveedores ORDER BY date_added DESC";
$query = $conn->query($sql);

$data1 = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
    $sub_array = array();
    $sub_array[] = $row['id_proveedor'];
    $sub_array[] = $row['nombre_proveedor'];
    $sub_array[] = $row['telefono_proveedor'];
    $sub_array[] = $row['email_proveedor'];
    $sub_array[] = $row['cif'];
    $sub_array[] = $row['status_proveedor'] ? 'Activo' : 'Inactivo';
    $sub_array[] = date("d/m/Y H:i", strtotime($row['date_added']));
    $sub_array[] = '<button class="btn btn-sm btn-primary editar-proveedor" data-id="' . $row['id_proveedor'] . '">Editar</button>';
    $data1[] = $sub_array;
}

$new_array = array("data"=>$data1);
echo json_encode($new_array);
?>