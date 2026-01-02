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
            
            // Inicializar la tabla después de que se cree el DOM
            setTimeout(function() {
                console.log('Intentando inicializar tabla...');
                inicializarTablaPedidos();
            }, 500);
            
            // Evento para nuevo pedido
            $('#nuevoPedido').on('click', function() {
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
                $('#agregarProductoPedido').on('click', function() {
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
                
                $('#guardarPedidoBtn').on('click', function() {
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
    
    // En la función addRandomTab3 (pedidos) - ya la teníamos
    // Agregamos también la función para stock
    $('#addRandomTab6').on('click', function (e) {
        if ($('#stock').length == 0) {
            var randIdx1 = 'Stock';
            var randIdx2 = 'stock';
            $('#example_0').data('uiScrollTabs')
                .addTab1(randIdx2, randIdx1, 
                    '<div class="row">' +
                    '   <div class="col-md-12">' +
                    '       <div class="pull-right">' +
                    '           <button type="button" class="btn btn-primary" id="nuevoAjusteStock">' +
                    '               <i class="fa fa-plus"></i> Ajuste de Stock' +
                    '           </button>' +
                    '       </div>' +
                    '   </div>' +
                    '   <div class="col-md-12">' +
                    '       <div class="box">' +
                    '           <div class="box-header">' +
                    '               <h3 class="box-title">Productos con Stock Bajo</h3>' +
                    '           </div>' +
                    '           <div class="box-body">' +
                    '               <table id="tablaStockBajo" class="table table-bordered table-striped">' +
                    '                   <thead>' +
                    '                       <tr>' +
                    '                           <th>ID</th>' +
                    '                           <th>Producto</th>' +
                    '                           <th>Cantidad</th>' +
                    '                           <th>Precio</th>' +
                    '                       </tr>' +
                    '                   </thead>' +
                    '                   <tbody></tbody>' +
                    '               </table>' +
                    '           </div>' +
                    '       </div>' +
                    '   </div>' +
                    '   <div class="col-md-12">' +
                    '       <div class="box">' +
                    '           <div class="box-header">' +
                    '               <h3 class="box-title">Todos los Productos</h3>' +
                    '           </div>' +
                    '           <div class="box-body">' +
                    '               <table id="tablaStockCompleta" class="table table-bordered table-striped">' +
                    '                   <thead>' +
                    '                       <tr>' +
                    '                           <th>ID</th>' +
                    '                           <th>Código</th>' +
                    '                           <th>Producto</th>' +
                    '                           <th>Cantidad</th>' +
                    '                           <th>Precio</th>' +
                    '                           <th>Stock</th>' +
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
            
            // Inicializar DataTables para stock
            $('#tablaStockBajo').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                "ajax": "../ajax/buscar_stock_bajo.php",
                "columns": [
                    {"data": "0"},
                    {"data": "1"},
                    {"data": "2"},
                    {"data": "3"}
                ]
            });
            
            $('#tablaStockCompleta').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                "ajax": "../ajax/cargar_productos_stock.php",
                "columns": [
                    {"data": "0"},
                    {"data": "1"},
                    {"data": "2"},
                    {"data": "3"},
                    {"data": "4"},
                    {"data": "5"},
                    {"data": "6"}
                ]
            });
            
            // Evento para nuevo ajuste de stock
            $('#nuevoAjusteStock').click(function() {
                abrirModalAjusteStock();
            });
        }
    });

    // Función para abrir modal de ajuste de stock
    function abrirModalAjusteStock() {
        // Cargar productos
        $.ajax({
            url: "../ajax/cargar_productos_stock.php",
            method: "GET",
            success: function(productos) {
                var productosHtml = '<option value="">Seleccionar producto</option>';
                $.each(productos, function(index, producto) {
                    productosHtml += '<option value="' + producto.id_producto + '">' + producto.nombre_producto + '</option>';
                });
                
                var modalContent = `
                    <div class="modal fade" id="modalAjusteStock" tabindex="-1" aria-labelledby="modalAjusteStockLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalAjusteStockLabel">Ajuste de Stock</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="formAjusteStock">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="productoAjuste" class="form-label">Producto</label>
                                                    <select class="form-select" id="productoAjuste" required>
                                                        ${productosHtml}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tipoMovimientoAjuste" class="form-label">Tipo de Movimiento</label>
                                                    <select class="form-select" id="tipoMovimientoAjuste" required>
                                                        <option value="entrada">Entrada</option>
                                                        <option value="salida">Salida</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="cantidadAjuste" class="form-label">Cantidad</label>
                                                    <input type="number" class="form-control" id="cantidadAjuste" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="referenciaAjuste" class="form-label">Referencia</label>
                                                    <input type="text" class="form-control" id="referenciaAjuste" placeholder="Número de pedido, factura, etc.">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="descripcionAjuste" class="form-label">Descripción</label>
                                            <textarea class="form-control" id="descripcionAjuste" rows="2"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary" id="guardarAjusteStock">Guardar Ajuste</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                $('body').append(modalContent);
                $('#modalAjusteStock').modal('show');
                
                // Evento para guardar ajuste
                $('#guardarAjusteStock').click(function() {
                    guardarAjusteStock();
                });
            }
        });
    }

    // Función para guardar ajuste de stock
    function guardarAjusteStock() {
        var id_producto = $('#productoAjuste').val();
        var tipo = $('#tipoMovimientoAjuste').val();
        var cantidad = $('#cantidadAjuste').val();
        var referencia = $('#referenciaAjuste').val();
        var descripcion = $('#descripcionAjuste').val();
        
        if (!id_producto || !cantidad) {
            alert('Complete todos los campos obligatorios');
            return;
        }
        
        // Enviar datos al servidor
        $.ajax({
            url: "../ajax/actualizar_stock.php",
            method: "POST",
            data: {
                id_producto: id_producto,
                tipo_movimiento: tipo,
                cantidad: cantidad,
                referencia: referencia,
                descripcion: descripcion
            },
            success: function(response) {
                if (response.success) {
                    alert('Ajuste de stock guardado correctamente');
                    $('#modalAjusteStock').modal('hide');
                    // Recargar tablas
                    $('#tablaStockBajo').DataTable().ajax.reload();
                    $('#tablaStockCompleta').DataTable().ajax.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error en la conexión');
            }
        });
    }

    // Función para abrir ventana de historial de movimientos
    function abrirHistorialMovimientos() {
        var modalContent = `
            <div class="modal fade" id="modalHistorialMovimientos" tabindex="-1" aria-labelledby="modalHistorialMovimientosLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalHistorialMovimientosLabel">Historial de Movimientos de Stock</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table id="tablaMovimientos" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Producto</th>
                                            <th>Tipo</th>
                                            <th>Cantidad</th>
                                            <th>Referencia</th>
                                            <th>Fecha</th>
                                            <th>Usuario</th>
                                            <th>Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(modalContent);
        $('#modalHistorialMovimientos').modal('show');
        
        // Inicializar DataTable para movimientos
        $('#tablaMovimientos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": "../ajax/movimientos_stock.php",
            "columns": [
                {"data": "0"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4"},
                {"data": "5"},
                {"data": "6"},
                {"data": "7"}
            ],
            "order": [[5, "desc"]]
        });
    }

    // En la función addRandomTab3 (pedidos) - ya la teníamos
    // ... (código existente hasta el punto de contabilidad)



// Agregamos también la función para Libro Diario
$('#addRandomTab7').on('click', function (e) {
    if ($('#contabilidad_libro_diario').length == 0) {
        var randIdx1 = 'Libro Diario';
        var randIdx2 = 'contabilidad_libro_diario';
        $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, 
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <div class="pull-right">' +
                '           <button type="button" class="btn btn-primary" id="nuevoAsiento">' +
                '               <i class="fa fa-plus"></i> Nuevo Asiento' +
                '           </button>' +
                '           <button type="button" class="btn btn-default" id="importarAsientos">' +
                '               <i class="fa fa-download"></i> Importar Asientos' +
                '           </button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Registro de Asientos Contables</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <div class="table-responsive">' +
                '                   <table id="tablaAsientosContables" class="table table-striped table-bordered">' +
                '                       <thead>' +
                '                           <tr>' +
                '                               <th>Número</th>' +
                '                               <th>Fecha</th>' +
                '                               <th>Concepto</th>' +
                '                               <th>Cuenta Débito</th>' +
                '                               <th>Cuenta Crédito</th>' +
                '                               <th>Importe (€)</th>' +
                '                               <th>Acciones</th>' +
                '                           </tr>' +
                '                       </thead>' +
                '                       <tbody></tbody>' +
                '                   </table>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '</div>'
            );
        
        // Inicializar DataTables para movimientos contables
        $('#tablaAsientosContables').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": "../ajax/contabilidad_asientos.php",
            "columns": [
                {"data": "0"}, // numero_asiento
                {"data": "1"}, // fecha
                {"data": "2"}, // concepto
                {"data": "3"}, // cuenta_debe
                {"data": "4"}, // cuenta_haber
                {"data": "5", "render": function(data) { 
                    return "€" + parseFloat(data).toFixed(2); 
                }},
                {"data": "6", "orderable": false, "searchable": false}
            ],
            "order": [[0, "desc"]]
        });
        
        // Evento para nuevo movimiento
        $('#nuevoAsiento').click(function() {
            abrirModalNuevoAsiento();
        });
    }
});

// Función para cargar el modal de nuevo asiento
function cargarModalNuevoAsiento() {
    // Verificar si el modal ya existe
    if ($('#modalNuevoAsiento').length === 0) {
        // Crear el modal dinámicamente
        var modalHTML = `
            <!-- Modal para Nuevo Asiento -->
            <div class="modal fade" id="modalNuevoAsiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Nuevo Asiento Contable</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formNuevoAsiento">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fechaAsiento">Fecha</label>
                                            <input type="date" class="form-control" id="fechaAsiento" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="conceptoAsiento">Concepto</label>
                                            <input type="text" class="form-control" id="conceptoAsiento" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cuentaDebe">Cuenta Débito</label>
                                            <select class="form-control" id="cuentaDebe" required>
                                                <option value="">Seleccione una cuenta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cuentaHaber">Cuenta Crédito</label>
                                            <select class="form-control" id="cuentaHaber" required>
                                                <option value="">Seleccione una cuenta</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="importeAsiento">Importe (€)</label>
                                            <input type="number" step="0.01" class="form-control" id="importeAsiento" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="referenciaAsiento">Referencia</label>
                                            <input type="text" class="form-control" id="referenciaAsiento">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descripcionAsiento">Descripción</label>
                                            <textarea class="form-control" id="descripcionAsiento" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="guardarAsiento">Guardar Asiento</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Agregar el modal al body
        $('body').append(modalHTML);
        
        // Evento para cerrar el modal y limpiar formulario
        $('#modalNuevoAsiento').on('hidden.bs.modal', function () {
            $('#formNuevoAsiento')[0].reset();
            $(this).find('select').val('');
        });
        
        // Evento para guardar el asiento
        $(document).on('click', '#guardarAsiento', function() {
            guardarAsiento();
        });
    }
}

// Función para abrir el modal de nuevo asiento
function abrirModalNuevoAsiento() {
    // Cargar el modal si no existe
    cargarModalNuevoAsiento();
    
    // Cargar las cuentas contables para los selects
    $.ajax({
        url: '../ajax/cargar_cuentas.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Limpiar opciones anteriores
                $('#cuentaDebe').empty().append('<option value="">Seleccione una cuenta</option>');
                $('#cuentaHaber').empty().append('<option value="">Seleccione una cuenta</option>');
                
                // Añadir nuevas opciones
                $.each(response.cuentas, function(index, cuenta) {
                    $('#cuentaDebe').append('<option value="' + cuenta.id_cuenta + '">' + cuenta.codigo_cuenta + ' - ' + cuenta.nombre_cuenta + '</option>');
                    $('#cuentaHaber').append('<option value="' + cuenta.id_cuenta + '">' + cuenta.codigo_cuenta + ' - ' + cuenta.nombre_cuenta + '</option>');
                });
                
                // Mostrar el modal
                $('#modalNuevoAsiento').modal('show');
            } else {
                alert('Error al cargar las cuentas: ' + response.message);
            }
        },
        error: function() {
            alert('Error al cargar las cuentas');
        }
    });
}

// Función para guardar el asiento
function guardarAsiento() {
    // Validar campos
    if (!$('#fechaAsiento').val() || !$('#conceptoAsiento').val() || 
        !$('#cuentaDebe').val() || !$('#cuentaHaber').val() || 
        !$('#importeAsiento').val()) {
        alert('Por favor complete todos los campos obligatorios');
        return;
    }
    
    // Verificar que las cuentas sean diferentes
    if ($('#cuentaDebe').val() === $('#cuentaHaber').val()) {
        alert('Las cuentas de débito y crédito no pueden ser iguales');
        return;
    }
    
    // Preparar datos para enviar
    var datos = {
        fecha: $('#fechaAsiento').val(),
        concepto: $('#conceptoAsiento').val(),
        cuenta_debe: $('#cuentaDebe').val(),
        cuenta_haber: $('#cuentaHaber').val(),
        importe: $('#importeAsiento').val(),
        referencia: $('#referenciaAsiento').val(),
        descripcion: $('#descripcionAsiento').val()
    };
    
    // Enviar datos mediante AJAX
    $.ajax({
        url: '../ajax/guardar_asiento.php',
        type: 'POST',
        data: datos,
        dataType: 'json',
        beforeSend: function() {
            $('#guardarAsiento').prop('disabled', true).text('Guardando...');
        },
        success: function(response) {
            if (response.success) {
                alert('Asiento guardado correctamente');
                $('#modalNuevoAsiento').modal('hide');
                // Refrescar la tabla de asientos
                if ($('#tablaAsientosContables').length > 0) {
                    $('#tablaAsientosContables').DataTable().ajax.reload();
                }
                // Limpiar formulario
                $('#formNuevoAsiento')[0].reset();
            } else {
                alert('Error al guardar el asiento: ' + response.message);
            }
        },
        error: function() {
            alert('Error al guardar el asiento');
        },
        complete: function() {
            $('#guardarAsiento').prop('disabled', false).text('Guardar Asiento');
        }
    });
}
// Función para el Libro Mayor
$('#addRandomTab71').on('click', function (e) {
    if ($('#contabilidad_libro_mayor').length == 0) {
        var randIdx1 = 'Libro Mayor';
        var randIdx2 = 'contabilidad_libro_mayor';
        $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, 
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <div class="pull-right">' +
                '           <button type="button" class="btn btn-default" id="verBalance">' +
                '               <i class="fa fa-file-text"></i> Ver Balance' +
                '           </button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Libro Mayor</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <div class="table-responsive">' +
                '                   <table id="tablaMayorContable" class="table table-striped table-bordered">' +
                '                       <thead>' +
                '                           <tr>' +
                '                               <th>Cuenta</th>' +
                '                               <th>Saldo Inicial</th>' +
                '                               <th>Total Débitos</th>' +
                '                               <th>Total Créditos</th>' +
                '                               <th>Saldo Final</th>' +
                '                               <th>Acciones</th>' +
                '                           </tr>' +
                '                       </thead>' +
                '                       <tbody></tbody>' +
                '                   </table>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '</div>'
            );
        
        // Inicializar DataTables para libro mayor
        $('#tablaMayorContable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "../ajax/contabilidad_mayor.php",
                "type": "POST",
                "dataSrc": "data",
                "error": function(xhr, error, thrown) {
                    console.log("Error AJAX Libro Mayor:", xhr, error, thrown);
                }
            },
            "columns": [
                {"data": "0"}, // cuenta
                {"data": "1", "render": function(data) { return "€" + parseFloat(data).toFixed(2); }}, // saldo_inicial
                {"data": "2", "render": function(data) { return "€" + parseFloat(data).toFixed(2); }}, // total_debitos
                {"data": "3", "render": function(data) { return "€" + parseFloat(data).toFixed(2); }}, // total_creditos
                {"data": "4", "render": function(data) { return "€" + parseFloat(data).toFixed(2); }}, // saldo_final
                {"data": "5", "orderable": false, "searchable": false} // acciones
            ],
            "order": [[0, "asc"]],
            "drawCallback": function(settings) {
                console.log("Libro Mayor dibujado, registros:", settings.fnRecordsDisplay());
            }
        });
    }
});
// Función para el Plan de Cuentas
$('#addRandomTab72').on('click', function (e) {
    if ($('#contabilidad_plan_cuentas').length == 0) {
        var randIdx1 = 'Plan de Cuentas';
        var randIdx2 = 'contabilidad_plan_cuentas';
        $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, 
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <div class="pull-right">' +
                '           <button type="button" class="btn btn-primary" id="nuevaCuenta">' +
                '               <i class="fa fa-plus"></i> Nueva Cuenta' +
                '           </button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Plan de Cuentas Contable</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <div class="table-responsive">' +
                '                   <table id="tablaPlanCuentasContables" class="table table-striped table-bordered">' +
                '                       <thead>' +
                '                           <tr>' +
                '                               <th>Código</th>' +
                '                               <th>Nombre</th>' +
                '                               <th>Naturaleza</th>' +
                '                               <th>Grupo</th>' +
                '                               <th>Acciones</th>' +
                '                           </tr>' +
                '                       </thead>' +
                '                       <tbody></tbody>' +
                '                   </table>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '</div>'
            );
        
        // Inicializar DataTables para plan de cuentas
        $('#tablaPlanCuentasContables').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": "../ajax/contabilidad_plan_cuentas.php",
            "columns": [
                {"data": "0"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4", "orderable": false, "searchable": false}
            ]
        });
        
        // Evento para nueva cuenta
        $('#nuevaCuenta').click(function() {
            abrirModalNuevaCuenta();
        });
    }
});

// Función para abrir el modal de nueva cuenta
function abrirModalNuevaCuenta() {
    // Cargar el modal si no existe
    if ($('#modalNuevaCuenta').length === 0) {
        // Crear el modal dinámicamente
        var modalHTML = `
            <!-- Modal para Nueva Cuenta -->
            <div class="modal fade" id="modalNuevaCuenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabelNuevaCuenta">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabelNuevaCuenta">Nueva Cuenta Contable</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formNuevaCuenta">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="codigoCuenta">Código de Cuenta *</label>
                                            <input type="text" class="form-control" id="codigoCuenta" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombreCuenta">Nombre de Cuenta *</label>
                                            <input type="text" class="form-control" id="nombreCuenta" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="naturalezaCuenta">Naturaleza *</label>
                                            <select class="form-control" id="naturalezaCuenta" required>
                                                <option value="">Seleccione...</option>
                                                <option value="activo">Activo</option>
                                                <option value="pasivo">Pasivo</option>
                                                <option value="patrimonio">Patrimonio</option>
                                                <option value="ingreso">Ingreso</option>
                                                <option value="gasto">Gasto</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nivelCuenta">Nivel *</label>
                                            <select class="form-control" id="nivelCuenta" required>
                                                <option value="">Seleccione...</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descripcionCuenta">Descripción</label>
                                            <textarea class="form-control" id="descripcionCuenta" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="guardarCuenta">Guardar Cuenta</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Agregar el modal al body
        $('body').append(modalHTML);
        
        // Evento para guardar la cuenta
        $(document).on('click', '#guardarCuenta', function() {
            guardarCuenta();
        });
        
        // Evento para cerrar el modal y limpiar formulario
        $('#modalNuevaCuenta').on('hidden.bs.modal', function () {
            $('#formNuevaCuenta')[0].reset();
            $(this).find('select').val('');
        });
    }
    
    // Mostrar el modal
    $('#modalNuevaCuenta').modal('show');
}

// Función para guardar la cuenta
function guardarCuenta() {
    // Validar campos
    if (!$('#codigoCuenta').val() || !$('#nombreCuenta').val() || 
        !$('#naturalezaCuenta').val() || !$('#nivelCuenta').val()) {
        alert('Por favor complete todos los campos obligatorios');
        return;
    }
    
    // Preparar datos para enviar
    var datos = {
        codigo_cuenta: $('#codigoCuenta').val(),
        nombre_cuenta: $('#nombreCuenta').val(),
        naturaleza: $('#naturalezaCuenta').val(),
        nivel: $('#nivelCuenta').val(),
        descripcion: $('#descripcionCuenta').val()
    };
    
    // Enviar datos mediante AJAX
    $.ajax({
        url: '../ajax/guardar_cuenta.php',
        type: 'POST',
        data: datos,
        dataType: 'json',
        beforeSend: function() {
            $('#guardarCuenta').prop('disabled', true).text('Guardando...');
        },
        success: function(response) {
            if (response.success) {
                alert('Cuenta guardada correctamente');
                $('#modalNuevaCuenta').modal('hide');
                // Refrescar la tabla de cuentas
                if ($('#tablaPlanCuentasContables').length > 0) {
                    $('#tablaPlanCuentasContables').DataTable().ajax.reload();
                }
                // Limpiar formulario
                $('#formNuevaCuenta')[0].reset();
            } else {
                alert('Error al guardar la cuenta: ' + response.message);
            }
        },
        error: function() {
            alert('Error al guardar la cuenta');
        },
        complete: function() {
            $('#guardarCuenta').prop('disabled', false).text('Guardar Cuenta');
        }
    });
}
// Función para el Catálogo de Cuentas
$('#addRandomTab73').on('click', function (e) {
    if ($('#contabilidad_catalogo').length == 0) {
        var randIdx1 = 'Catálogo de Cuentas';
        var randIdx2 = 'contabilidad_catalogo';
        $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, 
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <div class="pull-right">' +
                '           <button type="button" class="btn btn-primary" id="nuevaSubcuenta">' +
                '               <i class="fa fa-plus"></i> Nueva Subcuenta' +
                '           </button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Catálogo de Cuentas Puente / Subcuentas</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <div class="table-responsive">' +
                '                   <table id="tablaCatalogoCuentas" class="table table-striped table-bordered">' +
                '                       <thead>' +
                '                           <tr>' +
                '                               <th>Código</th>' +
                '                               <th>Nombre</th>' +
                '                               <th>Tipo</th>' +
                '                               <th>Referencia</th>' +
                '                               <th>Acciones</th>' +
                '                           </tr>' +
                '                       </thead>' +
                '                       <tbody></tbody>' +
                '                   </table>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '</div>'
            );
        
        // Inicializar DataTables para catálogo de cuentas
        $('#tablaCatalogoCuentas').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": "../ajax/contabilidad_catalogo.php",
            "columns": [
                {"data": "0"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4", "orderable": false, "searchable": false}
            ]
        });
        
        // Evento para nueva subcuenta
        $('#nuevaSubcuenta').click(function() {
            abrirModalNuevaSubcuenta();
        });
    }
});

// Función para abrir el modal de nueva subcuenta
function abrirModalNuevaSubcuenta() {
    // Cargar el modal si no existe
    if ($('#modalNuevaSubcuenta').length === 0) {
        // Crear el modal dinámicamente
        var modalHTML = `
            <!-- Modal para Nueva Subcuenta -->
            <div class="modal fade" id="modalNuevaSubcuenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabelNuevaSubcuenta">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabelNuevaSubcuenta">Nueva Subcuenta Contable</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formNuevaSubcuenta">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="codigoSubcuenta">Código de Subcuenta *</label>
                                            <input type="text" class="form-control" id="codigoSubcuenta" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombreSubcuenta">Nombre de Subcuenta *</label>
                                            <input type="text" class="form-control" id="nombreSubcuenta" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipoSubcuenta">Tipo de Subcuenta *</label>
                                            <select class="form-control" id="tipoSubcuenta" required>
                                                <option value="">Seleccione...</option>
                                                <option value="cliente">Cliente</option>
                                                <option value="proveedor">Proveedor</option>
                                                <option value="centro_coste">Centro de Coste</option>
                                                <option value="proyecto">Proyecto</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="referenciaId">Referencia *</label>
                                            <select class="form-control" id="referenciaId" required>
                                                <option value="">Seleccione...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descripcionSubcuenta">Descripción</label>
                                            <textarea class="form-control" id="descripcionSubcuenta" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="guardarSubcuenta">Guardar Subcuenta</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Agregar el modal al body
        $('body').append(modalHTML);
        
        // Evento para cambiar el tipo de subcuenta y cargar referencias
        $('#tipoSubcuenta').change(function() {
            cargarReferencias($(this).val());
        });
        
        // Evento para guardar la subcuenta
        $(document).on('click', '#guardarSubcuenta', function() {
            guardarSubcuenta();
        });
        
        // Evento para cerrar el modal y limpiar formulario
        $('#modalNuevaSubcuenta').on('hidden.bs.modal', function () {
            $('#formNuevaSubcuenta')[0].reset();
            $(this).find('select').val('');
        });
    }
    
    // Mostrar el modal
    $('#modalNuevaSubcuenta').modal('show');
}

// Función para cargar referencias según el tipo
function cargarReferencias(tipo) {
    if (!tipo) {
        $('#referenciaId').empty().append('<option value="">Seleccione...</option>');
        return;
    }
    
    var url = '';
    if (tipo === 'cliente') {
        url = '../ajax/cargar_datos_clientes.php';
    } else if (tipo === 'proveedor') {
        url = '../ajax/cargar_datos_proveedores.php';
    } else {
        $('#referenciaId').empty().append('<option value="">Seleccione...</option>');
        return;
    }
    
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var options = '<option value="">Seleccione...</option>';
                if (tipo === 'cliente') {
                    $.each(response.clientes, function(index, cliente) {
                        options += '<option value="' + cliente.id_cliente + '">' + cliente.nombre_cliente + '</option>';
                    });
                } else if (tipo === 'proveedor') {
                    $.each(response.proveedores, function(index, proveedor) {
                        options += '<option value="' + proveedor.id_proveedor + '">' + proveedor.nombre_proveedor + '</option>';
                    });
                }
                $('#referenciaId').html(options);
            } else {
                alert('Error al cargar referencias: ' + response.message);
            }
        },
        error: function() {
            alert('Error al cargar referencias');
        }
    });
}
// Función para guardar la subcuenta
function guardarSubcuenta() {
    // Validar campos
    if (!$('#codigoSubcuenta').val() || !$('#nombreSubcuenta').val() || 
        !$('#tipoSubcuenta').val() || !$('#referenciaId').val()) {
        alert('Por favor complete todos los campos obligatorios');
        return;
    }
    
    // Preparar datos para enviar
    var datos = {
        codigo_subcuenta: $('#codigoSubcuenta').val(),
        nombre_subcuenta: $('#nombreSubcuenta').val(),
        tipo_subcuenta: $('#tipoSubcuenta').val(),
        referencia_id: $('#referenciaId').val(),
        descripcion: $('#descripcionSubcuenta').val()
    };
    
    // Enviar datos mediante AJAX
    $.ajax({
        url: '../ajax/guardar_subcuenta.php',
        type: 'POST',
        data:  datos,
        dataType: 'json',
        beforeSend: function() {
            $('#guardarSubcuenta').prop('disabled', true).text('Guardando...');
        },
        success: function(response) {
            if (response.success) {
                alert('Subcuenta guardada correctamente');
                $('#modalNuevaSubcuenta').modal('hide');
                // Refrescar la tabla de subcuentas
                if ($('#tablaCatalogoCuentas').length > 0) {
                    $('#tablaCatalogoCuentas').DataTable().ajax.reload();
                }
                // Limpiar formulario
                $('#formNuevaSubcuenta')[0].reset();
            } else {
                alert('Error al guardar la subcuenta: ' + response.message);
            }
        },
        error: function() {
            alert('Error al guardar la subcuenta');
        },
        complete: function() {
            $('#guardarSubcuenta').prop('disabled', false).text('Guardar Subcuenta');
        }
    });
}



// Agregamos también la función para presupuestos
$('#addRandomTab8').on('click', function (e) {
    if ($('#presupuestos').length == 0) {
        var randIdx1 = 'Presupuestos';
        var randIdx2 = 'presupuestos';
        $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1,
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <div class="pull-right">' +
                '           <button type="button" class="btn btn-primary" id="nuevoPresupuesto">' +
                '               <i class="fa fa-plus"></i> Nuevo Presupuesto' +
                '           </button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Lista de Presupuestos</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <table id="tablaPresupuestos" class="table table-bordered table-striped">' +
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

        // Inicializar DataTables para presupuestos
        $('#tablaPresupuestos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": "../ajax/buscar_presupuestos.php",
                "type": "GET",
                "dataSrc": "data"
            },
            "columns": [
                {"data": "0"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4"},
                {"data": "5"}
            ],
          "drawCallback": function() {
    // Añadir evento para generar PDF
    $('.generar-pdf-presupuesto').off('click').on('click', function() {
        var id_presupuesto = $(this).data('id');
        
        // Intentar usar VentanaCentrada si está definida
        if (typeof VentanaCentrada !== 'undefined') {
            // Usar VentanaCentrada si está disponible
            VentanaCentrada(
                '../html2pdf/documentos/generar_presupuesto_pdf.php?id_presupuesto=' + id_presupuesto,
                'Presupuesto',
                '',
                '1024',
                '768',
                'true'
            );
        } else {
            // Fallback a window.open si VentanaCentrada no está definida
            window.open(
                '../html2pdf/documentos/generar_presupuesto_pdf.php?id_presupuesto=' + id_presupuesto,
                'Presupuesto',
                'width=1024,height=768,scrollbars=yes,resizable=yes,toolbar=no,menubar=no,location=no'
            );
        }
    });
}
        });

        // Evento para nuevo presupuesto
        $('#nuevoPresupuesto').click(function() {
            abrirModalNuevoPresupuesto();
        });
    }
});

// Función para abrir modal de nuevo presupuesto
function abrirModalNuevoPresupuesto() {
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
                <div class="modal fade" id="modalNuevoPresupuesto" tabindex="-1" aria-labelledby="modalNuevoPresupuestoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalNuevoPresupuestoLabel">Nuevo Presupuesto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formNuevoPresupuesto">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="clientePresupuesto" class="form-label">Cliente</label>
                                                <select class="form-select" id="clientePresupuesto" required>
                                                    ${clientesHtml}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="vendedorPresupuesto" class="form-label">Vendedor</label>
                                                <select class="form-select" id="vendedorPresupuesto" required>
                                                    <option value="${sessionStorage.getItem('userId') || 1}">Mi perfil</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="condicionesPresupuesto" class="form-label">Condiciones de pago</label>
                                                <select class="form-select" id="condicionesPresupuesto">
                                                    <option value="Efectivo">Efectivo</option>
                                                    <option value="Transferencia">Transferencia</option>
                                                    <option value="Giro 30 Dias">Giro 30 Dias</option>
                                                    <option value="Giro 60 Dias">Giro 60 Dias</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="descuentoPresupuesto" class="form-label">Descuento (%)</label>
                                                <input type="number" class="form-control" id="descuentoPresupuesto" min="0" max="100" value="0">
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
                                            <button type="button" id="agregarProductoPresupuesto" class="btn btn-secondary mt-2">
                                                <i class="fas fa-plus"></i> Agregar Producto
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="alert alert-info">
                                                <strong>Total:</strong> <span id="totalPresupuesto">€0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" id="guardarPresupuestoBtn">Guardar Presupuesto</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $('body').append(modalContent);
            $('#modalNuevoPresupuesto').modal('show');

            // Cargar productos cuando se abre el modal
            cargarProductosModal();

            // Eventos para el modal
            $('#agregarProductoPresupuesto').on('click', function() {
                agregarProductoPresupuesto();
            });

            $(document).on('change', '.producto-select', function() {
                var precio = $(this).find('option:selected').data('precio');
                var precioInput = $(this).closest('.producto-item').find('.precio-input');
                precioInput.val(precio);
                calcularSubtotal($(this).closest('.producto-item'));
                calcularTotalPresupuesto();
            });

            $(document).on('input', '.cantidad-input, .precio-input', function() {
                calcularSubtotal($(this).closest('.producto-item'));
                calcularTotalPresupuesto();
            });

            $(document).on('click', '.remove-producto', function() {
                $(this).closest('.producto-item').remove();
                calcularTotalPresupuesto();
            });

            $('#guardarPresupuestoBtn').on('click', function() {
                guardarPresupuesto();
            });
        },
        error: function() {
            alert('Error al cargar clientes');
        }
    });
}

// Función para cargar productos en el modal (ya estaba)
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

// Función para agregar producto al presupuesto (ya estaba)
function agregarProductoPresupuesto() {
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
        calcularTotalPresupuesto();
    });

    $(document).on('input', '.cantidad-input, .precio-input', function() {
        calcularSubtotal($(this).closest('.producto-item'));
        calcularTotalPresupuesto();
    });
}

// Función para calcular subtotal de un producto (ya estaba)
function calcularSubtotal(item) {
    var cantidad = parseFloat(item.find('.cantidad-input').val()) || 0;
    var precio = parseFloat(item.find('.precio-input').val()) || 0;
    var subtotal = cantidad * precio;
    item.find('.subtotal-input').val('€' + subtotal.toFixed(2));
}

// Función para calcular total del presupuesto (ya estaba)
function calcularTotalPresupuesto() {
    var total = 0;
    $('.producto-item').each(function() {
        var cantidad = parseFloat($(this).find('.cantidad-input').val()) || 0;
        var precio = parseFloat($(this).find('.precio-input').val()) || 0;
        total += cantidad * precio;
    });
    $('#totalPresupuesto').text('€' + total.toFixed(2));
}

// Función para guardar presupuesto (ya estaba)
function guardarPresupuesto() {
    var id_cliente = $('#clientePresupuesto').val();
    var id_vendedor = $('#vendedorPresupuesto').val();
    var condiciones = $('#condicionesPresupuesto').val();
    var descuento = $('#descuentoPresupuesto').val();

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
        url: "../ajax/guardar_presupuesto.php",
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
                alert('Presupuesto guardado correctamente');
                $('#modalNuevoPresupuesto').modal('hide');
                // Recargar tabla de presupuestos
                $('#tablaPresupuestos').DataTable().ajax.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Error en la conexión');
        }
    });
}

// Agregar la función para Perfil después de la función guardarNuevoMovimiento
$('#addRandomTab9').on('click', function (e) {
    if ($('#perfil_empresa').length == 0) {
        var randIdx1 = 'Perfil Empresa';
        var randIdx2 = 'perfil_empresa';
$('#example_0').data('uiScrollTabs')
    .addTab1(randIdx2, randIdx1, 
        '<div class="row">' +
        '   <div class="col-md-12">' +
        '       <div class="pull-right">' +
        '           <button type="button" class="btn btn-primary" id="guardarPerfil">' +
        '               <i class="fa fa-save"></i> Guardar Perfil' +
        '           </button>' +
        '       </div>' +
        '   </div>' +
        '   <div class="col-md-12">' +
        '       <div class="box">' +
        '           <div class="box-header">' +
        '               <h3 class="box-title">Editar Perfil Empresa</h3>' +
        '           </div>' +
        '           <div class="box-body">' +
        '               <form id="formPerfil">' +
        '                   <div class="row">' +
        '                       <div class="col-md-6">' +
        '                           <div class="mb-3">' +
        '                               <label for="nombre_empresa" class="form-label">Nombre de Empresa</label>' +
        '                               <input type="text" class="form-control" id="nombre_empresa" required>' +
        '                           </div>' +
        '                       </div>' +
        '                       <div class="col-md-6">' +
        '                           <div class="mb-3">' +
        '                               <label for="cif" class="form-label">CIF</label>' +
        '                               <input type="text" class="form-control" id="cif">' +
        '                           </div>' +
        '                       </div>' +
        '                   </div>' +
        '                   <div class="row">' +
        '                       <div class="col-md-6">' +
        '                           <div class="mb-3">' +
        '                               <label for="direccion" class="form-label">Dirección</label>' +
        '                               <input type="text" class="form-control" id="direccion">' +
        '                           </div>' +
        '                       </div>' +
        '                       <div class="col-md-6">' +
        '                           <div class="mb-3">' +
        '                               <label for="ciudad" class="form-label">Ciudad</label>' +
        '                               <input type="text" class="form-control" id="ciudad">' +
        '                           </div>' +
        '                       </div>' +
        '                   </div>' +
        '                   <div class="row">' +
        '                       <div class="col-md-6">' +
        '                           <div class="mb-3">' +
        '                               <label for="codigo_postal" class="form-label">Código Postal</label>' +
        '                               <input type="text" class="form-control" id="codigo_postal">' +
        '                           </div>' +
        '                       </div>' +
        '                       <div class="col-md-6">' +
        '                           <div class="mb-3">' +
        '                               <label for="estado" class="form-label">Estado</label>' +
        '                               <input type="text" class="form-control" id="estado">' +
        '                           </div>' +
        '                       </div>' +
        '                   </div>' +
        '                   <div class="row">' +
        '                       <div class="col-md-6">' +
        '                           <div class="mb-3">' +
        '                               <label for="telefono" class="form-label">Teléfono</label>' +
        '                               <input type="text" class="form-control" id="telefono">' +
        '                           </div>' +
        '                       </div>' +
        '                       <div class="col-md-6">' +
        '                           <div class="mb-3">' +
        '                               <label for="email" class="form-label">Email</label>' +
        '                               <input type="email" class="form-control" id="email">' +
        '                           </div>' +
        '                       </div>' +
        '                   </div>' +
        '                   <div class="row">' +
        '                       <div class="col-md-6">' +
        '                           <div class="mb-3">' +
        '                               <label for="impuesto" class="form-label">Impuesto (%)</label>' +
        '                               <input type="number" class="form-control" id="impuesto" min="0" max="100" step="0.01">' +
        '                           </div>' +
        '                       </div>' +
        '                       <div class="col-md-6">' +
        '                           <div class="mb-3">' +
        '                               <label for="moneda" class="form-label">Moneda</label>' +
        '                               <select class="form-select" id="moneda" required>' +
        '                                   <option value="€">Euro (€)</option>' +
        '                                   <option value="$">Dólar ($)</option>' +
        '                                   <option value="£">Libra (£)</option>' +
        '                                   <option value="¥">Yen (¥)</option>' +
        '                                   <option value="R$">Real (R$)</option>' +
        '                                   <option value="C$">Dólar Canadiense (C$)</option>' +
        '                                   <option value="A$">Dólar Australiano (A$)</option>' +
        '                                   <option value="CHF">Franco Suizo (CHF)</option>' +
        '                                   <option value="JPY">Yen Japonés (¥)</option>' +
        '                                   <option value="CAD">Dólar Canadiense (CAD)</option>' +
        '                                   <option value="AUD">Dólar Australiano (AUD)</option>' +
        '                                   <option value="GBP">Libra Esterlina (GBP)</option>' +
        '                                   <option value="MXN">Peso Mexicano (MXN)</option>' +
        '                                   <option value="BRL">Real Brasileño (BRL)</option>' +
        '                                   <option value="SEK">Corona Sueca (SEK)</option>' +
        '                                   <option value="NZD">Dólar Neozelandés (NZD)</option>' +
        '                                   <option value="HKD">Dólar de Hong Kong (HKD)</option>' +
        '                                   <option value="SGD">Dólar de Singapur (SGD)</option>' +
        '                                   <option value="NOK">Corona Noruega (NOK)</option>' +
        '                                   <option value="KRW">Won Surcoreano (₩)</option>' +
        '                                   <option value="TRY">Lira Turca (₺)</option>' +
        '                                   <option value="INR">Rupia India (₹)</option>' +
        '                                   <option value="">Otra</option>' +
        '                               </select>' +
        '                           </div>' +
        '                       </div>' +
        '                   </div>' +
        '                   <div class="row">' +
        '                       <div class="col-md-12">' +
        '                           <div class="mb-3">' +
        '                               <label for="logo_url" class="form-label">Logo URL</label>' +
        '                               <div class="input-group">' +
        '                                   <input type="text" class="form-control" id="logo_url">' +
        '                                   <button type="button" class="btn btn-outline-secondary" id="subirLogoBtn">Subir Logo</button>' +
        '                               </div>' +
        '                               <div class="mt-2">' +
        '                                   <input type="file" class="form-control" id="logoFile" accept="image/*">' +
        '                               </div>' +
        '                               <div class="mt-2">' +
        '                                   <img id="previewLogo" src="" alt="Vista previa del logo" style="max-height: 100px; display: none;">' +
        '                               </div>' +
        '                           </div>' +
        '                       </div>' +
        '                   </div>' +
        '                   <input type="hidden" id="id_perfil">' +
        '               </form>' +
        '           </div>' +
        '       </div>' +
        '   </div>' +
        '</div>'
    );
        

     // Cargar datos del perfil
    $.ajax({
    url: "../ajax/cargar_perfil.php",
    method: "GET",
    success: function(perfil) {
        if (perfil) {
            $('#id_perfil').val(perfil.id_perfil);
            $('#nombre_empresa').val(perfil.nombre_empresa);
            $('#direccion').val(perfil.direccion);
            $('#ciudad').val(perfil.ciudad);
            $('#codigo_postal').val(perfil.codigo_postal);
            $('#estado').val(perfil.estado);
            $('#telefono').val(perfil.telefono);
            $('#email').val(perfil.email);
            $('#cif').val(perfil.cif);
            $('#impuesto').val(perfil.impuesto);
            $('#moneda').val(perfil.moneda);
            $('#logo_url').val(perfil.logo_url);
            
            // Mostrar vista previa del logo si existe
            if (perfil.logo_url) {
                $('#previewLogo').attr('src', perfil.logo_url).show();
            }
        }
    }
});


        
        // Evento para guardar perfil
        $('#guardarPerfil').click(function() {
            guardarPerfil();
        });
        
        // Evento para subir logo
       $('#subirLogoBtn').click(function() {
            subirLogo();
      });
      
      // Evento para previsualizar imagen al seleccionar archivo
    $('#logoFile').change(function() {
    var input = this;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#previewLogo').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(input.files[0]);
    }
});

    }
});

// Función para guardar perfil
function guardarPerfil() {
    var id_perfil = $('#id_perfil').val();
    var nombre_empresa = $('#nombre_empresa').val();
    var direccion = $('#direccion').val();
    var ciudad = $('#ciudad').val();
    var codigo_postal = $('#codigo_postal').val();
    var estado = $('#estado').val();
    var telefono = $('#telefono').val();
    var email = $('#email').val();
    var cif = $('#cif').val();
    var impuesto = $('#impuesto').val();
    var moneda = $('#moneda').val();
    var logo_url = $('#logo_url').val();
    
    // Enviar datos al servidor
    $.ajax({
        url: "../ajax/guardar_perfil.php",
        method: "POST",
        data: {
            id_perfil: id_perfil,
            nombre_empresa: nombre_empresa,
            direccion: direccion,
            ciudad: ciudad,
            codigo_postal: codigo_postal,
            estado: estado,
            telefono: telefono,
            email: email,
            cif: cif,
            impuesto: impuesto,
            moneda: moneda,
            logo_url: logo_url
        },
        success: function(response) {
            if (response.success) {
                alert('Perfil actualizado correctamente');
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Error en la conexión');
        }
    });
}

// Función para subir logo
function subirLogo() {
    var formData = new FormData();
    var fileInput = $('#logoFile')[0];
    
    if (fileInput.files.length === 0) {
        alert('Por favor seleccione una imagen');
        return;
    }
    
    formData.append('logo', fileInput.files[0]);
    
    $.ajax({
        url: "../ajax/subir_logo.php",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                $('#logo_url').val(response.url);
                $('#previewLogo').attr('src', '../' + response.url);
                alert('Imagen subida correctamente');
            } else {
                alert('Error al subir imagen: ' + response.message);
            }
        },
        error: function() {
            alert('Error en la conexión al subir imagen');
        }
    });
}

// Agregar la función para Usuario después de la función guardarNuevoMovimiento
$('#addRandomTab10').on('click', function (e) {
    if ($('#usuario').length == 0) {
        var randIdx1 = 'Usuario';
        var randIdx2 = 'usuario';
        $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, 
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <div class="pull-right">' +
                '           <button type="button" class="btn btn-primary" id="guardarUsuario">' +
                '               <i class="fa fa-save"></i> Guardar Usuario' +
                '           </button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Editar Usuario</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <form id="formUsuario">' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="usuario" class="form-label">Usuario</label>' +
                '                               <input type="text" class="form-control" id="usuario" required>' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="rol" class="form-label">Rol</label>' +
                '                               <select class="form-select" id="rol" required>' +
                '                                   <option value="user">Usuario</option>' +
                '                                   <option value="admin">Administrador</option>' +
                '                               </select>' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="activo" class="form-label">Activo</label>' +
                '                               <select class="form-select" id="activo" required>' +
                '                                   <option value="1">Sí</option>' +
                '                                   <option value="0">No</option>' +
                '                               </select>' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="password" class="form-label">Nueva Contraseña (Opcional)</label>' +
                '                               <input type="password" class="form-control" id="password">' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <input type="hidden" id="id_usuario">' +
                '               </form>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '</div>'
            );
        
        // Cargar datos del usuario
        $.ajax({
            url: "../ajax/cargar_usuario.php",
            method: "GET",
            success: function(usuario1) {
                if (usuario1) {
                    $('#id_usuario').val(usuario1.id);
                    $('#usuario').val(usuario1.usuario);
                    $('#rol').val(usuario1.rol);
                    $('#activo').val(usuario1.activo);
                }
            }
        });
        
        // Evento para guardar usuario
        $('#guardarUsuario').click(function() {
            guardarUsuario();
        });
    }
});

// Función para guardar usuario
function guardarUsuario() {
    var id_usuario = $('#id_usuario').val();
    var usuario = $('#usuario').val();
    var rol = $('#rol').val();
    var activo = $('#activo').val();
    var password = $('#password').val();
    
    // Enviar datos al servidor
    $.ajax({
        url: "../ajax/guardar_usuario.php",
        method: "POST",
        data: { // <-- Corregido: esta llave de apertura era la que faltaba
            id_usuario: id_usuario,
            usuario: usuario,
            rol: rol,
            activo: activo,
            password: password
        },
        success: function(response) {
            if (response.success) {
                alert('Usuario actualizado correctamente');
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Error en la conexión');
        }
    });
}

// Agregar la función para Crear Usuario después de la función guardarUsuario
$('#addRandomTab11').on('click', function (e) {
    if ($('#crear_usuario').length == 0) {
        var randIdx1 = 'Crear Usuario';
        var randIdx2 = 'crear_usuario';
        $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, 
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <div class="pull-right">' +
                '           <button type="button" class="btn btn-primary" id="guardarNuevoUsuario">' +
                '               <i class="fa fa-plus"></i> Crear Usuario' +
                '           </button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Crear Nuevo Usuario</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <form id="formCrearUsuario">' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="nuevo_usuario" class="form-label">Nombre de Usuario</label>' +
                '                               <input type="text" class="form-control" id="nuevo_usuario" required>' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="nueva_password" class="form-label">Contraseña</label>' +
                '                               <input type="password" class="form-control" id="nueva_password" required>' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="nuevo_rol" class="form-label">Rol</label>' +
                '                               <select class="form-select" id="nuevo_rol" required>' +
                '                                   <option value="user">Usuario</option>' +
                '                                   <option value="admin">Administrador</option>' +
                '                               </select>' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="nuevo_activo" class="form-label">Activo</label>' +
                '                               <select class="form-select" id="nuevo_activo" required>' +
                '                                   <option value="1">Sí</option>' +
                '                                   <option value="0">No</option>' +
                '                               </select>' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '               </form>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12 mt-4">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Usuarios Existentes</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <table id="tablaUsuarios" class="table table-bordered table-striped">' +
                '                   <thead>' +
                '                       <tr>' +
                '                           <th>ID</th>' +
                '                           <th>Usuario</th>' +
                '                           <th>Rol</th>' +
                '                           <th>Activo</th>' +
                '                           <th>Creado</th>' +
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
        
        // Inicializar DataTable para usuarios
        $('#tablaUsuarios').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": "../ajax/listar_usuarios.php",
                "type": "GET",
                "dataSrc": "data"
            },
            "columns": [
                {"data": "0"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4"},
                {"data": "5"}
            ]
        });
        
        // Evento para crear nuevo usuario
        $('#guardarNuevoUsuario').click(function() {
            crearNuevoUsuario();
        });
    }
});

// Función para crear nuevo usuario
function crearNuevoUsuario() {
    var usuario = $('#nuevo_usuario').val();
    var password = $('#nueva_password').val();
    var rol = $('#nuevo_rol').val();
    var activo = $('#nuevo_activo').val();
    
    // Verificar datos antes de enviar
    console.log("Datos a enviar para crear usuario:", {
        usuario: usuario,
        password: password ? "********" : "",
        rol: rol,
        activo: activo
    });
    
    if (!usuario || !password) {
        alert('Complete todos los campos obligatorios');
        return;
    }
    
    // Enviar datos al servidor
    $.ajax({
        url: "../ajax/crear_usuario.php",
        method: "POST",
        data: {
            usuario: usuario,
            password: password,
            rol: rol,
            activo: activo
        },
        success: function(response) {
            console.log("Respuesta del servidor:", response);
            if (response.success) {
                alert('Usuario creado correctamente');
                // Limpiar formulario
                $('#nuevo_usuario').val('');
                $('#nueva_password').val('');
                // Recargar tabla de usuarios
                $('#tablaUsuarios').DataTable().ajax.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log("Error AJAX:", status, error);
            console.log("Respuesta completa:", xhr.responseText);
            alert('Error en la conexión: ' + error);
        }
    });
}

// Agregar la función para Clientes después de la función crearNuevoUsuario
$('#addRandomTab12').on('click', function (e) {
    if ($('#clientes').length == 0) {
        var randIdx1 = 'Clientes';
        var randIdx2 = 'clientes';
        $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, 
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <div class="pull-right">' +
                '           <button type="button" class="btn btn-primary" id="guardarNuevoCliente">' +
                '               <i class="fa fa-plus"></i> Crear Cliente' +
                '           </button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Crear Nuevo Cliente</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <form id="formCrearCliente">' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="nombre_cliente" class="form-label">Nombre del Cliente *</label>' +
                '                               <input type="text" class="form-control" id="nombre_cliente" required>' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="cif" class="form-label">CIF</label>' +
                '                               <input type="text" class="form-control" id="cif">' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="telefono_cliente" class="form-label">Teléfono</label>' +
                '                               <input type="text" class="form-control" id="telefono_cliente">' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="telefono_movil" class="form-label">Teléfono Móvil</label>' +
                '                               <input type="text" class="form-control" id="telefono_movil">' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="email_cliente" class="form-label">Email</label>' +
                '                               <input type="email" class="form-control" id="email_cliente">' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="pago" class="form-label">Forma de Pago</label>' +
                '                               <input type="text" class="form-control" id="pago">' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <div class="row">' +
                '                       <div class="col-md-12">' +
                '                           <div class="mb-3">' +
                '                               <label for="direccion_cliente" class="form-label">Dirección</label>' +
                '                               <input type="text" class="form-control" id="direccion_cliente">' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="n_cuenta" class="form-label">Número de Cuenta</label>' +
                '                               <input type="text" class="form-control" id="n_cuenta">' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="status_cliente" class="form-label">Estado</label>' +
                '                               <select class="form-select" id="status_cliente">' +
                '                                   <option value="1">Activo</option>' +
                '                                   <option value="0">Inactivo</option>' +
                '                               </select>' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <input type="hidden" id="id_cliente">' +
                '               </form>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12 mt-4">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Clientes Existentes</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <table id="tablaClientes" class="table table-bordered table-striped">' +
                '                   <thead>' +
                '                       <tr>' +
                '                           <th>ID</th>' +
                '                           <th>Nombre</th>' +
                '                           <th>Teléfono</th>' +
                '                           <th>Email</th>' +
                '                           <th>CIF</th>' +
                '                           <th>Estado</th>' +
                '                           <th>Creado</th>' +
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
         // Inicializar DataTable para clientes
        $('#tablaClientes').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": "../ajax/listar_clientes.php",
                "type": "GET",
                "dataSrc": "data"
            },
            "columns": [
                {"data": "0"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4"},
                {"data": "5"},
                {"data": "6"},
                {"data": "7"}
            ]
        });
        
        // Evento para crear nuevo cliente
        $('#guardarNuevoCliente').click(function() {
            crearNuevoCliente();
        });
        
        // Evento para editar cliente (se manejará con el DataTable)
        $(document).on('click', '.editar-cliente', function() {
            var id_cliente = $(this).data('id');
            editarCliente(id_cliente);
        });
    }
});

// Función para editar cliente
function editarCliente(id_cliente) {
    console.log("Editando cliente ID:", id_cliente);
    
    $.ajax({
        url: "../ajax/cargar_cliente.php",
        method: "GET",
        data: { id: id_cliente },
        success: function(cliente) {
            console.log("Datos del cliente cargados:", cliente);
            if (cliente) {
                $('#id_cliente').val(cliente.id_cliente);
                $('#nombre_cliente').val(cliente.nombre_cliente);
                $('#n_cuenta').val(cliente.n_cuenta);
                $('#telefono_cliente').val(cliente.telefono_cliente);
                $('#telefono_movil').val(cliente.telefono_movil);
                $('#email_cliente').val(cliente.email_cliente);
                $('#direccion_cliente').val(cliente.direccion_cliente);
                $('#pago').val(cliente.pago);
                $('#cif').val(cliente.cif);
                $('#status_cliente').val(cliente.status_cliente);
                
                // Cambiar el texto del botón a "Actualizar Cliente"
                $('#guardarNuevoCliente').html('<i class="fa fa-save"></i> Actualizar Cliente');
                
                // Cambiar evento del botón a actualizar
                $('#guardarNuevoCliente').off('click').on('click', function() {
                    actualizarCliente();
                });
            } else {
                alert('Cliente no encontrado');
            }
        },
        error: function(xhr, status, error) {
            console.log("Error al cargar cliente:", status, error);
            alert('Error al cargar cliente: ' + error);
        }
    });
}

// Función para crear nuevo cliente
function crearNuevoCliente() {
    var nombre_cliente = $('#nombre_cliente').val();
    var n_cuenta = $('#n_cuenta').val();
    var telefono_cliente = $('#telefono_cliente').val();
    var telefono_movil = $('#telefono_movil').val();
    var email_cliente = $('#email_cliente').val();
    var direccion_cliente = $('#direccion_cliente').val();
    var pago = $('#pago').val();
    var cif = $('#cif').val();
    var status_cliente = $('#status_cliente').val();
    
    // Verificar datos antes de enviar
    console.log("Datos a enviar para crear cliente:", {
        nombre_cliente: nombre_cliente,
        n_cuenta: n_cuenta,
        telefono_cliente: telefono_cliente,
        telefono_movil: telefono_movil,
        email_cliente: email_cliente,
        direccion_cliente: direccion_cliente,
        pago: pago,
        cif: cif,
        status_cliente: status_cliente
    });
    
    if (!nombre_cliente) {
        alert('Complete el nombre del cliente');
        return;
    }
    
    // Enviar datos al servidor
    $.ajax({
        url: "../ajax/crear_cliente.php",
        method: "POST",
        data: { // <-- Corregido: Se añade 'data:'
            nombre_cliente: nombre_cliente,
            n_cuenta: n_cuenta,
            telefono_cliente: telefono_cliente,
            telefono_movil: telefono_movil,
            email_cliente: email_cliente,
            direccion_cliente: direccion_cliente,
            pago: pago,
            cif: cif,
            status_cliente: status_cliente
        },
        success: function(response) {
            console.log("Respuesta del servidor:", response);
            if (response.success) {
                alert('Cliente creado correctamente');
                // Limpiar formulario
                $('#nombre_cliente').val('');
                $('#n_cuenta').val('');
                $('#telefono_cliente').val('');
                $('#telefono_movil').val('');
                $('#email_cliente').val('');
                $('#direccion_cliente').val('');
                $('#pago').val('');
                $('#cif').val('');
                $('#status_cliente').val('1');
                // Recargar tabla de clientes
                $('#tablaClientes').DataTable().ajax.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log("Error AJAX:", status, error);
            console.log("Respuesta completa:", xhr.responseText);
            alert('Error en la conexión: ' + error);
        }
    });
}

// Función para actualizar cliente
function actualizarCliente() {
    var id_cliente = $('#id_cliente').val();
    var nombre_cliente = $('#nombre_cliente').val();
    var n_cuenta = $('#n_cuenta').val();
    var telefono_cliente = $('#telefono_cliente').val();
    var telefono_movil = $('#telefono_movil').val();
    var email_cliente = $('#email_cliente').val();
    var direccion_cliente = $('#direccion_cliente').val();
    var pago = $('#pago').val();
    var cif = $('#cif').val();
    var status_cliente = $('#status_cliente').val();
    
    // Verificar datos antes de enviar
    console.log("Datos a enviar para actualizar cliente:", {
        id_cliente: id_cliente,
        nombre_cliente: nombre_cliente,
        n_cuenta: n_cuenta,
        telefono_cliente: telefono_cliente,
        telefono_movil: telefono_movil,
        email_cliente: email_cliente,
        direccion_cliente: direccion_cliente,
        pago: pago,
        cif: cif,
        status_cliente: status_cliente
    });
    
    if (!nombre_cliente) {
        alert('Complete el nombre del cliente');
        return;
    }
    
    // Enviar datos al servidor
    $.ajax({
        url: "../ajax/editar_cliente.php",
        method: "POST",
        data: { // <-- Corregido: Se añade 'data:'
            id_cliente: id_cliente,
            nombre_cliente: nombre_cliente,
            n_cuenta: n_cuenta,
            telefono_cliente: telefono_cliente,
            telefono_movil: telefono_movil,
            email_cliente: email_cliente,
            direccion_cliente: direccion_cliente,
            pago: pago,
            cif: cif,
            status_cliente: status_cliente
        },
        success: function(response) {
            console.log("Respuesta del servidor:", response);
            if (response.success) {
                alert('Cliente actualizado correctamente');
                // Limpiar formulario
                $('#nombre_cliente').val('');
                $('#n_cuenta').val('');
                $('#telefono_cliente').val('');
                $('#telefono_movil').val('');
                $('#email_cliente').val('');
                $('#direccion_cliente').val('');
                $('#pago').val('');
                $('#cif').val('');
                $('#status_cliente').val('1');
                $('#id_cliente').val('');
                // Cambiar el texto del botón de nuevo
                $('#guardarNuevoCliente').html('<i class="fa fa-plus"></i> Crear Cliente');
                // Cambiar evento del botón a crear
                $('#guardarNuevoCliente').off('click').on('click', function() {
                    crearNuevoCliente();
                });
                // Recargar tabla de clientes
                $('#tablaClientes').DataTable().ajax.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log("Error AJAX:", status, error);
            console.log("Respuesta completa:", xhr.responseText);
            alert('Error en la conexión: ' + error);
        }
    });
}

// Agregar la función para Proveedores después de la función actualizarCliente
$('#addRandomTab13').on('click', function (e) {
    if ($('#proveedores').length == 0) {
        var randIdx1 = 'Proveedores';
        var randIdx2 = 'proveedores';
        $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, 
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <div class="pull-right">' +
                '           <button type="button" class="btn btn-primary" id="guardarNuevoProveedor">' +
                '               <i class="fa fa-plus"></i> Crear Proveedor' +
                '           </button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Crear Nuevo Proveedor</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <form id="formCrearProveedor">' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="nombre_proveedor" class="form-label">Nombre del Proveedor *</label>' +
                '                               <input type="text" class="form-control" id="nombre_proveedor" required>' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="cif" class="form-label">CIF</label>' +
                '                               <input type="text" class="form-control" id="cif">' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="telefono_proveedor" class="form-label">Teléfono</label>' +
                '                               <input type="text" class="form-control" id="telefono_proveedor">' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="telefono_movil" class="form-label">Teléfono Móvil</label>' +
                '                               <input type="text" class="form-control" id="telefono_movil">' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="email_proveedor" class="form-label">Email</label>' +
                '                               <input type="email" class="form-control" id="email_proveedor">' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="pago" class="form-label">Forma de Pago</label>' +
                '                               <input type="text" class="form-control" id="pago">' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <div class="row">' +
                '                       <div class="col-md-12">' +
                '                           <div class="mb-3">' +
                '                               <label for="direccion_proveedor" class="form-label">Dirección</label>' +
                '                               <input type="text" class="form-control" id="direccion_proveedor">' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="n_cuenta" class="form-label">Número de Cuenta</label>' +
                '                               <input type="text" class="form-control" id="n_cuenta">' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="status_proveedor" class="form-label">Estado</label>' +
                '                               <select class="form-select" id="status_proveedor">' +
                '                                   <option value="1">Activo</option>' +
                '                                   <option value="0">Inactivo</option>' +
                '                               </select>' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <input type="hidden" id="id_proveedor">' +
                '               </form>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12 mt-4">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Proveedores Existentes</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <table id="tablaProveedores" class="table table-bordered table-striped">' +
                '                   <thead>' +
                '                       <tr>' +
                '                           <th>ID</th>' +
                '                           <th>Nombre</th>' +
                '                           <th>Teléfono</th>' +
                '                           <th>Email</th>' +
                '                           <th>CIF</th>' +
                '                           <th>Estado</th>' +
                '                           <th>Creado</th>' +
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
        
        // Inicializar DataTable para proveedores
        $('#tablaProveedores').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": "../ajax/listar_proveedores.php",
                "type": "GET",
                "dataSrc": "data"
            },
            "columns": [
                {"data": "0"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4"},
                {"data": "5"},
                {"data": "6"},
                {"data": "7"}
            ]
        });
        
        // Evento para crear nuevo proveedor
        $('#guardarNuevoProveedor').click(function() {
            crearNuevoProveedor();
        });
        
        // Evento para editar proveedor (se manejará con el DataTable)
        $(document).on('click', '.editar-proveedor', function() {
            var id_proveedor = $(this).data('id');
            editarProveedor(id_proveedor);
        });
    }
});

// Función para crear nuevo proveedor
function crearNuevoProveedor() {
    var nombre_proveedor = $('#nombre_proveedor').val();
    var n_cuenta = $('#n_cuenta').val();
    var telefono_proveedor = $('#telefono_proveedor').val();
    var telefono_movil = $('#telefono_movil').val();
    var email_proveedor = $('#email_proveedor').val();
    var direccion_proveedor = $('#direccion_proveedor').val();
    var pago = $('#pago').val();
    var cif = $('#cif').val();
    var status_proveedor = $('#status_proveedor').val();
    
    // Verificar datos antes de enviar
    console.log("Datos a enviar para crear proveedor:", {
        nombre_proveedor: nombre_proveedor,
        n_cuenta: n_cuenta,
        telefono_proveedor: telefono_proveedor,
        telefono_movil: telefono_movil,
        email_proveedor: email_proveedor,
        direccion_proveedor: direccion_proveedor,
        pago: pago,
        cif: cif,
        status_proveedor: status_proveedor
    });
    
    if (!nombre_proveedor) {
        alert('Complete el nombre del proveedor');
        return;
    }
    
    // Enviar datos al servidor
    $.ajax({
        url: "../ajax/crear_proveedor.php",
        method: "POST",
        data: { // <-- Corregido: Se añade 'data:' antes del objeto
            nombre_proveedor: nombre_proveedor,
            n_cuenta: n_cuenta,
            telefono_proveedor: telefono_proveedor,
            telefono_movil: telefono_movil,
            email_proveedor: email_proveedor,
            direccion_proveedor: direccion_proveedor,
            pago: pago,
            cif: cif,
            status_proveedor: status_proveedor
        },
        success: function(response) {
            console.log("Respuesta del servidor:", response);
            if (response.success) {
                alert('Proveedor creado correctamente');
                // Limpiar formulario
                $('#nombre_proveedor').val('');
                $('#n_cuenta').val('');
                $('#telefono_proveedor').val('');
                $('#telefono_movil').val('');
                $('#email_proveedor').val('');
                $('#direccion_proveedor').val('');
                $('#pago').val('');
                $('#cif').val('');
                $('#status_proveedor').val('1');
                // Recargar tabla de proveedores
                $('#tablaProveedores').DataTable().ajax.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log("Error AJAX:", status, error);
            console.log("Respuesta completa:", xhr.responseText);
            alert('Error en la conexión: ' + error);
        }
    });
}

// Función para editar proveedor
function editarProveedor(id_proveedor) {
    console.log("Editando proveedor ID:", id_proveedor);
    
    $.ajax({
        url: "../ajax/cargar_proveedor.php",
        method: "GET",
        data: { id: id_proveedor },
        success: function(proveedor) {
            console.log("Datos del proveedor cargados:", proveedor);
            if (proveedor) {
                $('#id_proveedor').val(proveedor.id_proveedor);
                $('#nombre_proveedor').val(proveedor.nombre_proveedor);
                $('#n_cuenta').val(proveedor.n_cuenta);
                $('#telefono_proveedor').val(proveedor.telefono_proveedor);
                $('#telefono_movil').val(proveedor.telefono_movil);
                $('#email_proveedor').val(proveedor.email_proveedor);
                $('#direccion_proveedor').val(proveedor.direccion_proveedor);
                $('#pago').val(proveedor.pago);
                $('#cif').val(proveedor.cif);
                $('#status_proveedor').val(proveedor.status_proveedor);
                
                // Cambiar el texto del botón a "Actualizar Proveedor"
                $('#guardarNuevoProveedor').html('<i class="fa fa-save"></i> Actualizar Proveedor');
                
                // Cambiar evento del botón a actualizar
                $('#guardarNuevoProveedor').off('click').on('click', function() {
                    actualizarProveedor();
                });
            } else {
                alert('Proveedor no encontrado');
            }
        },
        error: function(xhr, status, error) {
            console.log("Error al cargar proveedor:", status, error);
            alert('Error al cargar proveedor: ' + error);
        }
    });
}

// Función para actualizar proveedor
function actualizarProveedor() {
    var id_proveedor = $('#id_proveedor').val();
    var nombre_proveedor = $('#nombre_proveedor').val();
    var n_cuenta = $('#n_cuenta').val();
    var telefono_proveedor = $('#telefono_proveedor').val();
    var telefono_movil = $('#telefono_movil').val();
    var email_proveedor = $('#email_proveedor').val();
    var direccion_proveedor = $('#direccion_proveedor').val();
    var pago = $('#pago').val();
    var cif = $('#cif').val();
    var status_proveedor = $('#status_proveedor').val();
    
    // Verificar datos antes de enviar
    console.log("Datos a enviar para actualizar proveedor:", {
        id_proveedor: id_proveedor,
        nombre_proveedor: nombre_proveedor,
        n_cuenta: n_cuenta,
        telefono_proveedor: telefono_proveedor,
        telefono_movil: telefono_movil,
        email_proveedor: email_proveedor,
        direccion_proveedor: direccion_proveedor,
        pago: pago,
        cif: cif,
        status_proveedor: status_proveedor
    });
    
    if (!nombre_proveedor) {
        alert('Complete el nombre del proveedor');
        return;
    }
    
    // Enviar datos al servidor
    $.ajax({
        url: "../ajax/editar_proveedor.php",
        method: "POST",
        data: { // <-- Corregido: Se añade 'data:' antes del objeto
            id_proveedor: id_proveedor,
            nombre_proveedor: nombre_proveedor,
            n_cuenta: n_cuenta,
            telefono_proveedor: telefono_proveedor,
            telefono_movil: telefono_movil,
            email_proveedor: email_proveedor,
            direccion_proveedor: direccion_proveedor,
            pago: pago,
            cif: cif,
            status_proveedor: status_proveedor
        },
        success: function(response) {
            console.log("Respuesta del servidor:", response);
            if (response.success) {
                alert('Proveedor actualizado correctamente');
                // Limpiar formulario
                $('#nombre_proveedor').val('');
                $('#n_cuenta').val('');
                $('#telefono_proveedor').val('');
                $('#telefono_movil').val('');
                $('#email_proveedor').val('');
                $('#direccion_proveedor').val('');
                $('#pago').val('');
                $('#cif').val('');
                $('#status_proveedor').val('1');
                $('#id_proveedor').val('');
                // Cambiar el texto del botón de nuevo
                $('#guardarNuevoProveedor').html('<i class="fa fa-plus"></i> Crear Proveedor');
                // Cambiar evento del botón a crear
                $('#guardarNuevoProveedor').off('click').on('click', function() {
                    crearNuevoProveedor();
                });
                // Recargar tabla de proveedores
                $('#tablaProveedores').DataTable().ajax.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log("Error AJAX:", status, error);
            console.log("Respuesta completa:", xhr.responseText);
            alert('Error en la conexión: ' + error);
        }
    });
}

// Agregar la función para Productos después de la función actualizarProveedor
$('#addRandomTab14').on('click', function (e) {
    if ($('#productos').length == 0) {
        var randIdx1 = 'Productos';
        var randIdx2 = 'productos';
        $('#example_0').data('uiScrollTabs')
            .addTab1(randIdx2, randIdx1, 
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <div class="pull-right">' +
                '           <button type="button" class="btn btn-primary" id="guardarNuevoProducto">' +
                '               <i class="fa fa-plus"></i> Crear Producto' +
                '           </button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Crear Nuevo Producto</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <form id="formCrearProducto">' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="codigo_producto" class="form-label">Código del Producto *</label>' +
                '                               <input type="text" class="form-control" id="codigo_producto" required>' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="nombre_producto" class="form-label">Nombre del Producto *</label>' +
                '                               <input type="text" class="form-control" id="nombre_producto" required>' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="categoria" class="form-label">Categoría</label>' +
                '                               <input type="text" class="form-control" id="categoria">' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="precio_producto" class="form-label">Precio</label>' +
                '                               <input type="number" class="form-control" id="precio_producto" step="0.01" min="0">' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <div class="row">' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="cantidad" class="form-label">Cantidad</label>' +
                '                               <input type="number" class="form-control" id="cantidad" min="0">' +
                '                           </div>' +
                '                       </div>' +
                '                       <div class="col-md-6">' +
                '                           <div class="mb-3">' +
                '                               <label for="status_producto" class="form-label">Estado</label>' +
                '                               <select class="form-select" id="status_producto">' +
                '                                   <option value="1">Activo</option>' +
                '                                   <option value="0">Inactivo</option>' +
                '                               </select>' +
                '                           </div>' +
                '                       </div>' +
                '                   </div>' +
                '                   <input type="hidden" id="id_producto">' +
                '               </form>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-md-12 mt-4">' +
                '       <div class="box">' +
                '           <div class="box-header">' +
                '               <h3 class="box-title">Productos Existentes</h3>' +
                '           </div>' +
                '           <div class="box-body">' +
                '               <table id="tablaProductos" class="table table-bordered table-striped">' +
                '                   <thead>' +
                '                       <tr>' +
                '                           <th>ID</th>' +
                '                           <th>Código</th>' +
                '                           <th>Nombre</th>' +
                '                           <th>Categoría</th>' +
                '                           <th>Cantidad</th>' +
                '                           <th>Precio</th>' +
                '                           <th>Estado</th>' +
                '                           <th>Creado</th>' +
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
        
        // Inicializar DataTable para productos
        $('#tablaProductos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": "../ajax/listar_productos.php",
                "type": "GET",
                "dataSrc": "data"
            },
            "columns": [
                {"data": "0"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4"},
                {"data": "5"},
                {"data": "6"},
                {"data": "7"},
                {"data": "8"}
            ]
        });
        
        // Evento para crear nuevo producto
        $('#guardarNuevoProducto').click(function() {
            crearNuevoProducto();
        });
        
        // Evento para editar producto (se manejará con el DataTable)
        $(document).on('click', '.editar-producto', function() {
            var id_producto = $(this).data('id');
            editarProducto(id_producto);
        });
    }
});

// Función para crear nuevo producto
function crearNuevoProducto() {
    var codigo_producto = $('#codigo_producto').val();
    var nombre_producto = $('#nombre_producto').val();
    var categoria = $('#categoria').val();
    var cantidad = $('#cantidad').val();
    var status_producto = $('#status_producto').val();
    var precio_producto = $('#precio_producto').val();
    
    // Verificar datos antes de enviar
    console.log("Datos a enviar para crear producto:", {
        codigo_producto: codigo_producto,
        nombre_producto: nombre_producto,
        categoria: categoria,
        cantidad: cantidad,
        status_producto: status_producto,
        precio_producto: precio_producto
    });
    
    if (!codigo_producto || !nombre_producto) {
        alert('Complete el código y nombre del producto');
        return;
    }
    
    // Enviar datos al servidor
    $.ajax({
        url: "../ajax/crear_producto.php",
        method: "POST",
        data: { // <-- Corregido: Se añade 'data:' antes del objeto
            codigo_producto: codigo_producto,
            nombre_producto: nombre_producto,
            categoria: categoria,
            cantidad: cantidad,
            status_producto: status_producto,
            precio_producto: precio_producto
        },
        success: function(response) {
            console.log("Respuesta del servidor:", response);
            if (response.success) {
                alert('Producto creado correctamente');
                // Limpiar formulario
                $('#codigo_producto').val('');
                $('#nombre_producto').val('');
                $('#categoria').val('');
                $('#cantidad').val('');
                $('#precio_producto').val('');
                $('#status_producto').val('1');
                // Recargar tabla de productos
                $('#tablaProductos').DataTable().ajax.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log("Error AJAX:", status, error);
            console.log("Respuesta completa:", xhr.responseText);
            alert('Error en la conexión: ' + error);
        }
    });
}

// Función para editar producto
function editarProducto(id_producto) {
    console.log("Editando producto ID:", id_producto);
    
    $.ajax({
        url: "../ajax/cargar_producto.php",
        method: "GET",
        data: { id: id_producto }, // <-- Corregido
        success: function(producto) {
            console.log("Datos del producto cargados:", producto);
            if (producto) {
                $('#id_producto').val(producto.id_producto);
                $('#codigo_producto').val(producto.codigo_producto);
                $('#nombre_producto').val(producto.nombre_producto);
                $('#categoria').val(producto.categoria);
                $('#cantidad').val(producto.cantidad);
                $('#precio_producto').val(producto.precio_producto);
                $('#status_producto').val(producto.status_producto);
                
                // Cambiar el texto del botón a "Actualizar Producto"
                $('#guardarNuevoProducto').html('<i class="fa fa-save"></i> Actualizar Producto');
                
                // Cambiar evento del botón a actualizar
                $('#guardarNuevoProducto').off('click').on('click', function() {
                    actualizarProducto();
                });
            } else {
                alert('Producto no encontrado');
            }
        },
        error: function(xhr, status, error) {
            console.log("Error al cargar producto:", status, error);
            alert('Error al cargar producto: ' + error);
        }
    });
}

// Función para actualizar producto
function actualizarProducto() {
    var id_producto = $('#id_producto').val();
    var codigo_producto = $('#codigo_producto').val();
    var nombre_producto = $('#nombre_producto').val();
    var categoria = $('#categoria').val();
    var cantidad = $('#cantidad').val();
    var status_producto = $('#status_producto').val();
    var precio_producto = $('#precio_producto').val();
    
    // Verificar datos antes de enviar
    console.log("Datos a enviar para actualizar producto:", {
        id_producto: id_producto,
        codigo_producto: codigo_producto,
        nombre_producto: nombre_producto,
        categoria: categoria,
        cantidad: cantidad,
        status_producto: status_producto,
        precio_producto: precio_producto
    });
    
    if (!codigo_producto || !nombre_producto) {
        alert('Complete el código y nombre del producto');
        return;
    }
    
    // Enviar datos al servidor
    $.ajax({
        url: "../ajax/editar_producto.php",
        method: "POST",
        data: { // <-- Corregido: Se añade 'data:' antes del objeto
            id_producto: id_producto,
            codigo_producto: codigo_producto,
            nombre_producto: nombre_producto,
            categoria: categoria,
            cantidad: cantidad,
            status_producto: status_producto,
            precio_producto: precio_producto
        },
        success: function(response) {
            console.log("Respuesta del servidor:", response);
            if (response.success) {
                alert('Producto actualizado correctamente');
                // Limpiar formulario
                $('#codigo_producto').val('');
                $('#nombre_producto').val('');
                $('#categoria').val('');
                $('#cantidad').val('');
                $('#precio_producto').val('');
                $('#status_producto').val('1');
                $('#id_producto').val('');
                // Cambiar el texto del botón de nuevo
                $('#guardarNuevoProducto').html('<i class="fa fa-plus"></i> Crear Producto');
                // Cambiar evento del botón a crear
                $('#guardarNuevoProducto').off('click').on('click', function() {
                    crearNuevoProducto();
                });
                // Recargar tabla de productos
                $('#tablaProductos').DataTable().ajax.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log("Error AJAX:", status, error);
            console.log("Respuesta completa:", xhr.responseText);
            alert('Error en la conexión: ' + error);
        }
    });
}





// Agregar la función para Facturas de Compra 
$('#addRandomTab15').on('click', function (e) {
    if ($('#factura_compras').length == 0) {
        var randIdx1 = 'Facturas Compras';
        var randIdx2 = 'factura_compras';
        $('#example_0').data('uiScrollTabs')
        .addTab1(randIdx2, randIdx1, randIdx1 + '<section class="content">' +
        ' <div class="row">' +
        ' <div class="col-md-12">' +
        ' <div class="pull-right">' +
        '<button type="button" class="btn btn-default" id="actualizar_compras"> <span class="glyphicon glyphicon-refresh"></span> Actualizar datos</button>' +
        ' <button type="button" class="btn btn-default" id="nueva_f_compras"> <span class="glyphicon glyphicon-plus"></span> Nueva F Numerada</button>' + 
        '  <button type="button" class="btn btn-default" id="mostrar_compras"><span class="glyphicon glyphicon-plus"></span> Nueva Factura</button>' + 
        ' </div> ' + 
        ' </div>' + 
        ' <div class="col-12">' +
        ' <div class="box">' +
        ' <div class="box-header">' +
        ' <h4 class="box-title">Facturas Compras</h4>' +
        ' <div class="box-body">' +
        ' <div class="table table-bordered table-hover display nowrap margin-top-10 w-p100" style=" height: 400px;overflow: auto;">' +
        ' <table id="example_compras" class="display" style="width:100%">' +
        ' <thead>' +
        ' <tr>' +
        ' <th>Nº Factura</th>' +
        ' <th>Nº Pedido</th>' +
        ' <th>Fecha</th>' +
        ' <th>Proveedor</th>' +
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
        ' <th>Proveedor</th>' +
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
        ' <div class="box" id="d_compras">' +
        ' <div class="box-header with-border">' +
        ' <h3 class="box-title">Nueva Factura Compra</h3>' +
        ' </div>' +
        ' <div class="box-body">' +
        ' <div id="resultadoss_compras" class="col-md-12" style="margin-top:10px"></div>' +
        ' </div>' +
        ' </div>' +
        ' </div>' +
        ' <div class="box" id="d1_compras">' +
        ' <div class="box-header with-border">' +
        ' <h3 class="box-title">Detalles De La Factura</h3>' +
        ' </div>' +
        ' <div class="box-body">' +
        ' <div id="resultados_compras" class="col-md-12" style="margin-top:10px"></div>' +
        ' </div>' +
        ' </div>' +
        ' </div>' +
        ' </div> ' + 
        ' </section>'  
        );
    }
    $("#d_compras").hide();
    $("#d1_compras").hide();
    let table_compras = new $('#example_compras').DataTable( {
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
        ajax: "../ajax/buscar_facturas_compras.php",
        pageLength: -1,
        select: true
    } );
    
    table_compras
    .on('select', function (e, dt, type, indexes) {
        var paramJson1 = JSON.stringify( dt.row( { selected: true } ).data() );
        var myArray1 = JSON.parse(paramJson1);
        var yo1 = myArray1[0];
        $.ajax({
            type: "POST",
            url: "../ajax/editar_facturas_compras.php",
            data: {id1:yo1},
            success:function(data){
                $("#resultados_compras").html(data).fadeIn();
                $("#d1_compras").show(); //muestro mediante id
                $("#d_compras").hide();
            },
        });
    })
    .on('deselect', function (e, dt, type, indexes) {
        $("#resultados_compras").fadeOut();
        $("#d1_compras").hide();
    });
    
    $("#mostrar_compras").on( "click", function() {
        $("#d_compras").show(); //muestro mediante id
        $("#d1_compras").hide();
        $.ajax({
            type: "POST",
            url:'../ajax/nueva_factura_compras.php',
            success:function(data){
                $("#resultadoss_compras").html(data).fadeIn('slow');
            }
        });
    });
    
    $("#actualizar_compras").on( "click", function() {
        $("#d_compras").hide(); //muestro mediante id
        $("#d1_compras").hide();
        $('#example_compras').DataTable().clear().destroy();
        let table_compras = new $('#example_compras').DataTable( {
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
            ajax: "../ajax/buscar_facturas_compras.php",
            pageLength: -1,
            select: true
        } );
    });
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
