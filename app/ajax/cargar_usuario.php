<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Usar el ID del usuario actual desde la sesión
$id_usuario = $_SESSION['user_id'];

// Consulta para obtener el usuario
$stmt = $conn->prepare("SELECT id, usuario, rol, activo FROM usuarios WHERE id = ?");
$stmt->execute([$id_usuario]);
$usuario1 = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($usuario1);
?>
