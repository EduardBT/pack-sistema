<?php
include "fpdf/fpdf.php";

$factura = "0001";
$fecha = "05/12/2021";
$personaEnv = "Yesenia Velasquez";
$personaDest = "José Lara";

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont("Arial", "", 20);


$pdf->Image('img/iso2.png', 90, 10, 30);
$pdf->SetFont('Arial', 'B', 20);
$pdf->Ln(6);
$pdf->Cell(30);

$pdf->SetFillColor(232, 232, 232);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Ln(30);
$pdf->Cell(180, 10, utf8_decode('Declaración General de Seguridad'), 1, 0, 'C');

//fecha
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(250, 10, 'Maturin', 0, 0, 'C');
$pdf->Cell(1, 10, '06/12/2021', 0, 0, 'C');

$pdf->Ln(10);
$pdf->Cell(47, 6, utf8_decode('Señores'), 0, 0, 'C', 1);
$pdf->Ln(10);
$pdf->Cell(47, 6, utf8_decode('Copa Airlines Fireban'), 0, 0, 'C');

$pdf->Ln(10);
$pdf->Cell(90, 6, utf8_decode('Presente'), 0, 0, 'C', 1);
$pdf->Cell(90, 6, utf8_decode('Ref. Nro. Guía'), 0, 0, 'C');
$pdf->Cell(1, 4, utf8_decode('00241AAA'), 0, 0, 'C');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(90, 6, utf8_decode('Mediante la presente, yo'), 0, 0, 'C', 0);
$pdf->Cell(1, 6, utf8_decode('Luis Peña'), 0, 0, 'C');
$pdf->Cell(30, 6, utf8_decode('Cédula: '), 0, 0, 'C');

$pdf->Ln(15);

$pdf->Cell(10, 10, utf8_decode('"Certifico que este embarque no contiene ningún producto explosivo, mercancías peligrosas o aparato destructivo'));
$pdf->Ln(6);
$pdf->Cell(10, 10, utf8_decode('NO AUTORIZADO, ASI COMO MERCANCIAS ILEGALES. Estoy consciente de que este embarque está sujeto'));
$pdf->Ln(6);
$pdf->Cell(10, 10, utf8_decode('a los respectivos controles de seguridad Aérea y otras Regulaciones Gubernamentales: Asimismo, soy consciente'));
$pdf->Ln(6);
$pdf->Cell(10, 10, utf8_decode(' que esta declaración y firma original así como el resto de los documentos de este embarque se mantendrán'));
$pdf->Ln(6);
$pdf->Cell(10, 10, utf8_decode('en archivo hasta que el embarque sea entregado al consignatario.'));
$pdf->Ln(10);
$pdf->Cell(10, 10, utf8_decode('Soy consciente y acepto que dada la emergencia sanitaria, existen retrasos en los envíos, siendo indefinido el arribo'));
$pdf->Ln(6);
$pdf->Cell(10, 10, utf8_decode('de la misma a su destino final"'));
$pdf->Ln(10);
$pdf->Cell(10, 10, utf8_decode('Adicionalmente autorizo al personal de Feriban S.A. a realizar cualquier gestión en nuestro nombre ante la Dirección'));
$pdf->Ln(6);
$pdf->Cell(10, 10, utf8_decode('de Aduanas del Uruguay'));
$pdf->Ln(30);
$pdf->Cell(10, 10, utf8_decode('Firma/signature y Sello/Seal'));
$pdf->Ln(20);
$pdf->Cell(10, 10, utf8_decode('Nota: El firmante debe adjuntar a la presente fotocopia de un documento de identidad con su fotografía y presentar el'));
$pdf->Ln(6);
$pdf->Cell(10, 10, utf8_decode('original para la verificación de su firma.'));

$pdf->output();

?>