/*! jquery-ui-scrolltab |  * v1.0.0  */
/*  pagina que crea los tab usando jquery-ui se carga desde index.php   */
$(function () {
    $('#example_0').scrollTabs({
        scrollOptions: {
            enableDebug: true,
            selectTabAfterScroll: false,
            selectTabOnAdd: true
        }
    });
    $('#addRandomTab').on('click', function (e) {
        var randIdx = Math.floor(Math.random() * keywords.length);
        $('#example_0').data('uiScrollTabs')
            .addTab(keywords[randIdx], keywords[randIdx] + '<br>' +
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.' +
            ' Quisque hendrerit vulputate porttitor. Fusce purus leo, faucibus' +
            ' a sagittis congue, molestie tempus felis. Donec convallis semper enim,' +
            ' varius sagittis eros imperdiet in. Vivamus semper sem at metus mattis' +
            ' a aliquam neque ornare. Proin sed semper lacus.');
    });
    $('#addRandomTab2').on('click', function (e) {
         if ( $('#ofertas').length == 0 ) {
           var randIdx1 = 'Ofertas';
         var randIdx2 = 'ofertas';
            $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, randIdx1 + '<br>' +
            '111Lorem ipsum dolor sit amet, consectetur adipiscing elit.' +
            ' Quisque hendrerit vulputate porttitor. Fusce purus leo, faucibus' +
            ' a sagittis congue, molestie tempus felis. Donec convallis semper enim,' +
            ' varius sagittis eros imperdiet in. Vivamus semper sem at metus mattis' +
            ' a aliquam neque ornare. Proin sed semper lacus.');
          }
    });
    // En la función addRandomTab3 (pedidos)
// En el evento click del menú de pedidos
$('#addRandomTab3').on('click', function (e) {
    if ($('#pedidos').length == 0) {
        var randIdx1 = 'Pedidos';
        var randIdx2 = 'pedidos';
        $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, 
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <div class="pull-right">' +
                '           <button type="button" class="btn btn-primary" id="nuevoPedido">' +
                '               <i class="fa fa-plus"></i> Nuevo Pedido' +
                '           </button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Lista de Pedidos</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <table id="tablaPedidos" class="table table-bordered table-striped">' +
                '                   <thead>' +
                '                       <tr>' +
                '                           <th>ID</th>' +
                '                           <th>Cliente</th>' +
                '                           <th>Fecha</th>' +
                '                           <th>Total</th>' +
                '                           <th>Estado</th>' +
                '                           <th>Acciones</th>' +
                '                       </tr>' +
                '                   </thead>' +
                '                   <tbody></tbody>' +
                '               </table>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '</div>'
            );
        
     
        
      // Función para inicializar la tabla de pedidos
function inicializarTablaPedidos() {
    // Verificar si la tabla ya existe
    if ($('#tablaPedidos').length > 0) {
        console.log('Inicializando tabla de pedidos...');
        
        // Destruir tabla existente si existe
        if ($.fn.DataTable.isDataTable('#tablaPedidos')) {
            console.log('Destruyendo tabla existente...');
            $('#tablaPedidos').DataTable().destroy();
        }
        
        // Inicializar nueva tabla
        var table = $('#tablaPedidos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": "../ajax/buscar_pedidos.php",
                "type": "GET",
                "dataSrc": "data",
                "error": function(xhr, status, error) {
                    console.log("Error AJAX en tabla pedidos:", error);
                    console.log("Status:", status);
                    console.log("XHR:", xhr);
                    alert("Error al cargar datos: " + error);
                },
                "success": function(data) {
                    console.log("Datos cargados correctamente:", data);
                }
            },
            "columns": [
                {"data": 0},  // id_pedido
                {"data": 1},  // nombre_cliente
                {"data": 2},  // fecha_pedido
                {"data": 3},  // total
                {"data": 4},  // estado
                {"data": 5}   // acciones
            ],
            "order": [[0, "desc"]], // Ordenar por ID descendente
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "drawCallback": function() {
                console.log('Tabla dibujada');
                // Añadir eventos a botones después de dibujar la tabla
                $('.verPedido').off('click').on('click', function() {
                    var id = $(this).data('id');
                    console.log('Ver pedido ID:', id);
                    verPedidoDetalle(id);
                });
            },
            "initComplete": function() {
                console.log('Tabla inicializada completamente');
            }
        });
        
        // Verificar si la tabla se creó correctamente
        console.log('Tabla DataTables creada:', table);
    } else {
        console.log('Tabla #tablaPedidos no encontrada');
    }
}

// Función para ver detalles de pedido
function verPedidoDetalle(id) {
    alert('Ver detalles del pedido ID: ' + id);
    console.log('Mostrando detalles del pedido:', id);
}

        // Evento para nuevo pedido
        $('#nuevoPedido').click(function() {
            abrirModalNuevoPedido();
        });
    }
});

