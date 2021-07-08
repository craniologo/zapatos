<?php
	class SettingData {
		public static $tablename = "setting";

		public function __construct(){
			$this->image = "";
			$this->company = "";
			$this->ruc = "";
			$this->address = "";
			$this->phone = "";
			$this->tax = "";
			$this->coin = "";
			$this->note = "";
			$this->admin_id = "";
		}

		public function getAdmin(){ return UserData::getById($this->admin_id);}

		public function add(){
			$sql = "insert into ".self::$tablename." (company,ruc,address,phone,tax,coin,note,admin_id) ";
			$sql .= "value (\"$this->company\",\"$this->ruc\",\"$this->address\",\"$this->phone\",\"$this->tax\",\"$this->coin\",\"$this->note\",$this->admin_id)";
			Executor::doit($sql);
		}

		public function add_with_image(){
			$sql = "insert into ".self::$tablename." (image,company,ruc,address,phone,note,admin_id) ";
			$sql .= "value (\"$this->image\",\"$this->company\",\"$this->ruc\",\"$this->address\",\"$this->phone\",\"$this->tax\",\"$this->note\",$this->admin_id)";
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

	// partiendo de que ya tenemos creado un objecto SettingData previamente utilizamos el contexto
		public function update(){
			$sql = "update ".self::$tablename." set company=\"$this->company\",ruc=\"$this->ruc\",address=\"$this->address\",phone=\"$this->phone\",tax=\"$this->tax\",coin=\"$this->coin\",note=\"$this->note\" where id=$this->id";
			Executor::doit($sql);
		}

		public function update_image(){
			$sql = "update ".self::$tablename." set image=\"$this->image\" where id=$this->id";
			Executor::doit($sql);
		}

		public static function updateValFromName($name,$val){
			$sql = "update ".self::$tablename." set val=\"$val\" where short=\"$name\"";
			Executor::doit($sql);
		}

		public static function getById($id){
			$sql = "select * from ".self::$tablename." where id=$id";
			$query = Executor::doit($sql);
			return Model::one($query[0],new SettingData());
		}

		public static function getByAdmin($id){
			$sql = "select * from ".self::$tablename." where admin_id=$id";
			$query = Executor::doit($sql);
			return Model::one($query[0],new SettingData());
		}

		public static function getByPreffix($id){
			$sql = "select * from ".self::$tablename." where short=\"$id\"";
			$query = Executor::doit($sql);
			return Model::one($query[0],new SettingData());
		}

		public static function getAll(){
			$sql = "select * from ".self::$tablename;
			$query = Executor::doit($sql);
			return Model::many($query[0],new SettingData());
		}

		public static function getAllByAdmin($id){
			$sql = "select * from ".self::$tablename." where admin_id=$id";
			$query = Executor::doit($sql);
			return Model::many($query[0],new SettingData());
		}
	}

?>