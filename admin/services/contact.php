<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/ContactManager.php");

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
		log_debug("contact  > Insert " . print_r($result,true));
	break;
	case "edit":
		$result = Update($_POST);
		log_debug("update > Update " . print_r($result,true));
	break;
	case "del":
		$result = Delete($id);
	break;
	case "item":
		$result = getItems($id);
	break;
	case "option":
		$result = getOptions();
	break;
	default:
	
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($start_fetch,$max_fetch){
	
	$contact = new ContactManager();
	$data = $contact->get_list_contact_fetch($start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$item =  array("id"=>$row->id
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
						,"type"=>$row->typename
						,"create_date"=>$row->create_date
						,"update_date"=>$row->update_date
						,"active"=>$row->active
						);

			$result[] = $item;
	}
	return $result;
	
}

function getOptions(){
	
	$contact = new ContactManager();
	$data = $contact->get_list_option();

	if($data){

		while($row = $data->fetch_array()){

			// $item =  array("id"=>$row->id
						// ,"parent"=>$row->parent
						// ,"title"=>$row->title
		  				// ,"link"=>$row->link);

			$result[] = $row;
		}

	}
	return $result;
}

function getItems($id){
	
	$contact = new ContactManager();
	$data = $contact->get_contact_info($id);
	
	if($data){
		
			$row = $data->fetch_object();
			$item =  $row;
			
			// array("id"=>$row->id
			// ,"title_th"=>$row->title_th
			// ,"title_en"=>$row->title_en
			// ,"icon"=>$row->detail_th
			// ,"detail_en"=>$row->detail_en
			// ,"contury_th"=>$row->contury_th
			// ,"contury_en"=>$row->contury_en
			// ,"thumbnail"=>"../".$row->thumbnail
			// ,"image"=>"../".$row->image
			// ,"islocal"=>$row->islocal
			// ,"active"=>$row->active
			// );

			$result = $item;
		
	}
	return $result;
}

function Insert($items){
	
	if($_FILES['file_upload']['name']!=""){
		
		$filename = "images/contact/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];  
		$items["icon"] = $filename;
	}

	$contact = new ContactManager();
	//1)insert data
	$result = $contact->insert_contact($items);
	//2)upload image personal
	if($items["icon"]){
		upload_image($source,$distination);
	}
	
	return "INSERT SUCCESS.";
}

function Update($items){
	
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/contact/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];
		$items["icon"] = $filename;
	}
	
	$contact = new ContactManager();
	//1)update data
	$result = $contact->update_contact($items);
	
	//2)upload image
	if($items["icon"]){
		upload_image($source,$distination);
	}
	
	return "UPDATE SUCCESS.";
	
}

function Delete($id){
	
	$contact = new ContactManager();
	$contact->delete_contact($id);
	return "DELETE SUCCESS.";
}

?>