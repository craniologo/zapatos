<?php

	if(count($_POST)>0){
		$user = UserData::getById($_POST["user_id"]);
		$user->name = $_POST["name"];
		$user->lastname = $_POST["lastname"];
		$user->username = $_POST["email"];
		$user->email = $_POST["email"];
		  if(isset($_FILES["image"])){
		    $image = new Upload($_FILES["image"]);
		    if($image->uploaded){
		      $image->Process("storage/profiles/");
		      if($image->processed){
		        $user->image = $image->file_dst_name;
		      }
		    }
		  }
		$user->status = isset($_POST["status"])?1:0;
		if(isset($_POST["stock_id"]) && $_POST["stock_id"]!=""){
			$user->kind = $_POST["kind"];
			$user->stock_id = $_POST["stock_id"];
			$user->update_kind_stock();
		}else{	
			$user->update();
		}

		if($_POST["password"]!=""){
			$user->password = sha1(md5($_POST["password"]));
			$user->update_passwd();
	print "<script>alert('Se ha actualizado el password');</script>";

		}

	print "<script>window.location='index.php?view=users';</script>";

	}

?>