
<?php
	include 'plantillaPDF.php';
	require '../conexion.php';
	
    $query = "SELECT * FROM factura as f INNER JOIN guia_embarque AS g  ON  f.guia_id = g.id_guia  WHERE id_factura ='1'";
    $resultado = mysqli_query($conexion, $query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
    
	$pdf->SetFillColor(232,232,232);


    $pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
    while($row = $resultado->fetch_assoc())
	{
	$pdf->Cell(25,6,'Nro',1,0,'C');
    $pdf->Cell(25,6,utf8_decode($row['id_factura']),1,0,'C',1);
    $pdf->Ln(6);
	$pdf->Cell(25,6,'fecha',1,0,'C');
    $pdf->Cell(25,6,$row['fecha'],1,0,'C',1);
    $pdf->Ln(10);

    $pdf->Cell(190,6,'SUMINISTRADOR: Pack Express Uruguay S.A.S',1,0,'C',1);
    $pdf->Ln(6);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(95,6,utf8_decode(''),1,0,'C');
    $pdf->Cell(47,6,utf8_decode('Código RUT'),1,0,'C');
    $pdf->Cell(48,6,utf8_decode('218883410015'),1,0,'C');
    $pdf->Ln(6);
    $pdf->Cell(95,6,utf8_decode('Dirección: Carlos Quijano No. 1258'),1,0,'C');
    $pdf->Cell(47,6,utf8_decode('Actividad'),1,0,'C');
    $pdf->Cell(48,6,utf8_decode('Courier'),1,0,'C');
    $pdf->Ln(6);
    $pdf->Cell(95,6,utf8_decode('Esq. Soriano. MVD. Uruguay'),1,0,'C');
    $pdf->Cell(47,6,utf8_decode('Agencia Bancaria'),1,0,'C');
    $pdf->Cell(48,6,utf8_decode('Scotiabank'),1,0,'C');
    $pdf->Ln(6);
    $pdf->Cell(95,6,utf8_decode(''),1,0,'C');
    $pdf->Cell(47,6,utf8_decode('Cuenta Bancaria UY'),1,0,'C');
    $pdf->Cell(48,6,utf8_decode('046-3519208500'),1,0,'C');
    $pdf->Ln(6);
    $pdf->Cell(95,6,utf8_decode(''),1,0,'C');
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

        
		//$pdf->Cell(20,6,utf8_decode($row['id_factura']),1,0,'C');
		//$pdf->Cell(20,6,$row['fecha'],1,0,'C');
		//$pdf->Cell(70,6,utf8_decode($row['id_factura']),1,1,'C');
	}
	$pdf->Output();
?>