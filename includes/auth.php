<?php
session_start();
require 'conexion.php';

// Función para registrar usuarios (solo admin)
function registrarUsuario($usuario, $password_plana, $rol) {
    global $conn;
    $hash = password_hash($password_plana, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password_hash, rol) VALUES (?, ?, ?)");
    return $stmt->execute([$usuario, $hash, $rol]);
}

// Función de login
function login($usuario, $password_plana) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, usuario, password_hash, rol FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password_plana, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_rol'] = $user['rol'];
        $_SESSION['user_name'] = $user['usuario'];
        return true;
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function logout() {
    session_unset();
    session_destroy();
}

// Ejemplo de uso al recibir POST del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = ['success' => false, 'error' => ''];
    
    if ($_POST['action'] === 'login') {
        if (login($_POST['usuario'], $_POST['password'])) {
            $response['success'] = true;
        } else {
            $response['error'] = 'Usuario o contraseña incorrectos';
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>