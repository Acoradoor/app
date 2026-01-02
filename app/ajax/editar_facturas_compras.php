<?php
/*-------------------------
Autor: Toni gallur

pagina ajax que se carga en
index.php lamado por una funcion
en jquery.init.js 
---------------------------*/
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['id1'])){
    $numero_factura1 = $_POST['id1'];
    $rest1 = substr($numero_factura1, 2);
    $sql1 = "SELECT * FROM facturas_compras WHERE numero_factura_compra = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute([$rest1]);
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    $id_factura11 = $row1['id_factura_compra'];
    $campos1="proveedores.id_proveedor, proveedores.nombre_proveedor, proveedores.telefono_proveedor, proveedores.email_proveedor, facturas_compras.id_vendedor, facturas_compras.fecha_factura_compra, facturas_compras.condiciones, facturas_compras.estado_factura, facturas_compras.numero_factura_compra, facturas_compras.descuento";
    // Usar PDO para esta consulta también
    $sql_factura1 = $conn->prepare("SELECT $campos1 FROM facturas_compras, proveedores WHERE facturas_compras.id_proveedor = proveedores.id_proveedor AND id_factura_compra = ?");
    $sql_factura1->execute([$id_factura11]);
    $count1 = $sql_factura1->rowCount();
    if ($count1==1) {
        $rw_factura1 = $sql_factura1->fetch(PDO::FETCH_ASSOC);
        $id_proveedor=$rw_factura1['id_proveedor'];
        $nombre_proveedor=$rw_factura1['nombre_proveedor'];
        $telefono_proveedor=$rw_factura1['telefono_proveedor'];
        $email_proveedor=$rw_factura1['email_proveedor'];
        $id_vendedor_db=$rw_factura1['id_vendedor'];
        $fecha_factura=date("d/m/Y", strtotime($rw_factura1['fecha_factura_compra']));
        $condiciones=$rw_factura1['condiciones'];
        $estado_factura=$rw_factura1['estado_factura'];
        $numero_factura1=$rw_factura1['numero_factura_compra'];
        $descuento=$rw_factura1['descuento'];
        $_SESSION['id_factura11']=$id_factura11;
        $_SESSION['numero_factura11']=$numero_factura11; 
    } else {
        echo "no tengo respuesta".$rest1 ;
    }
} else {
    echo "No recibí datos por POST";
}     

include("../modal/registro_proveedores2.php");
include("../modal/registro_productos4.php");
include("../modal/agregar_producto2.php");
?>

<form class="form-horizontal" role="form" id="datos_factura_compras">
    <div class="form-group row">
        <label for="nombre_proveedor" class="col-md-1 control-label">Proveedor</label>
        <div class="col-md-3">
            <input type="text" class="form-control input-sm" id="nombre_proveedor" placeholder="Selecciona un proveedor" readonly value="<?php echo $nombre_proveedor;?>">
            <input id="id_proveedor" name="id_proveedor" type='hidden' value="<?php echo $id_proveedor;?>">	
        </div>
        <label for="tel1" class="col-md-1 control-label">Teléfono</label>
        <div class="col-md-2">
            <input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" value="<?php echo $telefono_proveedor;?>" readonly>
        </div>
        <label for="mail" class="col-md-1 control-label">Email</label>
        <div class="col-md-3">
            <input type="text" class="form-control input-sm" id="mail" placeholder="Email" readonly value="<?php echo $email_proveedor;?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="empresa" class="col-md-1 control-label">Vendedor</label>
        <div class="col-md-3">
            <select class="form-select input-sm" id="id_vendedor" name="id_vendedor">
                <?php
                $sql_vendedor = $conn->query("select * from users order by lastname");
                while ($rw = $sql_vendedor->fetch(PDO::FETCH_ASSOC)){
                    $id_vendedor=$rw["user_id"];
                    $nombre_vendedor=$rw["firstname"]." ".$rw["lastname"];
                    if ($id_vendedor==$id_vendedor_db){
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
        <label for="tel2" class="col-md-1 control-label">Fecha</label>
        <div class="col-md-2">
            <input type="text" class="form-control input-sm" id="fecha" value="<?php echo $fecha_factura;?>" readonly>
        </div>
        <label for="email" class="col-md-1 control-label">Pago</label>
        <div class="col-md-2">
            <select class="form-select" id="condiciones" name="condiciones" required>
                <option value="Giro 30 Dias" <?php if ($condiciones=="Giro 30 Dias"){echo "selected";}?> >Giro 30 Dias</option>
                <option value="Giro 60 Dias" <?php if ($condiciones=="Giro 60 Dias"){echo "selected";}?>>Giro 60 Dias</option>
                <option value="Giro 30 y 60 Dias" <?php if ($condiciones=="Giro 30 y 60 Dias"){echo "selected";}?>>Giro 30 y 60 Dias</option>
                <option value="Efectivo" <?php if ($condiciones=="Efectivo"){echo "selected";}?>>Efectivo</option>
                <option value="Transferencia" <?php if ($condiciones=="Transferencia"){echo "selected";}?>>Transferencia</option>
                <option value="Pagare 30 Dias" <?php if ($condiciones=="Pagare 30 Dias"){echo "selected";}?>>Pagare 30 Dias</option>
                <option value="Pagare 60 Dias" <?php if ($condiciones=="Pagare 60 Dias"){echo "selected";}?>>Pagare 60 Dias</option>
                <option value="Pagare 90 Dias" <?php if ($condiciones=="Pagare 90 Dias"){echo "selected";}?>>Pagare 90 Dias</option>
                <option value="Confirming 60 Dias" <?php if ($condiciones=="Confirming 60 Dias"){echo "selected";}?>>Confirming 60 Dias</option>
                <option value="Confirming 120 Dias" <?php if ($condiciones=="Confirming 120 Dias"){echo "selected";}?>>Confirming 120 Dias</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class='form-select input-sm ' id="estado_factura" name="estado_factura">
                <option value="1" <?php if ($estado_factura==1){echo "selected";}?>>Pagado</option>
                <option value="2" <?php if ($estado_factura==2){echo "selected";}?>>Pendiente</option>
            </select>
        </div>
    </div>
    <div class="form-group row"> 
        <label for="descuento" class="col-md-1 control-label">Descuento</label>
        <div class="col-md-2">
            <input type="text" class="form-control input-sm" id="descuento" name="descuento" value="<?php echo $descuento;?>">
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="pull-right">
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-refresh"></span> Actualizar datos
            </button>
            <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#registro_producto4">
                <span class="glyphicon glyphicon-plus"></span> Nuevo producto
            </button>
            <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#nuevoProveedor2">
                <span class="glyphicon glyphicon-user"></span> Nuevo proveedor
            </button>
            <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#myModal41_compras">
                <span class="glyphicon glyphicon-search"></span> Agregar productos
            </button>
            <button type="button" class="btn btn-default" onclick="imprimir_factura('<?php echo $id_factura1;?>')">
                <span class="glyphicon glyphicon-print"></span> Imprimir
            </button>
            <button type="button" class="btn btn-default" onclick="borrar_factura_compras('<?php echo $numero_factura;?>')">
                <span class="glyphicon glyphicon-trash"></span> Eliminar
            </button>
        </div>	
    </div>
</form>

<div id="resultados1_compras" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->

<script type="text/javascript" src="../assets/js/ajax/VentanaCentrada.js"></script>
<script type="text/javascript" src="../assets/js/ajax/editar_factura_compras.js"></script>
