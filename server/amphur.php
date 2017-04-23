<?php ob_start(); ?>
<?php require_once('../include/connect.php'); ?>
<?php

$conn = new mysql;
	if ($_POST){
		$id = $_POST["province"];	
		$amphur = $_POST["amphur"];	

		$where = " where province_id = '$id'";
	}
	
	$text = "<option value=\"\">--Select Amphur--</option>";

	$sql = "select * from amphur 
			 $where
			order by amphur_name
		   ";
	$conn->query($sql);
	while($row = $conn->fetchArray()){
	  if ($amphur==$row['amphur_id'])	
		$text .= "<option value=\"".$row['amphur_id']."\" selected>".$row['amphur_name_eng']."</option>";
	  else
		$text .= "<option value=\"".$row['amphur_id']."\">".$row['amphur_name_eng']."</option>";
	}
	
	echo $text;
?>
<?php ob_end_flush() ?>