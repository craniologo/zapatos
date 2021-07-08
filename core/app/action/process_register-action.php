<?php
	$alphabeth ="abcdefghijklmnopqrstuvwxyz";
	  $code = "";
	  for($i=0;$i<5;$i++){
	      $code .= $alphabeth[rand(0,strlen($alphabeth)-1)];
	  }

	if(!empty($_POST)){
		$user = new UserData();
		$user->code = $code;
		$user->name = $_POST["name"];
		$user->lastname = $_POST["lastname"];
		$user->username = $_POST["email"];
		$user->email = $_POST["email"];
		$user->password = sha1(md5($_POST["password"]));
		$user->kind = 1;
		$user->add();

		$admin_last = UserData::getLastUser();

		$stock = new StockData();
		$stock->name = "MI SUCURSAL";
		$stock->address = "MI CALLE";
		$stock->phone = "MI TELEFONO";
		$stock->email = $_POST["email"];
		$stock->admin_id = $admin_last->id;
		$stock->add_principal();

		$stock_last = StockData::getLastStock();

		$admin = UserData::getById($admin_last->id);
		$admin->admin_id = $admin_last->id;
		$admin->stock_id = $stock_last->id;
		$admin->update_admin_stock();

		$conf = new SettingData();
		$conf->company = "MI EMPRESA";
		$conf->ruc = "0";
		$conf->address = "MI DIRECCION";
		$conf->Phone = "MI TELEFONO";
		$conf->tax = "18";
		$conf->coin = "S/";
		$conf->admin_id = $admin_last->id;
		$conf->add();

		Core::alert("Registro Exitoso!, ya puedes a iniciar sesion con tu nombre de usuario y password.");
		print "<script>window.location='index.php?view=login';</script>";
	}
?>