
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
                <img style="width: 80%;" src="../../<?php echo get_row('perfil','logo_url', 'id_perfil', 1);?>" alt="Logo"><br>
                
            </td>
			<td style="width: 50%; color: #34495e;font-size:12px;text-align:center">
                <span style="color: #34495e;font-size:14px;font-weight:bold"><?php echo get_row('perfil','nombre_empresa', 'id_perfil', 1);?></span>
				<br><?php echo get_row('perfil','direccion', 'id_perfil', 1).", ". get_row('perfil','ciudad', 'id_perfil', 1)." ".get_row('perfil','estado', 'id_perfil', 1);?><br> 
				Teléfono: <?php echo get_row('perfil','telefono', 'id_perfil', 1);?><br>
				Email: <?php echo get_row('perfil','email', 'id_perfil', 1);?><br>
                                NIF: <?php echo get_row('perfil','cif', 'id_perfil', 1);?>
            </td>
			
			
        </tr>
    </table>
	
