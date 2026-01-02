<?php
// test_html2pdf_autoloader.php
// Colócalo en la raíz de tu proyecto

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir el autoloader desde la carpeta html2pdf
require_once(dirname(__FILE__) . '/../autoloader.php');

// Cargar HTML2PDF
loadHtml2Pdf();

try {
    // Probar que las clases se cargan correctamente
    $html2pdf = new Spipu\Html2Pdf\Html2Pdf();
    echo "✅ Clase Html2Pdf cargada correctamente<br>";
    
    // Probar carga de excepciones
    $exception = new Spipu\Html2Pdf\Exception\Html2PdfException('Test');
    echo "✅ Clase Html2PdfException cargada correctamente<br>";
    
    // Probar que podemos generar un PDF simple
    $html2pdf->writeHTML('<h1>Test exitoso</h1><p>El autoloader funciona correctamente</p>');
    
    // Guardar en un archivo en lugar de enviar al navegador para esta prueba
    $pdfContent = $html2pdf->output('test.pdf', 'S');
    file_put_contents('test_output.pdf', $pdfContent);
    
    echo "✅ PDF generado correctamente<br>";
    echo "🎉 ¡Autoloader interno funcionando correctamente!<br>";
    echo "📄 PDF de prueba guardado como: test_output.pdf";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
    echo "<br><br>Trace:<br>";
    echo nl2br($e->getTraceAsString());
}
?>
