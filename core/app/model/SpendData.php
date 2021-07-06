<?php
	class SpendData {
		public static $tablename = "spend";

		public function __construct(){
			$this->name = "";
			$this->price = "";
			$this->user_id = "";
			$this->admin_id = "";
			$this->created_at = "NOW()";
		}

		public function getUser(){ return UserData::getById($this->user_id);}
		public function getAdmin(){ return UserData::getById($this->admin_id);}

		public function add(){
			$sql = "insert into spend (name,price,user_id,admin_id,created_at) ";
			$sql .= "value (\"$this->name\",\"$this->price\",$this->user_id,$this->admin_id,$this->created_at) ";
			Executor::doit($sql);
		}

		public static function delById($id){
			$sql = "delete from ".self::$tablename." where id=$id";
			Executor::doit($sql);
		}
		public function del(){
			$sql = "delete from ".self::$tablename." where id=$this->id";
			Executor::doit($sql);
		}

	// partiendo de que ya tenemos creado un objecto CategoryData previamente utilizamos el contexto
		public function update(){
			$sql = "update ".self::$tablename." set name=\"$this->name\",price=\"$this->price\",created_at=\"$this->created_at\" where id=$this->id";
			Executor::doit($sql);
		}

		public function update_box(){
			$sql = "update ".self::$tablename." set box_id=$this->box_id where id=$this->id";
			Executor::doit($sql);
		}

		public function del_category(){
			$sql = "update ".self::$tablename." set category_id=NULL where id=$this->id";
			Executor::doit($sql);
		}

		public function update_image(){
			$sql = "update ".self::$tablename." set image=\"$this->image\" where id=$this->id";
			Executor::doit($sql);
		}

		public static function getById($id){
			$sql = "select * from ".self::$tablename." where id=$id";
			$query = Executor::doit($sql);
			return Model::one($query[0],new SpendData());
		}

		public static function getAll(){
			$sql = "select * from ".self::$tablename." order by created_at ";
			$query = Executor::doit($sql);
			return Model::many($query[0],new SpendData());
		}

		public static function getAllUnBoxed(){
			$sql = "select * from ".self::$tablename." where box_id is NULL order by created_at desc";
			$query = Executor::doit($sql);
			return Model::many($query[0],new SpendData());
		}

		public static function getAllByPage($start_from,$limit){
			$sql = "select * from ".self::$tablename." where id>=$start_from limit $limit";
			$query = Executor::doit($sql);
			return Model::many($query[0],new SpendData());
		}

		public static function getAllByUser($id){
			$sql = "select * from ".self::$tablename." where user_id=$id order by created_at desc";
			$query = Executor::doit($sql);
			return Model::many($query[0],new SpendData());
		}

		public static function getAllByAdmin($id){
			$sql = "select * from ".self::$tablename." where admin_id=$id order by created_at desc";
			$query = Executor::doit($sql);
			return Model::many($query[0],new SpendData());
		}

		public static function getAllByCategoryId($category_id){
			$sql = "select * from ".self::$tablename." where category_id=$category_id order by created_at desc";
			$query = Executor::doit($sql);
			return Model::many($query[0],new SpendData());
		}

		public static function getGroupByDateOp($start,$end){
	 		$sql = "select *,sum(price) as t from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\"";
			$query = Executor::doit($sql);
			return Model::many($query[0],new SpendData());
		}

		public static function getGroupByDateOpByAdmin($start,$end,$id){
	 		$sql = "select *,sum(price) as t from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and admin_id=$id";
			$query = Executor::doit($sql);
			return Model::many($query[0],new SpendData());
		}

	}

?>