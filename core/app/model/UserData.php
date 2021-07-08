<?php
	class UserData {
		public static $tablename = "user";

		public function getStock(){ return StockData::getById($this->stock_id); }

		public function __construct(){
			$this->name = "";
			$this->lastname = "";
			$this->username = "";
			$this->email = "";
			$this->password = "";
			$this->image = "";
			$this->status = "";
			$this->kind = "";
			$this->stock_id = "";
			$this->admin_id = "";
			$this->limit_users = "";
			$this->limit_services = "";
			$this->counter = "";
			$this->created_at = "NOW()";
		}
		
		public function getAdmin(){ return UserData::getById($this->admin_id);}

		public function add(){
			$sql = "insert into user (name,lastname,username,email,password,kind,counter,created_at) ";
			$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->username\",\"$this->email\",\"$this->password\",\"$this->kind\",1,$this->created_at)";
			Executor::doit($sql);
		}

		public function add_new(){
			$sql = "insert into user (name,lastname,username,email,password,image,kind,stock_id,admin_id,counter,created_at) ";
			$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->username\",\"$this->email\",\"$this->password\",\"$this->image\",\"$this->kind\",\"$this->stock_id\",\"$this->admin_id\",1,$this->created_at)";
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

	// partiendo de que ya tenemos creado un objecto UserData previamente utilizamos el contexto
		public function update(){
			$sql = "update ".self::$tablename." set name=\"$this->name\",lastname=\"$this->lastname\",username=\"$this->username\",email=\"$this->email\",image=\"$this->image\",status=\"$this->status\" where id=$this->id";
			Executor::doit($sql);
		}

		public function update_profile(){
			$sql = "update ".self::$tablename." set name=\"$this->name\",lastname=\"$this->lastname\",username=\"$this->username\",email=\"$this->email\",image=\"$this->image\" where id=$this->id";
			Executor::doit($sql);
		}

		public function update_kind_stock(){
			$sql = "update ".self::$tablename." set name=\"$this->name\",lastname=\"$this->lastname\",username=\"$this->username\",email=\"$this->email\",image=\"$this->image\",status=\"$this->status\",kind=\"$this->kind\",stock_id=\"$this->stock_id\" where id=$this->id";
			Executor::doit($sql);
		}

		public function update_passwd(){
			$sql = "update ".self::$tablename." set password=\"$this->password\" where id=$this->id";
			Executor::doit($sql);
		}

		public function update_counter(){
			$sql = "update ".self::$tablename." set counter=\"$this->counter\" where id=$this->id";
			Executor::doit($sql);
		}

		public function update_admin_stock(){
			$sql = "update ".self::$tablename." set admin_id=\"$this->admin_id\",stock_id=\"$this->stock_id\" where id=$this->id";
			Executor::doit($sql);
		}

		public static function getById($id){
			$sql = "select * from ".self::$tablename." where id=$id";
			$query = Executor::doit($sql);
			return Model::one($query[0],new UserData());
		}

		public static function getAllbyAdmin($id){
			$sql = "select * from ".self::$tablename." where admin_id=$id order by created_at asc";		
			$query = Executor::doit($sql);
			return Model::many($query[0],new UserData());
		}

		public static function getAll(){
			$sql = "select * from ".self::$tablename;		
			$query = Executor::doit($sql);
			return Model::many($query[0],new UserData());
		}

		public static function getAllAdmins(){
			$sql = "select * from ".self::$tablename." where kind=1 order by created_at desc";		
			$query = Executor::doit($sql);
			return Model::many($query[0],new UserData());
		}

		public static function getLike($q){
			$sql = "select * from ".self::$tablename." where name like '%$q%'";
			$query = Executor::doit($sql);
			return Model::many($query[0],new UserData());
		}

		public static function getLastUser(){
			$sql = "select id from ".self::$tablename." order by id desc limit 1";
			$query = Executor::doit($sql);
			return Model::one($query[0],new UserData());
		}

	}

?>