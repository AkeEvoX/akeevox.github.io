<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/ProductManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");

$product = new ProductManager();

//$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}


$type = $_GET["type"];
$cate = 1;

switch($type)
{
	case "product" :
		
	break;
}

log_debug("get contact > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));

function viewproduct($lang,$cate)
{

	$data = $product->getProductList($lang,$cate);

	$result = null;
	while($row = $data->fetch_object()) 
	{
		$result[] = array(
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

	return $result;
}


?>