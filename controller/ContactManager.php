<?php
include("../lib/database.php");
//include("../../../controller/logger.php");

class ContactManager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
//			echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial registermanager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function getContact(){
		
		try{
			
			$sql = " select * from contacts ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Contact : ".$e->getMessage();
		} 
		
	}
	
}

?>