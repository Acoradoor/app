<?php
// Activar errores para debugging (puedes desactivarlo en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ob_start();

/* Connect To Database */
require_once '../../includes/auth.php';

if (!isLoggedIn()) {
    header("Location: ../../index.php");
    exit();
}

// Archivo de funciones PHP
include("../../funciones.php");
$session_id = session_id();

// --- CONSULTAS PDO ---
$sql_count = $conn->prepare("SELECT * FROM tmp WHERE session_id = ?");
$sql_count->execute([$session_id]);
$count = $sql_count->rowCount();

if ($count == 0) {
    echo "<script>alert('No hay productos agregados a la factura')</script>";
    echo "<script>window.close();</script>";
    exit;
}

// Obtener variables pasadas por GET
$id_cliente = intval($_GET['id_cliente']);
$id_vendedor = intval($_GET['id_vendedor']);
$descuento = $_GET['descuento'];
$condiciones = strip_tags($_REQUEST['condiciones'], ENT_QUOTES);

// --- OBTENER EL ÚLTIMO NÚMERO DE FACTURA ---
// Usar PDO para obtener el último número de factura
$sql = $conn->prepare("SELECT LAST_INSERT_ID(numero_factura) as last FROM facturas ORDER BY id_factura DESC LIMIT 0,1");
$sql->execute();
$rw = $sql->fetch(PDO::FETCH_ASSOC);

if (!$rw || !isset($rw['last'])) {
    // Manejar error si no se puede obtener el número
    die("Error al obtener el número de factura.");
}
$ultimoNumero = $rw['last'];

$rest = substr($ultimoNumero, 0, -4);
$anio = $ultimoNumero / 10000;
$anioActual = date("Y");

if ($rest != $anioActual) {
    $numero_factura = $anioActual * 10000 + 1;
} else {
    $numero_factura = $ultimoNumero + 1;
}

// --- GENERAR EL CONTENIDO HTML ---
/* Template */
$file_template = "nueva_factura_html.php";
/* Template */

// Usar un buffer de salida para capturar el contenido
ob_start();

// Asegurarnos de que las variables necesarias estén disponibles en el scope del archivo incluido
// Esto es crucial para evitar errores al incluir el archivo HTML
// Definimos todas las variables que el archivo HTML espera
// (Esto puede parecer redundante, pero es necesario para evitar errores de variable no definida)
// Variables definidas por el script principal
// $id_cliente, $id_vendedor, $condiciones, $descuento, $session_id, $numero_factura, $simbolo_moneda, $anio, $rw, $ultimoNumero, $rest, $anioActual
// Variables definidas en el HTML original (aunque se usan variables locales en el HTML)
// $impuesto, $subtotal, $descuento1, $total_descuento, $aplicar_descuento, $aplicar_descuento1, $total_iva, $total_factura

// Definir variables que el HTML necesita para evitar errores
$simbolo_moneda = get_row('perfil','moneda', 'id_perfil', 1);
$anio = date('Y');

// Incluir el archivo HTML que contiene el contenido de la factura
// Para evitar errores, usamos un bloque try-catch para capturar posibles errores durante la inclusión
try {
    include(dirname(__FILE__) . '/res/' . $file_template);
} catch (Exception $e) {
    die("Error incluyendo el archivo HTML: " . $e->getMessage());
}

$content = ob_get_clean();

// --- DEBUG: Verificar contenido HTML ---
// echo "<!-- DEBUG HTML CONTENT STARTS -->";
// echo htmlspecialchars($content); // Muestra el HTML como texto plano
// echo "<!-- DEBUG HTML CONTENT ENDS -->";

// Verificar si el contenido está vacío o tiene errores
if (empty(trim($content))) {
    die("Error: El contenido HTML está vacío o tiene errores. Revisa el archivo nueva_factura_html.php.");
}

// --- GENERAR EL PDF CON DOMPDF ---

// Incluir el autoload de dompdf (ajusta la ruta según donde hayas colocado la carpeta dompdf)
require_once '../autoload.inc.php'; // Ajusta la ruta según tu estructura

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar opciones de dompdf
$options = new Options();
$options->set('defaultFont', 'Arial'); // Opcional: establecer fuente por defecto
$options->set('isRemoteEnabled', true); // Permitir carga de recursos remotos (imágenes, etc.)
$options->set('isHtml5ParserEnabled', true); // Habilitar el parser HTML5 (puede ayudar con ciertos problemas)
$options->set('isPhpEnabled', false); // Deshabilitar PHP para evitar riesgos de seguridad

// Crear instancia de Dompdf
$dompdf = new Dompdf($options);

// Cargar el contenido HTML
try {
    $dompdf->loadHtml($content);
} catch (Exception $e) {
    die("Error cargando HTML en dompdf: " . $e->getMessage());
}

// Establecer el tamaño de papel y orientación
$dompdf->setPaper('A4', 'portrait');

// Renderizar el PDF
try {
    $dompdf->render();
} catch (Exception $e) {
    die("Error renderizando PDF: " . $e->getMessage());
}

// Obtener el PDF generado
$pdf_output = $dompdf->output();

// Comprobar si se generó el PDF correctamente
if (empty($pdf_output)) {
    die("Error: No se pudo generar el PDF. Verifica la salida HTML o los recursos externos.");
}

// Enviar el PDF al navegador
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="factura.pdf"'); // Para abrir en el navegador
// header('Content-Disposition: attachment; filename="factura.pdf"'); // Para forzar descarga
header('Content-Length: ' . strlen($pdf_output));

// Imprimir el PDF
echo $pdf_output;

// --- REALIZAR LAS INSERCIONES EN LA BASE DE DATOS DESPUÉS DE GENERAR EL PDF ---
// NOTA: En este caso, las inserciones se harían en nueva_factura_html.php o en el archivo original
// Pero para mantener consistencia con el código original, puedes hacerlas aquí si es necesario.
// $date=date("Y-m-d H:i:s");
// $insert = $conn->prepare("INSERT INTO facturas VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
// $insert->execute([$numero_factura, $date, $id_cliente, $id_vendedor, $condiciones, $aplicar_descuento1, $descuento, '2', '', '']);
// $delete = $conn->prepare("DELETE FROM tmp WHERE session_id = ?");
// $delete->execute([$session_id]);

?>
