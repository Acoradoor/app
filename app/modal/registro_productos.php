      <!---------------------------
	Autor: Toni gallur 
	modal que se carga en la pagina
	nueva_factura.php 
	---------------------------->

<!-- The Modal -->
<div class="modal" id="registro_producto">
  <div class="modal-dialog ">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo producto</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
			<div id="resultados_ajax_alert"></div>
			  <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Código</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código del producto" required>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="nombre" name="nombre" placeholder="Nombre del producto" required maxlength="255" ></textarea>
				  
				</div>
			  </div>
			  
                          <div class="form-group">
				<label for="categoria" class="col-sm-3 control-label">Categoria</label>
				<div class="col-sm-8">
				 <select class="form-control" id="categoria" name="categoria" required>
					<option value="puertas" selected>Puertas</option>
					<option value="molduras">Molduras</option>
					<option value="tableros">Tableros</option>
                                        <option value="herrajes">Herrajes</option>
                                        <option value="bombillo">Bombillo</option>
                                        <option value="momtaje">Momtaje</option>
                                        <option value="p_paso">Puerta de paso</option>
                                        <option value="Otros">Otros</option>
				  </select>
				</div>
			  </div>
      
                          <div class="form-group">
				<label for="cantidad" class="col-sm-3 control-label">Cantidad</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidades del producto" required>
				</div>
			  </div>

			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>
			  <div class="form-group">
				<label for="precio" class="col-sm-3 control-label">Precio</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio de venta del producto" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			  </div>
			 
			 
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
      </div>
      </form>
     </div>
    </div>
  </div>
</div>	
