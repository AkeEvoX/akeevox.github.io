<?php ob_start(); ?>
<?php require_once('../include/connect.php'); ?>
<?php

$conn = new mysql;

	$province_dest = $_POST["province2"];	
	$location_src = $_POST["location1"];	
	
    if ($_POST["province_data"]!="undefined")
	  $province_dest = $_POST["province_data"];	
	  
    if ($_POST["location1_data"]!="undefined")
	  $location_src = $_POST["location1_data"];	

	$selected = $_POST["location_data"];	

	$text = "<option value=\"\">--Select Location--</option>";

	$sql = "select * from travel_location l
	where l.tlocation_id in ( select tlocation_id_destination from travel_route r
	where r.troute_status = 1 and r.tlocation_id_origin=$location_src
	group by r.tlocation_id_destination)
	and l.tprovince_id=$province_dest ;  ";
		   
	$conn->query($sql);
	while($row = $conn->fetchArray()){
	  if ($selected == $row["tlocation_id"])	
		$text .= "<option value=\"".$row['tlocation_id']."\" selected>".$row['tlocation_name']."</option>";
	  else
		$text .= "<option value=\"".$row['tlocation_id']."\">".$row['tlocation_name']."</option>";
	}
	
	echo $text;
?>
<?php ob_end_flush() ?>