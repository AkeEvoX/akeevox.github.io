<?php
Session_Start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/ManuManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");

$menu = new MenuManager();

$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

$req_id = $_GET["id"];
$item = "";

if(isset($req_id) && !empty($req_id))
{
	$item = $menu->getsubmenu($req_id);
}
else 
{
	$item = $menu->getmenu();
}

$result = null;

while($row = $item->fetch_object()){

	$data = array("id"=>$row->id,"name"=>$row->name,"seq"=>$row->seq);
	$result[] = $data;
}

log_debug("get list menu > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));

?>