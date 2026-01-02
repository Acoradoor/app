<?php
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo'])) {
    try {
        $uploadDir = '../images/';
        $uploadUrl = 'images/';
        
        // Verificar que el directorio de subida exista
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $file = $_FILES['logo'];
        $fileName = basename($file['name']);
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];
        
        // Verificar errores de subida
        if ($fileError !== UPLOAD_ERR_OK) {
            throw new Exception('Error al subir el archivo');
        }
        
        // Verificar tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception('Tipo de archivo no permitido. Solo se permiten JPG, PNG y GIF.');
        }
        
        // Verificar tamaño (máximo 5MB)
        $maxFileSize = 5 * 1024 * 1024; // 5MB
        if ($fileSize > $maxFileSize) {
            throw new Exception('El archivo excede el tamaño máximo permitido (5MB).');
        }
        
        // Generar nombre único
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFileName = uniqid('logo_', true) . '.' . $fileExtension;
        $uploadPath = $uploadDir . $newFileName;
        $uploadUrlPath = $uploadUrl . $newFileName;
        
        // Mover archivo
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            echo json_encode([
                'success' => true, 
                'message' => 'Imagen subida correctamente',
                'url' => $uploadUrlPath
            ]);
        } else {
            throw new Exception('Error al mover el archivo subido.');
        }
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false, 
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Método de solicitud no válido o archivo no proporcionado'
    ]);
}
?>