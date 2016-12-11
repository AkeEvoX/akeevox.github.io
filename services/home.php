<?php
session_start();
include("../lib/common.php");
include("../lib/logger.php");
//$base_dir = "../";
require_once("../controller/HomeManager.php");

$home = new HomeManager();


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
if($item){
	while($row = $item->fetch_object())
	{
		$data = array("cover"=>$row->cover);
		$result[] = $data;
	}
}


log_debug("get covert home > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>
