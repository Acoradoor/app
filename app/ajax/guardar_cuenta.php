<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

try {
    // Verificar que se hayan enviado todos los datos necesarios
    if (!isset($_POST['codigo_cuenta']) || !isset($_POST['nombre_cuenta']) || 
        !isset($_POST['naturaleza']) || !isset($_POST['nivel'])) {
        throw new Exception('Faltan datos requeridos');
    }
    
    // Recoger datos del formulario
    $codigo_cuenta = $_POST['codigo_cuenta'];
    $nombre_cuenta = $_POST['nombre_cuenta'];
    $naturaleza = $_POST['naturaleza'];
    $nivel = $_POST['nivel'];
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    
    // Validar datos
    if (empty($codigo_cuenta) || empty($nombre_cuenta) || empty($naturaleza) || empty($nivel)) {
        throw new Exception('Todos los campos obligatorios deben estar completos');
    }
    
    // Verificar que el código de cuenta no exista
    $check_sql = "SELECT id_cuenta FROM cuentas_contables WHERE codigo_cuenta = :codigo";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':codigo', $codigo_cuenta);
    $check_stmt->execute();
    
    if ($check_stmt->rowCount() > 0) {
        throw new Exception('Ya existe una cuenta con ese código');
    }
    
    // Insertar la nueva cuenta contable
    $sql = "INSERT INTO cuentas_contables (codigo_cuenta, nombre_cuenta, naturaleza, nivel, descripcion, activo) 
            VALUES (:codigo, :nombre, :naturaleza, :nivel, :descripcion, 1)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo', $codigo_cuenta);
    $stmt->bindParam(':nombre', $nombre_cuenta);
    $stmt->bindParam(':naturaleza', $naturaleza);
    $stmt->bindParam(':nivel', $nivel);
    $stmt->bindParam(':descripcion', $descripcion);
    
    if ($stmt->execute()) {
        echo json_encode(array(
            "success" => true,
            "message" => "Cuenta guardada correctamente"
        ));
    } else {
        throw new Exception('Error al guardar la cuenta');
    }
    
} catch (Exception $e) {
    echo json_encode(array(
        "success" => false,
        "message" => $e->getMessage()
    ));
}
?>