<?php
// Configuración de conexión
$servername = "localhost";
$username = "acoradoor";
$password = "acoradoor1";
$dbname = "acoradoor2";

try {
    // Configuración adicional para mayor seguridad
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ];
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password, $options);
    
    // Verificar conexión
    $conn->query("SELECT 1");
    
} catch(PDOException $e) {
    error_log("Error de conexión: " . $e->getMessage());
    // En producción, muestra un mensaje genérico
    die("Error de conexión a la base de datos. Por favor, inténtelo más tarde.");
}
?>
