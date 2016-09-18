<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/PressManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");


$press = new PressManager();

$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

$req_id = $_GET["id"];
$item = "";

if(!isset($req_id) && empty($req_id))  //no request id
{
	$item = $press->getListItem($lang);
}
else
{
	$item = $press->getItem($req_id,$lang);
}

$result = null;

while($row = $item->fetch_object()){

	$data = array("id"=>$row->id,"title"=>$row->title,"detail"=>$row->detail,"thumbnail"=>$row->thumbnail,"coverpage"=>$row->coverpage,"date"=>$row->update_date);
	$result[] = $data;
}

log_debug("get list press > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>