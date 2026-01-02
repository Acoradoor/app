<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

try {
    // Consulta para obtener pedidos
    $sql = "SELECT p.id_pedido, c.nombre_cliente, p.fecha_pedido, p.total, p.estado 
            FROM pedidos p 
            JOIN clientes c ON p.id_cliente = c.id_cliente 
            ORDER BY p.fecha_pedido DESC";
    
    $query = $conn->query($sql);
    
    $data1 = array();
    
    while ($row = $query->fetch(PDO::FETCH_ASSOC)){
        $sub_array = array();
        $sub_array[] = $row['id_pedido'];           // Columna 0
        $sub_array[] = $row['nombre_cliente'];      // Columna 1
        $sub_array[] = date("d/m/Y", strtotime($row['fecha_pedido'])); // Columna 2
        $sub_array[] = $row['total'];               // Columna 3
        $sub_array[] = $row['estado'];              // Columna 4
        $sub_array[] = '<button class="btn btn-sm btn-primary verPedido" data-id="' . $row['id_pedido'] . '">Ver</button>'; // Columna 5
        $data1[] = $sub_array;
    }

    // Formato correcto para DataTables
    $new_array = array("data"=>$data1);
    header('Content-Type: application/json');
    echo json_encode($new_array);
    
} catch(PDOException $e) {
    // En caso de error, devolver estructura vacía
    echo json_encode(["data" => []]);
    error_log("Error en buscar_pedidos.php: " . $e->getMessage());
}
?>
