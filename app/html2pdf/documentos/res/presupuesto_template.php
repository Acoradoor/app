<?php
// Asegurar que las variables estén definidas
if (!isset($presupuesto)) {
    $presupuesto = [
        'id_presupuesto' => '0',
        'nombre_cliente' => 'Cliente Desconocido',
        'direccion_cliente' => '',
        'cif' => '',
        'fecha_presupuesto' => date('Y-m-d'),
        'condiciones' => 'Sin especificar'
    ];
}

if (!isset($perfil)) {
    $perfil = [
        'nombre_empresa' => 'Empresa',
        'direccion' => 'Dirección',
        'ciudad' => 'Ciudad',
        'estado' => 'Estado',
        'telefono' => 'Teléfono',
        'email' => 'Email',
        'cif' => 'CIF',
        'moneda' => '€',
        'logo_url' => ''
    ];
}

// Incluir encabezado

?>

<style type="text/css">
<!--
div.zone {
    border: solid 0.5mm red;
    border-radius: 2mm;
    padding: 1mm;
    background-color: #FFF;
    color: #440000;
}
div.zone_over {
    width: 30mm;
    height: 20mm;
}
.midnight-blue {
    background: #2c3e50;
    padding: 4px 4px 4px;
    color: white;
    font-weight: bold;
    font-size: 12px;
}
.bordeado {
    border: solid 0.5mm #eee;
    border-radius: 1mm;
    padding: 0mm;
    font-size: 12px;
}
.table {
    border-spacing: 0;
    border-collapse: collapse;
}
.table-bordered td, .table-bordered th {
    padding: 3px;
    text-align: left;
    vertical-align: top;
}
.table-bordered {
    border: 0px solid #eee;
    border-collapse: separate;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}
.left {
    border-left: 1px solid #eee;
}
.top {
    border-top: 1px solid #eee;
}
.bottom {
    border-bottom: 1px solid #eee;
}
table.page_footer {
    width: 100%;
    border: none;
    background-color: white;
    padding: 2mm;
    border-collapse: collapse;
    border: none;
}
.page-header {
    margin: 0px 0 0px 0;
    font-size: 16px;
    padding: 4px;
    padding-top: -34px;
}
-->
</style>

<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 13px; font-family: helvetica">

<?php
include("encabezado_presupuesto.php");
?>
<br><br><br><br>

<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
    <tr>
        <td style="width:40%;" class='midnight-blue'>DATOS DEL CLIENTE</td>
    </tr>
    <tr>
        <td style="width:40%;">
            <?php
            echo "Nombre: ";
            echo htmlspecialchars($presupuesto['nombre_cliente']);
            echo "<br> Dirección:  ";
            echo htmlspecialchars($presupuesto['direccion_cliente']);
            echo "<br> CIF:  ";
            echo htmlspecialchars($presupuesto['cif']);
            ?>
        </td>
    </tr>
</table>
<br>
<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
    <tr>
        <td style="width:25%;" class='midnight-blue'>FECHA</td>
        <td style="width:40%;" class='midnight-blue'>CONDICIONES DE PAGO</td>
        <td style="width:35%;" class='midnight-blue'>VENCIMIENTO</td>
    </tr>
    <tr>
        <td style="width:25%;"><?php echo date("d/m/Y", strtotime($presupuesto['fecha_presupuesto']));?></td>
        <td style="width:40%;">
            <?php
            echo htmlspecialchars($presupuesto['condiciones']);
            ?>
        </td>
        <td style="width:35%;">
            <?php echo date("d/m/Y", strtotime($presupuesto['fecha_presupuesto'] . ' + 30 days'));?>
        </td>
    </tr>
</table>
<br><br><br>

<table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
    <tr>
        <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
        <th style="width: 60%" class='midnight-blue'>DESCRIPCION</th>
        <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO UNIT.</th>
        <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th>
    </tr>

<?php
$nums = 1;
$sumador_total = 0;

foreach ($detalles as $detalle) {
    $cantidad = $detalle['cantidad'];
    $nombre_producto = $detalle['nombre_producto'];
    $precio_unitario = $detalle['precio_unitario'];

    $precio_venta_f = number_format($precio_unitario, 2);
    $precio_venta_r = str_replace(",", "", $precio_venta_f);
    $precio_total = $precio_venta_r * $cantidad;
    $precio_total_f = number_format($precio_total, 2);
    $precio_total_r = str_replace(",", "", $precio_total_f);
    $sumador_total += $precio_total_r;

    if ($nums % 2 == 0) {
        $clase = "clouds";
    } else {
        $clase = "silver";
    }
?>

    <tr>
        <td class='<?php echo $clase;?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
        <td class='<?php echo $clase;?>' style="width: 60%; text-align: left"><?php echo htmlspecialchars($nombre_producto);?></td>
        <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_venta_f;?></td>
        <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_total_f;?></td>
    </tr>

<?php
    $nums++;
}

// Calcular impuestos y totales
$subtotal = number_format($sumador_total, 2, '.', '');
$descuento1 = number_format($descuento, 2, '.', '');
$total_descuento = ($subtotal * $descuento1) / 100;
$total_descuento = number_format($total_descuento, 2, '.', '');
$base_imponible = $subtotal - $total_descuento;
$base_imponible = number_format($base_imponible, 2);
$total_iva = ($base_imponible * $impuesto) / 100;
$total_iva = number_format($total_iva, 2, '.', '');
$total_presupuesto = $base_imponible + $total_iva;
?>

    <tr><td colspan="4"><br></td></tr>
    <tr>
        <td colspan="3" style=" text-align: right;"><strong>SUBTOTAL <?php echo $perfil['moneda'];?></strong> </td>
        <td style=" text-align: right;"> <?php echo number_format($subtotal, 2);?></td>
    </tr>
    <?php if ($descuento != "0") { echo "
    <tr>
        <td colspan='3' style=' text-align: right;'><strong>DESCUENTO - ($descuento)%  $perfil[moneda]</strong> </td>
        <td style=' text-align: right;'> " . number_format($total_descuento, 2) . "</td>
    </tr>"; } ?>
    <tr>
        <td colspan="3" style=" text-align: right;"><strong>IVA (<?php echo $impuesto; ?>)% <?php echo $perfil['moneda'];?></strong> </td>
        <td style=" text-align: right;"> <?php echo number_format($total_iva, 2);?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td colspan="1" style=" text-align: right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:16px">TOTAL <?php echo $perfil['moneda'];?> </td>
        <td style=" text-align: right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:16px"> <?php echo number_format($total_presupuesto, 2);?></td>
    </tr>
</table>
<br><br><br>
<div style="font-size:11pt;text-align:center;font-weight:bold">GRACIAS POR SU INTERÉS</div>

<page_footer>
    <table class="page_footer">
        <tr>
            <td style="width: 30%; text-align: left;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;">
                P&aacute;gina [[page_cu]]/[[page_nb]]
            </td>
            <td style="width: 40%; text-align: left;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;">
                IBAN:ES46 3159 0058 0230 7687 0421
            </td>
            <td style="width: 30%; text-align: right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;">
                &copy; <?php echo "AcoraDoor.com "; echo date('Y'); ?>
            </td>
        </tr>
    </table>
</page_footer>
</page>
