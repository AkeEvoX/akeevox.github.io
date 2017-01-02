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
						,"link"=>"../".$row->link
						,"active"=>$row->active
				);

			$result = $item;
		
	}
	return $result;
}

function Update($items){
	
	$items["link"] = "";

	if($_FILES['file_upload']['name']!=""){
		
		$filename = "images/contact/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];
		$items["link"] = $filename;
		
	}
	
	$contact = new ContactManager();
	$result = $contact->update_map($items);
	
	if($items["link"] && !file_exists($distination)){
		upload_image($source,$distination);
	}
	
	return "UPDATE SUCCESS.";
	
}


?>