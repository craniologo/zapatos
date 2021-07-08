<?php

	if(count($_POST)>0){
		$admin = UserData::getById($_SESSION["user_id"]);
		$user = new UserData();
		$user->name = $_POST["name"];
		$user->lastname = $_POST["lastname"];
		$user->username = $_POST["email"];
		$user->email = $_POST["email"];
		$user->password = sha1(md5($_POST["password"]));

		$user->image="";
		  if(isset($_FILES["image"])){
		    $image = new Upload($_FILES["image"]);
		    if($image->uploaded){
		      $image->Process("storage/profiles/");
		      if($image->processed){
		        $user->image = $image->file_dst_name;
		      }
		    }
		  }

		
		$user->kind = $_POST["kind"];
		$user->stock_id = $_POST["stock_id"];
		$user->admin_id = $admin->admin_id;
		$user->add_new();

	print "<script>window.location='index.php?view=users';</script>";

	}

?>