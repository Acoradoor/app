<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

header('Content-Type: application/json');

if ($_POST) {
    try {
        // Recibir datos de la factura de compra
        $numero_factura_compra = $_POST['numero_factura_compra'] ?? 0;
        $fecha_factura_compra = $_POST['fecha_factura_compra'] ?? date('Y-m-d H:i:s');
        $id_proveedor = $_POST['id_proveedor'];
        $id_vendedor = $_POST['id_vendedor'];
        $condiciones = $_POST['condiciones'];
        $total_venta = $_POST['total_venta'];
        $descuento = $_POST['descuento'];
        $estado_factura = $_POST['estado_factura'] ?? 1;
        $numero_pedido = $_POST['numero_pedido'] ?? '';
        $items = $_POST['items'] ?? [];
        
        // Verificar que la factura no exista
        $stmt = $conn->prepare("SELECT id_factura_compra FROM facturas_compras WHERE numero_factura_compra = ?");
        $stmt->execute([$numero_factura_compra]);
        if ($stmt->fetch()) {
            throw new Exception('La factura ya existe');
        }
        
        // Insertar factura de compra
        $stmt = $conn->prepare("INSERT INTO facturas_compras (numero_factura_compra, fecha_factura_compra, id_proveedor, id_vendedor, condiciones, total_venta, descuento, estado_factura, numero_pedido) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$numero_factura_compra, $fecha_factura_compra, $id_proveedor, $id_vendedor, $condiciones, $total_venta, $descuento, $estado_factura, $numero_pedido]);
        $id_factura = $conn->lastInsertId();
        
        // Insertar detalles
        foreach ($items as $item) {
            $stmt = $conn->prepare("INSERT INTO detalle_factura_compras (numero_factura_compra, id_producto, cantidad, precio_venta) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_factura, $item['id'], $item['cantidad'], $item['precio']]);
        }
        
        echo json_encode(['success' => true, 'message' => 'Factura de compra creada correctamente', 'id_factura' => $id_factura]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al crear factura de compra: ' . $e->getMessage()]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>