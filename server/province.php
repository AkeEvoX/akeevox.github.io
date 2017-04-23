<?php ob_start(); ?>
<?php require_once('../include/connect.php'); ?>
<?php

$conn = new mysql;

	if ($_POST){
		$location1 = $_POST["location1"];	
		$condition = " and p.tprovince_id = '$id'";
	}
	
	if ($_GET){
		$selected = $_GET["province1"];	
	}
	
	$text = "<option value=\"\">--Filter by Province--</option>";
/*
	$sql = "select * from travel_province 
			where tprovince_status = 1
			 $where
			order by tprovince_name
		   ";
		   */
		   
		   $sql  ="
		   select * from travel_province p
		   where p.tprovince_id in  ( select tprovince_id from travel_location 
		   where tlocation_id in ( select tlocation_id_origin from travel_route
		   where troute_status = 1
		   group by tlocation_id_origin ))
		   
		   ";
		   /*
	select * from travel_province 
where tprovince_id in  ( select tprovince_id from travel_location 
where tlocation_id in ( select tlocation_id_origin from travel_route
where troute_status = 1
group by tlocation_id_origin
)) 	   
*/
		   
	$conn->query($sql);
	while($row = $conn->fetchArray()){
	  if ($selected == $row["tprovince_id"])
		$text .= "<option value=\"".$row['tprovince_id']."\" selected>".$row['tprovince_name']."</option>";
	  else
		$text .= "<option value=\"".$row['tprovince_id']."\">".$row['tprovince_name']."</option>";
	}
	
	echo $text;
?>
<?php ob_end_flush() ?>