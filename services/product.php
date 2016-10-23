<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/ProductManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");


if(isset($_SESSION["lang"]) && !empty($_SESSION["lang"])) {
	$lang = $_SESSION["lang"];
}else {
	$lang = 'th';
	$_SESSION["lang"] = $lang;
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
		$result = setShowRoom($lang,$id);
	break;
	case "menu":
		$result = setMenu($lang);
	break;
}
//var_dump($result);
log_debug("get product > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));  //return

//*************** function ***************

function setProductList($lang,$cate) {
	try
	{
		$product = new ProductManager();
		$data = $product->getProductList($lang,$cate);

		$items = null;
		if($data){
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
		}
		return $items;
	}
	catch(Exception $e)
	{
		echo "Cannot Get Product List : ".$e->getMessage();
	}
}

//fix series top
function setSeriesInfo($lang,$id) {
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
		$row = $data->fetch_object();
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
function setShowRoom($lang,$id) {
	try
	{

		$product = new ProductManager();

		//set id default if is null
/*
		if(empty($id))
		{
			$data=$product->getSeriesDefault($lang);
			$row = $data->fetch_object();
			$id = $row->id;
		}*/
		//call infor by type series
		$data = $product->getProductType($lang,$id);
		$row = $data->fetch_object();
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
		echo "Cannot Get Showroom  : ".$e->getMessage();
	}

}

function setProductRelated($lang,$cate) {
	//echo "cate = ".$cate;
	$product = new ProductManager();
	$data = $product->getProductReleated($lang,$cate);

	$items = null;
	if($data){
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
	}
	return $items;
}

function setProduct($lang,$id) {
	$product = new ProductManager();
	$data = $product->getProduct($lang,$id);

	$items = null;
	if($data){
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
	}
	return $items;
}

function setImages($id) {
	$product = new ProductManager();
	$data = $product->getImages($id);
	if($data){
		while($row= $data->fetch_object())
		{
			$item[] = array(
				"id"=>$row->id
				,"thumb"=>$row->thumb
				,"image"=>$row->image
				);
		}
	}
	return $item;
}

function setAttribute($lang,$id) {

	$product = new ProductManager();
	$data = $product->getAttributes($lang,$id);
	if($data){
		while($row = $data->fetch_object())
		{
			$item[] = array(
				"id"=>$row->id
				,"title"=>$row->title
				,"label"=>$row->label
				);
		}
	}
	return $item;
}

function setMenu($lang){
	$product = new ProductManager();
	$data = $product->getMenu($lang);

	if($data){

		//step 1 ) fillter all parent
		while($row =  $data->fetch_object()){

			$id = $row->id;
			$parent = $row->parent;
			$isparent = $row->isparent;
			$menu =  array("id"=>$row->id
			,"parent"=>$row->parent
			,"title"=>$row->title
		  ,"link"=>$row->link);

			if($isparent>0) // set main parent
			{
					$item[$id] = $menu;
			}
			else { //set child of parent
					$item[$parent]["child"][] = $menu;
			}
		}

		//step 2 ) move sub parent to main parent
		foreach($item as $key=>$val){
			$subparent = $val["parent"];
			if($subparent != 0){
					$item[$subparent]["child"][] = $val;
					unset($item[$val["id"]]);
			}
		}
		//print_r($item);
	}
	return $item;
}

//move array with key
function movearray($arrs,$from,$to){
	$out = array_splice($arrs,$from,1);
	array_splice($arrs,$to,0,$out);
	return $arrs;
}

?>
