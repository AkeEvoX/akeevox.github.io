<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
$base_dir = "../../";
include("../../controller/ContactManager.php");


$type="";
$id="";

$id = GetParameter('id');
$type = GetParameter('type');

$result = "";

switch($type){
	case "edit":
		
		$result = Update($_POST);
		log_debug("Map Manager  > Update " . print_r($result,true));
		
	break;
	case "info":
		$result = getinfo($id);
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function getinfo($id){
	
	$contact = new ContactManager();
	$data = $contact->get_map_info($id);
	
	if($data){
		
			$row = $data->fetch_object();
			$item =  array("id"=>$row->id
				,"title_th"=>"../".$row->title_th
				,"title_en"=>"../".$row->title_en
				,"link"=>"../".$row->link
				,"active"=>$row->active
				);

			$result = $item;
		
	}
	return $result;
}

function Update($items){
	
	$items["title_th"] = "";
	$items["title_en"] = "";
	if($_FILES['file_upload_th']['name']!=""){
		$filename = "images/contact/th_".$_FILES['file_upload_th']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload_th']['tmp_name'];
		$items["title_th"] = $filename;
		upload_image($source,$distination);
	}
	if($_FILES['file_upload_en']['name']!=""){
		$filename = "images/contact/en_".$_FILES['file_upload_en']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload_en']['tmp_name'];
		$items["title_en"] = $filename;
		upload_image($source,$distination);
	}
	
	$contact = new ContactManager();
	$result = $contact->update_map($items);
	
	return "UPDATE SUCCESS.";
	
}


?>