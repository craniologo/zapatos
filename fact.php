
<?php

	$id = $_GET["id"];

	include "mc_table.php";
	include "core/controller/Core.php";
	include "core/controller/Database.php";
	include "core/controller/Executor.php";
	include "core/controller/Model.php";

	include "core/app/model/UserData.php";
	include "core/app/model/SellData.php";
	include "core/app/model/PersonData.php";
	include "core/app/model/OperationData.php";
	include "core/app/model/ColorData.php";
	include "core/app/model/Serie_sizeData.php";
	include "core/app/model/ProductData.php";
	include "core/app/model/StockData.php";
	include "core/app/model/SettingData.php";

	session_start();
	if(isset($_SESSION["user_id"])){ Core::$user = UserData::getById($_SESSION["user_id"]); }
	
	$fact = SellData::getById($id);
	$sett = SettingData::getByAdmin($fact->admin_id);
	$stock = StockData::getById($fact->stock_id)->name;
	$operations = OperationData::getAllProductsBySellId($id);
	$client = PersonData::getById($fact->person_id);
	$user = UserData::getById($fact->user_id);

	$acumulado = $fact->total+$fact->discount;
	$disc = $fact->discount;
	$total = $fact->total;
	$subtotal = $total/(1+$sett->tax/100);
	$igv = $subtotal*($sett->tax/100);

	$fecha = $fact->created_at;
	$fechaEntera = strtotime($fecha);
	$num_mes = date("m",$fechaEntera);
	$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SETIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
	$mes = $meses[$num_mes-1];


	$pdf=new PDF_MC_Table('P','mm','A4');
	$pdf->AddPage();
	$lMargin = 15;
	$uMargin = 15;

	$pdf->SetFont('Arial','B',10);    //Letra Arial, negrita (Bold), tam. 20
	if(isset($sett->image)){
		$pdf->Image('storage/settings/'.$sett->image,135,15,60,20,'jpg');
	}else{
		$pdf->Image('storage/settings/default.jpg',135,15,60,20,'jpg');
	}
	$pdf->setXY($lMargin,$uMargin);
	$pdf->Cell(50,5,'GUIA DE VENTA ',1,0,'C');
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(50,5,'Guia No: '.$fact->ref_id,1);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'Sucursal: '.utf8_decode($stock),1);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'Fecha: '.$fact->created_at,1);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'',0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'CLIENTE: ',0);
	$pdf->Cell(45,5,'',0);
	$pdf->Cell(45,5,'',0);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(45,5,utf8_decode($sett->address),0);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(140,5,'Nombre: '.utf8_decode($client->name.' '.$client->lastname),0);
	$pdf->Cell(45,5,$sett->phone,0,0,'C');
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'RUC/DNI: '.$client->ruc,0);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(100,5,'Direccion: '.utf8_decode($client->address),0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',11);
	$pdf->setX($lMargin);
	$pdf->Cell(20,6,'Codigo',1,0,'C');
	$pdf->Cell(20,6,'Imagen',1,0,'C');
	$pdf->Cell(55,6,'Descripcion del Producto',1,0,'C');
	$pdf->Cell(20,6,'Color',1,0,'C');
	$pdf->Cell(10,6,'Cant',1,0,'C');
	$pdf->Cell(15,6,'Talla',1,0,'C');
	$pdf->Cell(20,6,'Precio',1,0,'C');
	$pdf->Cell(20,6,'Total',1,0,'C');
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',9);
	//Table with 20 rows and 4 columns
	$i = 1;
	$j = 38;
	foreach($operations as $op){
	$pdf->setX($lMargin);
	$pdf->SetWidths(array(20,20,55,20,10,15,20,20));

		$product = $op->getProduct();
		$color = $product->getColor();
		$size = $op->getSize();
		$vert = count($operations);//contador de filas

		if($product->image!=""){
			$image1 = $product->image;
		}else{
			$image1 = "default.jpg";
		}

		if($i<=$vert){
			$j = $j+18;
			$pdf->Row(array($product->barcode,$pdf->Image('storage/products/'.$image1,36,$j+18,18,18),utf8_decode($product->modelo." ".$product->sex),utf8_decode($color->name),$op->q,$size->size,number_format($product->price_out,2,".",","),number_format($op->q*$product->price_out,2,".",",")));
			$i = $i+1;
		}
	}
	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->Cell(135,6,'',0);
	$pdf->Cell(25,6,'Acumulado '.$sett->coin,1);
	$pdf->Cell(20,6,number_format($acumulado,2,".",","),1,0,'R');
	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->Cell(135,6,'',0);
	$pdf->Cell(25,6,'Descuento '.$sett->coin,1);
	$pdf->Cell(20,6,number_format($disc,2,".",","),1,0,'R');
	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->Cell(135,6,'',0);
	$pdf->Cell(25,6,'Subtotal '.$sett->coin,1);
	$pdf->Cell(20,6,number_format($subtotal,2,".",","),1,0,'R');
	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->Cell(135,6,'Atendido por: '.utf8_decode($user->name)." ".utf8_decode($user->lastname),0);
	$pdf->Cell(25,6,'IGV ('.$sett->tax.'%) '.$sett->coin,1);
	$pdf->Cell(20,6,number_format($igv,2,".",","),1,0,'R');
	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->Cell(135,6,'',0);
	$pdf->Cell(25,6,'Total a Pagar '.$sett->coin,1);
	$pdf->Cell(20,6,number_format($total,2,".",","),1,0,'R');


	$pdf->setX($lMargin);
	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(40,6,'Nota: ',0);
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',10);
	$pdf->SetWidths(array(180));
	$pdf->setX($lMargin);
	$pdf->Row(array(utf8_decode($sett->note)));

	$pdf->Output();
?>