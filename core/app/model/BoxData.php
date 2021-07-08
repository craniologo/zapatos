<?php
	class BoxData {
		public static $tablename = "box";

		public function __construct(){
			$this->ref_id = "";
			$this->admin_id = "";
			$this->created_at = "NOW()";
		}

		public function getAdmin(){ return UserData::getById($this->admin_id); }

		public function add(){
			$sql = "insert into box (ref_id,admin_id,created_at) ";
			$sql .= "value (\"$this->ref_id\",$this->admin_id,$this->created_at)";
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

	// partiendo de que ya tenemos creado un objecto BoxData previamente utilizamos el contexto
		public function update(){
			$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
			Executor::doit($sql);
		}

		public static function getById($id){
			$sql = "select * from ".self::$tablename." where id=$id";
			$query = Executor::doit($sql);
			$found = null;
			$data = new BoxData();
			while($r = $query[0]->fetch_array()){
				$data->id = $r['id'];
				$data->ref_id = $r['ref_id'];
				$data->admin_id = $r['admin_id'];
				$data->created_at = $r['created_at'];
				$found = $data;
				break;
			}
			return $found;
		}

		public static function getAll(){
			$sql = "select * from ".self::$tablename;
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new BoxData();
				$array[$cnt]->id = $r['id'];
				$array[$cnt]->ref_id = $r['ref_id'];
				$array[$cnt]->admin_id = $r['admin_id'];
				$array[$cnt]->created_at = $r['created_at'];
				$cnt++;
			}
			return $array;
		}

		public static function getAllByAdmin($id){
			$sql = "select * from ".self::$tablename." where admin_id=$id order by created_at desc";
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new BoxData();
				$array[$cnt]->id = $r['id'];
				$array[$cnt]->ref_id = $r['ref_id'];
				$array[$cnt]->admin_id = $r['admin_id'];
				$array[$cnt]->created_at = $r['created_at'];
				$cnt++;
			}
			return $array;
		}

		public static function getLike($q){
			$sql = "select * from ".self::$tablename." where name like '%$q%'";
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new BoxData();
				$array[$cnt]->id = $r['id'];
				$array[$cnt]->ref_id = $r['ref_id'];
				$array[$cnt]->admin_id = $r['admin_id'];
				$array[$cnt]->created_at = $r['created_at'];
				$cnt++;
			}
			return $array;
		}

		public static function getLastByAdmin($id){
			$sql = "select ref_id from ".self::$tablename." where admin_id=$id order by ref_id desc limit 1";
			$query = Executor::doit($sql);
			return Model::one($query[0],new BoxData());
		}

	}

?>