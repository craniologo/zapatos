<?php
	if(isset($_SESSION["reabastecer"])){
		$cart = $_SESSION["reabastecer"];
		if(count($cart)>0){

	$process = true;

	$admin = UserData::getById($_SESSION["user_id"]);

	//////////////////////////////////
			if($process==true){
				$prods = SellData::getLastReByAdmin($admin->admin_id);
					$last = 1;
			        if(isset($prods)<""){
			            $last = 1;
			        }else{
			            foreach ($prods as $prod) {
			            $last = $prod->ref_id+1;
			            }
			        }
				$sell = new SellData();
				$sell->ref_id = $last;
				$sell->person_id=$_POST["client_id"];
				$sell->total = $_POST["money1"];
			 	$sell->user_id = $admin->id;
			 	$sell->admin_id = $admin->admin_id;	 	
	 			$s = $sell->add_re_with_client();

			foreach($cart as  $c){

				$op = new OperationData();
				$op->product_id = $c["product_id"] ;
				$op->stock_id = StockData::getPrincipal()->id;
				$op->operation_type_id=1; // 1 - entrada
				$op->q= $c["q"];
				$op->size_id=$c["size_id"];
				$op->price_in = "NULL";
	        	$op->price_out = "NULL";
				$op->sell_id=$s[1];
				$op->admin_id = $admin->admin_id;
				$add = $op->add();			 		

			}
				unset($_SESSION["reabastecer"]);
				setcookie("selled","selled");
	////////////////////
	print "<script>window.location='index.php?view=re_one&id=$s[1]';</script>";
			}
		}
	}

?>
