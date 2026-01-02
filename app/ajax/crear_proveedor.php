<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

header('Content-Type: application/json');

if ($_POST) {
    try {
        // Recibir datos del proveedor
        $nombre_proveedor = $_POST['nombre_proveedor'];
        $n_cuenta = $_POST['n_cuenta'];
        $telefono_proveedor = $_POST['telefono_proveedor'];
        $telefono_movil = $_POST['telefono_movil'];
        $email_proveedor = $_POST['email_proveedor'];
        $direccion_proveedor = $_POST['direccion_proveedor'];
        $pago = $_POST['pago'];
        $cif = $_POST['cif'];
        $status_proveedor = $_POST['status_proveedor'];
        
        // Verificar que el proveedor no exista
        $stmt = $conn->prepare("SELECT id_proveedor FROM proveedores WHERE nombre_proveedor = ?");
        $stmt->execute([$nombre_proveedor]);
        if ($stmt->fetch()) {
            throw new Exception('El nombre de proveedor ya existe');
        }
        
        // Insertar nuevo proveedor
        $stmt = $conn->prepare("INSERT INTO proveedores (nombre_proveedor, n_cuenta, telefono_proveedor, telefono_movil, email_proveedor, direccion_proveedor, pago, cif, status_proveedor, date_added) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$nombre_proveedor, $n_cuenta, $telefono_proveedor, $telefono_movil, $email_proveedor, $direccion_proveedor, $pago, $cif, $status_proveedor]);
        
        echo json_encode(['success' => true, 'message' => 'Proveedor creado correctamente']);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al crear proveedor: ' . $e->getMessage()]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>