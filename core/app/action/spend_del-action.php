<?php
	$spend = SpendData::getById($_GET["id"]);
	$spend->del();
	Core::redir("./index.php?view=spends");
?>