<?php
session_start();
include("../lib/common.php");
include("../lib/logger.php");
require_once("../controller/AboutManager.php");

$about = new AboutManager();

//$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

$item = "";
$item = $about->getItem($lang);

$result = null;
if($item){
$row = $item->fetch_object();

//$media = $row->link;

	$data = array("id"=>$row->id
								,"title"=>$row->title
								,"detail"=>$row->detail
								,"link"=>$row->link
								,"type"=>$row->type
								,"date"=>$row->update_date);

	$result = $data;
}

log_debug("get list about > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>