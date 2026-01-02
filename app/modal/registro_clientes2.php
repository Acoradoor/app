	<!---------------------------
	Autor: Toni gallur 
	modal que se carga en la pagina
	editar_factura.php 
	---------------------------->
	
	<!-- Modal -->
	<div class="modal fade" id="nuevoCliente2" >
	  <div class="modal-dialog">
		<div class="modal-content">
		 <!-- Modal Header -->
		  <div class="modal-header">
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo cliente</h4>
			<button type="button" class="btn-close" data-bs-dismiss="modal" ></button>
		  </div>
		   <!-- Modal body -->
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_cliente2" name="guardar_cliente2">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nombre" name="nombre" required>
				</div>
			  </div>
                         <div class="form-group">
				<label for="cuenta" class="col-sm-3 control-label">Nº Cuenta</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="cuenta" name="cuenta" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Teléfono Fijo</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="telefono" name="telefono" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="movil" class="col-sm-3 control-label">Teléfono Movil</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="movil" name="movil" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="email" class="col-sm-3 control-label">Email</label>
				<div class="col-sm-8">
					<input type="email" class="form-control" id="email" name="email" >
				  
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="direccion" name="direccion"   maxlength="255" ></textarea>
				  
				</div>
			  </div>
                           
                         <div class="form-group">
				<label for="pago" class="col-sm-3 control-label">Forma De Pago</label>
				<div class="col-sm-8">
				 <select class="form-control" id="pago" name="pago" required>
					<option value="" selected>-- Selecciona pago --</option>
					<option >Giro 30 Dias</option>
					<option >Giro 60 Dias</option>
                                        <option>Giro 30 y 60 Dias</option>
                                        <option >Efectivo</option>
					<option >Transferencia</option>
					<option>Pagare 30 Dias</option>
                                        <option>Pagare 60 Dias</option>
                                        <option>Pagare 90 Dias</option>
					<option>Confirming 60 Dias</option>
					<option >Confirming 120 Dias</option>
					</select>
				</div>
			  </div>
                        
                          <div class="form-group">
				<label for="cif" class="col-sm-3 control-label">C.I.F</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="cif" name="cif" >
				  
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="" selected>-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>
	 <!-- Modal footer -->
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos2">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
     </div>
