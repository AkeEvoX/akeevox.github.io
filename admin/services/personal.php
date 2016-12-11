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

if(isset($_GET["type"])) $type = $_GET["type"]; 
if(isset($_POST["type"])) $type = $_POST["type"]; 

if(isset($_GET["id"])) $id = $_GET["id"]; 
if(isset($_POST["id"])) $id = $_POST["id"]; 

if($type==""){
	
	$type = $_POST["data"]["type"];
	
}

	
	//print_r(json_decode(json_encode($_POST),true));
	//print_r($_POST);
	//print_r($_FILES['file_upload']);
	//log_warning('personal service > ');
	
	//.var_dump($_POST)

$result = "";

switch($type){
	
	case "add":
		
		//print_r($_FILES['file_upload']);
		
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
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/

function getPersonal(){
	
}

function getPersonalList(){
	
	$org = new OrgManager();
	
	$data = $org->getPersonalList();
	if($data){
		while($row = $data->fetch_object()){
			$item =  array("id"=>$row->id
						,"name_th"=>$row->name_th
						,"name_en"=>$row->name_en);
			
			$result[] = $item;
		}
	}
	return $result;
}

/*
	,"position_th"=>$row->position_th
	,"position_en"=>$row->position_en
	,"education_th"=>$row->education_th
	,"education_en"=>$row->education_en
	,"work_th"=>$row->work_th
	,"work_en"=>$row->work_en
	,"shareholder"=>$row->shareholder
*/

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

function Update_Page($items){
	
	$attr = new AttributeManager();
	
	foreach($items as $key => $data){
		$attr->update_attribute($data);
	}
	
	return "UPDATE SUCCESS.";
	
}


?>
