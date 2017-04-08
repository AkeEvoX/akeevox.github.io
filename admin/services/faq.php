<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/FaqManager.php");

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
		log_debug("reference  > Insert " . print_r($result,true));
	break;
	case "edit":
		$result = Update($_POST);
		log_debug("reference > Update " . print_r($result,true));
	break;
	case "del":
		$result = Delete($id);
	break;
	case "item":
		$result = getItems($id);
	break;
	default:
	
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($start_fetch,$max_fetch){
	
	$faq = new FaqManager();
	$data = $faq->get_fetch_list($start_fetch,$max_fetch);
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

function getItems($id){
	
	$faq = new FaqManager();
	$data = $faq->get_faq_info($id);
	
	if($data){
		
			$result = $data->fetch_object();
		
	}
	return $result;
}

function Insert($items){
	
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/faq/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];  
		$items["thumbnail"] = $filename;
	}

	
	$faq = new FaqManager();
	$result = $faq->insert_item($items);
	
	if($items["thumbnail"])
		upload_image($source,$distination);
	
	return "INSERT SUCCESS.";
}

function Update($items){
	
	
	$items["thumbnail"] = "";
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/faq/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];
		$items["thumbnail"] = $filename;
	}
	
	$faq = new FaqManager();
	
	$result = $faq->update_item($items);
	
	if($items["thumbnail"])
		upload_image($source,$distination);
	
	return "UPDATE SUCCESS.";
	
}

function Delete($id){
	
	$faq = new FaqManager();
	$faq->delete_item($id);
	return "DELETE SUCCESS.";
}

?>