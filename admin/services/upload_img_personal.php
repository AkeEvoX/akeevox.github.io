<?php
include("../../lib/common.php");
include("../../lib/logger.php");
include("../../controller/OrgManager.php");

$id=$_POST["id"];
$filename = $_FILES['file_upload']['name'];
$source = $_FILES['file_upload']['tmp_name'];       // Storing source path of the file in a variable
$distination = "../images/personal/".$filename;
move_uploaded_file($source,$distination) ;

//echo "src=".$srouce."<br/>";
//echo "dist=".$distination."<br/>";

?>