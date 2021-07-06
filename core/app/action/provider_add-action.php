<?php
	if(count($_POST)>0){
		$admin = UserData::getById($_SESSION["user_id"]);
		$provider = new PersonData();
		$provider->name = $_POST["name"];
		$provider->lastname = $_POST["lastname"];
		$provider->ruc = $_POST["ruc"];
		$provider->address = $_POST["address"];
		$provider->phone = $_POST["phone"];
		$provider->email = $_POST["email"];
		$provider->user_id = $admin->id;
		$provider->admin_id = $admin->admin_id;
		$provider->add_provider();
		print "<script>window.location='index.php?view=providers';</script>";
	}
?>