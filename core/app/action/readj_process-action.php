<?php
if(isset($_SESSION["readjust"])){
	$cart = $_SESSION["readjust"];
	if(count($cart)>0){

$process = true;

$admin = UserData::getById($_SESSION["user_id"]);

//////////////////////////////////
		if($process==true){
			$sell = new SellData();
			$sell->ref_id = $_POST["ref_id"];
			$sell->user_id = $admin->id;
			$sell->admin_id = $admin->admin_id;
			$sell->total = 0;
 			$s = $sell->add_readj();

		foreach($cart as  $c){

			$op = new OperationData();
			$op->product_id = $c["product_id"] ;
			$op->stock_id = StockData::getPrincipal()->id;
			$op->operation_type_id=7; // 1 - entrada
			$op->q= $c["q"];
			$op->size_id=$c["size_id"];
			$op->price_in = "NULL";
        	$op->price_out = "NULL";
			$op->sell_id=$s[1];
			$op->admin_id = $admin->admin_id;
			$op->add();

		}
			unset($_SESSION["readjust"]);
			setcookie("selled","selled");
////////////////////
print "<script>window.location='index.php?view=readjustment_one&id=$s[1]';</script>";
		}
	}
}



?>
