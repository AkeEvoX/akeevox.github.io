<?php
session_start();
include("../lib/common.php");
include("../lib/logger.php");
include("../controller/AwardManager.php");


$lang = "th";
if(isset($_SESSION["lang"]) && !empty($_SESSION["lang"])) {
	$lang = $_SESSION["lang"];
}else{
	$lang = "th";
	 $_SESSION["lang"] = $lang;
}

$id = GetParameter("id");
$type = GetParameter("type");
$type_reward = GetParameter("type_reward");
$item = "";



switch($type){
	case "reward" :
		$result = get_item_list($lang,$type_reward);
	break ;
	default :
		$result = get_item($id,$lang);
	break;
}

log_debug("get award data > " . print_r($result,true));
echo json_encode(array("result"=> $result ,"code"=>"0"));

//**************List function ***************
function get_item($id,$lang){
	
	$award = new AwardManager();
	$data =  $award->getItem($id,$lang);
	$items  = $data->fetch_object();
	return $items;	
	
}

function get_item_list($lang,$type_reward){
	
	$award = new AwardManager();
	$data = $award->getListItem($lang,$type_reward);
	$items = null;
	
	if($data){
		while($row = $data->fetch_object()){

			$items[] = array(
			"id"=>$row->id
			,"title"=>$row->title
			,"thumbnail"=>$row->thumbnail
			,"detail"=>$row->detail
			,"date"=>$row->update_date
			,"type"=>$row->type
			,"seq"=>$row->seq
			);
			//$items[] = $data;
		}
	}

	return $items;
}



?>
