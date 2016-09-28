<?php
require_once("../lib/database.php");
//include("../../../controller/logger.php");

class ProductManager{
	
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

			$sql = "select id,title_".$lang." as title,detail_".$lang." as detail,thumb,image,plan,typeid,update_date ";
			$sql .= "from about where active=1 order by create_date desc ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  About : ".$e->getMessage();
		}
		
	}
	
	function getProductList($cate,)
	{
		
	}

	function getCategoryMenu($lang)
	{
		try{

			$sql = "select id,".$lang." as title ,parent,seq ";
			$sql .= "from product_type where active=1 order by parent ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  About : ".$e->getMessage();
		}

	}
	
}

?>