<?php

/*-------------------------
	Autor: Toni gallur 
	pagina ajax que se ejecuta desde modal
	registro_producto2.php y buscar_producto.php 
	la funcion esta en editar_facyura_nueva.js
	---------------------------*/


/* Connect To Database*/
require_once '../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

/*Inicia validacion del lado del servidor*/
if (empty($_POST['codigo'])) {
    $errors[] = "Código vacío";
} else if (empty($_POST['nombre'])) {
    $errors[] = "Nombre del producto vacío";
} else if ($_POST['estado']=="") {
    $errors[] = "Selecciona el estado del producto";
} else if (empty($_POST['precio'])) {
    $errors[] = "Precio de venta vacío";
} else if (!empty($_POST['codigo']) && !empty($_POST['nombre']) && $_POST['estado']!="" && !empty($_POST['precio'])) {
    // Usar PDO en lugar de MySQLi para escapar datos
    $codigo = strip_tags($_POST["codigo"], ENT_QUOTES);
    $nombre = strip_tags($_POST["nombre"], ENT_QUOTES);
    $categoria = strip_tags($_POST["categoria"], ENT_QUOTES);
    $cantidad = strip_tags($_POST["cantidad"], ENT_QUOTES);
    $estado = intval($_POST['estado']);
    $precio_venta = floatval($_POST['precio']);
    $date_added = date("Y-m-d H:i:s");

    // Usar PDO para la inserción (más seguro)
    try {
        $sql = "INSERT INTO products (codigo_producto, nombre_producto, categoria, cantidad, status_producto, date_added, precio_producto) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$codigo, $nombre, $categoria, $cantidad, $estado, $date_added, $precio_venta]);
        
        if ($result) {
            $messages[] = "Producto ha sido ingresado satisfactoriamente.";
        } else {
            $errors[] = "Lo siento algo ha salido mal intenta nuevamente.";
        }
    } catch (PDOException $e) {
        $errors[] = "Error en la base de datos: " . $e->getMessage();
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {
    ?>
    <div class="alert alert-danger" role="alert" id="ji">
        <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
        <strong>Error!</strong>
        <?php foreach ($errors as $error) { echo $error; }?>
    </div>
    <?php
}

if (isset($messages)) {
    ?>
    <div class="alert alert-success" role="alert" id="ji">
        <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
        <strong>¡Bien hecho!</strong>
        <?php foreach ($messages as $message) { echo $message; }?>
    </div>
    <?php
}
?>
