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
        $id_producto = $_POST['id_producto'];
        $codigo_producto = $_POST['codigo_producto'];
        $nombre_producto = $_POST['nombre_producto'];
        $categoria = $_POST['categoria'];
        $cantidad = $_POST['cantidad'];
        $status_producto = $_POST['status_producto'];
        $precio_producto = $_POST['precio_producto'];
        
        // Actualizar producto
        $stmt = $conn->prepare("UPDATE products SET codigo_producto = ?, nombre_producto = ?, categoria = ?, cantidad = ?, status_producto = ?, precio_producto = ? WHERE id_producto = ?");
        $stmt->execute([$codigo_producto, $nombre_producto, $categoria, $cantidad, $status_producto, $precio_producto, $id_producto]);
        
        echo json_encode(['success' => true, 'message' => 'Producto actualizado correctamente']);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar producto: ' . $e->getMessage()]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>