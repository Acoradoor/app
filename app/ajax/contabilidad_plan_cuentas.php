<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

try {
    // Consulta para obtener el plan de cuentas
    $sql = "SELECT id_cuenta, codigo_cuenta, nombre_cuenta, naturaleza, nivel, descripcion
            FROM cuentas_contables
            WHERE activo = 1
            ORDER BY codigo_cuenta";
    $query = $conn->query($sql);

    $data1 = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)){
        $sub_array = array();
        $sub_array[] = $row['codigo_cuenta'];
        $sub_array[] = $row['nombre_cuenta'];
        $sub_array[] = $row['naturaleza'];
        $sub_array[] = "Grupo " . $row['nivel']; // Grupo simplificado
        $sub_array[] = '<button class="btn btn-xs btn-info editar-cuenta" data-id="'.$row['id_cuenta'].'"><i class="fa fa-edit"></i></button>';
        $data1[] = $sub_array;
    }

    $new_array = array("data"=>$data1);
    echo json_encode($new_array);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
