<?php
	$prod_id = $_POST["prod_id"];
    $client_id = $_POST["client_id"];
	if(isset($_POST["password"])) {
		$pass = $_POST['password'];
		$base = new Database();
		$con = $base->connect();
		$sql = "select * from configuration where id=9 and val= \"".$pass."\" ";
		
		$query = $con->query($sql);
		$found = false;
		$userid = null;
		while($r = $query->fetch_array()){
			$found = true ;
			}

		if($found==true) {

			$user = Payment_planData::getById($prod_id);
			$user->status = 1;
			$user->user_p_id = $_SESSION["user_id"];
			$user->paid_date = date("Y-m-d H:i:s");
			$user->update_payment();

			print "<script>window.open('fact.php?id=$prod_id','_blank');</script>";

			print "<script>window.location='index.php?view=client_plan_admin&id=$client_id';</script>";
			}else {
			print "<script>window.location='index.php?view=client_plan_admin&id=$client_id';</script>";
				}

		}

?>