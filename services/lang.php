<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../lib/logger.php");
//$_SESSION["lang"] ="en";
if(isset($_GET["lang"])){

	$_SESSION["lang"] = $_GET["lang"];
	//echo "lang=".$_SESSION["lang"];
	log_debug("set lang > " . print_r($_SESSION["lang"],true));
	//header( "location: ../index.html" ); exit(0);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit(0);
}
else
{
	if(!isset($_SESSION["lang"]) && empty($_SESSION["lang"])){
		$_SESSION["lang"] = "th";
	}
} //default language

$result = array("lang"=>$_SESSION["lang"]);

echo json_encode(array("result"=> $result ,"code"=>"0"));


//


?>
