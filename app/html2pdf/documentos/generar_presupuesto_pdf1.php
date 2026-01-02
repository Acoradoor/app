<?php
// Activar errores de PHP para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../../index.php");
    exit();
}

// Verificar que se haya pasado el ID del presupuesto
if (!isset($_GET['id_presupuesto'])) {
    die("ID de presupuesto no especificado");
}

$id_presupuesto = intval($_GET['id_presupuesto']);

try {
    // --- CONSULTA CORREGIDA PARA PRESUPUESTOS ---
    $stmt = $conn->prepare("
        SELECT 
            p.*, 
            c.nombre_cliente, 
            c.direccion_cliente, 
            c.cif, 
            u.firstname, 
            u.lastname
        FROM presupuestos p
        JOIN clientes c ON p.id_cliente = c.id_cliente
        JOIN users u ON p.id_vendedor = u.user_id
        WHERE p.id_presupuesto = ?
    ");
    $stmt->execute([$id_presupuesto]);
    $presupuesto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$presupuesto) {
        die("Presupuesto no encontrado");
    }

    // --- CONSULTA CORREGIDA PARA DETALLE DE PRESUPUESTOS ---
    $stmt = $conn->prepare("
        SELECT 
            pd.*, 
            pr.nombre_producto, 
            pr.codigo_producto
        FROM presupuesto_detalle pd
        JOIN products pr ON pd.id_producto = pr.id_producto
        WHERE pd.id_presupuesto = ?
        ORDER BY pd.id_detalle
    ");
    $stmt->execute([$id_presupuesto]);
    $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // --- OBTENER DATOS DE PERFIL ---
    $stmt = $conn->prepare("SELECT * FROM perfil WHERE id_perfil = 1");
    $stmt->execute();
    $perfil = $stmt->fetch(PDO::FETCH_ASSOC);

    // --- VALIDACIÓN DE DATOS ---
    if (!$perfil) {
        die("Error: No se encontró la configuración del perfil");
    }

    // --- CALCULAR TOTALES ---
    $subtotal = 0;
    foreach ($detalles as $detalle) {
        $subtotal += $detalle['cantidad'] * $detalle['precio_unitario'];
    }

    $impuesto = $perfil['impuesto'] ?? 0;
    $descuento = $presupuesto['descuento'] ?? 0;

    $total_descuento = ($subtotal * $descuento) / 100;
    $base_imponible = $subtotal - $total_descuento;
    $total_iva = ($base_imponible * $impuesto) / 100;
    $total_presupuesto = $base_imponible + $total_iva;

    // --- LIMPIAR BUFFER DE SALIDA ANTES DE GENERAR PDF ---
    if (ob_get_level()) {
        ob_clean();
    }

    // --- GENERAR CONTENIDO HTML PARA PDF ---
    ob_start();
    include dirname(__FILE__).'/res/presupuesto_template.php';
    $content = ob_get_clean();

    // --- VERIFICACIÓN FINAL DEL CONTENIDO ---
    if (empty($content)) {
        die("Error: El contenido del PDF está vacío. Verifica que el archivo presupuesto_template.php esté correctamente incluido.");
    }

    // --- GENERAR PDF USANDO HTML2PDF ---
    require_once dirname(__FILE__).'/../vendor/autoload.php';  
    use Spipu\Html2Pdf\Html2Pdf;
    use Spipu\Html2Pdf\Exception\Html2PdfException;
    use Spipu\Html2Pdf\Exception\ExceptionFormatter;

    try {
        // Configurar Html2Pdf
        $html2pdf = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content);
        
        // --- SOLUCIÓN CLAVE: ENVIAR PDF CON HEADER CORRECTO ---
        // Limpia cualquier salida previa
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Establecer encabezados correctos para PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="Presupuesto_' . $id_presupuesto . '.pdf"');
        header('Content-Length: ' . strlen($content));
        header('Cache-Control: private');
        header('Pragma: private');
        
        // --- ENVÍO FINAL DEL PDF ---
        echo $content;
        exit; // Importante: terminar la ejecución

    } catch (Html2PdfException $e) {
        // Limpiar cualquier buffer residual
        if (ob_get_level()) {
            ob_end_clean();
        }
        $html2pdf->clean();
        $formatter = new ExceptionFormatter($e);
        echo "Error de Html2Pdf: " . $formatter->getHtmlMessage();
        exit;
    }

} catch (PDOException $e) {
    // Limpiar cualquier buffer residual
    if (ob_get_level()) {
        ob_end_clean();
    }
    die("Error en la base de datos: " . $e->getMessage());
} catch (Exception $e) {
    // Limpiar cualquier buffer residual
    if (ob_get_level()) {
        ob_end_clean();
    }
    die("Error general: " . $e->getMessage());
}
?>
