<?php
/**
 * Html2Pdf Library - example
 *
 * HTML => PDF converter
 * distributed under the OSL-3.0 License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2025 Laurent MINGUET
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

// get the HTML
ob_start();

/* Connect To Database*/
require_once '../../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../../index.php");
    exit();
}

// get the HTML
ob_start();

include("../../funciones.php");
// Obtener la conexión PDO
global $conn;
$session_id = session_id();

// Consulta PDO para verificar productos en tmp
try {
    $sql_count = $conn->prepare("SELECT * FROM tmp WHERE session_id = :session_id");
    $sql_count->execute([':session_id' => $session_id]);
    $count = $sql_count->rowCount();
} catch (PDOException $e) {
    die("Error de base de datos: " . $e->getMessage());
}

if ($count == 0) {
    echo "<script>alert('No hay productos agregados a la factura')</script>";
    echo "<script>window.close();</script>";
    exit;
}

// Obtener variables pasadas por GET
$id_proveedor = intval($_GET['id_proveedor']);
$id_vendedor = intval($_GET['id_vendedor']);
$descuento = $_GET['descuento'];
$condiciones = htmlspecialchars($_REQUEST['condiciones'], ENT_QUOTES, 'UTF-8');

// Consulta PDO para obtener último número de factura
try {
    $sql = $conn->prepare("SELECT numero_factura_compra as last FROM facturas_compras ORDER BY id_factura_compra DESC LIMIT 1");
    $sql->execute();
    $rw = $sql->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error obteniendo último número de factura: " . $e->getMessage());
}

// Calcular el nuevo número de factura
$ultimoNumero = $rw['last'] ?? 0;
$rest = substr($ultimoNumero, 0, -4);
$anio = $ultimoNumero / 10000;
$anioActual = date("Y");

if ($rest != $anioActual) {
    $numero_factura = $anioActual * 10000 + 1;
} else {
    $numero_factura = $ultimoNumero + 1;
}

$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    ob_start();
    include dirname(__FILE__).'/res/nueva_factura_compras_html.php';
    $content = ob_get_clean();

    $html2pdf = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8', array(0, 0, 0, 0));
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content);
    $html2pdf->output('Factura_Compra_' . $numero_factura . '.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}

// --- REALIZAR LAS INSERCIONES EN LA BASE DE DATOS DESPUÉS DE GENERAR EL PDF ---
// NOTA: En este caso, las inserciones se harían en nueva_factura_compras_html.php o en el archivo original
// Pero para mantener consistencia con el código original, puedes hacerlas aquí si es necesario.
// $date=date("Y-m-d H:i:s");
// $insert = $conn->prepare("INSERT INTO facturas_compras VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
// $insert->execute([$numero_factura, $date, $id_proveedor, $id_vendedor, $condiciones, $aplicar_descuento1, $descuento, '2', '', '']);
// $delete = $conn->prepare("DELETE FROM tmp WHERE session_id = ?");
// $delete->execute([$session_id]);
