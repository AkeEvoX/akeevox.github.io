<?php
include("../lib/database.php");
//include("../../../controller/logger.php");

class GalleryManager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial press manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function getItem($id,$lang){
		
		try{

			$sql = "select id,title_".$lang." as title ,thumbnail,update_date ";
			$sql .= "from gallery where active=1 and id='".$id."' order by create_date desc ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Press : ".$e->getMessage();
		}
		
	}

	function getListItem($lang)
	{
			try{
			
			$sql = "select id,title_".$lang." as title ,thumbnail,update_date ";
			$sql .= "from gallery where active=1 order by create_date desc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Press : ".$e->getMessage();
		}
	}
	
}

?>