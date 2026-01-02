<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

try {
    // Verificar que se hayan enviado todos los datos necesarios
    if (!isset($_POST['codigo_subcuenta']) || !isset($_POST['nombre_subcuenta']) || 
        !isset($_POST['tipo_subcuenta']) || !isset($_POST['referencia_id'])) {
        throw new Exception('Faltan datos requeridos');
    }
    
    // Recoger datos del formulario
    $codigo_subcuenta = $_POST['codigo_subcuenta'];
    $nombre_subcuenta = $_POST['nombre_subcuenta'];
    $tipo_subcuenta = $_POST['tipo_subcuenta'];
    $referencia_id = $_POST['referencia_id'];
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    
    // Validar datos
    if (empty($codigo_subcuenta) || empty($nombre_subcuenta) || empty($tipo_subcuenta) || empty($referencia_id)) {
        throw new Exception('Todos los campos obligatorios deben estar completos');
    }
    
    // Verificar que el código de subcuenta no exista
    $check_sql = "SELECT id_subcuenta FROM subcuentas_contables WHERE codigo_subcuenta = :codigo";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':codigo', $codigo_subcuenta);
    $check_stmt->execute();
    
    if ($check_stmt->rowCount() > 0) {
        throw new Exception('Ya existe una subcuenta con ese código');
    }
    
    // Insertar la nueva subcuenta contable
    $sql = "INSERT INTO subcuentas_contables (codigo_subcuenta, nombre_subcuenta, tipo_subcuenta, referencia_id, descripcion, activo) 
            VALUES (:codigo, :nombre, :tipo, :referencia, :descripcion, 1)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo', $codigo_subcuenta);
    $stmt->bindParam(':nombre', $nombre_subcuenta);
    $stmt->bindParam(':tipo', $tipo_subcuenta);
    $stmt->bindParam(':referencia', $referencia_id);
    $stmt->bindParam(':descripcion', $descripcion);
    
    if ($stmt->execute()) {
        echo json_encode(array(
            "success" => true,
            "message" => "Subcuenta guardada correctamente"
        ));
    } else {
        throw new Exception('Error al guardar la subcuenta');
    }
    
} catch (Exception $e) {
    echo json_encode(array(
        "success" => false,
        "message" => $e->getMessage()
    ));
}
?>