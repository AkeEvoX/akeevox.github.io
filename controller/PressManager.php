<?php
include("../lib/database.php");
//include("../../../controller/logger.php");

class PressManager{
	
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

			$sql = "select id,title_".$lang." as title ,detail_".$lang." as detail,thumbnail,coverpage,update_date ";
			$sql .= "from press where active=1 and id='".$id."' order by create_date desc ";
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
			
			$sql = "select id,title_".$lang." as title ,detail_".$lang." as detail ,thumbnail,coverpage,update_date ";
			$sql .= "from press where active=1 order by create_date desc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Press : ".$e->getMessage();
		}
	}
	
	function getSlideItem($lang){
		try{
			
			$sql = "select id,title_".$lang." as title,thumbnail,update_date ";
			$sql .= "from press where active=1 order by create_date desc limit 5 ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Slide Press : ".$e->getMessage();
		}	
	}
	
	function getHomeItem($lang){
		try{
			
			$sql = "select id,title_".$lang." as title,detail_".$lang." as detail,thumbnail,coverpage,update_date ";
			$sql .= "from press where active=1 order by update_date desc limit 4 ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Home Press : ".$e->getMessage();
		}	
	}
	
	
}

?>