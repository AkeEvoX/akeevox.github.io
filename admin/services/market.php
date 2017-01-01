<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/MarketManager.php");


$type="";
$id="";

$id = GetParameter('id');
$type = GetParameter('type');

$result = "";

switch($type){
	case "edit":
		
		/*
		$items["id"] = $_POST["id"];
		$items["title_th"] = replace_specialtext($_POST["title_th"]);
		$items["title_en"] = replace_specialtext($_POST["title_en"]);
		$items["link_th"] = replace_specialtext($_POST["link_th"]);
		$items["link_en"] = replace_specialtext($_POST["link_en"]);
		$items["detail_th"] = replace_specialtext($_POST["detail_th"]);
		$items["detail_en"] = replace_specialtext($_POST["detail_en"]);
		*/
		
		$result = Update($_POST);
		log_debug("Market Manager  > Update " . print_r($result,true));
	break;
	case "page":
		$result = getinfo($id);
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function getinfo($id){
	
	$market = new MarketManager();
	$data = $market->get_info($id);
	
	if($data){
		
			$row = $data->fetch_object();
			$item =  array("id"=>$row->id
						,"chart_th"=>"../".$row->chart_th
						,"chart_en"=>"../".$row->chart_en
				);

			$result = $item;
		
	}
	return $result;
}

function Update($items){
	
	$items["chart_th"] = "";

	if($_FILES['chart_th']['name']!=""){
		$filename = "images/organization/intermarket/".$_FILES['chart_th']['name'];
		$distination_th =  "../../".$filename;
		$source_th = $_FILES['chart_th']['tmp_name'];
		$items["chart_th"] = $filename;
	}
	
		$items["chart_en"] = "";
	if($_FILES['chart_en']['name']!=""){
		$filename = "images/organization/intermarket/".$_FILES['chart_en']['name'];
		$distination_en =  "../../".$filename;
		$source_en = $_FILES['chart_en']['tmp_name'];
		$items["chart_en"] = $filename;
	}
	
	$market = new MarketManager();
	$result = $market->update_item($items);
	
	
	if($items["chart_th"]){
		upload_image($source_th,$distination_th);
	}
	
	if($items["chart_en"]){
		upload_image($source_en,$distination_en);
	}
	
	return "UPDATE SUCCESS.";
	
}


?>