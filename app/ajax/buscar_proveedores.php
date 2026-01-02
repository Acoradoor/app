<?php
/*-------------------------
Autor: Toni gallur 
pagina ajax que se ejecuta ddentro modal
agregar_producto.php para
agregar proveedores a la factura
---------------------------*/

require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax'){
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = strip_tags($_REQUEST['q'], ENT_QUOTES);
    $aColumns = array('nombre_proveedor');//Columnas de busqueda
    $sTable = "proveedores";
    $sWhere = "";
    if ( $_GET['q'] != "" )
    {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    $per_page = 5; //how much records you want to show
    $adjacents  = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = $conn->prepare("SELECT COUNT(*) AS numrows FROM $sTable $sWhere");
    $count_query->execute();
    $row = $count_query->fetch(PDO::FETCH_ASSOC);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows/$per_page);
    $reload = './index.php';
    //main query to fetch the data
    $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = $conn->query($sql);
    //loop through fetched data
    if ($numrows>0){
        ?>
        <div class="table-responsive">
            <table class="table">
                <tr  class="warning">
                    <th>Proveedor</th>
                    <th><span class="pull-right">Acciones</span></th>
                </tr>
                <?php
                while ($row=$query->fetch(PDO::FETCH_ASSOC)){
                    $id_proveedor=$row['id_proveedor'];
                    $nombre_proveedor=$row['nombre_proveedor'];
                    ?>
                    <tr>
                        <td><?php echo $nombre_proveedor; ?></td>
                        <td class='text-center'><a class='btn btn-info'href="#" onclick="seleccionar_proveedor('<?php echo $id_proveedor ?>', '<?php echo $nombre_proveedor ?>')"><i class="glyphicon glyphicon-plus"></i></a></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan=2><span class="pull-right">
                        <?php
                        echo paginate($reload, $page, $total_pages, $adjacents);
                        ?></span></td>
                </tr>
            </table>
        </div>
        <?php
    }
}
?>
