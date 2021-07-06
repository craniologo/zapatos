<?php
class ColorData {
	public static $tablename = "color";
	
	public function __construct(){
		$this->name = "";
		$this->admin_id = "";
	}

	public function getAdmin(){ return UserData::getById($this->admin_id);}

	public function add(){
		$sql = "insert into color (name,admin_id)";
		$sql .= "value (\"$this->name\",$this->admin_id)";
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

// partiendo de que ya tenemos creado un objecto ColorData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ColorData
	();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->name = $r['name'];
			$data->admin_id = $r['admin_id'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAllByPrspId($id){
		$sql = "select * from ".self::$tablename." where id=$id order by id desc"; /*order by created_at desc*/
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ColorData
		();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->admin_id = $r['admin_id'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByPrdId($id){
		$sql = "select * from ".self::$tablename." where name=$id order by id desc"; /*order by created_at desc*/
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ColorData
		();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->admin_id = $r['admin_id'];
			$cnt++;
		}
		return $array;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by name asc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ColorData
		());
	}

	public static function getAllByAdmin($id){
		$sql = "select * from ".self::$tablename." where admin_id=$id order by name asc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ColorData
		());
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ColorData
		());
	}

	public static function getAllByRiskId($id){
		$sql = "select * from ".self::$tablename." where name=$id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ColorData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->admin_id = $r['admin_id'];
			$cnt++;
		}
		return $array;
	}

	public static function getRes(){
		$sql = "select * from ".self::$tablename." where user_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ColorData());
	}

}

?>