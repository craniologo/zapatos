<?php
	if(count($_POST)>0){
		$product = BrandData::getById($_POST["id"]);
		$product->name = $_POST["name"];
		$product->update();
		setcookie("prdupd","true");
		print "<script>window.location='index.php?view=details';</script>";
	}
?>			