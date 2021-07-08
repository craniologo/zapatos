<?php
    include 'barcode.php';

    if(count($_POST)>0){
        $admin = UserData::getById($_SESSION["user_id"]);

        $sizes = $_POST["value"];
        $id = $_POST["id"];
        for($i = 0; $i<sizeof($sizes); ++$i)
        /* "Id: ".$id[$i]." Talla: ".$sizes[$i]."<br>";*/
            {
                $product = new ProductData();
                $product->modelo = $_POST["modelo"];
                $product->sex = $_POST['sex'];
                $product->color_id = $_POST['color_id'];
                $product->brand_id = $_POST['brand_id'];
                $product->size_id = $id[$i];
                $product->qty = $sizes[$i];
                $product->stock_min = $_POST['stock_min'];
                $product->price_in = $_POST['price_in'];
                $product->price_out = $_POST['price_out'];
                $product->ubication = $_POST['ubication'];
                $product->admin_id = $admin->admin_id;

                if(isset($_FILES["image"])){
                $image = new Upload($_FILES["image"]);
                  if($image->uploaded){
                    $image->Process("storage/products/");
                    if($image->processed){
                      $product->image = $image->file_dst_name;
                      $prod = $product->add_with_image();
                    }
                  }else{

                $prod= $product->add();
                  }
                }
                else{
                $prod= $product->add();

                }

                $prods = ProductData::getLastByAdmin($admin->admin_id);
                    $last = 1;
                if(isset($prods)==""){
                    $last = $last;
                }else{
                    foreach ($prods as $prod) {
                    $last = $prod->id;
                    }
                }

                $op = new OperationData();
                $op->product_id = $last;
                $op->stock_id = StockData::getPrincipalByAdmin($admin->admin_id)->id;
                $op->operation_type_id=OperationTypeData::getByName("entrada")->id;
                $op->q = $sizes[$i];
                $op->size_id = $id[$i];
                $op->price_in = "NULL";
                $op->price_out = "NULL";
                $op->sell_id="NULL";
                $op->admin_id = $admin->admin_id;
                $op->add();

                $product = ProductData::getById($last);
                $brand = BrandData::getById($product->brand_id);
                if($product->sex=="Masculino"){ $sex = '01';
                    }else{
                        $sex = '02';
                  }
                $color = ColorData::getById($product->color_id);
                $s_size = Serie_sizeData::getById($product->size_id);

                $code = $product->id."".$brand->id."".$sex."".$color->id."".$s_size->id;
                barcode('storage/codigos/'.$code.'.png', $code, 20, 'horizontal', 'code128', true);

                $product = ProductData::getById($last);
                $product->barcode = $code;
                $product->update_barcode();

            }
        print "<script>window.location='index.php?view=products';</script>";
    }
?>