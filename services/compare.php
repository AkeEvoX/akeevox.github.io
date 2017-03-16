<?php
session_start();
include("../lib/common.php");
include("../lib/logger.php");
include("../controller/ProductManager.php");
//$result = $_SESSION['compare'];
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

$type= "";
$id = "";
if(isset($_GET["type"])) $type=$_GET["type"];
if(isset($_GET["id"])) $id=$_GET["id"];

switch($type){
	case "view" :

		$product = new ProductManager();
		
		$result = null;
		if(!isset($_SESSION["compare"])) break;

		foreach($_SESSION["compare"] as $item){

			$info = get_product_info($product->getProduct($lang,$item["id"]));
			$attrs = get_product_attr($product->getAttributes($lang,$item["id"]));
			$colorlist = get_product_color($product->getColor($item["id"]));

			$attrs[] = array('id'=>'addon',"title"=>$colorlist,'label'=>'color');
	    	$result[] = array("info"=>$info,"attrs"=>$attrs);

		}


	break;
	case "remove" :
		$result = null;
		foreach($_SESSION["compare"] as $key => $item){
			
			if($item["id"]==$id){
				unset($_SESSION["compare"][$key]);
			}
			
		}
		
		if(isset($_SESSION["compare"]))
			$result = $_SESSION['compare'];
		
	break;
	default:

		if(isset($id) && !empty($id)){


			if(!validate_compair($id)) 
			{
				$_SESSION['compare'][] = array('id'=>$id,'thumb'=>$_GET['thumb']);	
				//$result = $_SESSION['compare'];
			}
		}	

		$result = null;
		/*default return all */
		if(isset($_SESSION['compare']))
			$result = $_SESSION['compare'];

	break;
}


echo json_encode(array("result"=> $result ,"code"=>0,"validate"=>validate_compair($id)));//validate_compair($id)


/**********function list************/

function validate_compair($id){
	

	if(!isset($_SESSION['compare']) || $_SESSION["compare"]==null)
		return false;
	
	//limit item compair
	if(count((array)$_SESSION['compare']) > 4)
		return false;

	$result = false;
	foreach($_SESSION["compare"] as $item){
		
    	if ($id == $item["id"]) {
    		$result = true;
        	break;
    	}
	}
	return $result;
}

function get_product_info($data){
	$items = "";
	if($data){
	$row = $data->fetch_object();
	$items = array(
			"id"=>$row->id
			,"type"=>$row->typeid
			,"title"=>$row->title
			,"detail"=>$row->detail
			,"thumb"=>$row->thumb
			,"plan"=>$row->plan
			,"code"=>$row->code
			,"name"=>$row->name
			,"doc"=>$row->doc_link
			,"cate"=>$row->catename
			);
	}
	return $items;
}

function get_product_attr($data){
	$item="";
	if($data){
		while($row = $data->fetch_object())
		{
			$item[] = array(
				"id"=>$row->id
				,"title"=>$row->title
				,"label"=>$row->label
				);
		}
	}
	return $item;
}

function get_product_color($data){

	$item="";
	if($data){
		while($row= $data->fetch_object())
		{
			$item.= "<img src='".$row->thumb."' style='height:18px;width:18px;border:0;' />";
		}
	}
	return $item;
}
?>