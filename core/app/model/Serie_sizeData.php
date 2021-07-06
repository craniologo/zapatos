<?php
	class Serie_sizeData {
		public static $tablename = "serie_size";
		
		public function __construct(){		
			$this->serie_id = "";
			$this->size = "";
			$this->admin_id = "";
		}

		public function add(){
			$sql = "insert into serie_size (serie_id,size,admin_id)";
			$sql .= "value (\"$this->serie_id\",\"$this->size\",\"$this->admin_id\")";
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

	// partiendo de que ya tenemos creado un objecto Serie_sizeData previamente utilizamos el contexto
		public function update(){
			$sql = "update ".self::$tablename." set serie_id=\"$this->serie_id\",size=\"$this->size\"";
			Executor::doit($sql);
		}

		public static function getById($id){
			$sql = "select * from ".self::$tablename." where id=$id";
			$query = Executor::doit($sql);
			$found = null;
			$data = new Serie_sizeData
		();
			while($r = $query[0]->fetch_array()){
				$data->id = $r['id'];
				$data->serie_id = $r['serie_id'];
				$data->size = $r['size'];
				$data->admin_id = $r['admin_id'];
				$found = $data;
				break;
			}
			return $found;
		}

		public static function getAllByPrspId($id){
			$sql = "select * from ".self::$tablename." where ruc=$id order by size_3 desc"; /*order by size_3 desc*/
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new Serie_sizeData();
				$array[$cnt]->id = $r['id'];
				$array[$cnt]->serie_id = $r['serie_id'];
				$array[$cnt]->size = $r['size'];
				$array[$cnt]->admin_id = $r['admin_id'];
				$cnt++;
			}
			return $array;
		}

		public static function getAllSizeId($id){
			$sql = "SELECT serie_id, COUNT(*) AS total FROM serie_size WHERE serie_id=$id"; /*order by size_3 desc*/
			$query = Executor::doit($sql);
			return Model::many($query[0],new Serie_sizeData());
		}

		public static function getAllSerie(){
			$sql = "SELECT serie_id, COUNT(*) AS total FROM serie_size GROUP BY serie_id ASC";
			$query = Executor::doit($sql);
			return Model::many($query[0],new Serie_sizeData());
		}

		public static function getAllSerieAndAdmin($id,$ad){
			$sql = "select * from ".self::$tablename." where serie_id=$id and admin_id=$ad order by serie_id"; /*order by size_3 desc*/
			$query = Executor::doit($sql);
			return Model::many($query[0],new Serie_sizeData());
		}

	public static function getAllByPrdId($id){
			$sql = "select * from ".self::$tablename." where name=$id order by size_3 desc"; /*order by size_3 desc*/
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new Serie_sizeData();
				$array[$cnt]->id = $r['id'];
				$array[$cnt]->name = $r['name'];
				$array[$cnt]->size_1 = $r['size_1'];
				$array[$cnt]->value_1 = $r['value_1'];
				$array[$cnt]->size_2 = $r['size_2'];
				$array[$cnt]->value_2 = $r['value_2'];
				$array[$cnt]->size_3 = $r['size_3'];
				$array[$cnt]->value_3 = $r['value_3'];
				$array[$cnt]->size_4 = $r['size_4'];
				$array[$cnt]->value_4 = $r['value_4'];
				$array[$cnt]->size_5 = $r['size_5'];
				$array[$cnt]->value_5 = $r['value_5'];
				$array[$cnt]->size_6 = $r['size_6'];
				$array[$cnt]->value_6 = $r['value_6'];
				$array[$cnt]->size_7 = $r['size_7'];
				$array[$cnt]->value_7 = $r['value_7'];
				$cnt++;
			}
			return $array;
		}

		public static function getByLast(){
			$sql = "select * from ".self::$tablename." order by id desc limit 1";
			$query = Executor::doit($sql);
			return Model::many($query[0],new Serie_sizeData());
		}

		public static function getAll(){
			$sql = "select * from ".self::$tablename." order by id asc";
			$query = Executor::doit($sql);
			return Model::many($query[0],new Serie_sizeData());
		}

		public static function getLike($q){
			$sql = "select * from ".self::$tablename." where name like '%$q%' or model like '%$q%' or size_2 like '%$q%'";
			$query = Executor::doit($sql);
			return Model::many($query[0],new Serie_sizeData());
		}

		public static function getAllByListIdAll($id){
			$sql = "select * from ".self::$tablename." where user_id=$id";
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new Serie_sizeData();
				$array[$cnt]->id = $r['id'];
				$array[$cnt]->name = $r['name'];
				$array[$cnt]->size_1 = $r['size_1'];
				$array[$cnt]->value_1 = $r['value_1'];
				$array[$cnt]->size_2 = $r['size_2'];
				$array[$cnt]->value_2 = $r['value_2'];
				$array[$cnt]->size_3 = $r['size_3'];
				$array[$cnt]->value_3 = $r['value_3'];
				$array[$cnt]->size_4 = $r['size_4'];
				$array[$cnt]->value_4 = $r['value_4'];
				$array[$cnt]->size_5 = $r['size_5'];
				$array[$cnt]->value_5 = $r['value_5'];
				$array[$cnt]->size_6 = $r['size_6'];
				$array[$cnt]->value_6 = $r['value_6'];
				$array[$cnt]->size_7 = $r['size_7'];
				$array[$cnt]->value_7 = $r['value_7'];
				$cnt++;
			}
			return $array;
		}

		public static function getRes(){
			$sql = "select * from ".self::$tablename." where user_id=1 order by size_3 desc";
			$query = Executor::doit($sql);
			return Model::many($query[0],new Serie_sizeData());
		}

	}

?>