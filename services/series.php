<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/SeriesManager.php");
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
		$result = setProductList($lang,$cate);
	break;
	case "related":
		$result = setProductRelated($lang,$cate);
	break;
	case "item" : 
		$result = setProduct($lang,$id);
	break;
	case "attr":
		$result = setAttribute($lang,$id);
	break;
}
//var_dump($result);
log_debug("get product > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));  //return


//*************** function ***************

function setProductList($lang,$cate)
{
	try
	{
		$series = new SeriesManager();
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
	catch(Exception $e)
	{
		echo "Cannot Get Product List : ".$e->getMessage();
	}
}

function setProductRelated($lang,$cate)
{
	$product = new ProductManager();
	$data = $product->getProductReleated($lang,$cate);

	$items = null;
	while($row = $data->fetch_object()) 
	{
		$attrs = setAttribute($lang,$row->id);
		$items[] = array(
			"id"=>$row->id
			,"title"=>$row->title
			,"detail"=>$row->detail
			,"thumb"=>$row->thumb
			,"image"=>$row->image
			,"plan"=>$row->plan
			,"code"=>$row->code
			,"name"=>$row->name
			,"attributes"=>$attrs
			);
	}
	return $items;
}

function setProduct($lang,$id)
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
			,"image"=>setImages($id)
			,"plan"=>$row->plan
			,"code"=>$row->code
			,"name"=>$row->name
			);
	return $items;
}

function setImages($id)
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

function setAttribute($lang,$id)
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