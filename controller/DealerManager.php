<?php
include("../lib/database.php");
//include("../../../controller/logger.php");

class DealerManager{

	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial dealer manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function getItem($id,$lang){

		try{

			$sql = "select id,title_".$lang." as title ,province_".$lang." as province ,zone_".$lang." as zone, mobile ";
			$sql .= "from dealer where active=1 order by title_".$lang." asc";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  dealer : ".$e->getMessage();
		}

	}

	function getListItem($lang){
			try{
/*
			$sql = "select id,title_".$lang." as title ,province_".$lang." as province ,zone_".$lang." as zone, mobile ";
			$sql .= "from dealer where active=1 order by title_".$lang." asc";*/
			$sql = "select id,title_".$lang." as title ,province_".$lang." as province ,zone_".$lang." as zone, mobile ";
			$sql .= " from dealer where active=1 ";
			//$sql .= " and title_".$lang." like '%".$name."%' ";
			$sql .= " order by title_".$lang." asc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List dealer : ".$e->getMessage();
		}
	}

		function findName($lang,$name) {
			try{

				$sql = "select id,title_".$lang." as title ,province_".$lang." as province ,zone_".$lang." as zone, mobile ";
				$sql .= " from dealer where active=1 ";
				$sql .= " and title_".$lang." like '%".$name."%' ";
				$sql .= " order by title_".$lang." asc ";
				//log_debug($sql);

				$result = $this->mysql->execute($sql);
				return  $result;
			}
			catch(Exception $e){
				return "Cannot Get find dealer : " .$e->getMessage();
		 }
	}

}

?>
