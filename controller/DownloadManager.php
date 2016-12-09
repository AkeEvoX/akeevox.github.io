<?php
require_once($base_dir."/lib/database.php");

class DownloadManager{
	
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

	function getType($lang,$id){
		
		try{

			$sql = " select id,".$lang." as name from download_type where active=1  ";

			if(isset($id) && !empty($id)) {
				$sql  .= " and id=".$id;
			}
			
			$sql .= " order by seq";
		
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Type Download : ".$e->getMessage();
		} 
		
	}

	function getListItem($id,$lenght,$lang)
	{
			try{
			
			$sql = " select id,title_".$lang." as title,thumbnail,link from downloads where active=1  and type = ".$id . " order by create_date";

			if(isset($lenght) && !empty($lenght)){
				$sql .= " limit ". $lenght;
			}

			
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Download : ".$e->getMessage();
		} 
	}
	
}

?>