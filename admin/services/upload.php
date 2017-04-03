<?php
$sourcePath = $_FILES['file']['tmp_name'];       // Storing source path of the file in a variable
$distination = "upload/".$_FILES['file']['name'];

echo "src=".$sroucePath."<br/>";
echo "dist=".$targetPath."<br/>";
?>