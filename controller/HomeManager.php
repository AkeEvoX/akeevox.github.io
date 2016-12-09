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

	function getConverTop(){

		try{

			$sql = "select cover ";
			$sql .= "from home where active=1 and align=0 order by create_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Top Home : ".$e->getMessage();
		}

	}

	function getCoverBottom(){

		try{

			$sql = "select cover ";
			$sql .= "from home where active=1 and align=1 order by create_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Bottom Home : ".$e->getMessage();
		}

	}

}

?>
