<?php

if(isset($_SESSION["cart"])){
	$cart = $_SESSION["cart"];
	if(count($cart)>0){
/// antes de proceder con lo que sigue vamos a verificar que:
		// haya existencia de productos
		// si se va a facturar la cantidad a facturr debe ser menor o igual al producto facturado en inventario
		$num_succ = 0;
		$process=false;
		$errors = array();
		foreach($cart as $c){

			///
			$q = OperationData::getQYesF($c["product_id"]);
			if($c["q"]<=$q){
				if(isset($_POST["is_oficial"])){
				$qyf =OperationData::getQYesF($c["product_id"]); /// son los productos que puedo facturar
				if($c["q"]<=$qyf){
					$num_succ++;
				}else{
				$error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto para facturar en inventario.");					
				$errors[count($errors)] = $error;
				}
				}else{
					// si llegue hasta aqui y no voy a facturar, entonces continuo ...
					$num_succ++;
				}
			}else{
				$error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
			}

		}

if($num_succ==count($cart)){
	$process = true;
}

if($process==false){
$_SESSION["errors"] = $errors;
	?>	
<script>
	window.location="index.php?view=sell";
</script>
<?php
}

//////////////////////////////////
		if($process==true){
			$x = new XXData();
			$xx = $x->add();
			$sell = new SellData();
			$sell->ref_id = $xx[1];
			$sell->user_id = $_SESSION["user_id"];
			$sell->pay = $_POST["pay"];
			$sell->total = $_POST["stotal"];
			$sell->cash = $_POST["money"];
			$sell->discount = $_POST["discount"];
			$sell->stock_id = $_POST["stock_id"];

			 if(isset($_POST["client_id"]) && $_POST["client_id"]!=""){
			 	$sell->person_id=$_POST["client_id"];
 				$s = $sell->add_with_client();
			 }else{
 				$s = $sell->add();
			 }

		foreach($cart as  $c){


			$op = new OperationData();
			$op->product_id = $c["product_id"] ;
			$op->stock_id = StockData::getPrincipal()->id;
			$op->operation_type_id=OperationTypeData::getByName("salida")->id;
			$op->q= $c["q"];
			$op->size_id=$c["size_id"];
			$op->price_in = "NULL";
        	$op->price_out = "NULL";
			$op->sell_id=$s[1];
			$add = $op->add();			 		

			unset($_SESSION["cart"]);
			setcookie("selled","selled");
		}
////////////////////
print "<script>window.location='index.php?view=sell_one&id=$s[1]';</script>";
		}
	}
}



?>