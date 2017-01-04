<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/GalleryManager.php");

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
	case "list_album":
		$counter = $_GET["couter"];// count last fetch data
		$max_fetch = $_GET["fetch"];
		$result = get_list_album_fetch($counter,$max_fetch);
	break;
	
	case "add":
		$result = Insert($_POST);
		log_debug("gallery  > Insert " . print_r($result,true));
	break;
	case "add_album":
		$result = Insert_album($_POST);
		log_debug("gallery album > Insert " . print_r($result,true));
	break;
	case "edit":
		$result = Update($_POST);
		log_debug("gallery > Update " . print_r($result,true));
	break;
	case "edit_album":
		$result = Update($_POST);
		log_debug("gallery album > Update " . print_r($result,true));
	break;
	case "del":
		$result = Delete($id);
	break;
	case "item":
		$result = getItems($id);
	break;
	case "album_option":
		$result = getOptions();
	break;
	
	default:
	
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($start_fetch,$max_fetch){
	
	$gallery = new GalleryManager();
	$data = $gallery->get_fetch_list($start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$item =  array("id"=>$row->id
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
						,"update_date"=>$row->update_date
						,"active"=>$row->active
						);

			$result[] = $item;
	}
	return $result;
	
}

function get_list_album_fetch($start_fetch,$max_fetch){
	
	$gallery = new GalleryManager();
	$data = $gallery->get_fetch_list_album($start_fetch,$max_fetch);
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


function getOptions(){
	
	$gallery = new GalleryManager();
	$data = $gallery->get_option_album();

	if($data){

		while($row = $data->fetch_object()){
			$result[] = $row;
		}

	}
	return $result;
}

function getItems($id){
	
	$gallery = new GalleryManager();
	$data = $gallery->get_gallery_info($id);
	
	if($data){
		
			$result = $data->fetch_object();
		
	}
	return $result;
}

function Insert($items){
	
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/gallery/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];  
		$items["image"] = $filename;
		$items["thumbnail"] = $filename;
	}

	
	$gallery = new GalleryManager();
	//1)insert data
	$result = $gallery->insert_item($items);
	//2)upload image personal
	if($items["thumbnail"])
		upload_image($source,$distination);
	
	return "INSERT SUCCESS.";
}

function Insert_album($items){
	
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/gallery/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];  
		$items["cover"] = $filename;
	}

	
	$gallery = new GalleryManager();
	//1)insert data
	$result = $gallery->insert_album($items);
	//2)upload image personal
	if($items["cover"])
		upload_image($source,$distination);
	
	return "INSERT SUCCESS.";
}

function Update($items){
	
	$items["image"] = "";
	$items["thumbnail"] = "";
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/gallery/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];
		$items["image"] = $filename;
		$items["thumbnail"] = $filename;
	}
	
	$gallery = new GalleryManager();
	//1)update data
	$result = $gallery->update_item($items);
	
	//2)upload image
	if($items["thumbnail"])
		upload_image($source,$distination);
	
	return "UPDATE SUCCESS.";
	
}

function Update_album($items){
	
	$items["cover"] = "";
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/gallery/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];
		$items["cover"] = $filename;
	}
	
	$org = new OrgManager();
	//1)update data
	$result = $org->update_album($items);
	
	//2)upload image
	if($items["cover"])
		upload_image($source,$distination);
	
	return "UPDATE SUCCESS.";
	
}

function Delete($id){
	
	$gallery = new GalleryManager();
	$gallery->delete_item($id);
	return "DELETE SUCCESS.";
}

function Delete_Album($id){
	
	$gallery = new GalleryManager();
	$gallery->delete_album($id);
	return "DELETE SUCCESS.";
}

?>