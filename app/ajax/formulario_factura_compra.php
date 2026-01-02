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
?>
<?php
// Formulario para crear nueva factura de compra
// Similar a nueva_factura.php pero adaptado para compras
?>
<div class="row">
    <div class="col-12">
        <div class="box" id="dFacturaCompra">
            <div class="box-body">
                <form class="form-horizontal" role="form" id="formNuevaFacturaCompra">
                    <div class="form-group row">
                        <label for="proveedorFacturaCompra" class="col-md-1 control-label">Proveedor</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control input-sm" id="proveedorFacturaCompra" placeholder="Selecciona un proveedor" required>
                            <input id="id_proveedor_seleccionado" type='hidden' required>	
                        </div>
                        <label for="vendedorFacturaCompra" class="col-md-1 control-label">Vendedor</label>
                        <div class="col-md-3">
                            <select class="form-control input-sm" id="vendedorFacturaCompra">
                                <?php
                                // Suponiendo que ya tienes la conexión $conn
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
                        <label for="fechaFacturaCompra" class="col-md-1 control-label">Fecha</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control input-sm" id="fechaFacturaCompra" value="<?php echo date("d/m/Y");?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="condicionesFacturaCompra" class="col-md-1 control-label">Pago</label>
                        <div class="col-md-3">
                            <select class='form-control input-sm' id="condicionesFacturaCompra">
                                <option value="1">Efectivo</option>
                                <option value="2">Cheque</option>
                                <option value="3">Transferencia bancaria</option>
                                <option value="4">Crédito</option>
                            </select>
                        </div>
                        <label for="descuentoFacturaCompra" class="col-md-1 control-label">Descuento</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control input-sm" id="descuentoFacturaCompra" name="descuento" value="0">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#registro_producto_compra">
                                    <span class="glyphicon glyphicon-plus"></span> Nuevo producto
                                </button>
                                <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#nuevoProveedorCompra">
                                    <span class="glyphicon glyphicon-user"></span> Nuevo proveedor
                                </button>
                                <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#myModalCompra">
                                    <span class="glyphicon glyphicon-search"></span> Agregar productos
                                </button>
                                <button type="button" class="btn btn-default" id="guardarImprimirFacturaCompra">
                                    <span class="glyphicon glyphicon-print"></span> Guardar y Imprimir
                                </button>
                            </div>	
                        </div>
                    </div>
                </form>	
                <div id="resultadosFacturaCompra" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
            </div>
        </div>
        <div class="box" id="dFacturaCompraDetalle">
            <div class="box-header with-border">
                <h3 class="box-title">Detalles De La Factura</h3>
            </div>
            <div class="box-body">
                <div id="resultadosFacturaCompraDetalle" class="col-md-12" style="margin-top:10px"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para nuevo producto -->
<div class="modal fade" id="registro_producto_compra" tabindex="-1" aria-labelledby="registro_producto_compraLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registro_producto_compraLabel">Registrar Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="guardar_producto_compra">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="codigo_producto_compra" class="form-label">Código</label>
                                <input type="text" class="form-control" id="codigo_producto_compra" name="codigo" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre_producto_compra" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre_producto_compra" name="nombre" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categoria_producto_compra" class="form-label">Categoría</label>
                                <input type="text" class="form-control" id="categoria_producto_compra" name="categoria">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="precio_producto_compra" class="form-label">Precio</label>
                                <input type="number" step="0.01" class="form-control" id="precio_producto_compra" name="precio" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cantidad_producto_compra" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad_producto_compra" name="cantidad" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="estado_producto_compra" class="form-label">Estado</label>
                                <select class="form-select" id="estado_producto_compra" name="estado">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="guardar_datos_producto">Guardar Producto</button>
                    </div>
                </form>
                <div id="resultados_ajax_alert_producto"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para nuevo proveedor -->
