<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/ContactManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");

$contact = new ContactManager();

$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

$data = $contact->getContact($lang);

while($row = $data->fetch_object()) 
{
	$item = array("id"=>$row->id
	,"title"=>$row->title
	,"icon"=>$row->icon
	,"link"=>$row->link
	,"type"=>$row->typename);
	
	$result[] = $item;
}

log_debug("get contact > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>