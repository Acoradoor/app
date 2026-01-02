<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

header('Content-Type: application/json');

if ($_POST) {
    try {
        // Recibir datos del usuario
        $id_usuario = $_POST['id_usuario'];
        $usuario = $_POST['usuario'];
        $rol = $_POST['rol'];
        $activo = $_POST['activo'];
        $password = $_POST['password'];
        
        // Verificar si se quiere cambiar la contraseña
        if (!empty($password)) {
            // Hashear la nueva contraseña
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            // Actualizar usuario con nueva contraseña
            $stmt = $conn->prepare("UPDATE usuarios SET usuario = ?, rol = ?, activo = ?, password_hash = ? WHERE id = ?");
            $stmt->execute([$usuario, $rol, $activo, $password_hash, $id_usuario]);
        } else {
            // Actualizar usuario sin cambiar contraseña
            $stmt = $conn->prepare("UPDATE usuarios SET usuario = ?, rol = ?, activo = ? WHERE id = ?");
            $stmt->execute([$usuario, $rol, $activo, $id_usuario]);
        }
        
        echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar usuario: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>