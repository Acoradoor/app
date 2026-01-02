<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

header('Content-Type: application/json');

if ($_POST) {
    try {
        // Recibir datos del cliente
        $id_cliente = $_POST['id_cliente'];
        $nombre_cliente = $_POST['nombre_cliente'];
        $n_cuenta = $_POST['n_cuenta'];
        $telefono_cliente = $_POST['telefono_cliente'];
        $telefono_movil = $_POST['telefono_movil'];
        $email_cliente = $_POST['email_cliente'];
        $direccion_cliente = $_POST['direccion_cliente'];
        $pago = $_POST['pago'];
        $cif = $_POST['cif'];
        $status_cliente = $_POST['status_cliente'];
        
        // Actualizar cliente
        $stmt = $conn->prepare("UPDATE clientes SET nombre_cliente = ?, n_cuenta = ?, telefono_cliente = ?, telefono_movil = ?, email_cliente = ?, direccion_cliente = ?, pago = ?, cif = ?, status_cliente = ? WHERE id_cliente = ?");
        $stmt->execute([$nombre_cliente, $n_cuenta, $telefono_cliente, $telefono_movil, $email_cliente, $direccion_cliente, $pago, $cif, $status_cliente, $id_cliente]);
        
        echo json_encode(['success' => true, 'message' => 'Cliente actualizado correctamente']);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar cliente: ' . $e->getMessage()]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>