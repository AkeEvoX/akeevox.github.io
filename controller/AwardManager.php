<?php
include("../lib/database.php");
//include("../../../controller/logger.php");

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

			$sql = "select id,title_".$lang." as title ,thumbnail ,update_date as date,type ";
			$sql .= "from award where active=1 order by update_date desc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Award : ".$e->getMessage();
		}
	}

}

?>
