<?php
class ProductData {
	public static $tablename = "product";

	public function __construct(){
		$this->barcode = "";
		$this->image = "";
		$this->modelo = "";
		$this->sex = "";
		$this->color_id = "";
		$this->brand_id = "";
		$this->size_id = "";
		$this->qty = "";
		$this->stock_min = "";
		$this->price_in = "";
		$this->price_out = "";
		$this->ubication = "";
		$this->admin_id = "";
		$this->created_at = "NOW()";
	}

	public function getColor(){ return ColorData::getById($this->color_id);}
	public function getAdmin(){ return UserData::getById($this->admin_id);}

	public function add(){
		$sql = "insert into product (modelo,sex,color_id,brand_id,size_id,qty,stock_min,price_in,price_out,ubication,admin_id,created_at)";
		$sql .= "value (\"$this->modelo\",\"$this->sex\",\"$this->color_id\",\"$this->brand_id\",\"$this->size_id\",\"$this->qty\",\"$this->stock_min\",\"$this->price_in\",\"$this->price_out\",\"$this->ubication\",\"$this->admin_id\",$this->created_at)";
		Executor::doit($sql);
	}

	public function add_with_image(){
		$sql = "insert into product (image,modelo,sex,color_id,brand_id,size_id,qty,stock_min,price_in,price_out,ubication,admin_id,created_at)";
		$sql .= "value (\"$this->image\",\"$this->modelo\",\"$this->sex\",\"$this->color_id\",\"$this->brand_id\",\"$this->size_id\",\"$this->qty\",\"$this->stock_min\",\"$this->price_in\",\"$this->price_out\",\"$this->ubication\",\"$this->admin_id\",$this->created_at)";
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

// partiendo de que ya tenemos creado un objecto ProductData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set barcode=\"$this->barcode\",modelo=\"$this->modelo\",sex=\"$this->sex\",color_id=\"$this->color_id\",brand_id=\"$this->brand_id\",qty=\"$this->qty\",stock_min=\"$this->stock_min\",price_in=\"$this->price_in\",price_out=\"$this->price_out\",ubication=\"$this->ubication\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_by_barcode(){
		$sql = "update ".self::$tablename." set image=\"$this->image\",modelo=\"$this->modelo\",sex=\"$this->sex\",color_id=\"$this->color_id\",brand_id=\"$this->brand_id\",price_in=\"$this->price_in\",price_out=\"$this->price_out\",ubication=\"$this->ubication\" where barcode=$this->barcode";
		Executor::doit($sql);
	}

