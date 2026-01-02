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
	
$id_factura3= $_SESSION['id_factura1'];
$numero_factura3= $_SESSION['numero_factura1'];
if (isset($_POST['id1'])){$id=intval($_POST['id1']);}
if (isset($_POST['cantidad'])){$cantidad=intval($_POST['cantidad']);}
if (isset($_POST['precio_venta'])){$precio_venta=floatval($_POST['precio_venta']);}

if (!empty($id) and !empty($cantidad))
{
 $insert_tmp = $conn->prepare("INSERT INTO detalle_factura (numero_factura, id_producto, cantidad, precio_venta) VALUES (?, ?, ?, ?)");
 $insert_tmp->execute([$numero_factura3, $id, $cantidad, $precio_venta]);

}
if (isset($_GET['id1']))//codigo elimina un elemento del array
{
$id_detalle=intval($_GET['id1']);	
$delete = $conn->prepare("DELETE FROM detalle_factura WHERE id_detalle = ?");
$delete->execute([$id_detalle]);
}
$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
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
	$sumador_total=0;
       
	 $sql = $conn->prepare("SELECT * FROM products, detalle_factura, facturas WHERE products.id_producto=detalle_factura.id_producto AND detalle_factura.numero_factura=facturas.numero_factura AND facturas.id_factura = ?");
        $sql->execute([$id_factura3]);
	while ($row = $sql->fetch(PDO::FETCH_ASSOC))
	{
	$id_detalle=$row["id_detalle"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad'];
	$nombre_producto=$row['nombre_producto'];
	$descuento=$row['descuento'];
	
	$precio_venta=$row['precio_venta'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	
		?>
		<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			<td class='text-center'><?php echo $cantidad;?></td>
			<td><?php echo $nombre_producto;?></td>
			<td class='text-right'><?php echo $precio_venta_f;?></td>
			<td class='text-right'><?php echo $precio_total_f;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_detalle ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
      
        $descuento1=number_format($descuento,2,'.','');
        $total_descuento=($subtotal * $descuento1 )/100;
        $total_descuento=number_format($total_descuento,2,'.','');
        
        $aplicar_descuento=$subtotal-$total_descuento;
        $aplicar_descuento1=number_format($aplicar_descuento,2);
	$total_iva=($aplicar_descuento * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$aplicar_descuento+$total_iva;
        $update = $conn->prepare("UPDATE facturas SET total_venta = ? WHERE id_factura = ?");
        $update->execute([$aplicar_descuento1, $id_factura3]);
?>
<tr>
        <td></td>
        <td></td>
        <td></td>
	<td class='text-right' >SUBTOTAL <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($subtotal,2);?></td>
	<td></td>
</tr>
<?php if ($descuento!="0"){echo  " 
<tr>
        <td></td>
        <td></td>
        <td></td>
	<td class='text-right' >DESCUENTO -($descuento)% $simbolo_moneda</td>
	<td class='text-right'>$total_descuento</td>
	<td></td>
</tr>";}?> 

<tr>
        <td></td>
        <td></td>
        <td></td>
	<td class='text-right' >IVA (<?php echo $impuesto;?>)% <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($total_iva,2);?></td>
	<td></td>
</tr>
<tr>
        <td></td>
        <td></td>
        <td></td>
	<td class='text-right' >TOTAL <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($total_factura,2);?></td>
	<td></td>
</tr>

</table>

