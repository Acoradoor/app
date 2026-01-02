<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Datos de prueba para verificar funcionamiento
$test_data = [
    [
        "1",
        "Cliente de prueba",
        "01/09/2025",
        "100.00",
        "pendiente",
        "<button class='btn btn-sm btn-primary'>Ver</button>"
    ],
    [
        "2", 
        "Otro cliente",
        "02/09/2025",
        "250.50",
        "confirmado",
        "<button class='btn btn-sm btn-primary'>Ver</button>"
    ]
];

echo json_encode(["data" => $test_data]);
?>