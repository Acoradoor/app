  /*-------------------------
	Autor: Toni gallur
	
	pagina javascript que se carga en 
	la pagina editar_factura.php
	---------------------------*/

$(document).ready(function(){
			load_editar(1);
			$( "#resultados1" ).load( "../ajax/editar_facturacion_nueva.php" );
		});

		function load_editar(page_ef){
			var q_ef= $("#q_editar").val();
			$("#loader1_editar").fadeIn('slow');
			$.ajax({
				url:'../ajax/productos_factura2.php?action=ajax&page_ef='+page_ef+'&q_ef='+q_ef,
				 beforeSend: function(objeto){
				 $('#loader1_editar').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div1_editar").html(data).fadeIn('slow');
					$('#loader1_editar').html('');
					
				}
			})
		}

	function agregar_editar (id_editar)
		{
			var precio_venta=document.getElementById('precio_ventaa_'+id_editar).value;
			var cantidad=document.getElementById('cantidada_'+id_editar).value;
			//Inicia validacion
			if (isNaN(cantidad))
			{
			alert('Esto no es un numero');
			document.getElementById('cantidada_'+id_editar).focus();
			return false;
			}
			if (isNaN(precio_venta))
			{
			alert('Esto no es un numero');
			document.getElementById('precio_ventaa_'+id_editar).focus();
			return false;
			}
			//Fin validacion
			
			$.ajax({
        type: "POST",
        url: "../ajax/editar_facturacion_nueva.php",
        data: "id1="+id_editar+"&precio_venta="+precio_venta+"&cantidad="+cantidad,
		 beforeSend: function(objeto){
			$("#resultados1").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados1").html(datos);
		}
			});
		}
		
			function eliminar_editar (id_editar)
		{
			
			$.ajax({
        type: "GET",
        url: "../ajax/editar_facturacion_nueva.php",
        data: "id1="+id_editar,
		 beforeSend: function(objeto){
			$("#resultados1").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados1").html(datos);
		}
			});

		}
		
		$("#datos_factura").submit(function(event){
		  var id_cliente = $("#id_cliente").val();
	  
		  if (id_cliente==""){
			  alert("Debes seleccionar un cliente");
			  $("#nombre_cliente").focus();
			  return false;
		  }
			var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "../ajax/editar_factura_nueva.php",
					data: parametros,
					 beforeSend: function(objeto){
						$(".editar_factura").html("Mensaje: Cargando...");
					  },
					success: function(datos){
						$(".editar_factura").html(datos); 
                                                 load(1);
                                                 $("#resultados1").load( "../ajax/editar_facturacion_nueva.php" );
                                                setTimeout(function(){
                                                $("#fbygybgty").hide();
                                                }, 1000);
					}
			});
			
			 event.preventDefault();
	 	});
		
		$( "#guardar_cliente2" ).submit(function( event ) {
		  $('#guardar_datos2').attr("disabled", true);
		  
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
					// Cerrar el modal después de 2 segundos
                    setTimeout(function() {
                         var modal = bootstrap.Modal.getInstance(document.getElementById('nuevoCliente2'));
                         if (modal) {
                              modal.hide();
                          }
                    }, 2000);
				  }
			});
		  event.preventDefault();
		})
		
		$( "#guardar_producto2" ).submit(function( event ) {
		  $('#guardar_datos2').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "../ajax/nuevo_producto.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax_productos2").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax_productos2").html(datos);
					$('#guardar_datos2').attr("disabled", false);
					load(1);
					// Cerrar el modal después de 2 segundos
                    setTimeout(function() {
                         var modal = bootstrap.Modal.getInstance(document.getElementById('registro_producto2'));
                         if (modal) {
                              modal.hide();
                          }
                    }, 2000);
				  }
			});
		  event.preventDefault();
		})

		function imprimir_factura(id_factura){
			VentanaCentrada('../pdf/documentos/ver_factura.php?id_factura='+id_factura,'Factura','','1024','768','true');
		}
		
       function borrar_factura(numero_factura){
            
            $.ajax({
        type: "GET",
        url: "../ajax/buscar_facturas.php",
        data: "id_f="+numero_factura,
		 
        success: function(datos){
		
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
        ajax: "../ajax/buscar_facturas.php",

	pageLength: -1,
        select: true
    } );
		}
			});
            
		}
