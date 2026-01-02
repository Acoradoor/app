<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

header('Content-Type: application/json');

if ($_POST) {
    try {
        // Recibir datos del pedido
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
        
        // Insertar pedido
        $stmt = $conn->prepare("INSERT INTO pedidos (id_cliente, id_vendedor, condiciones, descuento, total, fecha_pedido) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$id_cliente, $id_vendedor, $condiciones, $descuento, $total]);
        $pedido_id = $conn->lastInsertId();
        
        // Insertar detalles
        foreach ($items as $item) {
            $stmt = $conn->prepare("INSERT INTO pedido_detalle (id_pedido, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
            $stmt->execute([$pedido_id, $item['id'], $item['cantidad'], $item['precio']]);
        }
        
        // Confirmar transacción
        $conn->commit();
        
        echo json_encode(['success' => true, 'message' => 'Pedido guardado correctamente', 'id_pedido' => $pedido_id]);
    } catch(PDOException $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error al guardar pedido: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>
