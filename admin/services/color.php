<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/ProductManager.php");


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
	
		$result = Insert($_POST);
		log_debug("Admin Color  > Insert " . print_r($result,true));
	break;
	case "edit":
		$result = Update($_POST);
		log_debug("Admin Color  > Update " . print_r($result,true));
	break;
	case "del":
		$items["id"] = $_POST["id"];
		$result = Delete($items["id"]);
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
	$product = new ProductManager();
	$data = $product->get_fetch_color($lang,$start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$item =  array("id"=>$row->id
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
		  				,"thumb"=>"../".$row->thumb
						,"active"=>$row->active);

			$result[] = $item;
	}
	return $result;
}


function getItems($items){
	
	$product = new ProductManager();
	$data = $product->getColorMaster($items["id"]);
	
	if($data){
		
			$row = $data->fetch_object();

			$item =  array("id"=>$row->id
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
						,"thumb"=>"../".$row->thumb
		  				,"active"=>$row->active);

			$result = $item;
		
	}
	return $result;
}

function Insert($items){
	
	
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/products/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];  
		$items["thumb"] = $filename;
	}
	
	$product = new ProductManager();
	$result = $product->insert_color($items);
	
	upload_image($source,$distination);
	
	return "INSERT SUCCESS.";	
}

function Update($items){
	$items["thumb"] = "";
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/products/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];
		$items["thumb"] = $filename;
	}
	
	$product = new ProductManager();
	$result = $product->update_color($items);
	
	upload_image($source,$distination);
	
	return "UPDATE SUCCESS.";
	
}

function Delete($items){
	
	$product = new ProductManager();
	$product->delete_color($items["id"]);
	return "DELETE SUCCESS.";
}

?>