<div class="modal fade" id="nuevoProveedorCompra" tabindex="-1" aria-labelledby="nuevoProveedorCompraLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoProveedorCompraLabel">Registrar Nuevo Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="guardar_proveedor_compra">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre_proveedor_compra" class="form-label">Nombre del Proveedor</label>
                                <input type="text" class="form-control" id="nombre_proveedor_compra" name="nombre_proveedor" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cif_proveedor_compra" class="form-label">CIF</label>
                                <input type="text" class="form-control" id="cif_proveedor_compra" name="cif">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono_proveedor_compra" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono_proveedor_compra" name="telefono_proveedor">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email_proveedor_compra" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email_proveedor_compra" name="email_proveedor">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="direccion_proveedor_compra" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion_proveedor_compra" name="direccion_proveedor">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pago_proveedor_compra" class="form-label">Forma de Pago</label>
                                <input type="text" class="form-control" id="pago_proveedor_compra" name="pago">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="n_cuenta_proveedor_compra" class="form-label">Número de Cuenta</label>
                                <input type="text" class="form-control" id="n_cuenta_proveedor_compra" name="n_cuenta">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status_proveedor_compra" class="form-label">Estado</label>
                                <select class="form-select" id="status_proveedor_compra" name="status_proveedor">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="guardar_datos_compra">Guardar Proveedor</button>
                    </div>
                </form>
                <div id="resultados_ajax_proveedor"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para buscar productos -->
<div class="modal fade" id="myModalCompra" tabindex="-1" aria-labelledby="myModalCompraLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalCompraLabel">Buscar Productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="q_compra" placeholder="Buscar productos...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary" id="buscarProductosCompra">Buscar</button>
                    </div>
                </div>
                <div id="loader1_compra"></div>
                <div class="outer_div10_compra"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

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
            // Opcional: Puedes llenar otros campos si lo deseas
            // $('#telefono_proveedor').val(ui.item.telefono_proveedor);
            // $('#email_proveedor').val(ui.item.email_proveedor);
            console.log("Proveedor seleccionado:", ui.item);
        }
    });
    
    // Manejo de teclas para limpiar campos (igual que en facturas ventas)
    $("#proveedorFacturaCompra").on("keydown", function(event) {
        if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || 
            event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || 
            event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE) {
            $("#id_proveedor_seleccionado").val("");
            // Puedes limpiar otros campos si los tienes
        }
        if (event.keyCode == $.ui.keyCode.DELETE) {
            $("#proveedorFacturaCompra").val("");
            $("#id_proveedor_seleccionado").val("");
            // Puedes limpiar otros campos si los tienes
        }
    });
    
    // Evento para mostrar nueva factura (igual que en facturas ventas)
    $("#mostrarFacturaCompra").on( "click", function() {
        $("#dFacturaCompra").show(); //muestro mediante id
        $("#dFacturaCompraDetalle").hide();
        // Cargar el contenido de productos (similar a #resultados4)
        $.ajax({
            type: "POST",
            url:'../ajax/productos_factura_compra.php?action=ajax&page=1&q=',
            success:function(data){
                $("#resultadosFacturaCompra").html(data).fadeIn('slow');
            }
        });
    });
    
    // Evento para actualizar datos (igual que en facturas ventas)
    $("#actualizarFacturaCompra").on( "click", function() {
        $("#dFacturaCompra").hide(); //muestro mediante id
        $("#dFacturaCompraDetalle").hide();
        // No es necesario recrear el DataTable aquí, ya está creado
        // Solo recargamos los datos si es necesario
         $('#exampleFacturaCompra').DataTable().ajax.reload(); // Descomentar si es necesario
    });
    
    // Evento para guardar e imprimir factura (igual que en facturas ventas)
    $("#guardarImprimirFacturaCompra").on( "click", function() {
        var id_proveedor = $("#id_proveedor_seleccionado").val();
        var id_vendedor = $("#vendedorFacturaCompra").val();
        var condiciones = $("#condicionesFacturaCompra").val();
        var descuento = $("#descuentoFacturaCompra").val();
        
        if (id_proveedor==""){
            alert("Debes seleccionar un proveedor");
            $("#proveedorFacturaCompra").focus();
            return false;
        }
        // Llamada a VentanaCentrada (como en facturas ventas)
        // VentanaCentrada('../html2pdf/documentos/generar_presupuesto_pdf.php?id_presupuesto=' + id_proveedor, 'Presupuesto', '', '1024', '768', 'true');
        // Para facturas de compra, necesitarías usar el ID de la factura, no el proveedor.
        // Esto es solo un ejemplo, necesitarías un ID de factura real.
        // Ejemplo: VentanaCentrada('../html2pdf/documentos/generar_factura_compra_pdf.php?id_factura=' + id_factura, 'Factura Compra', '', '1024', '768', 'true');
        
        // Opcionalmente ocultar los divs
        $("#dFacturaCompraDetalle").hide();
        $("#dFacturaCompra").hide();
    });
    
    // Evento para buscar productos (ID único)
    $("#myModalCompra").on('click', '#buscarProductosCompra', function() {
        loadFacturaCompra(1);
    });

    // Evento para la tecla Enter en el campo de búsqueda del modal (ID único)
    $("#myModalCompra").on('keypress', '#q_compra', function(e) {
        if (e.which == 13) { // Tecla Enter
            loadFacturaCompra(1);
        }
    });
    
    // Cargar productos automáticamente al abrir el modal (ID único)
    $('#myModalCompra').on('shown.bs.modal', function () {
        // Cargar productos por defecto si no hay búsqueda
        if ($("#q_compra").val() === '') {
            loadFacturaCompra(1);
        }
    });
    
    // Inicializar función load (ID único)
    loadFacturaCompra(1);
    
    // Evento para cargar productos al iniciar (opcional)
    // Puedes cargar aquí el contenido inicial de productos si es necesario
    // Por ahora se carga al hacer clic en "Mostrar Factura"
});

