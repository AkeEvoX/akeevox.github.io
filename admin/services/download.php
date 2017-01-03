<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");

$base_dir = "../../";
include("../../controller/DownloadManager.php");

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
		log_debug("download  > Insert " . print_r($result,true));
	break;
	case "edit":
		$result = Update($_POST);
		log_debug("download > Update " . print_r($result,true));
	break;
		case "del":
		$result = Delete($id);
	break;
	case "listtype":
		$counter = $_GET["couter"];// count last fetch data
		$max_fetch = $_GET["fetch"];
		$result = get_list_type_fetch($counter,$max_fetch);
	break;
	case "add_type":
		$result = Insert_type($_POST);
		log_debug("download  > Insert type " . print_r($result,true));
	break;
	case "edit_type":
		$result = Update_type($_POST);
		log_debug("download > Update type" . print_r($result,true));
	break;
	case "del_type":
		$result = Delete_type($id);
	break;
	case "item":
		$result = getItems($id);
	break;
	case "item_type":
		$result = getItemtype($id);
	break;
	case "options":
		$result = getOptions();
	break;
	
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($start_fetch,$max_fetch){
	
	$download = new DownloadManager();
	$data = $download->get_list_download_fetch($start_fetch,$max_fetch);
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

function get_list_type_fetch($start_fetch,$max_fetch){
	
	$download = new DownloadManager();
	$data = $download->get_list_type_fetch($start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$item =  array("id"=>$row->id
						,"title_th"=>$row->th
						,"title_en"=>$row->en
						,"create_date"=>$row->create_date
						,"update_date"=>$row->update_date
						,"active"=>$row->active
						);

			$result[] = $item;
	}
	return $result;
	
}


function getOptions(){
	
	$download = new DownloadManager();
	$data = $download->getTypeOption();

	if($data){

		while($row = $data->fetch_object()){
			$result[] = $row;
		}

	}
	return $result;
}

function getItems($id){
	
	$download = new DownloadManager();
	$data = $download->get_download_info($id);
	
	if($data){
			$result = $data->fetch_object();
	}
	return $result;
}

function getItemtype($id){
	
	$download = new DownloadManager();
	$data = $download->get_download_type($id);
	
	if($data){
		
		$row = $data->fetch_object();
		$result = $row;

		
	}
	return $result;
}



function Insert($items){
	
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/download/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];  
		$items["link"] = $filename;
		$items["thumbnail"] = $filename;
	}
	
	$download = new DownloadManager();
	$result = $download->insert_download($items);
	
	if($items["thumbnail"])
		upload_image($source,$distination);
	
	return "INSERT SUCCESS.";
}


function Insert_type($items){
	
	$download = new DownloadManager();
	$result = $download->insert_type_download($items);
	
	return "INSERT SUCCESS.";
}

function Update($items){
	
	
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/download/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];  
		$items["link"] = $filename;
		$items["thumbnail"] = $filename;
	}
	
	$download = new DownloadManager();
	$result = $download->update_download($items);
	
	if($items["thumbnail"])
		upload_image($source,$distination);
	
	return "UPDATE SUCCESS.";
	
}

function Update_type($items){
	
	
	$download = new DownloadManager();
	$result = $download->update_type_download($items);
	
	return "UPDATE SUCCESS.";
	
}


function Delete($id){
	
	$download = new DownloadManager();
	$download->delete_download($id);
	return "DELETE SUCCESS.";
}

function Delete_type($id){
	
	$download = new DownloadManager();
	$download->delete_type_download($id);
	return "DELETE SUCCESS.";
}


?>