	public function update_image(){
		$sql = "update ".self::$tablename." set image=\"$this->image\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_barcode(){
		$sql = "update ".self::$tablename." set barcode=\"$this->barcode\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ProductData
	();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->barcode = $r['barcode'];
			$data->image = $r['image'];
			$data->modelo = $r['modelo'];
			$data->sex = $r['sex'];
			$data->color_id = $r['color_id'];
			$data->brand_id = $r['brand_id'];
			$data->size_id = $r['size_id'];
			$data->qty = $r['qty'];
			$data->stock_min = $r['stock_min'];
			$data->price_in = $r['price_in'];
			$data->price_out = $r['price_out'];
			$data->ubication = $r['ubication'];
			$data->admin_id = $r['admin_id'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getByBarcode($id){
		$sql = "select * from ".self::$tablename." where barcode like '%$id%' or modelo like '%$id%'";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ProductData
	();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->barcode = $r['barcode'];
			$data->image = $r['image'];
			$data->modelo = $r['modelo'];
			$data->sex = $r['sex'];
			$data->color_id = $r['color_id'];
			$data->brand_id = $r['brand_id'];
			$data->size_id = $r['size_id'];
			$data->stock_min = $r['stock_min'];
			$data->price_in = $r['price_in'];
			$data->price_out = $r['price_out'];
			$data->ubication = $r['ubication'];
			$data->admin_id = $r['admin_id'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getByBrandId($id){
		$sql = "select * from ".self::$tablename." where brand_id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ProductData
	();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->barcode = $r['barcode'];
			$data->image = $r['image'];
			$data->modelo = $r['modelo'];
			$data->sex = $r['sex'];
			$data->color_id = $r['color_id'];
			$data->brand_id = $r['brand_id'];
			$data->size_id = $r['size_id'];
			$data->stock_min = $r['stock_min'];
			$data->price_in = $r['price_in'];
			$data->price_out = $r['price_out'];
			$data->ubication = $r['ubication'];
			$data->admin_id = $r['admin_id'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getBySerieId($id){
		$sql = "select * from ".self::$tablename." where size_id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ProductData
	();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->barcode = $r['barcode'];
			$data->image = $r['image'];
			$data->modelo = $r['modelo'];
			$data->sex = $r['sex'];
			$data->color_id = $r['color_id'];
			$data->brand_id = $r['brand_id'];
			$data->size_id = $r['size_id'];
			$data->stock_min = $r['stock_min'];
			$data->price_in = $r['price_in'];
			$data->price_out = $r['price_out'];
			$data->ubication = $r['ubication'];
			$data->admin_id = $r['admin_id'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAllByPrspId($id){
		$sql = "select * from ".self::$tablename." where ruc=$id order by created_at desc"; /*order by created_at desc*/
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->barcode = $r['barcode'];
			$array[$cnt]->modelo = $r['modelo'];
			$array[$cnt]->sex = $r['sex'];
			$array[$cnt]->color_id = $r['color_id'];
			$array[$cnt]->brand_id = $r['brand_id'];
			$array[$cnt]->size_id = $r['size_id'];
			$array[$cnt]->qty = $r['qty'];
			$array[$cnt]->stock_min = $r['stock_min'];
			$array[$cnt]->price_in = $r['price_in'];
			$array[$cnt]->price_out = $r['price_out'];
			$array[$cnt]->ubication = $r['ubication'];
			$array[$cnt]->admin_id = $r['admin_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

public static function getAllByPrdId($id){
		$sql = "select * from ".self::$tablename." where barcode=$id order by size_3 desc"; /*order by size_3 desc*/
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->barcode = $r['barcode'];
			$array[$cnt]->modelo = $r['modelo'];
			$array[$cnt]->sex = $r['sex'];
			$array[$cnt]->color_id = $r['color_id'];
			$array[$cnt]->brand_id = $r['brand_id'];
			$array[$cnt]->size_id = $r['size_id'];
			$array[$cnt]->qty = $r['qty'];
			$array[$cnt]->stock_min = $r['stock_min'];
			$array[$cnt]->price_in = $r['price_in'];
			$array[$cnt]->price_out = $r['price_out'];
			$array[$cnt]->ubication = $r['ubication'];
			$array[$cnt]->admin_id = $r['admin_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by id asc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getAllByAdmin($id){
		$sql = "select * from ".self::$tablename." where admin_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where barcode like '%$q%' or modelo like '%$q%' ";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getLikeByAdmin($q,$id){
		$sql = "select * from ".self::$tablename." where (barcode like '%$q%' and admin_id=$id) or (modelo like '%$q%' and admin_id=$id)";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getAllByListIdAll($id){
		$sql = "select * from ".self::$tablename." where admin_id=$id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->barcode = $r['barcode'];
			$array[$cnt]->modelo = $r['modelo'];
			$array[$cnt]->sex = $r['sex'];
			$array[$cnt]->color_id = $r['color_id'];
			$array[$cnt]->brand_id = $r['brand_id'];
			$array[$cnt]->size_id = $r['size_id'];
			$array[$cnt]->qty = $r['qty'];
			$array[$cnt]->stock_min = $r['stock_min'];
			$array[$cnt]->price_in = $r['price_in'];
			$array[$cnt]->price_out = $r['price_out'];
			$array[$cnt]->ubication = $r['ubication'];
			$array[$cnt]->admin_id = $r['admin_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getRes(){
		$sql = "select * from ".self::$tablename." where admin_id=1 order by size_3 desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getLastByAdmin($id){
		$sql = "select * from ".self::$tablename." where admin_id=$id order by id desc limit 1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

}

?>