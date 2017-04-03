<?php
session_start();
require_once("../lib/common.php");
require_once("../lib/logger.php");
include("../controller/PressManager.php");


$press = new PressManager();

//$lang = "th";
if(isset($_SESSION["lang"]) && !empty($_SESSION["lang"])) {
	$lang = $_SESSION["lang"];
}

$req_id = $_GET["id"];
$type=$_GET["type"];
$item = "";

if($type=="slide"){
	$item = $press->getSlideItem($lang);
}
else if($type=="home"){
	$item = $press->getHomeItem($lang);
}
else if(isset($req_id))
{
	$item = $press->getItem($req_id,$lang);
}
else //if(!isset($req_id) && empty($req_id))  //no request id
{
	$item = $press->getListItem($lang);
}


$result = null;

while($row = $item->fetch_object()){
	
	$datetime = $row->update_date == null ? $row->create_date : $row->update_date;
	
	$data = array("id"=>$row->id,"title"=>$row->title,"detail"=>$row->detail,"thumbnail"=>$row->thumbnail,"coverpage"=>$row->coverpage,"date"=>$datetime);
	$result[] = $data;
}

log_debug("get list press > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>
