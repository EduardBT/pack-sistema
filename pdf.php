<?php
include "conexion.php";
include_once 'vendor/autoload.php' ;
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
$dompdf = new Dompdf();

ob_start();
include_once "pdf-guia.php";

$html = ob_get_clean();


$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
/*$dompdf->setPaper('A5', 'portrait');*/
$dompdf->render();
$dompdf->stream("reportes.pdf", array("Attachment"=>false));
?>