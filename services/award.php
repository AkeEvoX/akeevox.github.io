<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/AwardManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");


$award = new AwardManager();

//$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

$req_id = $_GET["id"];
$item = "";

if(!isset($req_id) && empty($req_id))  //no request id
{
	$item = $award->getListItem($lang);
}
else
{
	$item = $award->getItem($req_id,$lang);
}

$result = null;

while($row = $item->fetch_object()){

	$data = array(
	"id"=>$row->id
	,"title"=>$row->title
	,"thumbnail"=>$row->thumbnail
	,"date"=>$row->update_date
	,"type"=>$row->type
	);
	$result[] = $data;
}

log_debug("get list award > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));

/*
$rows = "";

for($k=0;$k<2;$k++)
{

	$rows .= "<div class='slide' data-blurred='' >\r\n";
	$rows .= "<div class='content' >\r\n";
	
	for($j=0;$j<3;$j++)
	{

		$rows .= "<div class='row' >\r\n";

		for($i=0;$i<4;$i++)
		{
			$rows .= "<div class='col-md-3' ><img src='holder.js/150x150' /></div>\r\n";
		}
		$rows .= "</div >\r\n";
	}
	$rows .= "</div></div>\r\n";
}

echo $rows;
*/
?>

