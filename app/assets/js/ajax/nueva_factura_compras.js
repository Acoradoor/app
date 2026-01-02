/*-------------------------
Autor: Toni gallur

pagina javascript que se carga en 
la pagina nueva_factura_compras.php
---------------------------*/

$(document).ready(function(){
    load_facturas_compras(1);
});

function load_facturas_compras(page_compras){
    var q_compras= $("#q_facturas_compras").val();
    $("#loader1_facturas_compras").fadeIn('slow');
    $.ajax({
        url:'../ajax/productos_factura_compra.php?action=ajax&page_compras='+page_compras+'&q_compras='+q_compras,
        beforeSend: function(objeto){
            $('#loader1_facturas_compras').html('<img src="./img/ajax-loader.gif"> Cargando...');
        },
        success:function(data){
            $(".outer_div10_facturas_compras").html(data).fadeIn('slow');
            $('#loader1_facturas_compras').html('');
        }
    })
}

function agregarProductoCompraUnico (id_compras)
{
    var precio_ventacf=document.getElementById('precio_ventafc_'+id_compras).value;
    var cantidadcf=document.getElementById('cantidadfc_'+id_compras).value;
    //Inicia validacion
    if (isNaN(cantidadcf))
    {
    alert('Esto no es un numero');
    document.getElementById('cantidada_'+id_compras).focus();
    return false;
    }
    if (isNaN(precio_ventacf))
    {
    alert('Esto no es un numero');
    document.getElementById('precio_ventaa_'+id_compras).focus();
    return false;
    }
    //Fin validacion
    
    $.ajax({
        type: "POST",
        url: "../ajax/agregar_facturacion_compra.php",
        data: "idcf="+id_compras+"&precio_ventacf="+precio_ventacf+"&cantidadcf="+cantidadcf,
        beforeSend: function(objeto){
            $("#resultados4_compras").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultados4_compras").html(datos);
        }
    });
}

function eliminar_compras (id_compras)
{
    $.ajax({
        type: "GET",
        url: "../ajax/agregar_facturacion_compra.php",
         data: "idncf="+id_compras,
        beforeSend: function(objeto){
            $("#resultados4_compras").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultados4_compras").html(datos);
        }
    });
}

$("#mostrario_compras").on( "click", function() {
    var id_proveedor = $("#id_proveedor9").val();
    var id_vendedor = $("#id_vendedor9").val();
    var condiciones = $("#condiciones9").val();
    var descuento = $("#descuento9").val();
    
    if (id_proveedor==""){
        alert("Debes seleccionar un proveedor");
        $("#nombre_proveedor9").focus();
        return false;
    }
    VentanaCentrada('../html2pdf/documentos/nueva_factura_compras.php?id_proveedor='+id_proveedor+'&id_vendedor='+id_vendedor+'&condiciones='+condiciones+'&descuento='+descuento,'Factura','','1024','768','true');
    $("#d1_compras").hide();
    $("#d_compras").hide();
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

$( "#guardar_proveedor" ).submit(function( event ) {
    $('#guardar_datos').attr("disabled", true);
    
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/nuevo_proveedor.php",
        data: parametros,
        beforeSend: function(objeto){
            $("#resultados_ajax_proveedor").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultados_ajax_proveedor").html(datos);
            $('#guardar_datos').attr("disabled", false);
            load_facturas_compras(1);
        }
    });
    event.preventDefault();
})

$("#guardar_producto_compras").submit(function( event ) {
    $('#guardar_datos').attr("disabled", true);
    
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/nuevo_producto.php",
        data: parametros,
        beforeSend: function(objeto){
            $("#resultados_ajax_alert_compras").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultados_ajax_alert_compras").html(datos);
            $('#guardar_datos').attr("disabled", false);
            load_facturas_compras(1);
        }
    });
    event.preventDefault();
});

// Función para borrar factura de compras
function borrar_factura_compras(id_factura) {
    if (confirm('¿Estás seguro de que quieres eliminar esta factura?')) {
        $.ajax({
            type: "GET",
            url: "../ajax/buscar_facturas_compras.php",
            data: "id_f=" + id_factura,
            success: function(data) {
                $("#example_compras").DataTable().ajax.reload();
                alert("Factura eliminada correctamente");
            }
        });
    }
}
