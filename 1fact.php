
<?php
	$id = $_GET["id"];

	include "mc_table.php";
	include "core/controller/Core.php";
	include "core/controller/Database.php";
	include "core/controller/Executor.php";
	include "core/controller/Model.php";
	include "core/app/model/UserData.php";
	include "core/app/model/Payment_planData.php";
	include "core/app/model/Client_planData.php";
	include "core/app/model/ConfigurationData.php";

	session_start();
	if(isset($_SESSION["user_id"])){ Core::$user = UserData::getById($_SESSION["user_id"]); }
	$title = ConfigurationData::getByPreffix("company_name")->val;
	$address = ConfigurationData::getByPreffix("address")->val;
	$phone = ConfigurationData::getByPreffix("phone")->val;
	$image = ConfigurationData::getByPreffix("report_image")->val;
	$note = ConfigurationData::getByPreffix("note")->val;
	$imp = ConfigurationData::getByPreffix("imp-val")->val;
	$fact = Payment_planData::getById($id);
	$client = Client_planData::getById($fact->client_plan_id);
	$user = UserData::getById($fact->user_id);

	$igv = $imp * 0.01;
	$subt = $fact->total-$fact->total*$igv;

	$fecha = $fact->payment_date;
	$fechaEntera = strtotime($fecha);
	$num_mes = date("m",$fechaEntera);
	$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SETIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
	$mes = $meses[$num_mes-1];


	$pdf=new PDF_MC_Table('P','mm','A4');
	$pdf->AddPage();
	$lMargin = 15;
	$uMargin = 15;

	$pdf->SetFont('Arial','B',10);    //Letra Arial, negrita (Bold), tam. 20
	$pdf->Image('storage/configuration/'.$image,160,15,30,20,'jpg');
	$pdf->setXY($lMargin,$uMargin);
	$pdf->Cell(50,5,'FACTURA '.$mes.' '.date('Y'),1);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(50,5,'Factura N: '.$fact->code,1);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'Inicio: '.$client->created_at,1);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'Vencimiento: '.$fact->payment_date,1);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'Pago: '.$fact->paid_date,1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'Factura para: ',0);
	$pdf->Cell(45,5,'',0);
	$pdf->Cell(45,5,'',0);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(45,5,$address,0);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(140,5,'Nombre: '.$client->name.' '.$client->lastname,0);
	$pdf->Cell(45,5,$phone,0,0,'C');
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'DNI: '.$client->no,0);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(100,5,'Direccion: '.$client->address,0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',11);
	$pdf->setX($lMargin);
	$pdf->Cell(105,6,'Descripcion del Servicio',1,0,'C');
	$pdf->Cell(25,6,'Precio',1,0,'C');
	$pdf->Cell(25,6,'Descuento',1,0,'C');
	$pdf->Cell(25,6,'Subtotal',1,0,'C');
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',9);
	//Table with 20 rows and 4 columns
	$pdf->setX($lMargin);
	$pdf->SetWidths(array(105,25,25,25));
	
	$pdf->Row(array($fact->detail,number_format($fact->pay,2,".",","),number_format($fact->discont,2,".",","),number_format($fact->total,2,".",",")));

	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->Cell(140,6,'',0);
	$pdf->Cell(20,6,'Subtotal: ',1);
	$pdf->Cell(20,6,number_format($subt,2,".",","),1,0,'R');
	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->Cell(140,6,'Atendido por: '.$user->name." ".$user->lastname,0);
	$pdf->Cell(20,6,'Imp %: ',1);
	$pdf->Cell(20,6,number_format($fact->total*$igv,2,".",","),1,0,'R');
	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->Cell(140,6,'',0);
	$pdf->Cell(20,6,'Total S/: ',1);
	$pdf->Cell(20,6,number_format($fact->total,2,".",","),1,0,'R');
	

	$pdf->setX($lMargin);
	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(40,6,'Nota: ',0);
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',10);
	$pdf->SetWidths(array(180));
	$pdf->setX($lMargin);
	$pdf->Row(array($note));
	$pdf->Ln(20);

	$pdf->cell($lMargin,1,'---------------------------------------------------------------------------------------------------------------------------------------------------------------',0);

	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',10);    //Letra Arial, negrita (Bold), tam. 20
	$pdf->Image('storage/configuration/'.$image,160,163,30,20,'jpg');
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'FACTURA '.$mes.' '.date('Y'),1);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(50,5,'Factura N: '.$fact->code,1);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'Inicio: '.$client->created_at,1);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'Vencimiento: '.$fact->payment_date,1);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'Pago: '.$fact->paid_date,1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'Factura para: ',0);
	$pdf->Cell(45,5,'',0);
	$pdf->Cell(45,5,'',0);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(45,5,$address,0);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(140,5,'Nombre: '.$client->name.' '.$client->lastname,0);
	$pdf->Cell(45,5,$phone,0,0,'C');
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(50,5,'DNI: '.$client->no,0);
	$pdf->Ln(5);
	$pdf->setX($lMargin);
	$pdf->Cell(100,5,'Direccion: '.$client->address,0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',11);
	$pdf->setX($lMargin);
	$pdf->Cell(105,6,'Descripcion del Servicio',1,0,'C');
	$pdf->Cell(25,6,'Precio',1,0,'C');
	$pdf->Cell(25,6,'Descuento',1,0,'C');
	$pdf->Cell(25,6,'Subtotal',1,0,'C');
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',9);
	//Table with 20 rows and 4 columns
	$pdf->setX($lMargin);
	$pdf->SetWidths(array(105,25,25,25));
	
	$pdf->Row(array($fact->detail,number_format($fact->pay,2,".",","),number_format($fact->discont,2,".",","),number_format($fact->total,2,".",",")));

	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->Cell(140,6,'',0);
	$pdf->Cell(20,6,'Subtotal: ',1);
	$pdf->Cell(20,6,number_format($subt,2,".",","),1,0,'R');
	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->Cell(140,6,'Atendido por: '.$user->name." ".$user->lastname,0);
	$pdf->Cell(20,6,'Imp %: ',1);
	$pdf->Cell(20,6,number_format($fact->total*$igv,2,".",","),1,0,'R');
	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->Cell(140,6,'',0);
	$pdf->Cell(20,6,'Total S/: ',1);
	$pdf->Cell(20,6,number_format($fact->total,2,".",","),1,0,'R');
	

	$pdf->setX($lMargin);
	$pdf->Ln(6);
	$pdf->setX($lMargin);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(40,6,'Nota: ',0);
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',10);
	$pdf->SetWidths(array(180));
	$pdf->setX($lMargin);
	$pdf->Row(array($note));

	$pdf->Output();
?>