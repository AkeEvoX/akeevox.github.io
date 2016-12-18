<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
$base_dir = "../../";
include("../../controller/AttributeManager.php");
include("../../controller/HomeManager.php");


$type="";
$id="";

$id = GetParameter('id');
$type = GetParameter('type');

$result = "";

switch($type){
	case "edit":
		$result = Update($_POST);
		log_debug("HomeManager  > Introl Update " . print_r($result,true));
	break;
	case "intro":
		$result = get_page_intro($id);
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

function get_page_intro($id){
	
	$attr = new AttributeManager();
	$data = $attr->getattrs_ctrl('index');
	
	if($data){
		
			while($row = $data->fetch_object()){
				$item[$row->name] =  array("id"=>$row->id
						,"th"=>$row->th
						,"en"=>$row->en
						,"options"=>$row->options);

			}
			$result= $item;
	}
	return $result;
	
}

function Update($items){
	
	$about = new AboutManager();
	$result = $about->update_about($items);
	return "UPDATE SUCCESS.";
	
}


?>