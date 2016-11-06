<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);
/*E_PARSE | E_WARNING | E_NOTICE , E_ALL*/

//$lang="en";

if(!isset($_SESSION["lang"]) or empty($_SESSION["lang"])){
	$_SESSION["lang"] = "en";
	$lang = $_SESSION["lang"];
} 

?>
