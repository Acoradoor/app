<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

try {
    // Debug: Mostrar qué parámetros llegan
    error_log("Parámetros recibidos: " . print_r($_POST, true));
    
    // Consulta para obtener el movimiento de cuentas con paginación
    $sql = "SELECT cc.id_cuenta, cc.nombre_cuenta, cc.codigo_cuenta,
                   COALESCE(SUM(CASE WHEN mc.id_cuenta_debe = cc.id_cuenta THEN mc.importe ELSE 0 END), 0) as total_debitos,
                   COALESCE(SUM(CASE WHEN mc.id_cuenta_haber = cc.id_cuenta THEN mc.importe ELSE 0 END), 0) as total_creditos,
                   (COALESCE(SUM(CASE WHEN mc.id_cuenta_debe = cc.id_cuenta THEN mc.importe ELSE 0 END), 0) - 
                    COALESCE(SUM(CASE WHEN mc.id_cuenta_haber = cc.id_cuenta THEN mc.importe ELSE 0 END), 0)) as saldo_final
            FROM cuentas_contables cc
            LEFT JOIN movimientos_contables mc ON (mc.id_cuenta_debe = cc.id_cuenta OR mc.id_cuenta_haber = cc.id_cuenta)
            WHERE cc.activo = 1
            GROUP BY cc.id_cuenta, cc.nombre_cuenta, cc.codigo_cuenta
            ORDER BY cc.codigo_cuenta";
    
    // Para DataTables server-side processing
    $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $search = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
    
    error_log("Variables: draw=$draw, start=$start, length=$length, search=$search");
    
    // Variable para almacenar la condición WHERE
    $whereClause = "";
    $params = array();
    
    // Aplicar búsqueda si existe
    if (!empty($search)) {
        $whereClause = " HAVING cc.nombre_cuenta LIKE :search OR cc.codigo_cuenta LIKE :search";
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
    error_log("Filas encontradas: " . count($rows));
    
    foreach ($rows as $row) {
        $sub_array = array();
        $sub_array[] = $row['codigo_cuenta'] . ' - ' . $row['nombre_cuenta'];
        $sub_array[] = "0.00"; // Saldo inicial (puede ser calculado)
        $sub_array[] = $row['total_debitos'];
        $sub_array[] = $row['total_creditos'];
        $sub_array[] = $row['saldo_final'];
        $sub_array[] = '<button class="btn btn-xs btn-info ver-mayor" data-id="'.$row['id_cuenta'].'"><i class="fa fa-eye"></i></button>';
        $data1[] = $sub_array;
    }
    
    // Contar total de registros
    $count_sql = "SELECT COUNT(*) FROM (
        SELECT cc.id_cuenta, cc.nombre_cuenta, cc.codigo_cuenta
        FROM cuentas_contables cc
        LEFT JOIN movimientos_contables mc ON (mc.id_cuenta_debe = cc.id_cuenta OR mc.id_cuenta_haber = cc.id_cuenta)
        WHERE cc.activo = 1
        GROUP BY cc.id_cuenta, cc.nombre_cuenta, cc.codigo_cuenta
    ) as cuentas";
    
    if (!empty($search)) {
        $count_sql = "SELECT COUNT(*) FROM (
            SELECT cc.id_cuenta, cc.nombre_cuenta, cc.codigo_cuenta
            FROM cuentas_contables cc
            LEFT JOIN movimientos_contables mc ON (mc.id_cuenta_debe = cc.id_cuenta OR mc.id_cuenta_haber = cc.id_cuenta)
            WHERE cc.activo = 1
            GROUP BY cc.id_cuenta, cc.nombre_cuenta, cc.codigo_cuenta
            HAVING cc.nombre_cuenta LIKE :search OR cc.codigo_cuenta LIKE :search
        ) as cuentas";
    }
    
    $count_query = $conn->prepare($count_sql);
    if (!empty($search)) {
        $searchParam = "%".$search."%";
        $count_query->bindValue(':search', $searchParam);
    }
    $count_query->execute();
    $total_records = $count_query->fetchColumn();
    
    error_log("Total registros: $total_records");
    
    $new_array = array(
        "draw" => $draw,
        "recordsTotal" => $total_records,
        "recordsFiltered" => $total_records,
        "data" => $data1
    );
    
    error_log("JSON retornado: " . json_encode($new_array));
    
    header('Content-Type: application/json');
    echo json_encode($new_array);
    
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(array("error" => $e->getMessage()));
}
?>
