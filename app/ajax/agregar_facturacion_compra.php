<?php
/*-------------------------
Autor: Toni Gallur

---------------------------*/

/* Connect To Database*/
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}
$session_idcf = session_id();

if (isset($_POST['idcf'])){$idcf=$_POST['idcf'];}
if (isset($_POST['cantidadcf'])){$cantidadcf=$_POST['cantidadcf'];}
if (isset($_POST['precio_ventacf'])){$precio_ventacf=$_POST['precio_ventacf'];}

//Archivo de funciones PHP
include("../funciones.php");

if (!empty($idcf) and !empty($cantidadcf) and !empty($precio_ventacf))
{
    $insert_tmpcf = $conn->prepare("INSERT INTO tmp (id_producto, cantidad_tmp, precio_tmp, session_id) VALUES (?, ?, ?, ?)");
    $insert_tmpcf->execute([$idcf, $cantidadcf, $precio_ventacf, $session_idcf]);

}
if (isset($_GET['idncf']))//codigo elimina un elemento del array
{
$id_tmpcf=intval($_GET['idncf']);	
$deletecf = $conn->prepare("DELETE FROM tmp WHERE id_tmp = ?");
    $deletecf->execute([$id_tmpcf]);
}
$simbolo_monedacf=get_row('perfil','moneda', 'id_perfil', 1);
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
	$sumador_totalcf=0;
	$sqlcf = $conn->prepare("SELECT * FROM products, tmp WHERE products.id_producto=tmp.id_producto AND tmp.session_id=? ORDER BY id_tmp DESC");
        $sqlcf->execute([$session_idcf]);
	while ($rowcf = $sqlcf->fetch(PDO::FETCH_ASSOC))
	{
	$id_tmpcf=$rowcf["id_tmp"];
	$codigo_productocf=$rowcf['codigo_producto'];
	$cantidadcf=$rowcf['cantidad_tmp'];
	$nombre_productocf=$rowcf['nombre_producto'];
	
	
	$precio_ventacf=$rowcf['precio_tmp'];
	$precio_venta_fcf=number_format($precio_ventacf,2);//Formateo variables
	$precio_venta_rcf=str_replace(",","",$precio_venta_fcf);//Reemplazo las comas
	$precio_totalcf=$precio_venta_rcf*$cantidadcf;
	$precio_total_fcf=number_format($precio_totalcf,2);//Precio total formateado
	$precio_total_rcf=str_replace(",","",$precio_total_fcf);//Reemplazo las comas
	$sumador_totalcf+=$precio_total_rcf;//Sumador
	
		?>
		<tr>
			<td class='text-center'><?php echo $codigo_productocf;?></td>
			<td class='text-center'><?php echo $cantidadcf;?></td>
			<td><?php echo $nombre_productocf;?></td>
			<td class='text-right'><?php echo $precio_venta_fcf;?></td>
			<td class='text-right'><?php echo $precio_total_fcf;?></td>
			<td class='text-center'><a href="#" onclick="eliminar_compras('<?php echo $id_tmpcf ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	$impuestocf=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotalcf=number_format($sumador_totalcf,2,'.','');
	$total_ivacf=($subtotalcf * $impuestocf )/100;
	$total_ivacf=number_format($total_ivacf,2,'.','');
	$total_facturacf=$subtotalcf+$total_ivacf;

?>
<tr>
        <td></td>
        <td></td>
        <td></td>
	<td class='text-right' >SUBTOTAL <?php echo $simbolo_monedacf;?></td>
	<td class='text-right'><?php echo number_format($subtotalcf,2);?></td>
	<td></td>
</tr>
<tr>
        <td></td>
        <td></td>
        <td></td>
	<td class='text-right' >IVA (<?php echo $impuestocf;?>)% <?php echo $simbolo_monedacf;?></td>
	<td class='text-right'><?php echo number_format($total_ivacf,2);?></td>
	<td></td>
</tr>
<tr>
        <td></td>
        <td></td>
        <td></td>
	<td class='text-right'>TOTAL <?php echo $simbolo_monedacf;?></td>
	<td class='text-right'><?php echo number_format($total_facturacf,2);?></td>
	<td></td>
</tr>

</table>
<?php echo $session_idcf;?>
