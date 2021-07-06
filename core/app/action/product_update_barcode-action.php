<?php
  if(count($_POST)>0){
    $product = ProductData::getByBarcode($_POST["barcode"]);
    $product->modelo = $_POST["modelo"];
    $product->sex = $_POST["sex"];
    $product->color_id = $_POST["color_id"];
    $product->brand_id = $_POST["brand_id"];
    $product->price_in = $_POST["price_in"];
    $product->price_out = $_POST["price_out"];
    $product->ubication = $_POST['ubication'];


    if(isset($_FILES["image"])){
  		$image = new Upload($_FILES["image"]);
  		if($image->uploaded){
  			$image->Process("storage/products/");
  			if($image->processed){
  				echo "<br>".$product->image = $image->file_dst_name;
  				$product->update_by_barcode();
  			}
  		}
  	}
    $product->update_by_barcode();

  	setcookie("prdupd","true");
  	print "<script>window.location='index.php?view=products';</script>";
  }
?>