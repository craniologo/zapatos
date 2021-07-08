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

	$admin = UserData::getById($_SESSION["user_id"]);

	//////////////////////////////////
			if($process==true){
				$prods = SellData::getLastSellByAdmin($admin->admin_id);
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
				$sell->pay = $_POST["pay"];
				$sell->total = $_POST["total"];
				$sell->cash = $_POST["cash"];
				$sell->discount = $_POST["discount"];
				$sell->stock_id = $_POST["stock_id"];
			 	$sell->user_id = $admin->id;
			 	$sell->admin_id = $admin->admin_id;
				$s = $sell->add_with_client();
				 

			foreach($cart as  $c){


				$op = new OperationData();
				$op->product_id = $c["product_id"] ;
				$op->stock_id = StockData::getPrincipal()->id;
				$op->operation_type_id=OperationTypeData::getByName("Salida")->id;
				$op->q= $c["q"];
				$op->size_id=$c["size_id"];
				$op->price_in = "NULL";
	        	$op->price_out = "NULL";
				$op->sell_id=$s[1];
				$op->admin_id = $admin->admin_id;
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