<?php
// Función get_row corregida para usar PDO
function get_row($tabla, $campo, $campo_where, $valor) {
    global $conn; // Accede a la conexión PDO global
    
    if (!isset($conn)) {
        return null;
    }
    
    try {
        $sql = "SELECT $campo FROM $tabla WHERE $campo_where = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$valor]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result[$campo];
        }
        return null;
    } catch (PDOException $e) {
        error_log("Error en get_row: " . $e->getMessage());
        return null;
    }
}
?>
