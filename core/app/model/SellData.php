<?php
class SellData {
	public static $tablename = "sell";

	public function __construct(){
		$this->id = "";
		$this->ref_id=NULL;
		$this->sell_from_id = "";
		$this->person_id = "";
		$this->stock_id = "";
		$this->operation_type_id = "";
		$this->box_id = "";
		$this->total = "";
		$this->cash = "";
		$this->discount = "";
		$this->user_id = "";
		$this->admin_id = "";
		$this->created = "NOW()";
		$this->created_at = "NOW()";
	}

	public function getRuc(){ return PersonData::getById($this->no);}
	public function getPerson(){ return PersonData::getById($this->person_id);}
	public function getUser(){ return UserData::getById($this->user_id);}
	public function getAdmin(){ return UserData::getById($this->admin_id);}
	public function getP(){ return PData::getById($this->p_id);}
	public function getD(){ return DData::getById($this->d_id);}
	public function getStockFrom(){ return StockData::getById($this->stock_from_id);}
	public function getStockTo(){ return StockData::getById($this->stock_to_id);}

	public function add(){
		$sql = "insert into ".self::$tablename." (ref_id,person_id,stock_id,stock_to_id,iva,p_id,d_id,pay,total,cash,discount,user_id,admin_id,created_at,created) ";
		$sql .= "value ($this->ref_id,$this->person_id,$this->stock_id,$this->stock_to_id,$this->iva,$this->p_id,$this->d_id,$this->pay,$this->total,$this->cash,$this->discount,$this->user_id,$this->admin_id,$this->created_at,$this->created)";
		return Executor::doit($sql);
	}
	public function add_traspase(){
		$sql = "insert into ".self::$tablename." (ref_id,stock_to_id,stock_from_id,operation_type_id,iva,p_id,d_id,total,discount,user_id,admin_id,created,created_at) ";
		$sql .= "value ($this->ref_id,$this->stock_to_id,$this->stock_from_id,6,$this->iva,$this->p_id,$this->d_id,$this->total,$this->discount,$this->user_id,$this->admin_id,$this->created,$this->created_at)";
		return Executor::doit($sql);
	}

	public function add_cotization(){
		$sql = "insert into ".self::$tablename." (is_draft,p_id,d_id,user_id,created_at,created) ";
		$sql .= "value (1,2,2,$this->user_id,$this->created_at,$this->created)";
		return Executor::doit($sql);
	}

	public function add_cotization_by_client(){
		$sql = "insert into ".self::$tablename." (is_draft,p_id,d_id,person_id,created_at,created) ";
		$sql .= "value (1,2,2,$this->person_id,$this->created_at,$this->created)";
		return Executor::doit($sql);
	}

	public function add_de(){
		$sql = "insert into ".self::$tablename." (status,stock_to_id,sell_from_id,user_id,operation_type_id,created_at,created) ";
		$sql .= "value (0,$this->stock_to_id,$this->sell_from_id,$this->user_id,5,$this->created_at,$this->created)";
		return Executor::doit($sql);
	}

	public function add_re(){
		$sql = "insert into ".self::$tablename."(ref_id,user_id,operation_type_id,total,created_at,created) ";
		$sql .= "value ($this->ref_id,$this->user_id,1,$this->total,$this->created_at,$this->created)";
		return Executor::doit($sql);
	}

	public function add_readj(){
		$sql = "insert into ".self::$tablename."(ref_id,operation_type_id,total,user_id,admin_id,created,created_at) ";
		$sql .= "value ($this->ref_id,7,$this->total,$this->user_id,$this->admin_id,$this->created,$this->created_at)";
		return Executor::doit($sql);
	}

	public function add_re_with_client(){
		$sql = "insert into ".self::$tablename." (ref_id,person_id,operation_type_id,total,user_id,admin_id,created,created_at) ";
		$sql .= "value ($this->ref_id,$this->person_id,1,\"$this->total\",$this->user_id,$this->admin_id,$this->created,$this->created_at)";
		return Executor::doit($sql);
	}

	public function add_with_client(){
		$sql = "insert into ".self::$tablename." (ref_id,person_id,stock_id,pay,total,cash,discount,user_id,admin_id,created,created_at) ";
		$sql .= "value ($this->ref_id,$this->person_id,$this->stock_id,\"$this->pay\",\"$this->total\",\"$this->cash\",\"$this->discount\",$this->user_id,$this->admin_id,$this->created,$this->created_at)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function process_cotization(){
		$sql = "update ".self::$tablename." set stock_to_id=$this->stock_to_id,p_id=$this->p_id,d_id=$this->d_id,iva=$this->iva,total=$this->total,discount=$this->discount,cash=$this->cash,is_draft=0 where id=$this->id";
		Executor::doit($sql);
	}
		
	public function update_box(){
		$sql = "update ".self::$tablename." set box_id=$this->box_id where id=$this->id";
		Executor::doit($sql);
	}

	public function update_d(){
		$sql = "update ".self::$tablename." set d_id=$this->d_id where id=$this->id";
		Executor::doit($sql);
	}

