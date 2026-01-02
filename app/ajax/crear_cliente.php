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
        $nombre_cliente = $_POST['nombre_cliente'];
        $n_cuenta = $_POST['n_cuenta'];
        $telefono_cliente = $_POST['telefono_cliente'];
        $telefono_movil = $_POST['telefono_movil'];
        $email_cliente = $_POST['email_cliente'];
        $direccion_cliente = $_POST['direccion_cliente'];
        $pago = $_POST['pago'];
        $cif = $_POST['cif'];
        $status_cliente = $_POST['status_cliente'];
        
        // Verificar que el cliente no exista
        $stmt = $conn->prepare("SELECT id_cliente FROM clientes WHERE nombre_cliente = ?");
        $stmt->execute([$nombre_cliente]);
        if ($stmt->fetch()) {
            throw new Exception('El nombre de cliente ya existe');
        }
        
        // Insertar nuevo cliente
        $stmt = $conn->prepare("INSERT INTO clientes (nombre_cliente, n_cuenta, telefono_cliente, telefono_movil, email_cliente, direccion_cliente, pago, cif, status_cliente, date_added) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$nombre_cliente, $n_cuenta, $telefono_cliente, $telefono_movil, $email_cliente, $direccion_cliente, $pago, $cif, $status_cliente]);
        
        echo json_encode(['success' => true, 'message' => 'Cliente creado correctamente']);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al crear cliente: ' . $e->getMessage()]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>