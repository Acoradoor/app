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
        $id_proveedor = $_POST['id_proveedor'];
        $nombre_proveedor = $_POST['nombre_proveedor'];
        $n_cuenta = $_POST['n_cuenta'];
        $telefono_proveedor = $_POST['telefono_proveedor'];
        $telefono_movil = $_POST['telefono_movil'];
        $email_proveedor = $_POST['email_proveedor'];
        $direccion_proveedor = $_POST['direccion_proveedor'];
        $pago = $_POST['pago'];
        $cif = $_POST['cif'];
        $status_proveedor = $_POST['status_proveedor'];
        
        // Actualizar proveedor
        $stmt = $conn->prepare("UPDATE proveedores SET nombre_proveedor = ?, n_cuenta = ?, telefono_proveedor = ?, telefono_movil = ?, email_proveedor = ?, direccion_proveedor = ?, pago = ?, cif = ?, status_proveedor = ? WHERE id_proveedor = ?");
        $stmt->execute([$nombre_proveedor, $n_cuenta, $telefono_proveedor, $telefono_movil, $email_proveedor, $direccion_proveedor, $pago, $cif, $status_proveedor, $id_proveedor]);
        
        echo json_encode(['success' => true, 'message' => 'Proveedor actualizado correctamente']);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar proveedor: ' . $e->getMessage()]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>