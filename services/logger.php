<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../lib/logger.php");
if(isset($_POST["lang"])){
	$_POST["type"]
	switch($_["type"])
	{
		case 'info': log_info($_POST["msg"]); break;
		case 'error': log_error($_POST["msg"]); break;
		case 'warn': log_warning($_POST["msg"]); break;
		case 'debug': log_debug($_POST["msg"]); break;

	}
}


?>