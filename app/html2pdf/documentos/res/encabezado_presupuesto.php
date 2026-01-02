<?php
// Asegurar que $presupuesto esté definida
if (!isset($presupuesto)) {
    $presupuesto = [
        'nombre_cliente' => 'Cliente',
        'fecha_presupuesto' => date('Y-m-d'),
        'condiciones' => 'Condiciones'
    ];
}

// Asegurar que $perfil esté definida
if (!isset($perfil)) {
    $perfil = [
        'nombre_empresa' => 'Nombre de Empresa',
        'direccion' => 'Dirección',
        'ciudad' => 'Ciudad',
        'estado' => 'Estado',
        'telefono' => 'Teléfono',
        'email' => 'Email',
        'cif' => 'CIF',
        'moneda' => '€'
    ];
}
?>

<table style="width:100%" class='page-header' cellspacing=0>
    <tr style="vertical-align: top">
        <td style="width:70%;border-bottom: 3px solid #2c3e50;padding:4px">
            PRESUPUESTO
        </td>
        <td style="width:30%;text-align:right;border-bottom: 3px solid #2c3e50;">
            <small>Nº PRESUPUESTO: PR/<?php echo $presupuesto['id_presupuesto'];?></small>
        </td>
    </tr>
</table>
<br>
<table cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 50%; color: #444444;">
            <img style="width: 80%;" src="../<?php echo $perfil['logo_url'];?>" alt="Logo"><br>
        </td>
        <td style="width: 50%; color: #34495e;font-size:12px;text-align:center">
            <span style="color: #34495e;font-size:14px;font-weight:bold"><?php echo htmlspecialchars($perfil['nombre_empresa']);?></span>
            <br><?php 
            echo htmlspecialchars($perfil['direccion']) . ", " . 
                htmlspecialchars($perfil['ciudad']) . " " . 
                htmlspecialchars($perfil['estado']); 
            ?><br> 
            Teléfono: <?php echo htmlspecialchars($perfil['telefono']);?><br>
            Email: <?php echo htmlspecialchars($perfil['email']);?><br>
            NIF: <?php echo htmlspecialchars($perfil['cif']);?>
        </td>
    </tr>
</table>
