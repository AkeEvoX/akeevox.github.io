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
	
	function get_fetch_list($lang,$start_fetch,$max_fetch){
		try{

			$sql = " select p.id ,p.title_th ,p.title_en ,p.thumb ,p.cover_".$lang."  as cover,p.create_date  ";
			$sql .= " from product_type p ";
			$sql .= " where p.parent in ('3') ";
			$sql .= " order by p.id ";
			$sql .= " LIMIT $start_fetch,$max_fetch ;";

			log_debug($sql);
			
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Fetch ShowRoom  : ".$e->getMessage();
		}
	}
	
	
	function insert_item($items){
		try{
			$parent = $items["parent"];
			$title_th = $items["title_th"];
			$title_en = $items["title_en"];
			$link = $items["link"];
			$cover = $items["cover"];
			$active = "1";
			$create_by = "0";
			$create_date = "now()";
			
			$sql = "insert into product_type(parent,title_th,title_en,cover,active,link,create_by,create_date) ";
			$sql .= "values($parent,'$title_th','$title_en','$cover',$active,'$link',$create_by,$create_date); ";
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Insert ShowRoom : ".$e->getMessage();
		}
	}
	
	function update_item($items){
		try{
			$id = $items["id"];
			$parent = $items["parent"];
			$title_th = $items["title_th"];
			$title_en = $items["title_en"];
			$cover = $items["cover"];
			$update_by = "0";
			$update_date = "now()";
			
			$sql = "update product_type set  ";
			$sql .= "parent=$parent ";
			$sql .= ",title_th='$title_th' ";
			$sql .= ",title_en='$title_en' ";
			$sql .= ",cover='$cover' ";
			$sql .= ",update_by=$update_by";
			$sql .= ",update_date='$update_date' ";
			$sql .= "where id=$id ;";
			
			//echo $sql."<br/>";
			log_warning("update_ShowRoom > " . $sql);
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Update ShowRoom : ".$e->getMessage();
		}
	}
	
	function delete_item($id){
		try{
			$sql = "delete product_type where id=$id ;";
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete ShowRoom : ".$e->getMessage();
		}
	}
}

?>