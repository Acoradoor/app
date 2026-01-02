<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

header('Content-Type: application/json');

if ($_POST) {
    try {
        $tipo_movimiento = $_POST['tipo_movimiento'];
        $concepto = $_POST['concepto'];
        $importe = $_POST['importe'];
        $id_cliente = $_POST['id_cliente'] ?? null;
        $id_categoria = $_POST['id_categoria'] ?? null;
        $referencia = $_POST['referencia'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        
        // Validar datos
        if (!$concepto || !$importe) {
            throw new Exception('Campos obligatorios no completados');
        }
        
        // Iniciar transacción
        $conn->beginTransaction();
        
        // Insertar movimiento
        $stmt = $conn->prepare("INSERT INTO movimientos_contables 
                               (tipo_movimiento, concepto, descripcion, importe, fecha_movimiento, id_cliente, id_usuario, referencia) 
                               VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)");
        $stmt->execute([
            $tipo_movimiento,
            $concepto,
            $descripcion,
            $importe,
            $id_cliente,
            $_SESSION['user_id'],
            $referencia
        ]);
        
        // Confirmar transacción
        $conn->commit();
        
        echo json_encode(['success' => true, 'message' => 'Movimiento contable guardado correctamente']);
    } catch(Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>