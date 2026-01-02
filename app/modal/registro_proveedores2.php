<!---------------------------
Autor: Toni gallur 
modal que se carga en la pagina
nueva_factura_compras.php 
---------------------------->
<!-- Modal -->
<div class="modal fade" id="nuevoProveedor2" >
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo proveedor</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" ></button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form class="form-horizontal" method="post" id="guardar_proveedor2" name="guardar_proveedor2">
        <div id="resultados_ajax_proveedor2"></div>
          <div class="form-group">
            <label for="nombre2" class="col-sm-3 control-label">Nombre</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="nombre2" name="nombre" required>
            </div>
          </div>
          <div class="form-group">
            <label for="cuenta2" class="col-sm-3 control-label">Nº Cuenta</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="cuenta2" name="cuenta" >
            </div>
          </div>
          <div class="form-group">
            <label for="telefono2" class="col-sm-3 control-label">Teléfono Fijo</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="telefono2" name="telefono" >
            </div>
          </div>
          <div class="form-group">
            <label for="movil2" class="col-sm-3 control-label">Teléfono Movil</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="movil2" name="movil" >
            </div>
          </div>
          <div class="form-group">
            <label for="email2" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-8">
                <input type="email" class="form-control" id="email2" name="email" >
            </div>
          </div>
          
          <div class="form-group">
            <label for="direccion2" class="col-sm-3 control-label">Dirección</label>
            <div class="col-sm-8">
                <textarea class="form-control" id="direccion2" name="direccion"   maxlength="255" ></textarea>
            </div>
          </div>
          
          <div class="form-group">
            <label for="pago2" class="col-sm-3 control-label">Forma De Pago</label>
            <div class="col-sm-8">
             <select class="form-control" id="pago2" name="pago" required>
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
            <label for="cif2" class="col-sm-3 control-label">C.I.F</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="cif2" name="cif" >
            </div>
          </div>
          
          <div class="form-group">
            <label for="estado2" class="col-sm-3 control-label">Estado</label>
            <div class="col-sm-8">
             <select class="form-control" id="estado2" name="estado" required>
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
