<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	background:#2c3e50;
	padding: 4px 4px 4px;
	color:white;
	font-weight:bold;
	font-size:12px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
       
	<?php include("encabezado_factura.php");?>
    <br><br><br><br>
    

	
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='midnight-blue'>FACTURAR A</td>
        </tr>
		<tr>
           <td style="width:50%;" >
			<?php 
				$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
				$rw_cliente=mysqli_fetch_array($sql_cliente);
				echo "Nombre: ";
				echo $rw_cliente['nombre_cliente'];
				echo "<br> Direccion: ";
				echo $rw_cliente['direccion_cliente'];
				echo "<br> NIF / CIF:  ";
				echo $rw_cliente['cif'];
				echo "<br> Teléfono: ";
				echo $rw_cliente['telefono_movil'];
				echo "<br> Email: ";
				echo $rw_cliente['email_cliente'];
			?>
			
		   </td>
        </tr>
        
   
    </table>
    
       <br>
		<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           
		  <td style="width:20%;" class='midnight-blue'>FECHA</td>
		   <td style="width:40%;" class='midnight-blue'>FORMA DE PAGO</td>
            <td style="width:20%;" class='midnight-blue'>FECHA DE PAGO</td>
        </tr>
		<tr>
                  
		  <td><?php echo date("d/m/Y", strtotime($fecha_factura));?></td>
                  <td><?php echo $condiciones;?></td>
                 <td><?php if ($condiciones=="Giro 30 Dias"){echo date("d/m/Y", strtotime($fecha_factura."+ 30 days"));}
                            if ($condiciones=="Giro 60 Dias"){echo date("d/m/Y", strtotime($fecha_factura."+ 60 days"));}
                            if ($condiciones=="Giro 30 y 60 Dias"){echo date("d/m/Y", strtotime($fecha_factura."+ 30 days")); echo"--" ; echo date("d/m/Y", strtotime($fecha_factura."+ 60 days"));}
                            if ($condiciones=="Efectivo"){echo date("d/m/Y", strtotime($fecha_factura));}
                            if ($condiciones=="Transferencia"){echo date("d/m/Y", strtotime($fecha_factura));}
                            if ($condiciones=="Pagare 30 Dias"){echo date("d/m/Y", strtotime($fecha_factura."+ 30 days"));}
                            if ($condiciones=="Pagare 60 Dias"){echo date("d/m/Y", strtotime($fecha_factura."+ 60 days"));}
                            if ($condiciones=="Pagare 90 Dias"){echo date("d/m/Y", strtotime($fecha_factura."+ 90 days"));}
                            if ($condiciones=="Confirming 60 Dias"){echo date("d/m/Y", strtotime($fecha_factura."+ 60 days"));}
                            if ($condiciones=="Confirming 120 Dias"){echo date("d/m/Y", strtotime($fecha_factura."+ 120 days"));}
                     ?></td>
        </tr>
		
        
   
    </table>
	<br>
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
            <th style="width: 60%" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th>
            
        </tr>

<?php
$nums=1;
$sumador_total=0;
$sql=mysqli_query($con, "select * from products, detalle_factura, facturas where products.id_producto=detalle_factura.id_producto and detalle_factura.numero_factura=facturas.numero_factura and facturas.id_factura='".$id_factura."'");

while ($row=mysqli_fetch_array($sql))
	{
	$id_producto=$row["id_producto"];
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
	if ($nums%2==0){
		$clase="clouds";
	} else {
		$clase="silver";
	}
	?>

        <tr>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase;?>' style="width: 60%; text-align: left"><?php echo $nombre_producto;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_venta_f;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_total_f;?></td>
            
        </tr>

	<?php 

	
	$nums++;
	}
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
        $descuento1=number_format($descuento,2,'.','');
        $total_descuento=($subtotal * $descuento1 )/100;
        $total_descuento=number_format($total_descuento,2,'.','');
        $total_descuento1=number_format($total_descuento,2);
        $aplicar_descuento=$subtotal-$total_descuento;
	$total_iva=($aplicar_descuento * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$aplicar_descuento+$total_iva;
?>
	  <tr><td> </td></tr>
        <tr><td> </td></tr>
         <tr><td> </td></tr>
        <tr><td> </td></tr>
         <tr><td> </td></tr>
        <tr><td> </td></tr>
         <tr><td> </td></tr>
        <tr><td> </td></tr>
        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;"><strong>SUBTOTAL <?php echo $simbolo_moneda;?></strong> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal,2);?></td>
        </tr>
          <?php if ($descuento!="0"){echo  " 

        <tr>
            <td colspan='3' style=' text-align: right;'><strong>DESCUENTO - ($descuento)%  $simbolo_moneda</strong> </td>
            <td style=' text-align: right;'> $total_descuento</td>
        </tr>";}?> 
           <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;"><strong>IVA (<?php echo $impuesto;?>)% <?php echo $simbolo_moneda;?></strong> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_iva,2);?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="1" style="text-align: right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:16px">TOTAL <?php echo $simbolo_moneda;?></td>
            <td style="text-align: right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:16px"> <?php echo number_format($total_factura,2);?></td>
        </tr>
    </table>
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
                    &copy; <?php echo "AcoraDoor.com "; echo  $anio=date('Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>

</page>
