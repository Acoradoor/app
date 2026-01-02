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

// Incluir el archivo HTML que contiene el contenido de la factura
// NOTA: Debemos incluirlo como un string, no ejecutarlo directamente como antes.
// Para ello, vamos a usar un buffer de salida.
ob_start();
include(dirname(__FILE__) . '/res/' . $file_template);
$content = ob_get_clean();

// Debug: Verificar si el contenido se generó
// echo "Contenido generado:<pre>";
// echo htmlspecialchars($content);
// echo "</pre>";
// exit;

// --- GENERAR EL PDF CON DOMPDF ---

// Incluir el autoload de dompdf (ajusta la ruta según donde hayas colocado la carpeta dompdf)
// Si instalaste manualmente, la estructura suele ser algo como:
// tu_proyecto/
//   lib/
//     dompdf/
//       src/
//         Autoloader/
//           Autoloader.php
//       ...
// Entonces, la ruta sería:
// require_once 'lib/dompdf/src/Autoloader.php';
// Dompdf\Autoloader::register(); // Registrar el autoloader
// Alternativamente, si tienes un autoload.inc.php o un archivo de carga específico:
require_once '../autoload.inc.php'; // Ajusta la ruta según tu estructura

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar opciones de dompdf
$options = new Options();
$options->set('defaultFont', 'Arial'); // Opcional: establecer fuente por defecto
$options->set('isRemoteEnabled', true); // Permitir carga de recursos remotos (imágenes, etc.)
$options->set('isHtml5ParserEnabled', true); // Habilitar el parser HTML5 (puede ayudar con ciertos problemas)

// Crear instancia de Dompdf
$dompdf = new Dompdf($options);

// Cargar el contenido HTML
$dompdf->loadHtml($content);

// Establecer el tamaño de papel y orientación
$dompdf->setPaper('A4', 'portrait');

// Renderizar el PDF
$dompdf->render();

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
