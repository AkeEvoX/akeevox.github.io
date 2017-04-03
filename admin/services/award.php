<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
$base_dir = "../../";
include("../../controller/AwardManager.php");

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
	case "seq":
		$result = get_seq($id);
		log_debug("award  > get sequence " . print_r($result,true));
	break;
	case "add":
		$result = Insert($_POST);
		log_debug("award  > Insert " . print_r($result,true));
	break;
	case "edit":
		$result = Update($_POST);
		log_debug("award > Update " . print_r($result,true));
	break;
	case "del":
		//$items["id"] = $_POST["id"];
		$result = Delete($id);
	break;
	case "item":
		//$items["id"] = $id;
		$result = get_Items($id);
	break;
	default:
	
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($start_fetch,$max_fetch){
	
	$award = new AwardManager();
	$data = $award->get_fetch_list($start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$item =  array("id"=>$row->id
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
						,"type"=>$row->type
						,"active"=>$row->active
						);

			$result[] = $item;
	}
	return $result;
	
}

function get_seq($typeid){
	
	$award = new AwardManager();
	$data = $award->get_sequence($typeid);
	
	if($data){
			$result = $data->fetch_object();
	}
	
	return $result;
}

function get_Items($id){
	
	$award = new AwardManager();
	$data = $award->get_award_info($id);
	
	if($data){
		
			$result = $data->fetch_object();
	}
	return $result;
}

function Insert($items){
	
	
	if($_FILES['file_upload']['name']!=""){
		$category = ($items["category"]=="1" ?  "award"  :  "standard"  );
		$filename = "images/organization/".$category."/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];  
		$items["thumbnail"] = $filename;
	}

	$award = new AwardManager();
	//1)insert data
	$result = $award->insert_item($items);
	//2)upload image personal
	if($items["thumbnail"])
		upload_image($source,$distination);
	
	return "INSERT SUCCESS.";
}

function Update($items){
	
	$items["thumbnail"] = "";
	if($_FILES['file_upload']['name']!=""){
		$category = ($items["category"]=="1" ?  "award"  :  "standard"  );
		//$filename = "images/organization/reference/".$_FILES['file_upload']['name'];
		$filename = "images/organization/".$category."/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];
		$items["thumbnail"] = $filename;
	}
	
	$award = new AwardManager();
	//1)update data
	$result = $award->update_item($items);
	
	//2)upload image
	if($items["thumbnail"])
		upload_image($source,$distination);
	
	return "UPDATE SUCCESS.";
	
}

function Delete($id){
	
	$award = new AwardManager();
	$award->delete_item($id);
	return "DELETE SUCCESS.";
}

?>