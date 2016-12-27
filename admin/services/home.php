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
	case "landing":
		$result = get_landing_info($id);
	break;
	case "banner":
		$result = get_banner_info();
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
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

function get_landing_info(){
	$attr = new AttributeManager();
	$data = $attr->getattrs_ctrl('intro');
	
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

function get_banner_info(){
	
	$home = new HomeManager();
	$data = $home->getCoverTop();
	
	if($data){
		
			while($row = $data->fetch_object()){
				
				$item[] =  array("id"=>$row->id
						,"cover"=>"../".$row->cover);

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