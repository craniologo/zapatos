<?php

    if(isset($_SESSION["traspase"])){
        $cart = $_SESSION["traspase"];
        if(count($cart)>0){
    /// antes de proceder con lo que sigue vamos a verificar que:
            // haya existencia de productos
            // si se va a facturar la cantidad a facturr debe ser menor o igual al producto facturado en inventario
            $num_succ = 0;
            $process=false;
            $errors = array();
            foreach($cart as $c){

                ///
                $q = OperationData::getQByStock($c["product_id"],$_SESSION["stock_id"]);
                if($c["q"]<=$q){
                    if(isset($_POST["is_oficial"])){
                    $qyf =OperationData::getQByStock($c["product_id"],$_SESSION["stock_id"]); /// son los productos que puedo facturar
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
        window.location="index.php?view=traspase";
    </script>
    <?php
    }

    $admin = UserData::getById($_SESSION["user_id"]);

    //////////////////////////////////
            if($process==true){
                $sell = new SellData();
                $sell->ref_id = $_POST["ref_id"];
                $sell->stock_from_id = $_SESSION["stock_id"];
                $sell->stock_to_id =  $_POST["stock_id"];
                $sell->p_id =1;// $_POST["p_id"];
                $sell->d_id = 1;// $_POST["d_id"];
                $sell->iva=  18;;
                $sell->total = $_POST["total"];
                $sell->discount = 0;//$_POST["discount"];
                $sell->user_id = $admin->id;
                $sell->admin_id = $admin->admin_id;
                $s = $sell->add_traspase();


            foreach($cart as  $c){
                $product = ProductData::getById($c["product_id"]);
                $op = new OperationData();
                $op->product_id = $c["product_id"] ;
                $op->stock_id = $_SESSION["stock_id"];
                $op->operation_type_id=OperationTypeData::getByName("traspaso")->id;
                $op->q= $c["q"];
                $op->size_id=$_POST["size_id"];
                $op->price_in = $product->price_in;
                $op->price_out = $product->price_out;
                $op->sell_id=$s[1];
                $op->admin_id = $admin->admin_id;
                $add = $op->add();

                $operation_type = "salida";
                $product = ProductData::getById($c["product_id"]);
                $op = new OperationData();
                $op->product_id = $c["product_id"] ;
                $op->stock_id = $_SESSION["stock_id"];
                $op->operation_from_id=$add[1];
                $op->operation_type_id=OperationTypeData::getByName($operation_type)->id;
                $op->q= $c["q"];
                $op->size_id=$_POST["size_id"];
                $op->price_in = $product->price_in;
                $op->price_out = $product->price_out;
                $op->sell_id=$s[1];
                $op->admin_id = $admin->admin_id;
                $op->add();

                $op = new OperationData();
                $op->product_id = $c["product_id"] ;
                $op->stock_id = $_POST["stock_id"];
                $op->operation_from_id=$add[1];
                $op->operation_type_id=OperationTypeData::getByName("entrada")->id;
                $op->q= $c["q"];
                $op->size_id=$_POST["size_id"];
                $op->price_in = $product->price_in;
                $op->price_out = $product->price_out;
                
                $op->sell_id=$s[1];                
                $op->admin_id = $admin->admin_id;
                $add = $op->add();

                unset($_SESSION["traspase"]);
                setcookie("selled","selled");
            }
    ////////////////////
            }
        }
    }
    print "<script>window.location='index.php?view=onetraspase&id=$s[1]';</script>";

?>