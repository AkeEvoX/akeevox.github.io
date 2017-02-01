<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
$base_dir = "../../";
include("../../controller/UserManager.php");

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
		log_debug("user  > Insert " . print_r($result,true));
	break;
	case "edit":
		$result = Update($_POST);
		log_debug("user > Update " . print_r($result,true));
	break;
	case "del":
		$result = Delete($id);
	break;
	case "item":
		$result = get_Items($id);
	break;
	default:
	
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($start_fetch,$max_fetch){
	
	$user = new UserManager();
	$data = $user->get_fetch_list($start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$result[] = $row;
	}
	return $result;
	
}

function get_Items($id){
	
	$user = new UserManager();
	$data = $user->get_user_info($id);
	
	if($data){
			$result = $data->fetch_object();
	}
	return $result;
}

function Insert($items){
	
	$user = new UserManager();
	//1)insert data
	$result = $user->insert_item($items);
	
	return "INSERT SUCCESS.";
}

function Update($items){
	
	$user = new UserManager();
	//1)update data
	$result = $user->update_item($items);
	
	return "UPDATE SUCCESS.";
	
}

function Delete($id){
	$user = new UserManager();
	$user->delete_item($id);
	return "DELETE SUCCESS.";
}

?>