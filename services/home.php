<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require_once("../controller/HomeManager.php");
require_once("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");


$home = new HomeManager();

//$lang = "th";
/*
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}
*/
//$req_id = $_GET["id"];

$type = $_GET["type"];
$item = "";
switch($type)
{
	case "top":
		$item = $home->getConverTop();
	break;
	case "bottom":
		$item = $home->getCoverBottom();
	break;
}

$result = null;
//$row = $item->fetch_object();

while($row = $item->fetch_object())
{
	$data = array("cover"=>$row->cover);
	$result[] = $data;
}



log_debug("get covert home > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>
