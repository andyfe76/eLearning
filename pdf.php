<?php
define('FPDF_FONTPATH','include/fpdf/font/');
require('include/fpdf/fpdf.php');


/*$pdf=new FPDF();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();*/


$pdf=new PDF();
$pdf->Open();
$title='20000 Leagues Under the Seas';
$pdf->SetTitle($title);
$pdf->SetAuthor('Jules Verne');
$pdf->PrintChapter(1,'A RUNAWAY REEF','20k_c1.txt');
$pdf->PrintChapter(2,'THE PROS AND CONS','20k_c2.txt');
$pdf->Output();

?>