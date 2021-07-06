<?php
	if(count($_POST)>0){
		$spend = SpendData::getById($_POST["spend_id"]);
		$spend->name = $_POST["name"];
		$spend->price = $_POST["price"];
		$spend->created_at = $_POST["created_at"];
		$spend->update();
		setcookie("prdupd","true");
		print "<script>window.location='index.php?view=spends';</script>";
	}
?>			