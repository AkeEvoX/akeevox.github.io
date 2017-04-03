<?php
require_once($base_dir."/lib/database.php");

class ShowRoomManager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial show room manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function get_showroom_info($id){
		
		try{
			
			$sql = "select * ";
			$sql .= " from product_type where  id=".$id;
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Showroom Info : ".$e->getMessage();
		}
	}

	function getProduct($lang,$id){
		
		try{
			
			$sql = "select p.id,p.title_".$lang." as title ,p.detail_".$lang." as detail,p.thumb,p.image,p.plan,d.code,d.name ";
			$sql .= " from products p inner join product_detail d on p.id=d.proid where  p.id=".$id;
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get ShowRoom Product Item : ".$e->getMessage();
		}
		
	}
	
	function get_fetch_list($start_fetch,$max_fetch){
		try{

			$sql = " select p.id ,p.title_th ,p.title_en ,p.thumb ,p.cover_th,p.cover_en,p.create_date,p.active  ";
			$sql .= " from product_type p ";
			$sql .= " where p.parent in ('3') ";
			$sql .= " order by p.id ";
			$sql .= " LIMIT $start_fetch,$max_fetch ;";

			log_debug("list showroom > " . $sql);
			
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Fetch ShowRoom  : ".$e->getMessage();
		}
	}
	
	function get_list_product($room_id){
		try{
		
			$sql = " select s.*,p.title_en as product_th,p.title_th as product_en,p.thumb,pd.code ";
			$sql .= " from showroom s inner join products p ";
			$sql .= " on s.pro_id = p.id ";
			$sql .= " inner join product_detail pd ";
			$sql .= " on s.pro_id = pd.proid ";
			$sql .= " where room_id=$room_id ";
			$sql .= " order by product_th ";

			log_debug("list product of showroom > " .$sql);
			
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product of showroom  : ".$e->getMessage();
		}
	}
	
	function insert_item($items){
		try{
			$parent = 3;
			$title_th = $items["title_th"];
			$title_en = $items["title_en"];
			$detail_th = $items["detail_th"];
			$detail_en = $items["detail_en"];
			$link = "showroom.html?id=";
			$cover_th = $items["cover_th"];
			$cover_en = $items["cover_en"];
			
			$active='0';
			if(isset($items["active"]))	$active='1';
			$create_by = "0";
			$create_date = "now()";
			
			$sql = "insert into product_type(parent,title_th,title_en,detail_th,detail_en,cover_th,cover_en,active,link,create_by,create_date) ";
			$sql .= "values($parent,'$title_th','$title_en','$detail_th','$detail_en','$cover_th','$cover_en',$active,'$link',$create_by,$create_date); ";
			
			log_debug("insert showroom > " .$sql);
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Insert ShowRoom Type : ".$e->getMessage();
		}
	}
	
	function insert_product($items){
		try{
			
			$room_id = $items["id"];
			$title_th = $items["title_th"];
			$title_en = $items["title_en"];
			$pro_id = $items["pro_id"];
			$active='1';
			
			$create_by = "0";
			$create_date = "now()";
			
			$sql = "insert into showroom(room_id,pro_id,title_th,title_en,active,create_by,create_date) ";
			$sql .= "values($room_id,$pro_id,'$title_th','$title_en',$active,$create_by,$create_date); ";
			
			log_debug("insert product showroom > " .$sql);
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Product Showroom : ".$e->getMessage();
		}
	}
	
	function update_item($items){
		try{
		
			$id = $items["id"];
			$title_th = $items["title_th"];
			$title_en = $items["title_en"];
			$detail_th = $items["detail_th"];
			$detail_en = $items["detail_en"];
			$cover_th = $items["cover_th"] == "" ? "" : ",cover_th='".$items["cover_th"]. "' ";
			$cover_en = $items["cover_en"] == "" ? "" : ",cover_en='".$items["cover_en"]. "' ";
			
			$active='0';
			if(isset($items["active"]))	$active='1';
			$update_by = "0";
			$update_date = "now()";
			
			$sql = "update product_type set  ";
			$sql .= "title_th='$title_th' ";
			$sql .= ",title_en='$title_en' ";
			$sql .= ",detail_th='$detail_th' ";
			$sql .= ",detail_en='$detail_en' ";
			$sql .= $cover_th;
			$sql .= $cover_en;
			$sql .= ",active=$active";
			$sql .= ",update_by=$update_by";
			$sql .= ",update_date='$update_date' ";
			$sql .= "where id=$id ;";
			
			//echo $sql."<br/>";
			log_warning("update ShowRoom > " . $sql);
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Update ShowRoom : ".$e->getMessage();
		}
	}
	
	function delete_item($id){
		try{
			$sql = "delete from product_type where id=$id ;";
			log_debug("delete showroom > " . $sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete ShowRoom : ".$e->getMessage();
		}
	}
	
	
	function delete_product($id){
		try{
			$sql = "delete from showroom where id=$id ;";
			log_debug("delete product showroom > " . $sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Product Showroom : ".$e->getMessage();
		}
	}
}

?>