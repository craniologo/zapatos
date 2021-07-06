<?php
include "core/controller/Core.php";
include "core/controller/Database.php";
include "core/controller/Executor.php";
include "core/controller/Model.php";

include "core/app/model/UserData.php";
include "core/app/model/SellData.php";
include "core/app/model/PersonData.php";
include "core/app/model/OperationData.php";
include "core/app/model/ProductData.php";
include "core/app/model/StockData.php";
include "core/app/model/ConfigurationData.php";
include "fpdf/fpdf.php";
session_start();
if(isset($_SESSION["user_id"])){ Core::$user = UserData::getById($_SESSION["user_id"]); }
$title = ConfigurationData::getByPreffix("ticket_title")->val;

$stock = StockData::getPrincipal();
$sell = SellData::getById($_GET["id"]);
$operations = OperationData::getAllProductsBySellId($_GET["id"]);
$user = $sell->getUser();
$client = $sell->getPerson();


$pdf = new FPDF($orientation='P',$unit='mm', array(80,170));
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);    //Letra Arial, negrita (Bold), tam. 20
//$pdf->setXY(5,0);
$pdf->setY(2);
$pdf->setX(2);
$pdf->Cell(5,5,strtoupper($title));
$pdf->SetFont('Arial','B',8);    //Letra Arial, negrita (Bold), tam. 20
$pdf->setX(2);
$pdf->Cell(8,12,"Dir: ".strtoupper($stock->address));
$pdf->setX(2);
$pdf->Cell(8,18,"Telf: ".strtoupper($stock->phone));
$pdf->setX(2);
$pdf->Cell(8,24,"FOLIO: ".$sell->id);
$pdf->setX(2);
$pdf->Cell(8,30,"FECHA: ".$sell->created_at);
$pdf->setX(2);
$pdf->Cell(8,36,"Cliente: ".strtoupper($client->name." ".$client->lastname));
$pdf->setX(2);
$pdf->Cell(8,42,"RUC: ".strtoupper($client->no));
$pdf->setX(2);
$pdf->Cell(8,48,'-------------------------------------------------------------------');
$pdf->setX(2);
$pdf->Cell(8,54,'CANT.  ARTICULO       		  PRECIO           TOTAL');

$total =0;
$off = 60;
foreach($operations as $op){
$product = $op->getProduct();
$pdf->setX(2);
$pdf->Cell(5,$off,"$op->q");
$pdf->setX(10);
$pdf->Cell(35,$off,  strtoupper(substr($product->name, 0,12)) );
$pdf->setX(20);
$pdf->Cell(29,$off,  "S/ ".number_format($product->price_out,2,".",",") ,0,0,"R");
$pdf->setX(32);
$pdf->Cell(35,$off,  "S/ ".number_format($op->q*$product->price_out,2,".",",") ,0,0,"R");

//    ".."  ".number_format($op->q*$product->price_out,2,".",","));
$total += $op->q*$product->price_out;
$off+=6;
}
$pdf->setX(2);
$pdf->Cell(5,$off+3,"DESCUENTO: " );
$pdf->setX(62);
$pdf->Cell(5,$off+3,"S/ ".number_format($total*$sell->discount/100,2,".",","),0,0,"R");
$pdf->setX(2);
$pdf->Cell(5,$off+9,"SUBTOTAL:  " );
$pdf->setX(62);
$pdf->Cell(5,$off+9,"S/ ".number_format($total*.82,2,".",","),0,0,"R");
$pdf->setX(2);
$pdf->Cell(5,$off+15,"IGV (18%):  " );
$pdf->setX(62);
$pdf->Cell(5,$off+15,"S/ ".number_format($total*.18,2,".",","),0,0,"R");
$pdf->setX(2);
$pdf->Cell(5,$off+21,"TOTAL: " );
$pdf->setX(62);
$pdf->Cell(5,$off+21,"S/ ".number_format($total - ($total*$sell->discount/100),2,".",","),0,0,"R");

$pdf->setX(2);
$pdf->Cell(5,$off+27,'-------------------------------------------------------------------');
$pdf->setX(2);
$pdf->Cell(5,$off+33,"EFECTIVO: " );
$pdf->setX(62);
$pdf->Cell(5,$off+33,"S/ ".number_format($sell->cash,2,".",","),0,0,"R");

$pdf->setX(2);
$pdf->Cell(5,$off+39,"CAMBIO: " );
$pdf->setX(62);
$pdf->Cell(5,$off+39,"S/ ".number_format($sell->cash-($total - ($total*$sell->discount/100)),2,".",","),0,0,"R");

$pdf->setX(2);
$pdf->Cell(5,$off+45,'-------------------------------------------------------------------');
$pdf->setX(2);
$pdf->Cell(5,$off+51,"Sucursal: ".strtoupper($stock->name));
$pdf->setX(2);
$pdf->Cell(5,$off+57,'Atendido por: '.strtoupper($user->name." ".$user->lastname));
$pdf->setX(10);
$pdf->Cell(5,$off+63,"GRACIAS POR SU COMPRA");
$pdf->setX(2);

$pdf->output();
