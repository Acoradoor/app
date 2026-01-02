<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Consulta para obtener el perfil
$stmt = $conn->prepare("SELECT * FROM perfil WHERE id_perfil = 1");
$stmt->execute();
$perfil = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($perfil);
?>