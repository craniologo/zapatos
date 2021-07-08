<?php
	if(count($_POST)>0){
		$product = SettingData::getById($_POST["config_id"]);
		$product->company = $_POST["company"];
		$product->ruc = $_POST["ruc"];
		$product->address = $_POST["address"];
		$product->phone = $_POST["phone"];
		$product->tax = $_POST["tax"];
		$product->coin = $_POST["coin"];
		$product->note = $_POST["note"];
		$product->update();

		if(isset($_FILES["image"])){
			$image = new Upload($_FILES["image"]);
			if($image->uploaded){
				$image->Process("storage/settings/");
				if($image->processed){
					$product->image = $image->file_dst_name;
					$product->update_image();
				}
			}
		}
	setcookie("prdupd","true");
	print "<script>window.location='index.php?view=settings';</script>";
	}
?>