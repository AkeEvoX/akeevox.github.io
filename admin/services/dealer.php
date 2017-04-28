<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/DealerManager.php");

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
		log_debug("dealer  > Insert " . print_r($result,true));
	break;
	
	case "edit":
		$result = Update($_POST);
		log_debug("dealer > Update " . print_r($result,true));
	break;
	case "del":
		$result = Delete($id);
	break;
	case "item":
		$result = get_Items($id);
	break;
	default:
		/*other implement here.*/
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($start_fetch,$max_fetch){
	
	$dealer = new DealerManager();
	$data = $dealer->get_fetch_list($start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$result[] = $row;
	}
	return $result;
	
}

function get_Items($id){
	
	$dealer = new DealerManager();
	$data = $dealer->get_dealer_info($id);
	
	if($data){
		
			$result = $data->fetch_object();
		
	}
	return $result;
}

function get_Item_album($id){
	
	$dealer = new DealerManager();
	$data = $dealer->get_album_info($id);
	
	if($data){
		
			$result = $data->fetch_object();
		
	}
	return $result;
}

function Insert($items){
	
	if($_FILES['file_upload_th']['name']!=""){
		$filename = "images/dealer/th_". date('Ymd_His')."_".$_FILES['file_upload_th']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload_th']['tmp_name'];  
		$items["link_th"] = $filename;
		upload_image($source,$distination);
	}
	
	
	if($_FILES['file_upload_en']['name']!=""){
		$filename = "images/dealer/en_". date('Ymd_His')."_".$_FILES['file_upload_en']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload_en']['tmp_name'];  
		$items["link_en"] = $filename;
		upload_image($source,$distination);
	}

	$dealer = new DealerManager();
	//1)insert data
	$result = $dealer->insert_item($items);
	
	return "INSERT SUCCESS.";
}


function Update($items){
	
	$items["link_th"] = "";
	$items["link_en"] = "";
	
	if($_FILES['file_upload_th']['name']!=""){
		$filename = "images/dealer/th_". date('Ymd_His') ."_".$_FILES['file_upload_th']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload_th']['tmp_name'];
		$items["link_th"] = $filename;
		upload_image($source,$distination);
	}
	if($_FILES['file_upload_en']['name']!=""){
		$filename = "images/dealer/en_". date('Ymd_His') ."_".$_FILES['file_upload_en']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload_en']['tmp_name'];
		$items["link_en"] = $filename;
		upload_image($source,$distination);
	}
	
	$dealer = new DealerManager();
	//1)update data
	$result = $dealer->update_item($items);
	
		
	
	return "UPDATE SUCCESS.";
	
}


function Delete($id){
	
	$dealer = new DealerManager();
	$dealer->delete_item($id);
	return "DELETE SUCCESS.";
}

?>