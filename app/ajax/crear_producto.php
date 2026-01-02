<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

header('Content-Type: application/json');

if ($_POST) {
    try {
        // Recibir datos del producto
        $codigo_producto = $_POST['codigo_producto'];
        $nombre_producto = $_POST['nombre_producto'];
        $categoria = $_POST['categoria'];
        $cantidad = $_POST['cantidad'];
        $status_producto = $_POST['status_producto'];
        $precio_producto = $_POST['precio_producto'];
        
        // Verificar que el código de producto no exista
        $stmt = $conn->prepare("SELECT id_producto FROM products WHERE codigo_producto = ?");
        $stmt->execute([$codigo_producto]);
        if ($stmt->fetch()) {
            throw new Exception('El código de producto ya existe');
        }
        
        // Insertar nuevo producto
        $stmt = $conn->prepare("INSERT INTO products (codigo_producto, nombre_producto, categoria, cantidad, status_producto, date_added, precio_producto) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
        $stmt->execute([$codigo_producto, $nombre_producto, $categoria, $cantidad, $status_producto, $precio_producto]);
        
        echo json_encode(['success' => true, 'message' => 'Producto creado correctamente']);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al crear producto: ' . $e->getMessage()]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>