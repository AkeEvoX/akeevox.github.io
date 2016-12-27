<?php
session_start();
include("../lib/common.php");
include("../lib/logger.php");
include("../controller/GalleryManager.php");


$gallery = new GalleryManager();

//$lang = "th"; 
//if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
//	$lang = $_SESSION["lang"];
//}
$id = "";
$type = "";
$id = GetParameter("id");
$type = GetParameter("type");
$item = "";

switch($type){
	case "album":
		$items = $gallery->get_list_album($lang);
		$result = set_album($items);
	break ;
	case "list":
		$items = $gallery->get_list_gallery($lang,$id);
		$result = set_list($items);
	break;	
	case "item":
		$items = $gallery->get_gallery($lang,$id);
		$result = set_item($items);
	break;	
}
/*
if(!isset($id) && empty($id))  //no request id
{
	$item = $gallery->getListItem($lang);
}
else
{
	$item = $gallery->getItem($id,$lang);
}

$result = null;

while($row = $item->fetch_object()){

	$data = array("id"=>$row->id,"title"=>$row->title,"thumbnail"=>$row->thumbnail,"image"=>$row->image,"date"=>$row->update_date);
	$result[] = $data;
}
*/

log_debug("get list gallery > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));

/****** function list ******/
function set_album($items){
	$result = "";
	if($items){
		$date = "";
		while($row = $items->fetch_object()){
		
			$data = array("id"=>$row->id
			,"title"=>$row->title
			,"cover"=>$row->cover
			,"date"=>$row->data_date);
			
			$result[] = $data;
		}
		
	}
	
	return $result;
	
}

function set_list($items){
	$result = "";
	if($items){
		
		$date = "";
		
		while($row = $items->fetch_object()){
			
			$data = array("id"=>$row->id
			,"title"=>$row->title
			,"thumbnail"=>$row->thumbnail
			,"image"=>$row->image
			,"date"=>$row->data_date);
			
			$result[] = $data;
		}
	}
	return $result;
}

function set_item($items){
	$result = "";
	if($items){
		$date = "";
		$row = $items->fetch_object();
		if($row){
						
			$data = array("id"=>$row->id
			,"title"=>$row->title
			,"thumbnail"=>$row->thumbnail
			,"image"=>$row->image
			,"date"=>$row->data_date);
			
			$result = $data;
		}
	
	}
	return $result;
}


?>