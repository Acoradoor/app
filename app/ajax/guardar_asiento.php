<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

try {
    // Verificar que se hayan enviado todos los datos necesarios
    if (!isset($_POST['fecha']) || !isset($_POST['concepto']) || 
        !isset($_POST['cuenta_debe']) || !isset($_POST['cuenta_haber']) || 
        !isset($_POST['importe'])) {
        throw new Exception('Faltan datos requeridos');
    }
    
    // Recoger datos del formulario
    $fecha = $_POST['fecha'];
    $concepto = $_POST['concepto'];
    $cuenta_debe = $_POST['cuenta_debe'];
    $cuenta_haber = $_POST['cuenta_haber'];
    $importe = $_POST['importe'];
    $referencia = isset($_POST['referencia']) ? $_POST['referencia'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    
    // Obtener el ID del usuario actual (suponiendo que lo tienes en la sesión)
    $id_usuario = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; // Valor por defecto
    
    // Validar datos
    if (empty($fecha) || empty($concepto) || empty($cuenta_debe) || 
        empty($cuenta_haber) || empty($importe)) {
        throw new Exception('Todos los campos obligatorios deben estar completos');
    }
    
    if ($cuenta_debe == $cuenta_haber) {
        throw new Exception('Las cuentas de débito y crédito no pueden ser iguales');
    }
    
    // Insertar el movimiento contable
    $sql = "INSERT INTO movimientos_contables (fecha_movimiento, concepto, id_cuenta_debe, id_cuenta_haber, importe, referencia, descripcion, id_usuario) 
            VALUES (:fecha, :concepto, :cuenta_debe, :cuenta_haber, :importe, :referencia, :descripcion, :id_usuario)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':concepto', $concepto);
    $stmt->bindParam(':cuenta_debe', $cuenta_debe);
    $stmt->bindParam(':cuenta_haber', $cuenta_haber);
    $stmt->bindParam(':importe', $importe);
    $stmt->bindParam(':referencia', $referencia);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':id_usuario', $id_usuario);
    
    if ($stmt->execute()) {
        echo json_encode(array(
            "success" => true,
            "message" => "Asiento guardado correctamente"
        ));
    } else {
        throw new Exception('Error al guardar el asiento');
    }
    
} catch (Exception $e) {
    echo json_encode(array(
        "success" => false,
        "message" => $e->getMessage()
    ));
}
?>
