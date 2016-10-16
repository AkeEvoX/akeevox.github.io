<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../lib/logger.php");
//$_SESSION["lang"] ="en";
if(isset($_GET["lang"])){
	
	$_SESSION["lang"] = $_GET["lang"];
	//echo "lang=".$_SESSION["lang"];
	log_debug("set lang > " . print_r($_SESSION["lang"],true));
}
else { $_SESSION["lang"] = "th"; } //default language
//echo "language = ".$_SESSION["lang"];

header( "location: ../index.html" ); exit(0); 


?>