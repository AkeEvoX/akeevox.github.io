<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/DownloadManager.php");
include("../lib/common.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");


$req_id = $_GET["id"];

$download = new DownloadManager();
//$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

$type = $download->getType($lang,$req_id);

$result = null;

while($rowtype = $type->fetch_object()){

	$data = array("id"=>$rowtype->id,"name"=>$rowtype->name);

	//## for custoum
	if(!isset($req_id) && empty($req_id))
	{
		$lenght = 3;//get 3 record
	}

	$item = $download->getListItem($rowtype->id ,$lenght);

	while($rowitem = $item->fetch_object())
	{
		$data["item"][] = array("title"=>$rowitem->title ,"thumbnail"=>$rowitem->thumbnail,"link"=>$rowitem->link);
	}


	$result[] = $data;
}

log_debug("get list download > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>