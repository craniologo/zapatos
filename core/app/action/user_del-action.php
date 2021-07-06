<?php
	$client = UserData::getById($_GET["id"]);
	$client->del();
	Core::redir("./index.php?view=users");
?>