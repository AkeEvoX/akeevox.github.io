<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/SecurityManager.php");

$user = $_POST["username"];
$pass = md5($_POST["password"]);
$security = new SecurityManager();
$result = $security->login($user,$pass);

if($result){

	$profile = $result->fetch_object();
	//$result = var_dump($profile) ." | ";
	if($profile != null){
		$_SESSION["profile"] = $profile;
		$result = "Success";
	}
	else{
		$result = "Error";
	}
	
	
}
else{
	$result = "Sorry !! you cannot login . Please checking username or password is invalid.";
}

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>