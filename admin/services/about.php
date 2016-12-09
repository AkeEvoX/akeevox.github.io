<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/AboutManager.php");


$type="";
$id="";

if(isset($_GET["type"])) $type = $_GET["type"]; 
if(isset($_POST["type"])) $type = $_POST["type"]; 

if(isset($_GET["id"])) $id = $_GET["id"]; 
if(isset($_POST["id"])) $id = $_POST["id"]; 

$result = "";

switch($type){
	case "edit":
	
		$items["id"] = $_POST["id"];
		
		$items["title_th"] = replace_specialtext($_POST["title_th"]);
		$items["title_en"] = replace_specialtext($_POST["title_en"]);
		$items["link_th"] = replace_specialtext($_POST["link_th"]);
		$items["link_en"] = replace_specialtext($_POST["link_en"]);
		$items["detail_th"] = replace_specialtext($_POST["detail_th"]);
		$items["detail_en"] = replace_specialtext($_POST["detail_en"]);
		
		$result = Update($items);
		log_debug("About Manager  > Update " . print_r($result,true));
	break;
	case "info":
		$items["id"] = $id;
		$result = getinfo($items);
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function getinfo($items){
	
	$about = new AboutManager();
	$data = $about->getInfo($items["id"]);
	
	if($data){
		
			$row = $data->fetch_object();
			$item =  array("id"=>$row->id
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
						,"detail_th"=>$row->detail_th
						,"detail_en"=>$row->detail_en
						,"link_th"=>$row->link_th
		  				,"link_en"=>$row->link_en);

			$result = $item;
		
	}
	return $result;
}

function Update($items){
	
	$about = new AboutManager();
	$result = $about->update_about($items);
	return "UPDATE SUCCESS.";
	
}


?>