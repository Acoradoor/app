<?php
      /*-------------------------
	Autor: Toni gallur
	
	pagina que le devuelve el json 
	para datatables a la pagina 
	jquery.init.js 
	---------------------------*/
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}
	
if (isset($_GET['id_f'])){
    $numero_factura = intval($_GET['id_f']);
    
    // Si estás usando PDO, usa PDO para las consultas
    $del1 = "DELETE FROM facturas WHERE numero_factura = ?";
    $del2 = "DELETE FROM detalle_factura WHERE numero_factura = ?";
    
    try {
        // Preparar y ejecutar eliminación de facturas
        $stmt1 = $conn->prepare($del1);
        $stmt2 = $conn->prepare($del2);
        
        if ($stmt1->execute([$numero_factura]) && $stmt2->execute([$numero_factura])){
            ?>
            <div class="alert alert-success alert-dismissible" role="alert" id="pandre">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Aviso!</strong> Datos eliminados exitosamente
            </div>
            <?php 
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert" id="pandre">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error!</strong> No se puedo eliminar los datos
            </div>
            <?php
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
}
         
		 $sql = "select * from facturas, clientes, users WHERE facturas.id_cliente=clientes.id_cliente and facturas.id_vendedor=users.user_id ORDER BY facturas.numero_factura DESC";
		  $query = $conn->query($sql);
		//loop through fetched data
		                        $data1 = array();
					
                           while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                                         $estado_factura=$row['estado_factura'];
                                         if ($estado_factura==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}
                                        $sub_array = array();
                                        $sub_array[] = 'FV'.$row['numero_factura'];
                                        $sub_array[] = $row['numero_pedido'];
                                        $sub_array[] = date("d/m/Y", strtotime($row['fecha_factura']));
                                        $sub_array[] = $row['nombre_cliente'];
                                        $sub_array[] = $nombre_vendedor=$row['firstname']." ".$row['lastname'];					
                                        $sub_array[] = $text_estado;
                                        $sub_array[] = $row['total_venta'];
                                        $sub_array[] = $row['email_cliente'];
                                       
                                        $data1[] = $sub_array;
	                              }
	                             
                                        
                                      $new_array  = array("data"=>$data1);
	                              echo json_encode($new_array);
?>

