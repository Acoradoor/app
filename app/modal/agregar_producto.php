<!---------------------------
Autor: Toni gallur 
modal que se carga en la pagina
nueva_factura.php (Ventas) y nueva_factura_compras.php (Compras)
---------------------------->
<!-- Modal -->
<div class="modal fade" id="myModal41" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-6">
              <input type="text" class="form-control" id="q_editar" placeholder="Buscar productos" onkeyup="load_editar(1)">
            </div>
            <button type="button" class="btn btn-default" onclick="load_editar(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
          </div>
        </form>
        <div id="loader1_editar" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
        <div class="outer_div1_editar" ></div><!-- Datos ajax Final -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
