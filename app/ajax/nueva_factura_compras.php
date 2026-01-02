<?php
/*-------------------------
Autor: Toni gallur

pagina que se carga en
index.php lamado por una funcion
en jquery.init.js 
---------------------------*/
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}
    
include("../modal/registro_proveedores.php");
include("../modal/registro_productos3.php");
include("../modal/buscar_productos2.php");
?>

<form class="form-horizontal" role="form" id="datos_factura_compras">
    <div class="form-group row">
        <label for="proveedorFacturaCompra" class="col-md-1 control-label">Proveedor</label>
        <div class="col-md-3">
            <input type="text" class="form-control input-sm" id="proveedorFacturaCompra" placeholder="Selecciona un proveedor" required>
            <input id="id_proveedor_seleccionado" type='hidden'>	
        </div>
        <label for="telefono_proveedor" class="col-md-1 control-label">Teléfono</label>
        <div class="col-md-2">
            <input type="text" class="form-control input-sm" id="telefono_proveedor" placeholder="Teléfono" readonly>
        </div>
        <label for="email_proveedor" class="col-md-1 control-label">Email</label>
        <div class="col-md-3">
            <input type="text" class="form-control input-sm" id="email_proveedor" placeholder="Email" readonly >
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
        <label for="tel2" class="col-md-1 control-label">Fecha</label>
        <div class="col-md-2">
            <input type="text" class="form-control input-sm" id="fecha" value="<?php echo date("d/m/Y");?>" readonly>
        </div>
        <label for="condicionesfc" class="col-md-1 control-label">Pago</label>
        <div class="col-md-2">
           <select class='form-control input-sm' id="condicionesfc">
		<option value="1">Efectivo</option>
		<option value="2">Cheque</option>
		<option value="3">Transferencia bancaria</option>
		<option value="4">Crédito</option>
	   </select>
        </div>
    </div>
    <div class="form-group row"> 
        <label for="descuentofc" class="col-md-1 control-label">Descuento</label>
        <div class="col-md-2">
            <input type="text" class="form-control input-sm" id="descuentofc" name="descuento" value="0">
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="pull-right">
            <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#registro_producto3">
                <span class="glyphicon glyphicon-plus"></span> Nuevo producto
            </button>
            <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#nuevoProveedor">
                <span class="glyphicon glyphicon-user"></span> Nuevo proveedor
            </button>
            <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#myModa_compras">
                <span class="glyphicon glyphicon-search"></span> Agregar productos
            </button>
            <button type="button" class="btn btn-default"id="mostrariofc" >
		 <span class="glyphicon glyphicon-print"></span> Guardar y Imprimir
	   </button>
        </div>	
    </div>
</form>

<div id="resultados4_compras" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->

<script type="text/javascript" src="../assets/js/ajax/VentanaCentrada.js"></script>
<script type="text/javascript" src="../assets/js/ajax/nueva_factura_compras.js"></script>
<script>
// Cargar proveedores al cargar la página
$(document).ready(function() {
    // Inicializar autocompletado para proveedor (igual que en facturas ventas)
    $("#proveedorFacturaCompra").autocomplete({
        source: "../ajax/autocomplete/proveedores.php",
        minLength: 2,
        select: function(event, ui) {
            event.preventDefault();
            $('#id_proveedor_seleccionado').val(ui.item.id_proveedor);
            $('#proveedorFacturaCompra').val(ui.item.nombre_proveedor);
            $('#telefono_proveedor').val(ui.item.telefono_proveedor);
            $('#email_proveedor').val(ui.item.email_proveedor);
            console.log("Proveedor seleccionado:", ui.item);
        }
    });
    
    // Manejo de teclas para limpiar campos (igual que en facturas ventas)
    $("#proveedorFacturaCompra").on("keydown", function(event) {
        if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || 
            event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || 
            event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE) {
            $("#id_proveedor_seleccionado").val("");
	    $("#telefono_proveedor" ).val("");
	    $("#email_proveedor" ).val("");
        }
        if (event.keyCode == $.ui.keyCode.DELETE) {
            $("#proveedorFacturaCompra").val("");
            $("#id_proveedor_seleccionado").val("");
	    $("#telefono_proveedor" ).val("");
	    $("#email_proveedor" ).val("");
        }
    });
     });
    </script>


