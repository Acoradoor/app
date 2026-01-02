<?php
	
	  /*-------------------------
	Autor: Toni gallur
	
	pagina ajax que se carga en
	index.php lamado por una funcion
	en jquery.init.js 
	---------------------------*/
	
	// get the HTML
     ob_start();
/* Connect To Database*/
	

require_once '../../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: ../../index.php");
    exit();
});
	// get the HTML
     ob_start();

	include("../../funciones.php");
	$session_id= session_id();
	$sql_count=mysqli_query($con,"select * from tmp where session_id='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('No hay productos agregados a la factura')</script>";
	echo "<script>window.close();</script>";
	exit;
	}

	
	//Ontengo variables pasadas por GET
	
	$id_cliente=intval($_GET['id_cliente']);
	$id_vendedor=intval($_GET['id_vendedor']);
        $descuento=$_GET['descuento'];
	$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
	
	
	//Fin de variables por GET
	$sql=mysqli_query($con, "select LAST_INSERT_ID(numero_factura) as last from facturas order by id_factura desc limit 0,1 ");
	$rw=mysqli_fetch_array($sql);
	$numero_factura1=$rw['last']+1;	
	$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
	
	  $ultimoNumero = $rw['last'];
	 $rest = substr($ultimoNumero, 0, -4);
          $anio = $ultimoNumero / 10000;
          $anioActual = date("Y");
          if( $rest != $anioActual ){
          $numero_factura = $anioActual * 10000 + 1;
          }else{
         $numero_factura = $ultimoNumero + 1;
	}
  
	/*Template*/
	
		$file_template="nueva_factura_html.php";
	/*Template*/

	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		

    
     include(dirname('__FILE__').'/res/'.$file_template);
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('factura.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
