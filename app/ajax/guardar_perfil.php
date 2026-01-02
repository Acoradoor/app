<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

header('Content-Type: application/json');

if ($_POST) {
    try {
        // Recibir datos del perfil
        $id_perfil = $_POST['id_perfil'];
        $nombre_empresa = $_POST['nombre_empresa'];
        $direccion = $_POST['direccion'];
        $ciudad = $_POST['ciudad'];
        $codigo_postal = $_POST['codigo_postal'];
        $estado = $_POST['estado'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $cif = $_POST['cif'];
        $impuesto = $_POST['impuesto'];
        $moneda = $_POST['moneda'];
        $logo_url = $_POST['logo_url'];
        
        // Actualizar perfil
        $stmt = $conn->prepare("UPDATE perfil SET 
                                nombre_empresa = ?, 
                                direccion = ?, 
                                ciudad = ?, 
                                codigo_postal = ?, 
                                estado = ?, 
                                telefono = ?, 
                                email = ?, 
                                cif = ?, 
                                impuesto = ?, 
                                moneda = ?, 
                                logo_url = ? 
                                WHERE id_perfil = ?");
        $stmt->execute([
            $nombre_empresa, 
            $direccion, 
            $ciudad, 
            $codigo_postal, 
            $estado, 
            $telefono, 
            $email, 
            $cif, 
            $impuesto, 
            $moneda, 
            $logo_url, 
            $id_perfil
        ]);
        
        echo json_encode(['success' => true, 'message' => 'Perfil actualizado correctamente']);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar perfil: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>