
 /*-------------------------
	Autor: Toni gallur
	
	pagina javascript que se carga en 
	la pagina nueva_factura.php
	---------------------------*/

		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader1").fadeIn('slow');
			$.ajax({
				url:'../ajax/productos_factura.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader1').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div10").html(data).fadeIn('slow');
					$('#loader1').html('');
					
				}
			})
		}

	function agregar (id)
		{
			var precio_venta=document.getElementById('precio_ventaa_'+id).value;
			var cantidad=document.getElementById('cantidada_'+id).value;
			//Inicia validacion
			if (isNaN(cantidad))
			{
			alert('Esto no es un numero');
			document.getElementById('cantidada_'+id).focus();
			return false;
			}
			if (isNaN(precio_venta))
			{
			alert('Esto no es un numero');
			document.getElementById('precio_ventaa_'+id).focus();
			return false;
			}
			//Fin validacion
			
			$.ajax({
        type: "POST",
        url: "../ajax/agregar_facturacion.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad,
		 beforeSend: function(objeto){
			$("#resultados4").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados4").html(datos);
		}
			});
		}
		
			function eliminar (id)
		{
			
			$.ajax({
        type: "GET",
        url: "../ajax/agregar_facturacion.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados4").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados4").html(datos);
		}
			});

		}
		 $("#mostrario").on( "click", function() {
		
		  var id_cliente = $("#id_cliente9").val();
		  var id_vendedor = $("#id_vendedor9").val();
		  var condiciones = $("#condiciones9").val();
          var descuento = $("#descuento9").val();
		  
		  if (id_cliente==""){
			  alert("Debes seleccionar un cliente");
			  $("#nombre_cliente9").focus();
			  return false;
		  }
		 VentanaCentrada('../html2pdf/documentos/nueva_factura.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor+'&condiciones='+condiciones+'&descuento='+descuento,'Factura','','1024','768','true');
		 	$("#d1").hide();
	$("#d").hide();
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
		
		$( "#guardar_cliente" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "../ajax/nuevo_cliente.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})
		
		$("#guardar_producto").submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "../ajax/nuevo_producto.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax_alert").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax_alert").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})
