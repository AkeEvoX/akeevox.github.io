<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/SecurityManager.php");


$type = GetParameter("type");
switch($type){
	case "verify" :
		$message = "pass";
		//if not found profile authen
		if(!isset($_SESSION["profile"])){
			$message = "fail";
			$redirect = "login.html";
		}
		//var_dump($_SESSION["profile"]);
		$role = $_SESSION["profile"]->role_name;
		$result = array("message"=>$message,"role"=>$role);
	break;	
	case "logout":
		unset($_SESSION["profile"]);
		$result = "logout success";
		$redirect = "login.html";
	break;
	case "authen":
		$user = GetParameter("username");
		$pass = md5(GetParameter("password"));
		$response = login($user,$pass);
		//var_dump($response);
		$result = $response["message"];
		$redirect = $response["redirect"];
	break;
}

echo json_encode(array("result"=> $result ,"code"=>"0","redirect"=>$redirect));


function login($user,$pass){
	//declare variable
	$redirect = "";
	$result = "";
	$security = new SecurityManager();
	$data = $security->login($user,$pass);
	//default error
	$message = "Sorry !! you cannot login . Please checking username or password is invalid.";
	if($data){

		$profile = $data->fetch_object();
		if($profile != null){
			$_SESSION["profile"] = $profile;
			$redirect = "center.html";
			$message = "success";
		}
	}
	
	$result = array("message"=>$message,"redirect"=>$redirect );
	
	return $result;
}

?>