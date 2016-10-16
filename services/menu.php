<?php
Session_Start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/MenuManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");


if(isset($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}
else {$_SESSION["lang"] = $lang;}

$menu = new MenuManager();

$id = $_GET["id"];
$item = "";
$result = null;

if(isset($id) && !empty($id))
{
	$item = $menu->getsubmenu($id,$lang);
}
else 
{
	$item = $menu->getmenu($lang);	
}


while($row = $item->fetch_object()){

	$data = array("id"=>$row->id,"name"=>$row->name,"seq"=>$row->seq,"child"=>$row->child,"link"=>$row->link);
	$result[] = $data;
}

log_debug("get list menu > " . print_r($result,true));
log_debug("lang > " . print_r($_SESSION["lang"],true));

echo json_encode(array("result"=> $result ,"code"=>"0","lang"=>$lang));

?>