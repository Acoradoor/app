<?php

      /*-------------------------
	Autor: Toni gallur
	
	pagina ajax que se carga en
	index.php lamado por una funcion
	en jquery.init.js 
	---------------------------*/
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}
	                include("../modal/registro_clientes.php");
			include("../modal/registro_productos.php");
			 include("../modal/buscar_productos.php");
	?>
 
			<form class="form-horizontal" role="form" id="datos_factura_nueva">
				<div class="form-group row">
				  <label for="nombre_cliente9" class="col-md-1 control-label">Cliente</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente9" placeholder="Selecciona un cliente" required>
					  <input id="id_cliente9" type='hidden'>	
				  </div>
				  <label for="tel19" class="col-md-1 control-label">Teléfono</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="tel19" placeholder="Teléfono" readonly>
							</div>
					<label for="mail9" class="col-md-1 control-label">Email</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="mail9" placeholder="Email" readonly>
							</div>
				 </div>
						<div class="form-group row">
							<label for="empresa9" class="col-md-1 control-label">Vendedor</label>
							<div class="col-md-3">
								<select class="form-control input-sm" id="id_vendedor9">
									<?php
										$sql_vendedor = $conn->query("select * from users order by lastname");
										while ($rw = $sql_vendedor->fetch(PDO::FETCH_ASSOC)){
											$id_vendedor=$rw["user_id"];
											$nombre_vendedor=$rw["firstname"]." ".$rw["lastname"];
											if ($id_vendedor==$_SESSION['user_id']){
												$selected="selected";
											} else {
												$selected="";
											}
											?>
											<option value="<?php echo $id_vendedor?>" <?php echo $selected;?>><?php echo $nombre_vendedor?></option>
											<?php
										}
									?>
								</select>
							</div>
							<label for="fecha9" class="col-md-1 control-label">Fecha</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="fecha9" value="<?php echo date("d/m/Y");?>" readonly>
							</div>
							<label for="condiciones9" class="col-md-1 control-label">Pago</label>
							<div class="col-md-3">
								<select class='form-control input-sm' id="condiciones9">
									<option value="1">Efectivo</option>
									<option value="2">Cheque</option>
									<option value="3">Transferencia bancaria</option>
									<option value="4">Crédito</option>
								</select>
							</div>
						</div>
				                <div class="form-group row"> 
                                                             <label for="descuento9" class="col-md-1 control-label">Descuento</label>
							 <div class="col-md-2">
								<input type="text" class="form-control input-sm" id="descuento9" name="descuento" value="0">
							</div>
						</div>
				
				<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#registro_producto">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#nuevoCliente">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="button" class="btn btn-default"id="mostrario" >
						  <span class="glyphicon glyphicon-print"></span> Guardar y Imprimir
						</button>
					</div>	
				</div>
			</form>	
			
		<div id="resultados4" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
<script type="text/javascript" src="../assets/js/ajax/VentanaCentrada.js"></script>		
<script type="text/javascript" src="../assets/js/ajax/nueva_factura.js"></script>	
	
<script>
		$(function() {
						$("#nombre_cliente9").autocomplete({
							source: "../ajax/autocomplete/clientes.php",
							minLength: 2,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente9').val(ui.item.id_cliente);
								$('#nombre_cliente9').val(ui.item.nombre_cliente);
								$('#tel19').val(ui.item.telefono_cliente);
								$('#mail9').val(ui.item.email_cliente);
																
								
							 }
						});
						 
						
					});
					
	$("#nombre_cliente9" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente9" ).val("");
							$("#tel19" ).val("");
							$("#mail9" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente9" ).val("");
							$("#id_cliente9" ).val("");
							$("#tel19" ).val("");
							$("#mail9" ).val("");
						}
			});	
	</script>	
   
	
 
