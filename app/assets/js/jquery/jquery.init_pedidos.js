// En la función addRandomTab3 (pedidos)
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
        
        // Inicializar DataTable para pedidos
        $('#tablaPedidos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": "../ajax/buscar_pedidos.php",
            "columns": [
                {"data": "id_pedido"},
                {"data": "nombre_cliente"},
                {"data": "fecha_pedido"},
                {"data": "total"},
                {"data": "estado"},
                {"data": null, "render": function(data, type, row) {
                    return '<button class="btn btn-sm btn-primary verPedido" data-id="' + row[0] + '">Ver</button>';
                }}
            ]
        });
        
        // Evento para nuevo pedido
        $('#nuevoPedido').click(function() {
            abrirModalNuevoPedido();
        });
    }
});

// Función para abrir modal de nuevo pedido
function abrirModalNuevoPedido() {
    // Cargar clientes
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
                                                    <option value="${sessionStorage.getItem('userId')}">Mi perfil</option>
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
                                                    <div class="col-md-3">
                                                        <label class="form-label">Cantidad</label>
                                                        <input type="number" class="form-control cantidad-input" min="1" value="1">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Precio</label>
                                                        <input type="number" step="0.01" class="form-control precio-input" readonly>
                                                    </div>
                                                    <div class="col-md-2 d-flex align-items-end">
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
            
            // Eventos para el modal
            $('#agregarProductoPedido').click(function() {
                agregarProductoPedido();
            });
            
            $(document).on('change', '.producto-select', function() {
                var precio = $(this).find('option:selected').data('precio');
                $(this).closest('.producto-item').find('.precio-input').val(precio);
                calcularTotalPedido();
            });
            
            $(document).on('input', '.cantidad-input', function() {
                calcularTotalPedido();
            });
            
            $(document).on('click', '.remove-producto', function() {
                $(this).closest('.producto-item').remove();
                calcularTotalPedido();
            });
            
            $('#guardarPedidoBtn').click(function() {
                guardarPedido();
            });
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
            <div class="col-md-3">
                <label class="form-label">Cantidad</label>
                <input type="number" class="form-control cantidad-input" min="1" value="1">
            </div>
            <div class="col-md-3">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control precio-input" readonly>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-producto">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    $('#productosContainer').append(newItem);
}

// Función para calcular total del pedido
function calcularTotalPedido() {
    var total = 0;
    $('.producto-item').each(function() {
        var cantidad = parseInt($(this).find('.cantidad-input').val()) || 0;
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
         {
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