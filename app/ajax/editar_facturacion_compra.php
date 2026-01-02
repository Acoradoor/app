<?php
	/*-------------------------
	Autor: Toni gallur 
	pagina ajax que se carga a la 
	pagina editar_factura.php llamada 
	por una funcion de la pagina 
	editar_factura_nueva.js
	---------------------------*/
	
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}
require_once("../funciones.php");	
	
$id_factura31= $_SESSION['id_factura11'];
$numero_factura31= $_SESSION['numero_factura11'];
if (isset($_POST['id11'])){$id1=intval($_POST['id11']);}
if (isset($_POST['cantidad1'])){$cantidad1=intval($_POST['cantidad1']);}
if (isset($_POST['precio_venta1'])){$precio_venta1=floatval($_POST['precio_venta1']);}

if (!empty($id1) and !empty($cantidad1))
{
 $insert_tmp1 = $conn->prepare("INSERT INTO detalle_factura (numero_factura, id_producto, cantidad, precio_venta) VALUES (?, ?, ?, ?)");
 $insert_tmp1->execute([$numero_factura31, $id1, $cantidad1, $precio_venta1]);

}
if (isset($_GET['id11']))//codigo elimina un elemento del array
{
$id_detalle1=intval($_GET['id11']);	
$delete1 = $conn->prepare("DELETE FROM detalle_factura WHERE id_detalle = ?");
$delete1->execute([$id_detalle1]);
}
$simbolo_moneda1=get_row('perfil','moneda', 'id_perfil', 1);
?>
<table class="table">
<tr>
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>CANT.</th>
	<th>DESCRIPCION</th>
	<th class='text-right'>PRECIO UNIT.</th>
	<th class='text-right'>PRECIO TOTAL</th>
	<th></th>
</tr>
<?php
	$sumador_total1=0;
       
	 $sql1 = $conn->prepare("SELECT * FROM products, detalle_factura_compras, facturas_compras WHERE products.id_producto=detalle_factura_compras.id_producto AND detalle_factura_compras.numero_factura_compra=facturas_compras.numero_factura_compra AND facturas_compras.id_factura_compra = ?");
        $sql1->execute([$id_factura31]);
	while ($rowcc = $sql1->fetch(PDO::FETCH_ASSOC))
	{
	$id_detallecc=$rowcc["id_detalle"];
	$codigo_productocc=$rowcc['codigo_producto'];
	$cantidadcc=$rowcc['cantidad'];
	$nombre_productocc=$rowcc['nombre_producto'];
	$descuentocc=$rowcc['descuento'];
	
	$precio_ventacc=$rowcc['precio_venta'];
	$precio_venta_fcc=number_format($precio_ventacc,2);//Formateo variables
	$precio_venta_rcc=str_replace(",","",$precio_venta_fcc);//Reemplazo las comas
	$precio_totalcc=$precio_venta_rcc*$cantidadcc;
	$precio_total_fcc=number_format($precio_totalcc,2);//Precio total formateado
	$precio_total_rcc=str_replace(",","",$precio_total_fcc);//Reemplazo las comas
	$sumador_totalcc+=$precio_total_rcc;//Sumador
	
		?>
		<tr>
			<td class='text-center'><?php echo $codigo_productocc;?></td>
			<td class='text-center'><?php echo $cantidadcc;?></td>
			<td><?php echo $nombre_productocc;?></td>
			<td class='text-right'><?php echo $precio_venta_fcc;?></td>
			<td class='text-right'><?php echo $precio_total_fcc;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_detallecc ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	$impuestocc=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotalcc=number_format($sumador_totalcc,2,'.','');
      
        $descuento1cc=number_format($descuentocc,2,'.','');
        $total_descuentocc=($subtotalcc * $descuento1cc )/100;
        $total_descuentocc=number_format($total_descuentocc,2,'.','');
        
        $aplicar_descuentocc=$subtotalcc-$total_descuentocc;
        $aplicar_descuento1cc=number_format($aplicar_descuentocc,2);
	$total_ivacc=($aplicar_descuentocc * $impuestocc )/100;
	$total_ivacc=number_format($total_ivacc,2,'.','');
	$total_facturacc=$aplicar_descuentocc+$total_ivacc;
        $update1 = $conn->prepare("UPDATE facturas SET total_venta = ? WHERE id_factura = ?");
        $update1->execute([$aplicar_descuento1cc, $id_factura31]);
?>
<tr>
        <td></td>
        <td></td>
        <td></td>
	<td class='text-right' >SUBTOTAL <?php echo $simbolo_moneda1;?></td>
	<td class='text-right'><?php echo number_format($subtotalcc,2);?></td>
	<td></td>
</tr>
<?php if ($descuentocc!="0"){echo  " 
<tr>
        <td></td>
        <td></td>
        <td></td>
	<td class='text-right' >DESCUENTO -($descuentocc)% $simbolo_moneda1</td>
	<td class='text-right'>$total_descuentocc</td>
	<td></td>
</tr>";}?> 

<tr>
        <td></td>
        <td></td>
        <td></td>
	<td class='text-right' >IVA (<?php echo $impuestocc;?>)% <?php echo $simbolo_moneda1;?></td>
	<td class='text-right'><?php echo number_format($total_ivacc,2);?></td>
	<td></td>
</tr>
<tr>
        <td></td>
        <td></td>
        <td></td>
	<td class='text-right' >TOTAL <?php echo $simbolo_moneda1;?></td>
	<td class='text-right'><?php echo number_format($total_facturacc,2);?></td>
	<td></td>
</tr>

</table>

