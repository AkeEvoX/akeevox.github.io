<?php
session_start();
include("../lib/common.php");
include("../lib/logger.php");
include("../controller/AwardManager.php");

$award = new AwardManager();

//$lang = "th";
if(isset($_SESSION["lang"]) && !empty($_SESSION["lang"])) {
	$lang = $_SESSION["lang"];
}else{
	$lang = "th";
	 $_SESSION["lang"] = $lang;
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
if($item){
	while($row = $item->fetch_object()){

		$data = array(
		"id"=>$row->id
		,"title"=>$row->title
		,"thumbnail"=>$row->thumbnail
		,"detail"=>$row->detail
		,"date"=>$row->update_date
		,"type"=>$row->type
		);
		$result[] = $data;
	}
}
log_debug("get list award > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));

?>
