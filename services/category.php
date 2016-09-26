<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/ProductManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");

echo "initial manager\r\n";
$product = new ProductManager();

$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

echo "get data category\r\n";
$data = $product->getCategoryMenu($lang);


echo "generate data start\r\n";
$result = null;
while($row = $data->fetch_object()) 
{
	echo "parent =".$row->parent."\r\n";
	echo  $result[$row->parent]["id"]."\r\n";
	if($result[$row->parent]["id"]!="")//skip parent menu
	{
		$item = array("id"=>$row->id
		,"title"=>$row->title);
		$result[$row->parent]["child"] .= $item ;//add child menu
		
	}
	else
	{
		$item = array("id"=>$row->id,"title"=>$row->title);
		$result[$row->id] = $item;
	}


}
var_dump($result);
	

echo "generate data completed\r\n";

log_debug("get contact > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>