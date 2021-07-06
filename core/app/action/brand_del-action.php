<?php
	$brand = BrandData::getById($_GET["id"]);
	$brand->del();
	Core::redir("./index.php?view=model");
?>