<?php
/*-------------------------
Autor: Toni gallur 
pagina ajax que se ejecuta desde modal
registro_proveedor2.php 
---------------------------*/

/* Connect To Database*/
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

/*Inicia validacion del lado del servidor*/
if (empty($_POST['nombre'])) {
    $errors[] = "Nombre vacío";
} else if (!empty($_POST['nombre'])){
    $nombre = strip_tags($_POST["nombre"], ENT_QUOTES);
    $cuenta = strip_tags($_POST["cuenta"], ENT_QUOTES);
    $telefono = strip_tags($_POST["telefono"], ENT_QUOTES);
    $movil = strip_tags($_POST["movil"], ENT_QUOTES);
    $email = strip_tags($_POST["email"], ENT_QUOTES);
    $direccion = strip_tags($_POST["direccion"], ENT_QUOTES);
    $pago = strip_tags($_POST["pago"], ENT_QUOTES);
    $cif = strip_tags($_POST["cif"], ENT_QUOTES);
    $estado=intval($_POST['estado']);
    $date_added=date("Y-m-d H:i:s");
    
    try {
        $sql = "INSERT INTO proveedores (nombre_proveedor, n_cuenta, telefono_proveedor, telefono_movil, email_proveedor, direccion_proveedor, pago, cif, status_proveedor, date_added) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$nombre, $cuenta, $telefono, $movil, $email, $direccion, $pago, $cif, $estado, $date_added]);
        
        if ($result){
            $messages[] = "Proveedor ha sido ingresado satisfactoriamente.";
        } else{
            $errors []= "Lo siento algo ha salido mal intenta nuevamente.";
        }
    } catch (PDOException $e) {
        $errors[] = "Error en la base de datos: " . $e->getMessage();
    }
} else {
    $errors []= "Error desconocido.";
}

if (isset($errors)){
    ?>
    <div class="alert alert-danger" role="alert" id="ya_proveedor">
        <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
        <strong>Error!</strong> 
        <?php
            foreach ($errors as $error) {
                echo $error;
            }
        ?>
    </div>
    <?php
}

if (isset($messages)){
    ?>
    <div class="alert alert-success" role="alert" id="ya_proveedor">
        <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
        <strong>¡Bien hecho!</strong>
        <?php
            foreach ($messages as $message) {
                echo $message;
            }
        ?>
    </div>
    <?php
}
?>