// Función para cargar productos (ID único)
function loadFacturaCompra(page){
    var q= $("#q_compra").val();
    $("#loader1_compra").fadeIn('slow');
    $.ajax({
        url:'../ajax/productos_factura_compra.php?action=ajax&page='+page+'&q='+q,
         beforeSend: function(objeto){
            $('#loader1_compra').html('<img src="./img/ajax-loader.gif"> Cargando...');
          },
        success:function(data){
            $(".outer_div10_compra").html(data).fadeIn('slow');
            $('#loader1_compra').html('');
            
        }
    })
}

// Función única para agregar producto (evitando conflictos)
function agregarProductoCompraUnico (id_producto) {
    // Usar un ID único para los campos de precio y cantidad
                        var precio_ventaa=document.getElementById('precio_ventaaa_'+id_producto).value;
			var cantidadd=document.getElementById('cantidadaa_'+id_producto).value;
			//Inicia validacion
			if (isNaN(cantidadd))
			{
			alert('Esto no es un numero');
			document.getElementById('cantidadaa_'+id).focus();
			return false;
			}
			if (isNaN(precio_ventaa))
			{
			alert('Esto no es un numero');
			document.getElementById('precio_ventaaa_'+id).focus();
			return false;
			}
			//Fin validacion
    
    // Enviar datos al servidor
    $.ajax({
        type: "POST",
        url: "../ajax/agregar_facturacion_compra.php",
        data: "id1="+id_producto+"&precio_venta1="+precio_ventaa+"&cantidad1="+cantidadd, // <-- Aquí va 
        beforeSend: function(objeto){
            $("#resultadosFacturaCompra").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultadosFacturaCompra").html(datos);
        }
    });
}

// Función para eliminar producto (similar a eliminar de nueva_factura.js)
function eliminarFacturaCompra (id) {
    $.ajax({
        type: "GET",
        url: "../ajax/agregar_facturacion_compra.php",
         data: "id="+id, // <-- Aquí va 
        beforeSend: function(objeto){
            $("#resultadosFacturaCompra").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultadosFacturaCompra").html(datos);
        }
    });
}

// Función para guardar nuevo proveedor (similar a guardar_cliente de nueva_factura.js)
$("#guardar_proveedor_compra").submit(function( event ) {
    $('#guardar_datos_compra').attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/nuevo_proveedor.php",
        data: parametros, // <-- Aquí va 
        beforeSend: function(objeto){
            $("#resultados_ajax_proveedor").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultados_ajax_proveedor").html(datos);
            $('#guardar_datos_compra').attr("disabled", false);
            // Recargar la lista de proveedores en el autocompletado si es necesario
            // load(1); // Si se necesita recargar algo
        }
    });
    event.preventDefault();
})

// Función para guardar nuevo producto (similar a guardar_producto de nueva_factura.js)
$("#guardar_producto_compra").submit(function( event ) {
    $('#guardar_datos_producto').attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/nuevo_producto.php",
        data: parametros, // <-- Aquí va 
        beforeSend: function(objeto){
            $("#resultados_ajax_alert_producto").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultados_ajax_alert_producto").html(datos);
            $('#guardar_datos_producto').attr("disabled", false);
            // Recargar la lista de productos si es necesario
            // load(1); // Si se necesita recargar algo
        }
    });
    event.preventDefault();
})

</script>
