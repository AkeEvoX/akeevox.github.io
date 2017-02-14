<?php
require_once($base_dir."/lib/database.php");

class SeriesManager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial about manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function get_series_info($id){
		
		try{
			
			$sql = "select * ";
			$sql .= " from product_type where  id=".$id;
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Series Info : ".$e->getMessage();
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
			echo "Cannot Get Series Product Item : ".$e->getMessage();
		}
		
	}
	
	function get_fetch_list($lang,$start_fetch,$max_fetch){
		try{
			//$max_fetch = 10;

			$sql = " select p.id ,p.title_th ,p.title_en ,p.thumb ,p.cover_".$lang."  as cover,p.create_date,p.active  ";
			$sql .= " from product_type p ";
			$sql .= " where p.parent in ('2') ";
			$sql .= " order by p.id ";
			$sql .= " LIMIT $start_fetch,$max_fetch ;";

			log_debug("list series > " .$sql);
			
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Fetch Series  : ".$e->getMessage();
		}
	}
	
	function get_list_product($series_id){
		try{
		
			$sql = " select s.*,p.title_en as product_th,p.title_th as product_en,p.thumb ,pd.code";
			$sql .= " from series s inner join products p ";
			$sql .= " on s.pro_id = p.id ";
			$sql .= " inner join product_detail pd ";
			$sql .= " on s.pro_id = pd.proid ";
			$sql .= " where series_id=$series_id ";
			$sql .= " order by product_th ";

			log_debug("list product of series > " .$sql);
			
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product of Series  : ".$e->getMessage();
		}
	}
	
	
	function insert_item($items){
		try{
			
			$parent = 2;
			$title_th = $items["title_th"];
			$title_en = $items["title_en"];
			$detail_th = $items["detail_th"];
			$detail_en = $items["detail_en"];
			$link = "series.html?id=";
			$cover_th = $items["cover_th"];
			$cover_en = $items["cover_en"];
			
			$active='0';
			if(isset($items["active"]))	$active='1';
			
			$create_by = "0";
			$create_date = "now()";
			
			$sql = "insert into product_type(parent,title_th,title_en,detail_th,detail_en,cover_th,cover_en,active,link,create_by,create_date) ";
			$sql .= "values($parent,'$title_th','$title_en','$detail_th','$detail_en','$cover_th','$cover_en',$active,'$link',$create_by,$create_date); ";
			
			log_debug("insert series > " .$sql);
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Series Type: ".$e->getMessage();
		}
	}
	
	function insert_product($items){
		try{
			
			$series_id = $items["id"];
			$title_th = $items["title_th"];
			$title_en = $items["title_en"];
			$pro_id = $items["pro_id"];
			$active='1';
			
			$create_by = "0";
			$create_date = "now()";
			
			$sql = "insert into series(series_id,pro_id,title_th,title_en,active,create_by,create_date) ";
			$sql .= "values($series_id,$pro_id,'$title_th','$title_en',$active,$create_by,$create_date); ";
			
			log_debug("insert product series > " .$sql);
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Product Series : ".$e->getMessage();
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
			log_debug("update series > " . $sql);
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Update Series : ".$e->getMessage();
		}
	}
	
	function delete_item($id){
		try{
			$sql = "delete from product_type where id=$id ;";
			log_debug("delete series > " . $sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Series : ".$e->getMessage();
		}
	}
	
	function delete_product($id){
		try{
			$sql = "delete from series where id=$id ;";
			log_debug("delete product series > " . $sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Product Series : ".$e->getMessage();
		}
	}
	
	
}

?>