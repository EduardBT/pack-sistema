<?php
include "../fpdf/fpdf.php";


$factura="0001";
$fecha="05/12/2021";
$personaEnv="Yesenia Velasquez";
$personaDest= "José Lara";



$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont("Arial","",20);


$pdf->Image('../img/iso2.png', 90, 10, 30);
$pdf->SetFont('Arial','B',20);
$pdf->Ln(6);
$pdf->Cell(30);
//$pdf->Cell(120,50, 'DECLARACION GENERAL DE SEGURIDAD',0,0,'C');
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','B',14);
$pdf->Ln(30);
$pdf->Cell(180,10,utf8_decode('prueba'),1,0,'C');

//fecha
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(250,10, 'Maturin',0,0,'C');

$pdf->Ln(10);
$pdf->Cell(30,10, utf8_decode('Señores'),0,0,'C');
$pdf->Ln(10);
$pdf->Cell(30,10, utf8_decode('Copa Airlines Fireban'),0,0,'C');
/*
$pdf->SetY(15);
$pdf->SetX(10);
$pdf->Cell(10,10,"logo");

$pdf->SetY(15);
$pdf->SetX(60);
$pdf->Cell(10,10,"FACTURA");

$pdf->SetFont("Arial","",14);
$pdf->SetY(10);
$pdf->SetX(150);
$pdf->Cell(10,10,"Nro.");

$pdf->SetY(10);
$pdf->SetX(155);
$pdf->Cell(10,10,$factura);

$pdf->SetY(25);
$pdf->SetX(60);
$pdf->Cell(10,10,$personaEnv);

*/
$pdf->output();

?>