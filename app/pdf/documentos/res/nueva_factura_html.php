<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Obtener la conexión PDO
global $conn;

// Verificar que las variables necesarias estén definidas
if (!isset($numero_factura) || !isset($id_cliente) || !isset($session_id)) {
    die("Variables necesarias no definidas");
}
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
// Incluir encabezado
include("encabezado_factura.php"); 
?>
<br><br><br><br>

<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
    <tr>
        <td style="width:40%;" class='midnight-blue'>FACTURAR A</td>
    </tr>
    <tr>
        <td style="width:40%;">
            <?php 
            try {
                // Consulta PDO para obtener datos del cliente
                $sql_cliente = $conn->prepare("SELECT * FROM clientes WHERE id_cliente = :id_cliente");
                $sql_cliente->execute([':id_cliente' => $id_cliente]);
                $rw_cliente = $sql_cliente->fetch(PDO::FETCH_ASSOC);
                
                if ($rw_cliente) {
                    echo "Nombre: ";
                    echo $rw_cliente['nombre_cliente'];
                    echo "<br> Direccion:  ";
                    echo $rw_cliente['direccion_cliente'];
                    echo "<br> NIF / CIF:  ";
                    echo $rw_cliente['cif'];
                    echo "<br> Teléfono: ";
                    echo $rw_cliente['telefono_movil'];
                    echo "<br> Email: ";
                    echo $rw_cliente['email_cliente'];
                } else {
                    echo "Cliente no encontrado";
                }
            } catch (PDOException $e) {
                echo "Error al obtener datos del cliente";
            }
            ?>
        </td>
    </tr>
</table>
<br>
<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
    <tr>
        <td style="width:25%;" class='midnight-blue'>FECHA</td>
        <td style="width:40%;" class='midnight-blue'>FORMA DE PAGO</td>
    </tr>
    <tr>
        <td style="width:25%;"><?php echo date("d/m/Y");?></td>
        <td style="width:40%;">
            <?php 
            if ($condiciones == 1) { echo "Efectivo"; }
            elseif ($condiciones == 2) { echo "Cheque"; }
            elseif ($condiciones == 3) { echo "Transferencia bancaria"; }
            elseif ($condiciones == 4) { echo "Crédito"; }
            else { echo "No especificado"; }
            ?>
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

try {
    // Consulta PDO para obtener productos
    $sql = $conn->prepare("SELECT * FROM products, tmp WHERE products.id_producto = tmp.id_producto AND tmp.session_id = :session_id ORDER BY id_tmp DESC");
    $sql->execute([':session_id' => $session_id]);

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $id_tmp = $row["id_tmp"];
        $id_producto = $row["id_producto"];
        $codigo_producto = $row['codigo_producto'];
        $cantidad = $row['cantidad_tmp'];
        $nombre_producto = $row['nombre_producto'];
        $precio_venta = $row['precio_tmp'];
        
        $precio_venta_f = number_format($precio_venta, 2);
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
        // Insertar en detalle_factura usando PDO
        try {
            $insert_detail = $conn->prepare("INSERT INTO detalle_factura (numero_factura, id_producto, cantidad, precio_venta) VALUES (:numero_factura, :id_producto, :cantidad, :precio_venta)");
            $insert_detail->execute([
                ':numero_factura' => $numero_factura,
                ':id_producto' => $id_producto,
                ':cantidad' => $cantidad,
                ':precio_venta' => $precio_venta_r
            ]);
        } catch (PDOException $e) {
            // Solo registrar error pero no detener ejecución
            error_log("Error insertando detalle: " . $e->getMessage());
        }
        
        $nums++;
    }
} catch (PDOException $e) {
    echo "<tr><td colspan='4'>Error al obtener productos: " . $e->getMessage() . "</td></tr>";
}

// Calcular impuestos y totales
$impuesto = get_row('perfil', 'impuesto', 'id_perfil', 1) ?? 0;
$subtotal = number_format($sumador_total, 2, '.', '');
$descuento1 = number_format($descuento, 2, '.', '');
$total_descuento = ($subtotal * $descuento1) / 100;
$total_descuento = number_format($total_descuento, 2, '.', '');
$aplicar_descuento = $subtotal - $total_descuento;
$aplicar_descuento1 = number_format($aplicar_descuento, 2);
$total_iva = ($aplicar_descuento * $impuesto) / 100;
$total_iva = number_format($total_iva, 2, '.', '');
$total_factura = $aplicar_descuento + $total_iva;
?>
  
    <tr><td colspan="4"><br></td></tr>
    <tr>
        <td colspan="3" style=" text-align: right;"><strong>SUBTOTAL <?php echo $simbolo_moneda;?></strong> </td>
        <td style=" text-align: right;"> <?php echo number_format($subtotal, 2);?></td>
    </tr>
    <?php if ($descuento != "0") { echo " 
    <tr>
        <td colspan='3' style=' text-align: right;'><strong>DESCUENTO - ($descuento)%  $simbolo_moneda</strong> </td>
        <td style=' text-align: right;'> " . number_format($total_descuento, 2) . "</td>
    </tr>"; } ?> 
    <tr>
        <td colspan="3" style=" text-align: right;"><strong>IVA (<?php echo $impuesto; ?>)% <?php echo $simbolo_moneda;?></strong> </td>
        <td style=" text-align: right;"> <?php echo number_format($total_iva, 2);?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td colspan="1" style=" text-align: right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:16px">TOTAL <?php echo $simbolo_moneda;?> </td>
        <td style=" text-align: right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:16px"> <?php echo number_format($total_factura, 2);?></td>
    </tr>
</table>
<br><br><br>
<div style="font-size:11pt;text-align:center;font-weight:bold">GRACIAS POR SU CONFIANZA</div>

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

<?php
// Insertar factura usando PDO
try {
    $date = date("Y-m-d H:i:s");
    $insert = $conn->prepare("INSERT INTO facturas (numero_factura, fecha, id_cliente, id_vendedor, condiciones, aplicar_descuento, descuento, estado) VALUES (:numero_factura, :date, :id_cliente, :id_vendedor, :condiciones, :aplicar_descuento, :descuento, '2')");
    $insert->execute([
        ':numero_factura' => $numero_factura,
        ':date' => $date,
        ':id_cliente' => $id_cliente,
        ':id_vendedor' => $id_vendedor,
        ':condiciones' => $condiciones,
        ':aplicar_descuento' => $aplicar_descuento1,
        ':descuento' => $descuento
    ]);
} catch (PDOException $e) {
    error_log("Error insertando factura: " . $e->getMessage());
}

// Eliminar productos temporales usando PDO
try {
    $delete = $conn->prepare("DELETE FROM tmp WHERE session_id = :session_id");
    $delete->execute([':session_id' => $session_id]);
} catch (PDOException $e) {
    error_log("Error eliminando temporales: " . $e->getMessage());
}
?>
