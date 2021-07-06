<?php
	$color = TacoData::getById($_GET["id"]);
	$color->del();
	Core::redir("./index.php?view=details");
?>