<?php
	if(count($_POST)>0){
		$last = Serie_sizeData::getByLast();
		foreach ($last as $la) {
			$id = $la->id + 1;
		}

		if($_POST["size_1"]==""){
			$size_1=0;
		}else{
			$size_1=$_POST["size_1"];
		}
		if($_POST["size_2"]==""){
			$size_2=0;
		}else{
			$size_2=$_POST["size_2"];
		}
		if($_POST["size_3"]==""){
			$size_3=0;
		}else{
			$size_3=$_POST["size_3"];
		}
		if($_POST["size_4"]==""){
			$size_4=0;
		}else{
			$size_4=$_POST["size_4"];
		}
		if($_POST["size_5"]==""){
			$size_5=0;
		}else{
			$size_5=$_POST["size_5"];
		}
		if($_POST["size_6"]==""){
			$size_6=0;
		}else{
			$size_6=$_POST["size_6"];
		}
		if($_POST["size_7"]==""){
			$size_7=0;
		}else{
			$size_7=$_POST["size_7"];
		}
		
		$user = new Serie_sizeData();
		$user->name = $_POST["name"];
		$user->size_1 = $size_1;
		$user->value_1 = $id+$size_1;
		$user->size_2 = $size_2;
		$user->value_2 = $id+$size_2;
		$user->size_3 = $size_3;
		$user->value_3 = $id+$size_3;
		$user->size_4 = $size_4;
		$user->value_4 = $id+$size_4;
		$user->size_5 = $size_5;
		$user->value_5 = $id+$size_5;
		$user->size_6 = $size_6;
		$user->value_6 = $id+$size_6;
		$user->size_7 = $size_7;
		$user->value_7 = $id+$size_7;
		$user->add();

	print "<script>window.location='index.php?view=serie_size';</script>";
	}
?>