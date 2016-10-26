<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require_once("../controller/AboutManager.php");
require_once("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");


$about = new AboutManager();

//$lang = "th";
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

//$req_id = $_GET["id"];
$item = "";
$item = $about->getItem($lang);

$result = null;
$row = $item->fetch_object();

//$row->link

$media = $row->link;

$data = array("id"=>$row->id
							,"title"=>$row->title
							,"detail"=>$row->detail
							,"media"=>$media
							,"type"=>$row->type
							,"date"=>$row->update_date);

$result = $data;

log_debug("get list about > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>
