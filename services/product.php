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

switch($type)
{
	case "list" :
		echo "call list product";
		$result = listproduct($lang,$cate);
	break;
}
//var_dump($result);
log_debug("get contact > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));  //return


//*************** function ***************

function listproduct($lang,$cate)
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



?>