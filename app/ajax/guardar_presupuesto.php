<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

header('Content-Type: application/json');

if ($_POST) {
    try {
        // Recibir datos del presupuesto
        $id_cliente = $_POST['id_cliente'];
        $id_vendedor = $_POST['id_vendedor'];
        $condiciones = $_POST['condiciones'];
        $descuento = $_POST['descuento'];
        $items = $_POST['items'];
        
        // Iniciar transacción
        $conn->beginTransaction();
        
        // Calcular total
        $total = 0;
        foreach ($items as $item) {
            $total += $item['cantidad'] * $item['precio'];
        }
        
        // Insertar presupuesto
        $stmt = $conn->prepare("INSERT INTO presupuestos (id_cliente, id_vendedor, condiciones, descuento, total, fecha_presupuesto) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$id_cliente, $id_vendedor, $condiciones, $descuento, $total]);
        $presupuesto_id = $conn->lastInsertId();
        
        // Insertar detalles
        foreach ($items as $item) {
            $stmt = $conn->prepare("INSERT INTO presupuesto_detalle (id_presupuesto, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
            $stmt->execute([$presupuesto_id, $item['id'], $item['cantidad'], $item['precio']]);
        }
        
        // Confirmar transacción
        $conn->commit();
        
        echo json_encode(['success' => true, 'message' => 'Presupuesto guardado correctamente', 'id_presupuesto' => $presupuesto_id]);
    } catch(PDOException $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error al guardar presupuesto: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>