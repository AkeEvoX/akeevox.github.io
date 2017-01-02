<?php
require_once($base_dir."/lib/database.php");

class VideoManager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial Video manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function getItem($id,$lang){
		
		try{

			$sql = "select id,title_".$lang." as title ,thumbnail,link,update_date ";
			$sql .= "from video where active=1 and id='".$id."' order by create_date desc ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Video : ".$e->getMessage();
		}
		
	}

	function getListItem($lang)
	{
			try{
			
			$sql = "select id,title_".$lang." as title ,thumbnail,link,update_date ";
			$sql .= "from video where active=1 and title_".$lang." is not null order by create_date desc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Video : ".$e->getMessage();
		}
	}
	
	
	function get_fetch_list($start_fetch,$max_fetch){
			try{

			$sql = " select * ";
			$sql .= " from video a ";
			$sql .= " order by id desc " ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("video > get_fetch_list > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  list video  : ".$e->getMessage();
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
			
			$sql = "insert into video (title_th ,title_en  ,location_th ,location_en  ,islocal ,active ,create_by ,create_date ) ";
			$sql .= "values('$title_th'  ,'$title_en'  ,'$location_th' ,'$location_en' ,$islocal  ,$active ,$create_by  ,$create_date ); ";
			$this->mysql->execute($sql);
			//echo $sql;
			
			log_debug("video > insert  > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert video : ".$e->getMessage();
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
			
			$sql = "update video set  ";
			$sql .= "title_th='$title_th' ,title_en='$title_en' ,location_th='$location_th' ,location_en='$location_en' ";
			$sql .= ",islocal='$islocal' ,active=$active ,update_by=$update_by ,update_date=$update_date  ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("video > update > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update video   : ".$e->getMessage();
		}
	}
	
	function delete_item($id){
		
		try{
			$sql = "delete from video where id=$id ; ";
			log_debug("video > delete > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete video : ".$e->getMessage();
		}
	}
	
	
	
}

?>