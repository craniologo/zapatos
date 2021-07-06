<?php
	if(count($_POST)>0){
		$admin = UserData::getById($_SESSION["user_id"]);
	  	$brand = new BrandData();
	  	$brand->name = $_POST["name"];
	  	$brand->admin_id = $admin->admin_id;
	  	$brand->add();
	  	print "<script>window.location='index.php?view=details';</script>";
	}
?>