	public function update_status(){
		$sql = "update ".self::$tablename." set status=$this->status where id=$this->id";
		Executor::doit($sql);
	}

	public function update_p(){
		$sql = "update ".self::$tablename." set p_id=$this->p_id where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		 $sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new SellData());
	}

	public function cancel(){
		$sql = "update ".self::$tablename." set d_id=3,p_id=3 where id=$this->id";
		Executor::doit($sql);
	}

	public static function getCotizations(){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and p_id=2 and d_id=2 and is_draft=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getCotizationsByClientId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and p_id=2 and d_id=2 and is_draft=1 and person_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSells(){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsClientId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and person_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsByUser($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and is_draft=0 and user_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsByAdmin($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and is_draft=0 and admin_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getCredits(){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and p_id=4 and is_draft=0 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getCreditsByUserId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and p_id=4 and is_draft=0 and user_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getCreditsByStockId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and p_id=4 and is_draft=0 and stock_to_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsByClientId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and p_id=1 and d_id=1 and is_draft=0 and person_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsToDeliver(){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and d_id=2 and is_draft=0 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsToDeliverByUserId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and d_id=2 and is_draft=0 and user_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}
	public static function getSellsToDeliverByStockId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and d_id=2 and is_draft=0 and stock_to_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsToDeliverByClient($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and d_id=2 and is_draft=0 and person_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsToCob(){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and p_id=2 and is_draft=0 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsToCobByUserId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and p_id=2 and is_draft=0 and user_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}
	public static function getSellsToCobByStockId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and p_id=2 and is_draft=0 and stock_to_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsToCobByClientId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and p_id=2 and is_draft=0 and person_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsUnBoxed(){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and box_id is NULL order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsUnBoxedByAdmin($id){
		$sql = "select * from ".self::$tablename." where admin_id=$id and operation_type_id=2 and box_id is NULL order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getByBoxId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and box_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getRes(){
		$sql = "select * from ".self::$tablename." where operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getResByAdmin($id){
		$sql = "select * from ".self::$tablename." where admin_id=$id and operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getReadjs(){
		$sql = "select * from ".self::$tablename." where operation_type_id=7 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getResByStockId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=1 and p_id=1 and d_id=1 and stock_to_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getResToPay(){
		$sql = "select * from ".self::$tablename." where operation_type_id=1 and p_id=2  order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getResToPayByStockId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=1 and p_id=2 and stock_to_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getResToReceive(){
		$sql = "select * from ".self::$tablename." where operation_type_id=1 and d_id=2  order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getResToReceiveByStockId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=1 and d_id=2 and stock_to_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSQL($sql){
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}


	public static function getAllBySQL($sqlextra){
		$sql = "select * from ".self::$tablename." $sqlextra order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}


	public static function getAllByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where id<=$start_from limit $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());

	}

	public static function getAllByDateOp($start,$end,$op){
	  $sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getAllByDateOpUs($user,$start,$end,$op){
	  $sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and user_id=\"$user\" and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getAllByDateOp1($start,$end,$op){
	  $sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op and is_draft=0 and p_id=1 and d_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getAllByDateOpByUserId($user,$start,$end,$op){
	  	$sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op and is_draft=0 and p_id=1 and d_id=1 and user_id=$user order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getGroupByDateOp2($start,$end,$op){
  		$sql = "select id,discount,sum(total) as tot,discount,sum(total-discount) as t,count(*) as c from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=2 group by id";

		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getGroupByDateOp1($start,$end,$op){
  	$sql = "select id,sum(total) as tot,discount,sum(total-discount) as t,count(*) as c from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op group by id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getAllByDateBCOp($clientid,$start,$end,$op){
 		$sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and person_id=$clientid  and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

		public static function getAllByDateBCOp1($clientid,$start,$end,$op){
 		$sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and person_id=$clientid  and operation_type_id=$op and is_draft=0 and p_id=1 and d_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());

	}

	public static function getAllByDateBCOpByUserId($user,$clientid,$start,$end,$op){
 		$sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and person_id=$clientid  and operation_type_id=$op and is_draft=0 and p_id=1 and d_id=1 and user_id=$user order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getGroupByDateOp($start,$end,$op){
  		$sql = "select id,sum(total) as tot,discount,sum(total) as t,count(*) as c from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getGroupByDateOpByAdmin($start,$end,$op,$id){
  		$sql = "select id,sum(total) as tot,discount,sum(total) as t,count(*) as c from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op and admin_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getGroupByDateOpC($start,$end,$op){
  		$sql = "select id,sum(pay) as tot,discount,sum(pay) as t,count(*) as c from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getGroupByDateOpCByAdmin($start,$end,$op,$id){
  		$sql = "select id,sum(pay) as tot,discount,sum(pay) as t,count(*) as c from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op and admin_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getLastReByAdmin($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=1 and admin_id=$id order by id desc limit 1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getLastReadjbyAdmin($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=7 and admin_id=$id order by id desc limit 1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getLastSellByAdmin($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and admin_id=$id order by id desc limit 1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getAllByLastTraspase(){
		$sql = "select * from ".self::$tablename." where operation_type_id=6 order by id desc limit 1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

}

?>