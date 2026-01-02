<?php
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
$id_cliente = intval($_GET['id_cliente']);
$id_vendedor = intval($_GET['id_vendedor']);
$descuento = $_GET['descuento'];
$condiciones = htmlspecialchars($_REQUEST['condiciones'], ENT_QUOTES, 'UTF-8');

// Consulta PDO para obtener último número de factura
try {
    $sql = $conn->prepare("SELECT numero_factura as last FROM facturas ORDER BY id_factura DESC LIMIT 1");
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

/* Template */
$file_template = "nueva_factura_html.php";
/* Template */

require_once(dirname(__FILE__).'/../html2pdf.class.php');

// Capturar el contenido del template
ob_start();
include(dirname(__FILE__).'/res/'.$file_template);
$content = ob_get_clean();

try {
    // init HTML2PDF
    $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
    // display the full page
    $html2pdf->pdf->SetDisplayMode('fullpage');
    // convert
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    // send the PDF
    $html2pdf->Output('Factura_' . $numero_factura . '.pdf');
} catch(HTML2PDF_exception $e) {
    echo "Error al generar PDF: " . $e->getMessage();
    exit;
}
