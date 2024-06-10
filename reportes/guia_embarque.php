<?php

require '../fpdf/fpdf.php';

require '../conexion.php';

$query = "SELECT * FROM factura as f INNER JOIN guia_embarque AS g  ON  f.guia_id = g.id_guia  WHERE id_factura ='1'";
$resultado = mysqli_query($conexion, $query);

$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();



$pdf->Image('../img/iso2.png', 5, 5, 30 );
$pdf->SetFont('Arial','B',20);
$pdf->Cell(30);
$pdf->Cell(120,10, 'Guia de Embarque',0,0,'C');
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','B',12);
$pdf->Ln(14);

$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
while($row = $resultado->fetch_assoc())
{

$pdf->SetFont('Arial','',10);
//$pdf->Cell(190,6,'SUMINISTRADOR: Pack Express Uruguay S.A.S (COMVD07341)',1,0,'C',1);
$pdf->Ln(6);

$pdf->Cell(80,6,utf8_decode('Cliente: Pack Express Uruguay S.A.S'),1,0,'C',1);
$pdf->SetFont('Arial','',8);
$pdf->Cell(47,6,utf8_decode('HOUSE'),1,0,'C');
$pdf->Cell(60,6,utf8_decode('Remitente:'),1,0,'C');
$pdf->Ln(6);
$pdf->Cell(80,6,utf8_decode('Origen: Aereopuerto de Carrasco, Montevideo (MVD) '),1,0,'C');
$pdf->Cell(47,6,utf8_decode(''),1,0,'C');
$pdf->Cell(20,6,utf8_decode('Nombre:'),1,0,'C');
$pdf->Cell(40,6,utf8_decode('Yesenia Velasquez'),1,0,'C');
$pdf->Ln(6);
$pdf->Cell(80,6,utf8_decode(''),1,0,'C');
$pdf->Cell(47,6,utf8_decode(''),1,0,'C');
$pdf->Cell(60,6,utf8_decode('Scotiabank'),1,0,'C');
$pdf->Ln(6);
$pdf->Cell(80,6,utf8_decode('Carlos Quijano 1258 Esq. Soriano, Centro'),1,0,'C');
$pdf->Cell(47,6,utf8_decode(''),1,0,'C');
$pdf->Cell(48,6,utf8_decode('046-3519208500'),1,0,'C');
$pdf->Ln(6);
$pdf->Cell(80,6,utf8_decode('MONTEVIDEO, URUGUAY'),1,0,'C');
$pdf->Cell(47,6,utf8_decode('Cuenta Bancaria USD'),1,0,'C');
$pdf->Cell(48,6,utf8_decode('46-3519208500'),1,0,'C');
$pdf->Ln(6);
$pdf->Cell(80,6,utf8_decode('Telf. (+598)2902 7227 / (+598) 93 594 297'),1,0,'C');
$pdf->Cell(47,6,utf8_decode('Cuenta Bancaria USD'),1,0,'C');
$pdf->Cell(48,6,utf8_decode('46-3519208500'),1,0,'C');
$pdf->Ln(6);
$pdf->Cell(80,6,utf8_decode('Email: packexpress2021@gmail.com'),1,0,'C');
$pdf->Cell(47,6,utf8_decode('Cuenta Bancaria USD'),1,0,'C');
$pdf->Cell(48,6,utf8_decode('46-3519208500'),1,0,'C');
$pdf->Ln(6);
$pdf->Cell(95,6,utf8_decode('CLIENTE'),1,0,'C',1);
$Envia=$row['personasEnv_id'];
$queryEnvia = "SELECT * FROM personas INNER JOIN cod_pais ON personas.pais = cod_pais.id_pais WHERE id_persona ='$Envia'";
$resultadoEnv = mysqli_query($conexion, $queryEnvia);
    
    while($rowEnv = $resultadoEnv->fetch_assoc())
    {
    $pdf->Cell(95,6,utf8_decode($rowEnv['nombre'].' '.$rowEnv['apellidos'] ),1,0,'C',1);

    $pdf->Ln(6);
    $pdf->Cell(95,6,utf8_decode('Direccion: '.$rowEnv['direccion']),1,0,'C');
    $pdf->Cell(47,6,utf8_decode('Cédula'),1,0,'C');
    $pdf->Cell(48,6,utf8_decode($rowEnv['dni']),1,0,'C');

    $pdf->Ln(6);
    $pdf->Cell(95,6,utf8_decode($rowEnv['departamento'].', '. $rowEnv['descripcion']),1,0,'C');
    $pdf->Cell(47,6,utf8_decode('Teléfono'),1,0,'C');
    $pdf->Cell(48,6,$rowEnv['tel'],1,0,'C');

    }

    $pdf->Ln(6);
    $pdf->Cell(47,6,'Nro Bultos',1,0,'C',1);
    $pdf->Cell(48,6,'Peso Kg',1,0,'C',1);
    $pdf->Cell(47,6,utf8_decode('Precio USD'),1,0,'C',1);
    $pdf->Cell(48,6,'Importe USD',1,0,'C',1);
    $pdf->Ln(6);
}

$pdf->Cell(10,10,utf8_decode('"Certifico que este embarque no contiene ningún producto explosivo, mercancías peligrosas o aparato destructivo')) ;
$pdf->Ln(6);
$pdf->Cell(10,10,utf8_decode('NO AUTORIZADO, ASI COMO MERCANCIAS ILEGALES. Estoy consciente de que este embarque está sujeto')) ;
$pdf->Ln(6);
$pdf->Cell(10,10,utf8_decode('a los respectivos controles de seguridad Aérea y otras Regulaciones Gubernamentales: Asimismo, soy consciente')) ;
$pdf->Ln(6);
$pdf->Cell(10,10,utf8_decode(' que esta declaración y firma original así como el resto de los documentos de este embarque se mantendrán'));
$pdf->Ln(6);
$pdf->Cell(10,10,utf8_decode('en archivo hasta que el embarque sea entregado al consignatario.'));
$pdf->Ln(10);
$pdf->Cell(10,10,utf8_decode('Soy consciente y acepto que dada la emergencia sanitaria, existen retrasos en los envíos, siendo indefinido el arribo'));
$pdf->Ln(6);
$pdf->Cell(10,10,utf8_decode('de la misma a su destino final"'));
$pdf->Ln(10);
$pdf->Cell(10,10,utf8_decode('Adicionalmente autorizo al personal de Feriban S.A. a realizar cualquier gestión en nuestro nombre ante la Dirección'));
$pdf->Ln(6);
$pdf->Cell(10,10,utf8_decode('de Aduanas del Uruguay'));
$pdf->Ln(30);
$pdf->Cell(10,10,utf8_decode('Firma/signature y Sello/Seal'));
$pdf->Ln(20);
$pdf->Cell(10,10,utf8_decode('Nota: El firmante debe adjuntar a la presente fotocopia de un documento de identidad con su fotografía y presentar el'));
$pdf->Ln(6);
$pdf->Cell(10,10,utf8_decode('original para la verificación de su firma.'));

//“ en archivo hasta que el embarque sea entregado al consignatario.”
//“Certifico que este embarque no contiene ningún producto explosivo, mercancías peligrosas o aparato destructivo NO AUTORIZADO, ASI COMO MERCANCIAS ILEGALES. Estoy consciente de que este embarque está sujeto a los respectivos controles de seguridad Aérea y otras Regulaciones Gubernamentales: Asimismo, soy consciente que esta declaración y firma original así como el resto de los documentos de este embarque se mantendrán en archivo hasta que el embarque sea entregado al consignatario.”



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