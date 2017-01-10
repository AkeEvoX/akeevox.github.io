<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/OrgManager.php");

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
		//$items["id"] = $_POST["id"];
		$result = Delete($id);
	break;
	case "item":
		//$items["id"] = $id;
		$result = getItems($id);
	break;
	default:
	
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($start_fetch,$max_fetch){
	$org = new OrgManager();
	$data = $org->get_list_reference_fetch($start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$menu =  array("id"=>$row->id
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
		  				,"contury_th"=>$row->contury_th
						,"contury_en"=>$row->contury_en
						,"thumbnail"=>$row->thumbnail
						,"image"=>$row->image
						,"islocal"=>$row->islocal
						,"active"=>$row->active
						);

			$result[] = $menu;
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
	
	$org = new OrgManager();
	$data = $org->get_refer_info($id);
	
	if($data){
		
			$row = $data->fetch_object();
			$item =  array("id"=>$row->id
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
						,"detail_th"=>$row->detail_th
						,"detail_en"=>$row->detail_en
						,"contury_th"=>$row->contury_th
						,"contury_en"=>$row->contury_en
		  				,"thumbnail"=>"../".$row->thumbnail
						,"image"=>"../".$row->image
						,"islocal"=>$row->islocal
						,"active"=>$row->active
						);

			$result = $item;
		
	}
	return $result;
}

function Insert($items){
	
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/organization/reference/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];  
		$items["image"] = $filename;
		$items["thumbnail"] = $filename;
	}

	
	$org = new OrgManager();
	//1)insert data
	$result = $org->insert_reference($items);
	//2)upload image personal
	upload_image($source,$distination);
	
	return "INSERT SUCCESS.";
}

function Update($items){
	
	$items["image"] = "";
	$items["thumbnail"] = "";
	if($_FILES['file_upload']['name']!=""){
		$filename = "images/organization/reference/".$_FILES['file_upload']['name'];
		$distination =  "../../".$filename;
		$source = $_FILES['file_upload']['tmp_name'];
		$items["image"] = $filename;
		$items["thumbnail"] = $filename;
		
		upload_image($source,$distination);
	}
	
	$org = new OrgManager();
	//1)update data
	$result = $org->update_reference($items);
	

	
	return "UPDATE SUCCESS.";
	
}

function Delete($id){
	
	$org = new OrgManager();
	$org->delete_reference($id);
	return "DELETE SUCCESS.";
}

?>