<?php
	if(count($_POST)>0){
		$admin = UserData::getById($_SESSION["user_id"]);
		$user = new SpendData();
		$user->name = $_POST["name"];
		$user->price = $_POST["price"];
		$user->user_id = $admin->id;
		$user->admin_id = $admin->admin_id;
		$user->add();
		print "<script>window.location='index.php?view=spends';</script>";
	}
?>