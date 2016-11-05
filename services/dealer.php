<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/DealerManager.php");
include("../lib/common.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");


$dealer = new DealerManager();

if(isset($_SESSION["lang"]) && !empty($_SESSION["lang"])) {
	$lang = $_SESSION["lang"];
}else{
	/* $_SESSION["lang"] = $lang;*/
}

$req_id = $_GET["id"];
$name = $_GET["name"];
$item = "";

if(isset($req_id) && !empty($req_id)) {  //no request id
	$item = $dealer->getItem($req_id,$lang);
}
else if(isset($name) && !empty($name)){
 $item = $dealer->findName($lang,$name);
}
else{
	$item = $dealer->getListItem($lang);
}

$result = null;

while($row = $item->fetch_object()){

	$data = array(
	"id"=>$row->id
	,"title"=>$row->title
	,"province"=>$row->province
	,"zone"=>$row->zone
	,"mobile"=>$row->mobile
	);
	$result[] = $data;
}

log_debug("get list dealer > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));

?>
