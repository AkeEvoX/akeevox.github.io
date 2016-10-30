<?php
require_once("../lib/database.php");
//require_once("../lib/logger.php");

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

			$sql = "select p.id ,p.typeid ,p.title_".$lang." as title ,p.detail_".$lang." as detail,p.thumb,p.image,p.plan,d.code,d.name ";
			$sql .= " from products p inner join product_detail d on p.id=d.proid where p.id='".$id."' ; ";
			log_warning("product > " . $sql);
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product Item : ".$e->getMessage();
		}

	}

	function getImages($id) {
		try{

			$sql = "select id,proid,thumb,image ";
			$sql .= " from product_images  where active=1 and proid='".$id."' ";
			log_warning("product image > " . $sql);
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product Images : ".$e->getMessage();
		}
	}

	function getProductList($lang,$cate) {
		try{

			$sql = " select p.id,p.title_".$lang." as title ,p.detail_".$lang." as detail,p.thumb,p.image,p.plan,d.code,d.name ";
			$sql .= " from products p inner join product_detail d on p.id=d.proid ";
			$sql .= " where p.typeid='".$cate."' ";
			$sql .= " order by p.create_date desc ";
			log_warning("product list > " . $sql);
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product List : ".$e->getMessage();
		}
	}

	function getProductType($lang,$id) {
		try{
			//get type serial condition top 1 asc
			$sql = " select id,title_".$lang." as title ,detail_".$lang." as detail,thumb,cover ";
			$sql .= " from product_type ";
			$sql .= " where active=1 and id='".$id."' ;";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Series List : ".$e->getMessage();
		}
	}

	function getSeriesDefault($lang) {
		try{
			//get type serial condition top 1 asc
			$sql = " select id,title_".$lang." as title ,detail_".$lang." as detail,thumb,cover ";
			$sql .= " from product_type ";
			$sql .= " where active=1 order by id asc limit 1;";
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Series List : ".$e->getMessage();
		}
	}

	function getProductReleated($lang,$cate) {
		try{

			$sql = "select p.id,p.title_".$lang." as title ,p.detail_".$lang." as detail,p.thumb,p.image,p.plan,d.code,d.name ";
			$sql .= " from products p inner join product_detail d on p.id=d.proid where p.typeid='".$cate."' ";
			$sql .= " order by  p.create_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product List : ".$e->getMessage();
		}
	}

	function getAttributes($lang,$id) {
		try{

			$sql = " select p.id,p.".$lang." as title,a.".$lang." as label from product_attribute p ";
			$sql .= " left join attribute_master a on a.name=p.attribute ";
			$sql .= " where p.proid='".$id."' ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product Attribute : ". $e->getMessage();
		}
	}

	function getMenu($lang)
	{
		try{
			//$sql = "select id,".$lang." as title ,parent ";
			//$sql .= "from product_type where active=1 order by parent ";
			//,(select count(1) from product_type b where b.parent=a.id) as isparent 

			$sql = " select a.id,a.parent,a.title_".$lang." as title,a.link ";
			$sql .= " from product_type a ";
			$sql .= " where a.active=1 ";
			$sql .= " order by a.id; ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Menu Product : ".$e->getMessage();
		}
	}


}

?>
