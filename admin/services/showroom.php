<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");

$base_dir = "../../";
include("../../controller/ProductManager.php");
include("../../controller/ShowRoomManager.php");

$type="";
$id="";

$id = GetParameter("id");
$type = GetParameter("type");

$result = "";

$product = new ProductManager();

switch($type){
	case "list":
		$counter = $_GET["couter"];// count last fetch data
		$max_fetch = $_GET["fetch"];
		$result = get_list_fetch($counter,$max_fetch);
	break;
	case "list_product":
		 $result = get_list_product($id);
	break;
	case "add":
		$result = Insert($_POST);
	break;
	case "add_product":
		$result = Insert_product($_POST);
	break;
	case "edit":
		$result = Update($_POST);
	break;
	case "del":
		$result = Delete($id);
	break;
	case "del_pro":
		$result = Delete_Product($id);
	case "item":
		$result = get_item($id);
	break;
	default:
	
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($start_fetch,$max_fetch){
	$room = new ShowRoomManager();
	$data = $room->get_fetch_list($start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$result[] =  array("id"=>$row->id
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
		  				,"thumb"=>$row->thumb
						,"cover"=>$row->cover
						,"active"=>$row->active
			);

			// $result[] = $item;
	}
	return $result;
}

function get_list_product($room_id){
	$room = new ShowRoomManager();
	$data = $room->get_list_product($room_id);
	$result = "";
	
	if($data==null) return $result;
	
	while($row = $data->fetch_object()){

			$result[] = $row;
	}
	return $result;
}

function getOptions($lang){
	
	$product = new ProductManager();
	$data = $product->getMenu($lang);

	if($data){

		while($row = $data->fetch_object()){

			$menu =  array("id"=>$row->id
						,"parent"=>$row->parent
						,"title"=>$row->title
		  				,"link"=>$row->link);

			$result[] = $menu;
		}

	}
	return $result;
}

function get_item($id){
	
	$room = new ShowRoomManager();
	$data = $room->get_showroom_info($id);
	
	if($data){
		
			$result = $data->fetch_object();
		
	}
	return $result;
}

function Insert($items){
	
	
	if($_FILES["file_upload_th"]["name"]!="")
	{
		$filename = "images/showroom/th/". date('Ymd_His') ."_".$_FILES['file_upload_th']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload_th']['tmp_name'];
		$items["cover_th"] = $filename;
		upload_image($source,$distination);
	}
	if($_FILES["file_upload_en"]["name"]!="")
	{
		$filename = "images/showroom/en/". date('Ymd_His') ."_".$_FILES['file_upload_en']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload_en']['tmp_name'];
		$items["cover_en"] = $filename;
		upload_image($source,$distination);
	}
	
	$room = new ShowRoomManager();
	$result = $room->insert_item($items);
	return "INSERT SUCCESS.";
}

function Insert_product($items){
		
	$room = new ShowRoomManager();
	$result = $room->insert_product($items);
	
	
	return "INSERT SUCCESS.";
}

function Update($items){
	
		$items["cover_th"] = "";
	$items["cover_en"] = "";
	if($_FILES["file_upload_th"]["name"]!="")
	{
		$filename = "images/showroom/th/". date('Ymd_His') ."_".$_FILES['file_upload_th']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload_th']['tmp_name'];
		$items["cover_th"] = $filename;
		upload_image($source,$distination);
	}
	if($_FILES["file_upload_en"]["name"]!="")
	{
		$filename = "images/showroom/en/". date('Ymd_His') ."_".$_FILES['file_upload_en']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload_en']['tmp_name'];
		$items["cover_en"] = $filename;
		upload_image($source,$distination);
	}
	
	$room = new ShowRoomManager();
	$result = $room->update_item($items);
	return "UPDATE SUCCESS.";
	
}

function Delete($id){
	
	$room = new ShowRoomManager();
	$room->delete_item($id);
	return "DELETE SUCCESS.";
}

function Delete_Product($id){
	
	$room = new ShowRoomManager();
	$room->delete_product($id);
	return "DELETE SUCCESS.";
}

?>