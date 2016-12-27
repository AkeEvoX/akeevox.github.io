<?php
session_start();
require_once("../lib/common.php");
require_once("../lib/logger.php");
include("../controller/VideoManager.php");


$video = new VideoManager();

//$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

$req_id = $_GET["id"];
$item = "";

if(!isset($req_id) && empty($req_id))  //no request id
{
	$item = $video->getListItem($lang);
}
else
{
	$item = $video->getItem($req_id,$lang);
}

$result = null;

while($row = $item->fetch_object()){

	$data = array("id"=>$row->id
	,"title"=>$row->title
	,"thumbnail"=>$row->thumbnail
	,"link"=>$row->link
	,"date"=>$row->update_date);
	
	$result[] = $data;
}

log_debug("get list video > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>