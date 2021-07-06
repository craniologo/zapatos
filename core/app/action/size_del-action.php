<?php
	$size = Serie_sizeData::getById($_GET["id"]);
	$size->del();
	Core::redir("./index.php?view=serie_size");
?>