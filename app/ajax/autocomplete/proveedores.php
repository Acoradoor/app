<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

/* Connect To Database*/
require_once '../../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../../index.php");
    exit();
}

if (isset($_GET['term'])) {
    $return_arr = array();
    
    /* Si la conexión a la base de datos existe, ejecuta la sentencia SQL */
    if (isset($conn)) {
        // Usar PDO en lugar de MySQLi
        $term = $_GET['term'];
        $sql = "SELECT * FROM proveedores WHERE nombre_proveedor LIKE ? LIMIT 0, 50";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["%" . $term . "%"]);
        
        /* Recuperar y almacenar en array los resultados de la consulta */
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id_proveedor = $row['id_proveedor'];
            $row_array['value'] = $row['nombre_proveedor'];
            $row_array['id_proveedor'] = $id_proveedor;
            $row_array['nombre_proveedor'] = $row['nombre_proveedor'];
            $row_array['telefono_proveedor'] = $row['telefono_proveedor'];
            $row_array['email_proveedor'] = $row['email_proveedor'];
            $row_array['pago'] = $row['pago'];
            array_push($return_arr, $row_array);
        }
    }
    
    /* Liberar recursos de conexión */
    // No es necesario con PDO
    
    /* Devolver resultados como array codificado en JSON */
    echo json_encode($return_arr);
}
?>
