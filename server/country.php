<?php ob_start(); ?>
<?php require_once('../include/connect.php'); ?>
<?php

$conn = new mysql;

	if ($_POST){
		$id = $_POST["mem_contact_province"];	
		$where = " and province_id = '$id'";
	}
	
	$text = "<option value=\"\">--Select Location--</option>";

	$sql = "select * from province 
			where mem_contact_province = $id
			 $where
			order by province_name
		   ";
	$conn->query($sql);
	while($row = $conn->fetchArray()){
		$text .= "<option value=\"".$row['province_id']."\">".$row['province_name']."</option>";
	}
	
	echo $text;
?>
<?php ob_end_flush() ?>