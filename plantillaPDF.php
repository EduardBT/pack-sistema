	<?php
    require 'fpdf/fpdf.php';

	class PDF extends FPDF
	{
		function Header()
		{
			$this->Image('img/iso2.png', 5, 5, 30 );
			$this->SetFont('Arial','B',20);
			$this->Cell(30);
			$this->Cell(120,10, 'FACTURA',0,0,'C');
            $this->SetFillColor(232,232,232);
            $this->SetFont('Arial','B',12);
            $this->Ln(14);

		}
		
		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
		}		
	}
?>