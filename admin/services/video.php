<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
$base_dir = "../../";
include("../../controller/VideoManager.php");

$id="";
$type="";

$id=GetParameter("id");
$type=GetParameter("type");

$result = "";

switch($type){
	case "list":
		$counter = $_GET["couter"];// count last fetch data
		$max_fetch = $_GET["fetch"];
		$result = get_list_fetch($counter,$max_fetch);
	break;
	case "add":
		$result = Insert($_POST);
		log_debug("video  > Insert " . print_r($result,true));
	break;
	case "edit":
		$result = Update($_POST);
		log_debug("video > Update " . print_r($result,true));
	break;
	case "del":
		$result = Delete($id);
	break;
	case "item":
		$result = get_Items($id);
	break;
	default:
	
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($start_fetch,$max_fetch){
	
	$video = new VideoManager();
	$data = $video->get_fetch_list($start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$item =  array("id"=>$row->id
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
						,"create_date"=>$row->create_date
						,"update_date"=>$row->update_date
						,"active"=>$row->active
						);

			$result[] = $item;
	}
	return $result;
	
}


function get_Items($id){
	
	$video = new VideoManager();
	$data = $video->get_video_info($id);
	
	if($data){
		
			$result = $data->fetch_object();
		
	}
	return $result;
}

function Insert($items){
	
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/video/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];  
		$items["thumbnail"] = $filename;
	}

	
	$video = new VideoManager();
	//1)insert data
	$result = $video->insert_item($items);
	//2)upload image personal
	if($items["thumbnail"])
		upload_image($source,$distination);
	
	return "INSERT SUCCESS.";
}

function Update($items){
	
	$items["image"] = "";
	$items["thumbnail"] = "";
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/organization/reference/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];
		$items["image"] = $filename;
		$items["thumbnail"] = $filename;
	}
	
	$video = new VideoManager();
	//1)update data
	$result = $video->update_item($items);
	
	//2)upload image
	upload_image($source,$distination);
	
	return "UPDATE SUCCESS.";
	
}

function Delete($id){
	
	$video = new VideoManager();
	$video->delete_item($id);
	return "DELETE SUCCESS.";
}

?>