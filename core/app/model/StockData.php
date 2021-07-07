<?php
	class StockData {
		public static $tablename = "stock";

		public function __construct(){
			$this->name = "";
			$this->address = "";
			$this->phone = "";
			$this->email = "";
			$this->is_principal = "";
			$this->admin_id = "";
		}

		public function getAdmin(){ return UserData::getById($this->admin_id);}

		public function add(){
			$sql = "insert into stock (name,address,phone,email,admin_id) ";
			$sql .= "value (\"$this->name\",\"$this->address\",\"$this->phone\",\"$this->email\",\"$this->admin_id\")";
			Executor::doit($sql);
		}

		public function add_principal(){
			$sql = "insert into stock (name,address,phone,email,is_principal,admin_id) ";
			$sql .= "value (\"$this->name\",\"$this->address\",\"$this->phone\",\"$this->email\",1,$this->admin_id)";
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

			public static function unset_principal(){
			$sql = "update ".self::$tablename." set is_principal=0";
			Executor::doit($sql);
		}
			public static function set_principal($id){
			$sql = "update ".self::$tablename." set is_principal=1 where id=$id";
			Executor::doit($sql);
		}

	// partiendo de que ya tenemos creado un objecto StockData previamente utilizamos el contexto
		public function update(){
			$sql = "update ".self::$tablename." set name=\"$this->name\",address=\"$this->address\",phone=\"$this->phone\",email=\"$this->email\" where id=$this->id";
			Executor::doit($sql);
		}

		public static function getById($id){
			$sql = "select * from ".self::$tablename." where id=$id";
			$query = Executor::doit($sql);
			return Model::one($query[0],new StockData());
		}

		public static function getPrincipal(){
				
			if(Core::$user->kind==2 || Core::$user->kind==3){
				$sql = "select * from ".self::$tablename." where id=".Core::$user->stock_id;
				$query = Executor::doit($sql);
				return Model::one($query[0],new StockData());

			}else{
				$sql = "select * from ".self::$tablename." where is_principal=1";
				$query = Executor::doit($sql);
				return Model::one($query[0],new StockData());
			}
		}

		public static function getPrincipalByAdmin($id){
	
			if(Core::$user->kind==2 || Core::$user->kind==3){
				$sql = "select * from ".self::$tablename." where id=".Core::$user->stock_id." and admin_id=$id";
				$query = Executor::doit($sql);
				return Model::one($query[0],new StockData());
	
			}else{
				$sql = "select * from ".self::$tablename." where admin_id=$id and is_principal=1";
				$query = Executor::doit($sql);
				return Model::one($query[0],new StockData());
			}
		}

		public static function getAll(){
			$sql = "select * from ".self::$tablename;
			$query = Executor::doit($sql);
			return Model::many($query[0],new StockData());
		}

		public static function getAllByAdmin($id){
			$sql = "select * from ".self::$tablename." where admin_id=$id order by is_principal desc";
			$query = Executor::doit($sql);
			return Model::many($query[0],new StockData());
		}

		public static function getLike($q){
			$sql = "select * from ".self::$tablename." where name like '%$q%'";
			$query = Executor::doit($sql);
			return Model::many($query[0],new StockData());
		}

		public static function getLastStock(){
			$sql = "select id from ".self::$tablename." order by id desc limit 1";
			$query = Executor::doit($sql);
			return Model::one($query[0],new StockData());
		}

	}

?>