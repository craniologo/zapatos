<?php
	if(count($_POST)>0){
		$admin = UserData::getById($_SESSION["user_id"]);
	  	$color = new ColorData();
	  	$color->name = $_POST["name"];
	  	$color->admin_id = $admin->admin_id;
	  	$color->add();
	  	print "<script>window.location='index.php?view=details';</script>";
	}
?>