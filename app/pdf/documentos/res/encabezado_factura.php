<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Obtener todos los datos del perfil en una sola consulta
global $conn;
$perfil_data = [];

try {
    $stmt = $conn->prepare("SELECT * FROM perfil WHERE id_perfil = 1");
    $stmt->execute();
    $perfil_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($perfil_data === false) {
        $perfil_data = [];
    }
} catch (PDOException $e) {
    // Usar valores por defecto en caso de error
    $perfil_data = [
        'nombre_empresa' => 'Nombre de Empresa',
        'direccion' => 'Dirección',
        'ciudad' => 'Ciudad',
        'estado' => 'Estado',
        'telefono' => 'Teléfono',
        'email' => 'Email',
        'cif' => 'CIF'
    ];
}

// Asegurar que $numero_factura esté definida
if (!isset($numero_factura)) {
    $numero_factura = '0000';
}
?>

<table style="width:100%" class='page-header' cellspacing=0>
    <tr style="vertical-align: top">
        <td style="width:70%;border-bottom: 3px solid #2c3e50;padding:4px">
            FACTURA
        </td>
        <td style="width:30%;text-align:right;border-bottom: 3px solid #2c3e50;">
            <small>Nº FACTURA: FV/<?php echo $numero_factura;?></small>
        </td>
    </tr>
</table>
<br>
<table cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 50%; color: #444444;">
            <!-- Espacio vacío -->
        </td>
        <td style="width: 50%; color: #34495e;font-size:12px;text-align:center">
            <span style="color: #34495e;font-size:14px;font-weight:bold"><?php echo htmlspecialchars($perfil_data['nombre_empresa'] ?? '');?></span>
            <br><?php 
            echo htmlspecialchars($perfil_data['direccion'] ?? '') . ", " . 
                htmlspecialchars($perfil_data['ciudad'] ?? '') . " " . 
                htmlspecialchars($perfil_data['estado'] ?? ''); 
            ?><br> 
            Teléfono: <?php echo htmlspecialchars($perfil_data['telefono'] ?? '');?><br>
            Email: <?php echo htmlspecialchars($perfil_data['email'] ?? '');?><br>
            NIF: <?php echo htmlspecialchars($perfil_data['cif'] ?? '');?>
        </td>
    </tr>
</table>
