<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/ProductManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");


$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}


$type = $_GET["type"];
$cate = $_GET["cate"];
$id =  $_GET["id"];
switch($type)
{
	case "list" :
		//echo "call list product";
		$result = getlistproduct($lang,$cate);
	break;
	case "item" : 
		
		$result = getproduct($lang,$id);
	break;
	case "attr":
		$result = getattribute($lang,$id);
	break;
}
//var_dump($result);
log_debug("get contact > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));  //return


//*************** function ***************

function getlistproduct($lang,$cate)
{
	$product = new ProductManager();
	$data = $product->getProductList($lang,$cate);

	$items = null;
	while($row = $data->fetch_object()) 
	{
		$items[] = array(
			"id"=>$row->id
			,"title"=>$row->title
			,"detail"=>$row->detail
			,"thumb"=>$row->thumb
			,"image"=>$row->image
			,"plan"=>$row->plan
			,"code"=>$row->code
			,"name"=>$row->name
			);
	}
	return $items;
}

function getproduct($lang,$id)
{
	$product = new ProductManager();
	$data = $product->getProduct($lang,$id);

	$items = null;
	$row = $data->fetch_object();
	$items = array(
			"id"=>$row->id
			,"title"=>$row->title
			,"detail"=>$row->detail
			,"thumb"=>$row->thumb
			,"image"=>getimages($id)
			,"plan"=>$row->plan
			,"code"=>$row->code
			,"name"=>$row->name
			);
	return $items;
}

function getimages($id)
{
	$product = new ProductManager();
	$data = $product->getImages($id);
	while($row= $data->fetch_object())
	{
		$item[] = array(
			"id"=>$row->id
			,"thumb"=>$row->thumb
			,"image"=>$row->image
			);
	}
	return $item;
}

function getattribute($lang,$id)
{

	$product = new ProductManager();
	$data = $product->getAttributes($lang,$id);
	
	while($row = $data->fetch_object())
	{
		$item[] = array(
			"id"=>$row->id
			,"title"=>$row->title
			,"label"=>$row->label
			);
	}

	return $item;


}



?>