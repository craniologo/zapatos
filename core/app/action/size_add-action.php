<?php
	if(count($_POST)>0){
		$admin = UserData::getById($_SESSION["user_id"]);
	  	$size = new Serie_sizeData();
	  	$size->serie_id = $_POST["serie_id"];
	  	$size->size = $_POST["size"];
	  	$size->admin_id = $admin->admin_id;
	  	$size->add();
	  	print "<script>window.location='index.php?view=serie_size';</script>";
	}
?>