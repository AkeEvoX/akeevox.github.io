<?php
require_once("../lib/database.php");
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

	function getContact($lang){
		
		try{
			
			$sql = " select c.id,".$lang." as title,c.icon,c.link,t.name as typename ";
			$sql .= " from contacts c inner join contact_type t on c.type = t.id where c.active=1 ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Contact : ".$e->getMessage();
		} 
		
	}
	
}

?>