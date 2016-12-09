<?php
session_start();
include("../lib/common.php");
include("../lib/logger.php");
include("../controller/MenuManager.php");

if(isset($_SESSION["lang"])) {
	$lang = $_SESSION["lang"];
}
else {
	//$lang = "en";
	//$_SESSION["lang"] = $lang;
}

$menu = new MenuManager();

$item = "";
$result = null;

if(isset($_GET["id"])) $id = $_GET["id"] ; else $id="";

if(isset($id) && !empty($id))
{
	$item = $menu->getsubmenu($id,$lang);
}
else
{
	$item = $menu->getmenu($lang);
}


while($row = $item->fetch_object()){

	//$data = array("id"=>$row->id,"name"=>$row->name,"seq"=>$row->seq,"child"=>$row->child,"link"=>$row->link);
	$data = array("id"=>$row->id,"name"=>$row->name,"seq"=>$row->seq,"parent"=>$row->parent,"link"=>$row->link);
	$result[] = $data;
}

log_debug("get list menu > " . print_r($result,true));
log_debug("lang > " . print_r($_SESSION["lang"],true));

echo json_encode(array("result"=> $result ,"code"=>"0","lang"=>$lang));

?>
