<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Consulta para obtener usuarios
$sql = "SELECT id, usuario, rol, activo, creado_en FROM usuarios ORDER BY creado_en DESC";
$query = $conn->query($sql);

$data1 = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
    $sub_array = array();
    $sub_array[] = $row['id'];
    $sub_array[] = $row['usuario'];
    $sub_array[] = $row['rol'];
    $sub_array[] = $row['activo'] ? 'Sí' : 'No';
    $sub_array[] = date("d/m/Y H:i", strtotime($row['creado_en']));
    $sub_array[] = '<button class="btn btn-sm btn-primary editar-usuario" data-id="' . $row['id'] . '">Editar</button>';
    $data1[] = $sub_array;
}

$new_array = array("data"=>$data1);
echo json_encode($new_array);
?>