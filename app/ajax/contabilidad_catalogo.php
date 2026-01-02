<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

try {
    // Consulta para obtener el catálogo de cuentas
    $sql = "SELECT sc.id_subcuenta, sc.codigo_subcuenta, sc.nombre_subcuenta, sc.tipo_subcuenta, 
                   CASE WHEN sc.tipo_subcuenta = 'cliente' THEN c.nombre_cliente 
                        WHEN sc.tipo_subcuenta = 'proveedor' THEN p.nombre_proveedor 
                        ELSE 'N/A' END as referencia
            FROM subcuentas_contables sc
            LEFT JOIN clientes c ON sc.referencia_id = c.id_cliente AND sc.tipo_subcuenta = 'cliente'
            LEFT JOIN proveedores p ON sc.referencia_id = p.id_proveedor AND sc.tipo_subcuenta = 'proveedor'
            WHERE sc.activo = 1
            ORDER BY sc.codigo_subcuenta";
    $query = $conn->query($sql);

    $data1 = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)){
        $sub_array = array();
        $sub_array[] = $row['codigo_subcuenta'];
        $sub_array[] = $row['nombre_subcuenta'];
        $sub_array[] = $row['tipo_subcuenta'];
        $sub_array[] = $row['referencia'];
        $sub_array[] = '<button class="btn btn-xs btn-info editar-subcuenta" data-id="'.$row['id_subcuenta'].'"><i class="fa fa-edit"></i></button>';
        $data1[] = $sub_array;
    }

    $new_array = array("data"=>$data1);
    echo json_encode($new_array);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
