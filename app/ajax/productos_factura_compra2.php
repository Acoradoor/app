<?php
/*-------------------------
Autor: Toni Gallur 
pagina ajax que se ejecuta ddentro modal
agregar_producto.php y registro_producto.php para
agregar productos a la factura de compra
---------------------------*/

require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax'){
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = strip_tags($_REQUEST['q_facturas_compras'], ENT_QUOTES);
    $aColumns = array('codigo_producto', 'nombre_producto');//Columnas de busqueda
    $sTable = "products";
    $sWhere = "";
    if ( $_GET['q_facturas_compras'] != "" )
    {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
    include 'pagination_compra.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page_facturas_compras']) && !empty($_REQUEST['page_facturas_compras']))?$_REQUEST['page_facturas_compras']:1;
    $per_page = 5; //how much records you want to show
    $adjacents  = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = $conn->prepare("SELECT COUNT(*) AS numrows FROM $sTable $sWhere");
    $count_query->execute();
    $row = $count_query->fetch(PDO::FETCH_ASSOC);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows/$per_page);
    $reload = './index.php'; // Este valor puede necesitar ajuste según la ruta real
    //main query to fetch the data
    $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = $conn->query($sql);
    //loop through fetched data
    if ($numrows>0){
        
        ?>
        <div class="table-responsive">
          <table class="table">
            <tr  class="warning">
                <th>Código</th>
                <th>Producto</th>
                <th><span class="pull-right">Cant.</span></th>
                <th><span class="pull-right">Precio</span></th>
                <th class='text-center' style="width: 36px;">Agregar</th>
            </tr>
            <?php
            while ($row=$query->fetch(PDO::FETCH_ASSOC)){
                $id_producto=$row['id_producto'];
                $codigo_producto=$row['codigo_producto'];
                $nombre_producto=$row['nombre_producto'];
                $precio_venta=$row["precio_producto"];
                $precio_venta1=number_format($precio_venta,2,'.','');
                ?>
                <tr>
                    <td><?php echo $codigo_producto; ?></td>
                    <td><?php echo $nombre_producto; ?></td>
                    <td class='col-xs-1'>
                    <div class="pull-right">
                    <input type="text" class="form-control" style="text-align:right" id="cantidadaa_<?php echo $id_producto; ?>"  value="1" >
                    </div></td>
                    <td class='col-xs-2'><div class="pull-right">
                    <input type="text" class="form-control" style="text-align:right" id="precio_ventaaa_<?php echo $id_producto; ?>"  value="<?php echo $precio_venta1;?>" >
                    </div></td>
                    <td class='text-center'><a class='btn btn-info'href="#" onclick="agregarProductoCompraUnico('<?php echo $id_producto ?>')"><i class="glyphicon glyphicon-plus"></i></a></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan=5><span class="pull-right">
                <?php
                 echo paginate_compra($reload, $page, $total_pages, $adjacents);
                ?></span></td>
            </tr>
          </table>
        </div>
        <?php
    }
}
?>
