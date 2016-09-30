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

	function getProduct($lang,$id){
		
		try{

			$sql = "select p.id,p.title_".$lang." as title ,p.detail_".$lang." as detail,p.thumb,p.image,p.plan,d.code,d.name ";
			$sql .= " from products p inner join product_detail d on p.id=d.proid where p.id=".$id;
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product Item : ".$e->getMessage();
		}
		
	}

	function getImages($id)
	{
		try{

			$sql = "select id,proid,thumb,image ";
			$sql .= " from product_images  where active=1 and proid=".$id;
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product Images : ".$e->getMessage();
		}
	}
	
	function getProductList($lang,$cate)
	{
		try{

			$sql = "select p.id,p.title_".$lang." as title ,p.detail_".$lang." as detail,p.thumb,p.image,p.plan,d.code,d.name ";
			$sql .= " from products p inner join product_detail d on p.id=d.proid ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product List : ".$e->getMessage();
		}
	}

	function getAttributes($lang,$id)
	{
		try{
 
			$sql = " select p.id,p.".$lang." as title,a.".$lang." as label from product_attribute p";
			$sql .= " left join attribute_master a on a.name=p.attribute ";
			$sql .= " where p.proid=".$id;
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product Attribute : ".$e->getMessage();
		}
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