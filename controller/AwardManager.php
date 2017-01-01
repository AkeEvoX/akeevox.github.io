<?php
require_once($base_dir."/lib/database.php");

class AwardManager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial award manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function getItem($id,$lang){
		
		try{

			$sql = " select id,title_".$lang." as title,detail_".$lang." as detail ,thumbnail ,update_date ";
			$sql .= "from award where active=1 and id='".$id."' order by update_date desc ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Award : ".$e->getMessage();
		}
		
	}

	function getListItem($lang)
	{
			try{
			
			$sql = "select id,thumbnail,update_date,type ";
			$sql .= "from award where active=1 order by update_date desc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Award : ".$e->getMessage();
		}
	}
	
	
	function get_fetch_list($start_fetch,$max_fetch){
			try{

			$sql = " select * ";
			$sql .= " from award a ";
			$sql .= " order by id desc " ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("Award > get_fetch_list > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  List Award  : ".$e->getMessage();
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
			
			$sql = "insert into award (title_th ,title_en  ,location_th ,location_en  ,islocal ,active ,create_by ,create_date ) ";
			$sql .= "values('$title_th'  ,'$title_en'  ,'$location_th' ,'$location_en' ,$islocal  ,$active ,$create_by  ,$create_date ); ";
			$this->mysql->execute($sql);
			//echo $sql;
			
			log_debug("OrgManager > insert_project  > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Award Project : ".$e->getMessage();
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
			
			$sql = "update award set  ";
			$sql .= "title_th='$title_th' ,title_en='$title_en' ,location_th='$location_th' ,location_en='$location_en' ";
			$sql .= ",islocal='$islocal' ,active=$active ,update_by=$update_by ,update_date=$update_date  ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("Award > update > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Organization Project : ".$e->getMessage();
		}
	}
	
	function delete_item($id){
		
		try{
			$sql = "delete from award where id=$id ; ";
			log_debug("Award > delete_project > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Organization Project : ".$e->getMessage();
		}
	}
	
}

?>