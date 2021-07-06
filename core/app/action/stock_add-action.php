<?php
	if(count($_POST)>0){
		$admin = UserData::getById($_SESSION["user_id"]);
		$stock = new StockData();
		$stock->name = $_POST["name"];
		$stock->address = $_POST["address"];
		$stock->phone = $_POST["phone"];
		$stock->email = $_POST["email"];
		$stock->admin_id = $admin->admin_id;
		$stock->add();
		print "<script>window.location='index.php?view=stocks';</script>";
	}
?>