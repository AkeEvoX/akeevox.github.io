<?php
require_once($base_dir."/lib/database.php");

class FaqManager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial Faq manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function getItem($id,$lang){
		
		try{

			$sql = "select id,title_".$lang." as title ,detail_".$lang." as detail ,thumbnail,coverpage,update_date ";
			$sql .= "from faq where active=1 and id='".$id."' order by create_date desc ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Faq : ".$e->getMessage();
		}
		
	}

	function getListItem($lang)
	{
		try{
			
			$sql = "select id,title_".$lang." as title ,detail_".$lang." as detail ,thumbnail,coverpage,update_date ";
			$sql .= "from faq where active=1 order by create_date desc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Faq : ".$e->getMessage();
		}
	}
	
	function getmostview($lang)
	{
		try{
			$sql = "select id,title_".$lang." as title ,detail_".$lang." as detail ,thumbnail,coverpage,update_date ";
			$sql .= "from faq where active=1 order by view desc limit 3 ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List MostView : ".$e->getMessage();
		}
	}
	
	function getrecentview($lang)
	{
		try{
			$sql = "select id,title_".$lang." as title ,detail_".$lang." as detail ,thumbnail,coverpage,update_date ";
			$sql .= "from faq where active=1 order by update_date desc limit 3 ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List RecentView : ".$e->getMessage();
		}
	}
	
	
	
	function get_fetch_list($start_fetch,$max_fetch){
			try{

			$sql = " select * ";
			$sql .= " from faq a ";
			$sql .= " order by id desc " ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("FAQ > get_fetch_list > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  list FAQ  : ".$e->getMessage();
		}
	}
	
	
	function insert_item($items){
		
		try{
			
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$location_th =$items["location_th"];
			$location_en =$items["location_en"];
			$islocal  =$items["islocal"];
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into press (title_th ,title_en  ,location_th ,location_en  ,islocal ,active ,create_by ,create_date ) ";
			$sql .= "values('$title_th'  ,'$title_en'  ,'$location_th' ,'$location_en' ,$islocal  ,$active ,$create_by  ,$create_date ); ";
			$this->mysql->execute($sql);
			//echo $sql;
			
			log_debug("FAQ > insert  > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert FAQ : ".$e->getMessage();
		}
		
	}
	
	function update_item($items){
		try{
			$id = $items["id"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$location_th =$items["location_th"];
			$location_en =$items["location_en"];
			$islocal  =$items["islocal"];
		
		
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';
			//title_th ,title_en  ,location_th ,location_en  ,islocal ,active ,create_by ,create_date
			
			$sql = "update faq set  ";
			$sql .= "title_th='$title_th' ,title_en='$title_en' ,location_th='$location_th' ,location_en='$location_en' ";
			$sql .= ",islocal='$islocal' ,active=$active ,update_by=$update_by ,update_date=$update_date  ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("FAQ > update > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Faq   : ".$e->getMessage();
		}
	}
	
	function delete_item($id){
		
		try{
			$sql = "delete from faq where id=$id ; ";
			log_debug("FAQ > delete > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete FAQ : ".$e->getMessage();
		}
	}
	
	
}

?>