<?php
	$admin = UserData::getById($_SESSION["user_id"]);
	$sells = SellData::getSellsUnBoxedByAdmin($admin->admin_id);
	$last_box = BoxData::getLastByAdmin($admin->admin_id);
	$last = 1;
		if(!isset($last_box->ref_id)){
			$last = 1;
		}else{
			$last = $last_box->ref_id+1;
		}
	if(count($sells)){
		$box = new BoxData();
		$box->ref_id = $last;
		$box->admin_id = $admin->admin_id;
		$b = $box->add();
		foreach($sells as $sell){
			$sell->box_id = $b[1];
			$sell->update_box();
		}
		Core::redir("./index.php?view=b&id=".$b[1]);
	}

	Core::redir("./index.php?view=box");
?>