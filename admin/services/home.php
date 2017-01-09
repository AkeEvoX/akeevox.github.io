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
	case "edit_landing":
		$result = update_landing($_POST);
		log_info("Home > Landing  > Update " . print_r($result,true));
	break;
	case "edit_banner":
		$result = update_banner($_POST);
		log_info("Home > Banner  > Update " . print_r($result,true));
	break;
	case "edit_content":
		$result = update_content($_POST);
		log_info("Home > content  > Update " . print_r($result,true));
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
						,"cover"=>"../".$row->cover
						,"active"=>$row->active
						);

			}
			$result= $item;
	}
	return $result;
	
}

function Update($items){
	
	$home = new HomeManager();
	$result = $about->update_about($items);
	return "UPDATE SUCCESS.";
	
}

function update_landing($items){
	
	$attr = new AttributeManager();
	
	$enable = $items["active"] != "" ? "1" : "0" ;
	
	$data = array("name"=>"intro.enable"
	,"th"=>$enable
	,"en"=>$enable
	,"options"=>"");

	//update enable landing
	$result = $attr->update_attribute_admin($data);
	
	//update cover landing
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/home/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];  
		$data = array("name"=>"intro.cover"
		,"th"=>$filename
		,"en"=>$filename
		,"options"=>"");
		
		$result = $attr->update_attribute_admin($data);
		
		if($filename)
			upload_image($source,$distination);
	
	}
	
	return "UPDATE SUCCESS.";
}

function update_banner($items){
	
	$home = new HomeManager();
	
	for($i=1;$i<5;$i++){		
	
		$enable = $items["active".$i] != "" ? "1" : "0" ;
		$data = array("id"=>$i ,"active"=>$enable);
		$fileobj = "file_upload".$i;
		
		if($_FILES[$fileobj]['name']!=""){
			$filename = "images/home/".$_FILES[$fileobj]['name'];
			$distination =  "../../".$filename;
			$source = $_FILES[$fileobj]['tmp_name'];  
			$data["cover"] = $filename;
			upload_image($source,$distination);
		}	
		$home->update_banner($data);
		
	}
	
	return "UPDATE SUCCESS.";
}

function update_content($items){
	
	$attr = new AttributeManager();
	
	$list_data[] = array(
		"name"=>"index.top_detail"
		,"th"=>$items["intro_th"]
		,"en"=>$items["intro_en"]
	);
	$list_data[] = array(
		"name"=>"index.series.detail"
		,"th"=>$items["series_th"]
		,"en"=>$items["series_en"]
	);
	
	foreach($list_data as $data){
		$result = $attr->update_attribute_admin($data);
	}
	
	return "UPDATE SUCCESS.";
}





?>