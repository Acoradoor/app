<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

try {
    // Consulta para obtener movimientos contables con paginación
    $sql = "SELECT mc.id_movimiento as numero_asiento, mc.fecha_movimiento as fecha, mc.concepto, 
                   cd.nombre_cuenta as cuenta_debe, ch.nombre_cuenta as cuenta_haber, 
                   mc.importe, mc.id_movimiento
            FROM movimientos_contables mc
            JOIN cuentas_contables cd ON mc.id_cuenta_debe = cd.id_cuenta
            JOIN cuentas_contables ch ON mc.id_cuenta_haber = ch.id_cuenta
            ORDER BY mc.fecha_movimiento DESC";
    
    // Para DataTables server-side processing
    $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $search = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
    
    // Variable para almacenar la condición WHERE
    $whereClause = "";
    $params = array();
    
    // Aplicar búsqueda si existe
    if (!empty($search)) {
        $whereClause = " WHERE mc.concepto LIKE :search OR cd.nombre_cuenta LIKE :search OR ch.nombre_cuenta LIKE :search";
        $params[':search'] = "%" . $search . "%";
    }
    
    // Construir la consulta completa para datos
    $sqlComplete = $sql . $whereClause . " LIMIT :start, :length";
    
    $query = $conn->prepare($sqlComplete);
    
    // Vincular parámetros de búsqueda si existen
    foreach ($params as $key => $value) {
        $query->bindValue($key, $value);
    }
    
    $query->bindValue(':start', $start, PDO::PARAM_INT);
    $query->bindValue(':length', $length, PDO::PARAM_INT);
    
    $query->execute();
    
    $data1 = array();
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($rows as $row) {
        $sub_array = array();
        $sub_array[] = $row['numero_asiento'];
        $sub_array[] = date("d/m/Y", strtotime($row['fecha']));
        $sub_array[] = $row['concepto'];
        $sub_array[] = $row['cuenta_debe'];
        $sub_array[] = $row['cuenta_haber'];
        $sub_array[] = $row['importe'];
        $sub_array[] = '<button class="btn btn-xs btn-info ver-asiento" data-id="'.$row['id_movimiento'].'"><i class="fa fa-eye"></i></button>
                       <button class="btn btn-xs btn-warning editar-asiento" data-id="'.$row['id_movimiento'].'"><i class="fa fa-edit"></i></button>
                       <button class="btn btn-xs btn-danger eliminar-asiento" data-id="'.$row['id_movimiento'].'"><i class="fa fa-trash"></i></button>';
        $data1[] = $sub_array;
    }
    
    // Contar total de registros
    $count_sql = "SELECT COUNT(*) FROM movimientos_contables mc
                  JOIN cuentas_contables cd ON mc.id_cuenta_debe = cd.id_cuenta
                  JOIN cuentas_contables ch ON mc.id_cuenta_haber = ch.id_cuenta";
    
    if (!empty($search)) {
        $count_sql .= " WHERE mc.concepto LIKE :search OR cd.nombre_cuenta LIKE :search OR ch.nombre_cuenta LIKE :search";
    }
    
    $count_query = $conn->prepare($count_sql);
    if (!empty($search)) {
        $searchParam = "%".$search."%";
        $count_query->bindValue(':search', $searchParam);
    }
    $count_query->execute();
    $total_records = $count_query->fetchColumn();
    
    // Asegurarse de que siempre haya un valor válido para recordsFiltered
    $records_filtered = $total_records;
    
    $new_array = array(
        "draw" => $draw,
        "recordsTotal" => $total_records,
        "recordsFiltered" => $records_filtered,
        "data" => $data1
    );
    
    header('Content-Type: application/json');
    echo json_encode($new_array);
    
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage()));
}
?>
