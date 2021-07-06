<?php
	if(count($_POST)>0){
		$admin = UserData::getById($_SESSION["user_id"]);
		$client = new PersonData();
		$client->name = $_POST["name"];
		$client->lastname = $_POST["lastname"];
		$client->ruc = $_POST["ruc"];
		$client->address = $_POST["address"];
		$client->email = $_POST["email"];
		$client->phone = $_POST["phone"];
		$client->user_id = $admin->id;
		$client->admin_id = $admin->admin_id;
		$client->add_client();
		print "<script>window.location='index.php?view=sell';</script>";
	}
?>