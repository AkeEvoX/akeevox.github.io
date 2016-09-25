<?php
require_once("../lib/database.php");
//include("../../../controller/logger.php");

class AboutManager{
	
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

	function getItem($lang){
		
		try{

			$sql = "select id,".$lang."_title as title,".$lang."_detail as detail ,type,link,update_date ";
			$sql .= "from about where active=1 order by create_date desc ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  About : ".$e->getMessage();
		}
		
	}
	
}

?>