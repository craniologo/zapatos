<?php
include "core/controller/Core.php";
include "core/controller/Database.php";
include "core/controller/Executor.php";
include "core/controller/Model.php";

include "core/app/model/ProductData.php";
include "core/app/model/BrandData.php";
include "core/app/model/ColorData.php";
include "core/app/model/Serie_sizeData.php";

include "fpdf/fpdf.php";
include 'barcode.php';

$product = ProductData::getById($_GET["id"]);

if($product->sex=="Masculino"){ $sex = '01'; }else{
    $sex = '02';
  }

$pdf = new FPDF($orientation='P',$unit='mm', array(80,80));
$pdf->AddPage();
//$pdf->SetAutoPageBreak(true, 20);
$pdf->SetFont('Arial','B',20);    //Letra Arial, negrita (Bold), tam. 20

//barcode('storage/codigos/'.$code.'.png', $code, 20, 'horizontal', 'code128', true);
$pdf->setY(5);
$pdf->setX(2);
$pdf->Cell(76,6,'S/ '.number_format($product->price_out,2,".",","),0,0,'C');
$pdf->Image('storage/codigos/'.$product->barcode.'.png',10,13,60,30,'png');

$pdf->output();