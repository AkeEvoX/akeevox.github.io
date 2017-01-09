<?php
require_once($base_dir."/lib/database.php");

class HomeManager{

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

	function getCoverTop(){

		try{

			$sql = "select * ";
			$sql .= "from home where active=1 and align=0 order by id ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Top Home : ".$e->getMessage();
		}

	}

	function getCoverBottom(){

		try{

			$sql = "select id,cover ";
			$sql .= "from home where active=1 and align=1 order by create_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Bottom Home : ".$e->getMessage();
		}

	}

	function get_covert_info( ){
		
			try{

			$sql = "select * ";
			$sql .= "from home where  align=0 order by id desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  HomeManager Top Home : ".$e->getMessage();
		}
		
	}
	
	function update_cover_intro($items){
		try{
			
			$cover = "";
			$id = $items["id"];
			if($items["cover"]){
				$cover=" ,cover='".$items["cover"]."' ";	
			}
			
			$update_by='0';
			$update_date='now()';
			
			$sql = "update home set  ";
			$sql .= "update_by=$update_by,update_date=$update_date " ;
			$sql .= $cover ;
			$sql .= "where id=$id; ";
			$this->mysql->execute($sql);
			
			log_debug("Homemanager > update cover intro > " .$sql);

			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot homemanager update cover intro : ".$e->getMessage();
		}
	}
	
	function update_banner($items){
		try{
			
			$cover = "";
			$id = $items["id"];
			$active = $items["active"];
			if($items["cover"]){
				$cover=" ,cover='".$items["cover"]."' ";	
			}
			
			$update_by='0';
			$update_date='now()';
			
			$sql = "update home set  ";
			$sql .= " active=$active ,update_by=$update_by,update_date=$update_date " ;
			$sql .= $cover ;
			$sql .= "where id=$id; ";
			$this->mysql->execute($sql);
			
			log_debug("Home manager > update cover intro > " .$sql);

			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot homemanager update cover intro : ".$e->getMessage();
		}
	}
	
}

?>
