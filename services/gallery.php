<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/GalleryManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");


$gallery = new GalleryManager();

//$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

$req_id = $_GET["id"];
$item = "";

if(!isset($req_id) && empty($req_id))  //no request id
{
	$item = $gallery->getListItem($lang);
}
else
{
	$item = $gallery->getItem($req_id,$lang);
}

$result = null;

while($row = $item->fetch_object()){

	$data = array("id"=>$row->id,"title"=>$row->title,"thumbnail"=>$row->thumbnail,"date"=>$row->update_date);
	$result[] = $data;
}

log_debug("get list gallery > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>