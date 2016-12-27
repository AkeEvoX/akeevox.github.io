<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/AttributeManager.php");
include("../../controller/OrgManager.php");


$type="";
$id="";

//if(isset($_GET["type"])) $type = $_GET["type"]; 
//if(isset($_POST["type"])) $type = $_POST["type"]; 

//if(isset($_GET["id"])) $id = $_GET["id"]; 
//if(isset($_POST["id"])) $id = $_POST["id"]; 

$type = GetParameter("type");
$id = GetParameter("id");


$result = "";

switch($type){
	
	case "add":
		$result = Insert_data($_POST);
	break;
		case "edit":
		$result = Update_data($_POST);
	break;	
	case "del" : 
		//$items["id"] = $_POST["id"];
		$result = Delete_data($_POST);
	break;
	case "edit_page":
		
		$items = $_POST["item"];
		$result = Update_Page($items);
		
	break;
	case "page":
		$result = getPersonalPage();
	break;
	case "list":
		$result = getPersonalList();
	break;
	case "item":
		$result = getPersonal($id);
	break;
	default :
		$result ="Service Not Found.";
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/

function getPersonal($id){
	
	$org = new OrgManager();
	$data = $org->getPersonal($id);
	$result = "Data Not Found";
	if($data){
		
			$row = $data->fetch_object();
//name_th,position_th,education_th,work_th,name_en,position_en,education_en,work_en
//,shareholder,image,active,create_by,create_date
			$item =  array("id"=>$row->id
						,"name_th"=>$row->name_th
						,"position_th"=>$row->position_th
						,"education_th"=>$row->education_th
						,"work_th"=>$row->work_th
						,"name_en"=>$row->name_en
						,"position_en"=>$row->position_en
		  				,"education_en"=>$row->education_en
						,"work_en"=>$row->work_en
						,"image"=>"../".$row->image
						,"active"=>$row->active);

			$result = $item;
	}
	
	return $result;
}

function getPersonalList(){
	
	$org = new OrgManager();
	
	$data = $org->getPersonalList();
	if($data){
		while($row = $data->fetch_object()){
			$item =  array("id"=>$row->id
						,"name_th"=>$row->name_th
						,"name_en"=>$row->name_en
						,"active"=>$row->active
						);
			
			$result[] = $item;
		}
	}
	return $result;
}

function getPersonalPage(){
	
	$attr = new AttributeManager();
	$data = $attr->getattrs_ctrl('org');
	
	if($data){
		
			while($row = $data->fetch_object()){
				$item[$row->name] =  array("id"=>$row->id
						,"th"=>$row->th
						,"en"=>$row->en
						,"options"=>$row->options);

			}
			$result= $item;
	}
	return $result;
}

function Insert_data($items){
	
	//define image path
	$filename = "images/personal/".$_FILES['file_upload']['name'];
	$distination =  "../../".$filename;
	$source = $_FILES['file_upload']['tmp_name'];  
	$items["image"] = $filename;
	
	$org = new OrgManager();
	//1)insert data
	$id = $org->Insert_personal($items);
	//2)upload image 
	upload_image($source,$distination);
	
	return "INSERT SUCCESS.";
}

function Update_data($items){
	
	//define image path
	$items["image"] = "";
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/personal/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];
		$items["image"] = $filename;
	}
	
	
	$org = new OrgManager();
	//1)update data
	$id = $org->update_personal($items);
	//2)upload image 
	if($items["image"]){
		upload_image($source,$distination);
	}
	
	return "UPDATE SUCCESS.";
}


function Delete_data($items){
	
	$org = new OrgManager();
	$org->delete_personal($items["id"]);
	return "DELETE SUCCESS.";
}


function Update_Page($items){
	
	$attr = new AttributeManager();
	
	foreach($items as $key => $data){
		$attr->update_attribute($data);
	}
	
	return "UPDATE SUCCESS.";
	
}

function upload_image_bak($source,$distination){
	
	if(move_uploaded_file($source,$distination))
	{
		log_debug('upload personal image success. > '.$distination);
	}
	else{
		log_debug('upload personal image Failed. >'.$distination);
	}
}


?>
