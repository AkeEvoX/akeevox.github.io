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
$id =  $_GET["id"];//meaning is product
switch($type)
{
	case "list" :
		//echo "call list product";
		$result = setProductList($lang,$cate);
	break;
	case "related":
	
		//call category
		//echo "pro = ".$id;
		$prod = setProduct($lang,$id);
		$cate = $prod["type"];
		$result = setProductRelated($lang,$cate);
		
		
	break;
	case "item" : 
		$result = setProduct($lang,$id);
	break;
	case "attr":
		$result = setAttribute($lang,$id);
	break;
	case "category":
		$result = setCategory($lang,$id);
	break;
	case "series":
		$result = setSeriesInfo($lang,$id);
	break;
	case "showroom":
		$result = setShowRoom($lang);
	break;
	case "":
	
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
	catch(Exception $e)
	{
		echo "Cannot Get Product List : ".$e->getMessage();
	}
}

//fix series top
function setSeriesInfo($lang,$id)
{
	try
	{

		$product = new ProductManager();
		
		//set id default if is null
		if(empty($id))
		{
			$data=$product->getSeriesDefault($lang);
			$row = $data->fetch_object();
			$id = $row->id;
		}
		//call infor by type series
		$data = $product->getProductType($lang,$id);

			$items = array(
				"id"=>$row->id
				,"title"=>$row->title
				,"detail"=>$row->detail
				,"thumb"=>$row->thumb
				,"cover"=>$row->cover
				);
		return $items;
	}
	catch(Exception $e)
	{
		echo "Cannot Get ProductType : ".$e->getMessage();
	}
	
}

function setProductRelated($lang,$cate)
{
	//echo "cate = ".$cate;
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
			,"type"=>$row->typeid
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