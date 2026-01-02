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
	
	
if (isset($_POST['id'])){
      $numero_factura = $_POST['id'];
      $rest = substr($numero_factura, 2);
      $sql = "SELECT * FROM facturas WHERE numero_factura = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$rest]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $id_factura1 = $row['id_factura'];
      $campos="clientes.id_cliente, clientes.nombre_cliente, clientes.telefono_cliente, clientes.email_cliente, facturas.id_vendedor, facturas.fecha_factura, facturas.condiciones, facturas.estado_factura, facturas.numero_factura, facturas.descuento";
      // Usar PDO para esta consulta también
    $sql_factura = $conn->prepare("SELECT $campos FROM facturas, clientes WHERE facturas.id_cliente = clientes.id_cliente AND id_factura = ?");
    $sql_factura->execute([$id_factura1]);
    $count = $sql_factura->rowCount();
      if ($count==1)
		{
				$rw_factura = $sql_factura->fetch(PDO::FETCH_ASSOC);
				$id_cliente=$rw_factura['id_cliente'];
				$nombre_cliente=$rw_factura['nombre_cliente'];
				$telefono_cliente=$rw_factura['telefono_cliente'];
				$email_cliente=$rw_factura['email_cliente'];
				$id_vendedor_db=$rw_factura['id_vendedor'];
				$fecha_factura=date("d/m/Y", strtotime($rw_factura['fecha_factura']));
				$condiciones=$rw_factura['condiciones'];
				$estado_factura=$rw_factura['estado_factura'];
				$numero_factura1=$rw_factura['numero_factura'];
                                $descuento=$rw_factura['descuento'];
				$_SESSION['id_factura1']=$id_factura1;
				$_SESSION['numero_factura1']=$numero_factura1; 
                               
		}else{
                     echo "no tengo respuesta".$rest ;
                     }
          }else {
		echo "No recibí datos por POST";
	 }     
	
   
			include("../modal/registro_clientes2.php");
			include("../modal/registro_productos2.php");
			 include("../modal/agregar_producto.php");?>
	 
		
		<form class="form-horizontal" role="form" id="datos_factura">
				<div class="form-group row">
				  <label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" readonly value="<?php echo $nombre_cliente;?>">
					  <input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente;?>">	
				  </div>
				  <label for="tel1" class="col-md-1 control-label">Teléfono</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" value="<?php echo $telefono_cliente;?>" readonly>
							</div>
					<label for="mail" class="col-md-1 control-label">Email</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="mail" placeholder="Email" readonly value="<?php echo $email_cliente;?>">
							</div>
				 </div>
						<div class="form-group row">
							<label for="empresa" class="col-md-1 control-label">Vendedor</label>
							<div class="col-md-3">
								<select class="form-select input-sm" id="id_vendedor" name="id_vendedor">
									<?php
										$sql_vendedor = $conn->query("select * from users order by lastname");
										while ($rw = $sql_vendedor->fetch(PDO::FETCH_ASSOC)){
											$id_vendedor=$rw["user_id"];
											$nombre_vendedor=$rw["firstname"]." ".$rw["lastname"];
											if ($id_vendedor==$id_vendedor_db){
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
							<label for="tel2" class="col-md-1 control-label">Fecha</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="fecha" value="<?php echo $fecha_factura;?>" readonly>
							</div>
							<label for="email" class="col-md-1 control-label">Pago</label>
							<div class="col-md-2">
								<select class="form-select" id="condiciones" name="condiciones" required>
					                                
		                                			<option value="Giro 30 Dias" <?php if ($condiciones=="Giro 30 Dias"){echo "selected";}?> >Giro 30 Dias</option>
					                                <option value="Giro 60 Dias" <?php if ($condiciones=="Giro 60 Dias"){echo "selected";}?>>Giro 60 Dias</option>
                                                                        <option value="Giro 30 y 60 Dias" <?php if ($condiciones=="Giro 30 y 60 Dias"){echo "selected";}?>>Giro 30 y 60 Dias</option>
                                                                        <option value="Efectivo" <?php if ($condiciones=="Efectivo"){echo "selected";}?>>Efectivo</option>
					                                <option value="Transferencia" <?php if ($condiciones=="Transferencia"){echo "selected";}?>>Transferencia</option>
					                                <option value="Pagare 30 Dias" <?php if ($condiciones=="Pagare 30 Dias"){echo "selected";}?>>Pagare 30 Dias</option>
                                                                        <option value="Pagare 60 Dias" <?php if ($condiciones=="Pagare 60 Dias"){echo "selected";}?>>Pagare 60 Dias</option>
                                                                        <option value="Pagare 90 Dias" <?php if ($condiciones=="Pagare 90 Dias"){echo "selected";}?>>Pagare 90 Dias</option>
					                                <option value="Confirming 60 Dias" <?php if ($condiciones=="Confirming 60 Dias"){echo "selected";}?>>Confirming 60 Dias</option>
					                                <option value="Confirming 120 Dias" <?php if ($condiciones=="Confirming 120 Dias"){echo "selected";}?>>Confirming 120 Dias</option>
					                       </select>
							</div>
							<div class="col-md-2">
								<select class='form-select input-sm ' id="estado_factura" name="estado_factura">
									<option value="1" <?php if ($estado_factura==1){echo "selected";}?>>Pagado</option>
									<option value="2" <?php if ($estado_factura==2){echo "selected";}?>>Pendiente</option>
								</select>
							</div>
                                                      </div>
                                                        <div class="form-group row"> 
                                                             <label for="descuento" class="col-md-1 control-label">Descuento</label>
							 <div class="col-md-2">
								<input type="text" class="form-control input-sm" id="descuento" name="descuento" value="<?php echo $descuento;?>">
							</div>
						</div>
				
				
				<div class="col-md-12">
					<div class="pull-right">
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-refresh"></span> Actualizar datos
						</button>
						<button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#registro_producto2">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#nuevoCliente2">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#myModal41">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="button" class="btn btn-default" onclick="imprimir_factura('<?php echo $id_factura1;?>')">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
						<button type="button" class="btn btn-default" onclick="borrar_factura('<?php echo $numero_factura;?>')">
						  <span class="glyphicon glyphicon-trash"></span> Eliminar
						</button>
					</div>	
				</div>
			</form>
			
			<div id="resultados1" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
	
			
<script type="text/javascript" src="../assets/js/ajax/VentanaCentrada.js"></script>
<script type="text/javascript" src="../assets/js/ajax/editar_factura_nueva.js"></script>

