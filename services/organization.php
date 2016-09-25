<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require_once("../controller/OrgManager.php");
require_once("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");


$Org = new OrgManager();

$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

//$req_id = $_GET["id"];
$item = "";

$type = $_GET["type"];

switch($type){
	case "org": 
				
		$item = $Org->getlistItem($lang);

		$result = null;
		while($row = $item->fetch_object())
		{
		//id,name_th,position_th,education_th,work_th,shareholder,image,age
			$data = array(
			"id"=>$row->id
			,"name"=>$row->name
			,"position"=>$row->position
			,"education"=>$row->education
			,"work"=>$row->work
			,"shareholder"=>$row->shareholder
			,"image"=>$row->image
			,"age"=>$row->age);
			
			$result[] = $data;
		}

	break;
	case "chart":  
		
		$item = $Org->getchart();
		$row= $item->fetch_object();
		
		$data = array (
		"chart"=>$row->chart
		,"date"=>$row->update_date
		);
		
		$result = $data;
		
	
	break;
	case "inter" :
	
		$item = $Org->getintermarket();
		$row= $item->fetch_object();
		
		$data = array (
		"chart"=>$row->chart
		,"date"=>$row->update_date
		);
		
		$result = $data;
	
	break;
	case "refer":
	 
		$item = $Org->getReferenceList($lang);
		while($row= $item->fetch_object())
		{
			$data = array (
			"id"=>$row->id
			,"title"=>$row->title
			,"detail"=>$row->detail
			,"thumbnail"=>$row->thumbnail
			,"image"=>$row->image
			,"date"=>$row->update_date
			,"local"=>$row->islocal
			);
			$result[] = $data;
		}
		
	break;
}

log_debug("get list organization > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>