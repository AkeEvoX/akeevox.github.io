<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/ProjectManager.php");

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
		log_debug("project  > Insert " . print_r($result,true));
	break;
	case "edit":
		$result = Update($_POST);
		log_debug("project > Update " . print_r($result,true));
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
	
	$project = new ProjectManager();
	$data = $project->get_fetch_list($start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$menu =  array("id"=>$row->id
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
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
	
	$pro = new ProjectManager();
	$data = $pro->get_info($id);
	
	if($data){
		
			$result = $data->fetch_object();
			
	}
	return $result;
}

function Insert($items){
	
	$pro = new ProjectManager();
	//1)insert data
	$result = $pro->insert_item($items);
	//2)upload image personal
	return "INSERT SUCCESS.";
}

function Update($items){
	
	$pro = new ProjectManager();
	//1)update data
	$result = $pro->update_item($items);
	
	
	return "UPDATE SUCCESS.";
	
}

function Delete($id){
	
	$pro = new ProjectManager();
	$pro->delete_item($id);
	return "DELETE SUCCESS.";
}

?>