// Función para abrir modal de nuevo pedido
function abrirModalNuevoPedido() {
    // Cargar clientes primero
    $.ajax({
        url: "../ajax/cargar_clientes.php",
        method: "GET",
        success: function(clientes) {
            var clientesHtml = '<option value="">Seleccionar cliente</option>';
            $.each(clientes, function(index, cliente) {
                clientesHtml += '<option value="' + cliente.id_cliente + '">' + cliente.nombre_cliente + '</option>';
            });
            
            var modalContent = `
                <div class="modal fade" id="modalNuevoPedido" tabindex="-1" aria-labelledby="modalNuevoPedidoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalNuevoPedidoLabel">Nuevo Pedido</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formNuevoPedido">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="clientePedido" class="form-label">Cliente</label>
                                                <select class="form-select" id="clientePedido" required>
                                                    ${clientesHtml}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="vendedorPedido" class="form-label">Vendedor</label>
                                                <select class="form-select" id="vendedorPedido" required>
                                                    <option value="${sessionStorage.getItem('userId') || 1}">Mi perfil</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="condicionesPedido" class="form-label">Condiciones de pago</label>
                                                <select class="form-select" id="condicionesPedido">
                                                    <option value="Efectivo">Efectivo</option>
                                                    <option value="Transferencia">Transferencia</option>
                                                    <option value="Giro 30 Dias">Giro 30 Dias</option>
                                                    <option value="Giro 60 Dias">Giro 60 Dias</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="descuentoPedido" class="form-label">Descuento (%)</label>
                                                <input type="number" class="form-control" id="descuentoPedido" min="0" max="100" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Productos</h5>
                                            <div id="productosContainer">
                                                <div class="row producto-item mb-2">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Producto</label>
                                                        <select class="form-select producto-select">
                                                            <option value="">Seleccionar producto</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Cantidad</label>
                                                        <input type="number" class="form-control cantidad-input" min="1" value="1">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Precio Unitario</label>
                                                        <input type="number" step="0.01" class="form-control precio-input" value="0.00">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Subtotal</label>
                                                        <input type="text" class="form-control subtotal-input" readonly value="€0.00">
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-end">
                                                        <button type="button" class="btn btn-danger remove-producto">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" id="agregarProductoPedido" class="btn btn-secondary mt-2">
                                                <i class="fas fa-plus"></i> Agregar Producto
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="alert alert-info">
                                                <strong>Total:</strong> <span id="totalPedido">€0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" id="guardarPedidoBtn">Guardar Pedido</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(modalContent);
            $('#modalNuevoPedido').modal('show');
            
            // Cargar productos cuando se abre el modal
            cargarProductosModal();
            
            // Eventos para el modal
            $('#agregarProductoPedido').click(function() {
                agregarProductoPedido();
            });
            
            $(document).on('change', '.producto-select', function() {
                var precio = $(this).find('option:selected').data('precio');
                var precioInput = $(this).closest('.producto-item').find('.precio-input');
                precioInput.val(precio);
                calcularSubtotal($(this).closest('.producto-item'));
                calcularTotalPedido();
            });
            
            $(document).on('input', '.cantidad-input, .precio-input', function() {
                calcularSubtotal($(this).closest('.producto-item'));
                calcularTotalPedido();
            });
            
            $(document).on('click', '.remove-producto', function() {
                $(this).closest('.producto-item').remove();
                calcularTotalPedido();
            });
            
            $('#guardarPedidoBtn').click(function() {
                guardarPedido();
            });
        },
        error: function() {
            alert('Error al cargar clientes');
        }
    });
}

// Función para cargar productos en el modal
function cargarProductosModal() {
    $.ajax({
        url: "../ajax/cargar_productos.php",
        method: "GET",
        success: function(productos) {
            // Cargar productos en todos los selects de productos del modal
            $('.producto-select').each(function() {
                var select = $(this);
                select.empty();
                select.append('<option value="">Seleccionar producto</option>');
                
                $.each(productos, function(index, producto) {
                    select.append('<option value="' + producto.id_producto + '" data-precio="' + producto.precio_producto + '">' + 
                        producto.nombre_producto + ' - €' + producto.precio_producto + '</option>');
                });
            });
        },
        error: function() {
            console.log('Error al cargar productos');
            alert('Error al cargar productos');
        }
    });
}


// Función para agregar producto al pedido
function agregarProductoPedido() {
    var newItem = `
        <div class="row producto-item mb-2">
            <div class="col-md-4">
                <label class="form-label">Producto</label>
                <select class="form-select producto-select">
                    <option value="">Seleccionar producto</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Cantidad</label>
                <input type="number" class="form-control cantidad-input" min="1" value="1">
            </div>
            <div class="col-md-3">
                <label class="form-label">Precio Unitario</label>
                <input type="number" step="0.01" class="form-control precio-input" value="0.00">
            </div>
            <div class="col-md-2">
                <label class="form-label">Subtotal</label>
                <input type="text" class="form-control subtotal-input" readonly value="€0.00">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-producto">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    $('#productosContainer').append(newItem);
    
    // Cargar productos para el nuevo elemento
    cargarProductosModal();
    
    // Eventos para el nuevo elemento
    $(document).on('change', '.producto-select', function() {
        var precio = $(this).find('option:selected').data('precio');
        var precioInput = $(this).closest('.producto-item').find('.precio-input');
        precioInput.val(precio);
        calcularSubtotal($(this).closest('.producto-item'));
        calcularTotalPedido();
    });
    
    $(document).on('input', '.cantidad-input, .precio-input', function() {
        calcularSubtotal($(this).closest('.producto-item'));
        calcularTotalPedido();
    });
}

// Función para calcular subtotal de un producto
function calcularSubtotal(item) {
    var cantidad = parseFloat(item.find('.cantidad-input').val()) || 0;
    var precio = parseFloat(item.find('.precio-input').val()) || 0;
    var subtotal = cantidad * precio;
    item.find('.subtotal-input').val('€' + subtotal.toFixed(2));
}

// Función para calcular total del pedido
function calcularTotalPedido() {
    var total = 0;
    $('.producto-item').each(function() {
        var cantidad = parseFloat($(this).find('.cantidad-input').val()) || 0;
        var precio = parseFloat($(this).find('.precio-input').val()) || 0;
        total += cantidad * precio;
    });
    $('#totalPedido').text('€' + total.toFixed(2));
}

// Función para guardar pedido
function guardarPedido() {
    var id_cliente = $('#clientePedido').val();
    var id_vendedor = $('#vendedorPedido').val();
    var condiciones = $('#condicionesPedido').val();
    var descuento = $('#descuentoPedido').val();
    
    if (!id_cliente) {
        alert('Seleccione un cliente');
        return;
    }
    
    var items = [];
    var total = 0;
    
    $('.producto-item').each(function() {
        var productoId = $(this).find('.producto-select').val();
        var cantidad = parseInt($(this).find('.cantidad-input').val()) || 0;
        var precio = parseFloat($(this).find('.precio-input').val()) || 0;
        
        if (productoId && cantidad > 0) {
            items.push({
                id: productoId,
                cantidad: cantidad,
                precio: precio
            });
            total += cantidad * precio;
        }
    });
    
    if (items.length === 0) {
        alert('Agregue al menos un producto');
        return;
    }
    
    // Enviar datos al servidor
    $.ajax({
        url: "../ajax/guardar_pedido.php",
        method: "POST",
        data: {
            id_cliente: id_cliente,
            id_vendedor: id_vendedor,
            condiciones: condiciones,
            descuento: descuento,
            items: items
        },
        success: function(response) {
            if (response.success) {
                alert('Pedido guardado correctamente');
                $('#modalNuevoPedido').modal('hide');
                // Recargar tabla de pedidos
                $('#tablaPedidos').DataTable().ajax.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Error en la conexión');
        }
    });
}
     $('#addRandomTab4').on('click', function (e) {
         if ( $('#albaranes').length == 0 ) {
           var randIdx1 = 'Albaranes';
         var randIdx2 = 'albaranes';
            $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, randIdx1 + '<br>' +
            '111Lorem ipsum dolor sit amet, consectetur adipiscing elit.' +
            ' Quisque hendrerit vulputate porttitor. Fusce purus leo, faucibus' +
            ' a sagittis congue, molestie tempus felis. Donec convallis semper enim,' +
            ' varius sagittis eros imperdiet in. Vivamus semper sem at metus mattis' +
            ' a aliquam neque ornare. Proin sed semper lacus.');
          }
    });
     $('#addRandomTab5').on('click', function (e) {
         if ( $('#albaranes_deposito').length == 0 ) {
           var randIdx1 = 'Albaranes de Deposito';
         var randIdx2 = 'albaranes_deposito';
            $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, randIdx1 + '<br>' +
            '111Lorem ipsum dolor sit amet, consectetur adipiscing elit.' +
            ' Quisque hendrerit vulputate porttitor. Fusce purus leo, faucibus' +
            ' a sagittis congue, molestie tempus felis. Donec convallis semper enim,' +
            ' varius sagittis eros imperdiet in. Vivamus semper sem at metus mattis' +
            ' a aliquam neque ornare. Proin sed semper lacus.');
          }
    });
     $('#addRandomTab1').on('click', function (e) {
         if ( $('#factura_ventas').length == 0 ) {
           var randIdx1 = 'Factura Ventas';
         var randIdx2 = 'factura_ventas';
            $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, randIdx1 + '<section class="content">' +
            ' <div class="row">' +
            ' <div class="col-md-12">' +
            ' <div class="pull-right">' +
            '<button type="button" class="btn btn-default" id="actualizar"> <span class="glyphicon glyphicon-refresh"></span> Actualizar datos</button>' +
            ' <button type="button" class="btn btn-default" id="nueva_f_numerada"> <span class="glyphicon glyphicon-plus"></span> Nueva F Numerada</button>' + 
            '  <button type="button" class="btn btn-default" id="mostrar"><span class="glyphicon glyphicon-plus"></span> Nueva Factura</button>' + 
            ' </div> ' + 
            ' </div>' + 
            ' <div class="col-12">' +
            ' <div class="box">' +
            ' <div class="box-header">' +
            ' <h4 class="box-title">Facturas Ventas</h4>' +
            ' <div class="box-body">' +
            ' <div class="table table-bordered table-hover display nowrap margin-top-10 w-p100" style=" height: 400px;overflow: auto;">' +
            ' <table id="example" class="display" style="width:100%">' +
            ' <thead>' +
            ' <tr>' +
            ' <th>Nº Factura</th>' +
            ' <th>Nº Pedido</th>' +
            ' <th>Fecha</th>' +
            ' <th>Cliente</th>' +
            ' <th>Vendedor</th>' +
            ' <th>Estado</th>' +
            ' <th class="text-right">Subtotal</th>' +
            ' <th class="text-right">Email</th>' +
            ' </tr>' +
            ' </thead>' +
            ' <tbody></tbody>' +
            '  <tfoot>' +
            ' <tr>' +
            ' <th>Nº Factura</th>' +
            ' <th>Nº Pedido</th>' +
            ' <th>Fecha</th>' +
            ' <th>Cliente</th>' +
            ' <th>Vendedor</th>' +
            ' <th>Estado</th>' +
            ' <th class="text-right">Subtotal</th>' +
            ' <th class="text-right">Email</th>' +
            ' </tr>' +
            ' </tfoot>' +
            ' </table>' +
            ' </div>' +
            ' </div>' +
            ' </div>' +
            ' </div>' +
            ' <div class="box" id="d">' +
            ' <div class="box-header with-border">' +
            ' <h3 class="box-title">Nueva Factura</h3>' +
            ' </div>' +
            ' <div class="box-body">' +
            ' <div id="resultadoss" class="col-md-12" style="margin-top:10px"></div>' +
            ' </div>' +
            ' </div>' +
            ' </div>' +
            ' <div class="box" id="d1">' +
            ' <div class="box-header with-border">' +
            ' <h3 class="box-title">Detalles De La Factura</h3>' +
            ' </div>' +
            ' <div class="box-body">' +
            ' <div id="resultados" class="col-md-12" style="margin-top:10px"></div>' +
            ' </div>' +
            ' </div>' +
            ' </div>' +
            ' </div> ' + 
            ' </section>'  
            );
          }
          $("#d").hide();
          $("#d1").hide();
          let table = new $('#example').DataTable( {
        "language": {
           "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }, 
        dom: 'Bfrtip',
        buttons: [
            'copy',
            'csv',
            'excel',
            'pdf',
            {
                extend: 'print',
                text: 'Print all (not just selected)',
                exportOptions: {
                    modifier: {
                        selected: null
                    }

                }
            }
        ],
        ajax: "../ajax/buscar_facturas_nueva.php",
	pageLength: -1,
        select: true
    } );
    
table
    .on('select', function (e, dt, type, indexes) {
                 var paramJson = JSON.stringify( dt.row( { selected: true } ).data() );
                 var myArray = JSON.parse(paramJson);
                  var yo = myArray[0];
                         $.ajax({
                                type: "POST",
                                url: "../ajax/editar_facturas.php",

                                data: {id:yo},
                              
                                success:function(data){
					$("#resultados").html(data).fadeIn();
					$("#d1").show(); //muestro mediante id
					$("#d").hide();
		                },
                                
                     });

    })
    .on('deselect', function (e, dt, type, indexes) {

       $("#resultados").fadeOut();
       $("#d1").hide();
    });
    
    
    
    $("#mostrar").on( "click", function() {
	$("#d").show(); //muestro mediante id
	$("#d1").hide();
	$.ajax({
	        type: "POST",
		url:'../ajax/nueva_factura.php',
				 
				success:function(data){
					$("#resultadoss").html(data).fadeIn('slow');
					
					
				}
			});
	
    });
     $("#actualizar").on( "click", function() {
	$("#d").hide(); //muestro mediante id
	$("#d1").hide();
	$('#example').DataTable().clear().destroy();
		let table = new $('#example').DataTable( {
        "language": {

           "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }, 
        dom: 'Bfrtip',

        buttons: [
            'copy',
            'csv',
            'excel',
            'pdf',
            {
                extend: 'print',
                text: 'Print all (not just selected)',
                exportOptions: {
                    modifier: {

                        selected: null
                    }
                }

            }
        ],
        ajax: "../ajax/buscar_facturas_nueva.php",

	pageLength: -1,
        select: true
    } );
    });

    });
     
   
   
   
});

//# sourceMappingURL=jquery.init.js.map
