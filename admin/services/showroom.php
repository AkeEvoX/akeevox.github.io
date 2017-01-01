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
		$result = get_list_fetch($lang,$counter,$max_fetch);
	break;
	case "option":
		$CATEGORIES = 1;
		$result = getOptions($lang);
		
	break;
	case "add":
		$items["parent"] = $_POST["parent"];
		$items["title_th"] = $_POST["th"];
		$items["title_en"] = $_POST["en"];
		$items["link"] = "category.html";
		//category.html
		//$items["cover"] = $_POST["cover"];
		$result = Insert($items);
		log_debug("Admin Category  > Insert " . print_r($result,true));
	break;
	case "edit":
		$items["id"] = $_POST["id"];
		$items["parent"] = $_POST["parent"];
		$items["title_th"] = $_POST["th"];
		$items["title_en"] = $_POST["en"];
		//$items["cover"] = $_POST["cover"];
		$result = Update($items);
		log_debug("Admin Category  > Update " . print_r($result,true));
	break;
	case "del":
		$items["id"] = $_POST["id"];
		$result = Delete($items);
	break;
	case "item":
		$items["id"] = $id;
		$result = getItems($items);
	break;
	default:
	
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($lang,$start_fetch,$max_fetch){
	$room = new ShowRoomManager();
	$data = $room->get_fetch_list($lang,$start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$item =  array("id"=>$row->id
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
		  				,"thumb"=>$row->thumb
						,"cover"=>$row->cover);

			$result[] = $item;
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

function getItems($items){
	
	$room = new ShowRoomManager();
	$data = $room->getProductTypeByID($items["id"]);
	
	if($data){
		
			$row = $data->fetch_object();
//id,parent,title_th,title_en,detail_th,detail_en,thumb,cover
			$item =  array("id"=>$row->id
						,"parent"=>$row->parent
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
						,"detail_th"=>$row->detail_th
						,"detail_en"=>$row->detail_en
						,"thumb"=>$row->thumb
		  				,"cover"=>$row->cover);

			$result = $item;
		
	}
	return $result;
}

function Insert($items){
	
	$room = new ShowRoomManager();
	$result = $room->insert_item($items);
	return "INSERT SUCCESS.";
}

function Update($items){
	
	$room = new ShowRoomManager();
	$result = $room->update_item($items);
	return "UPDATE SUCCESS.";
	
}

function Delete($items){
	
	$room = new ShowRoomManager();
	$room->delete_item($items["id"]);
	return "DELETE SUCCESS.";
}

?>