<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
//$source_globle = "../../";
$base_dir = "../../";
include("../../controller/ProductManager.php");


$type="";
$id="";

if(isset($_GET["type"])) $type = $_GET["type"]; 
if(isset($_POST["type"])) $type = $_POST["type"]; 

if(isset($_GET["id"])) $id = $_GET["id"]; 
//if(isset($_POST["id"])) $id = $_POST["id"]; 

$result = "";

$product = new ProductManager();

switch($type){
	case "list":
		$counter = $_GET["couter"];// count last fetch data
		$max_fetch = $_GET["fetch"];
		$result = get_list_fetch($lang,$counter,$max_fetch);
	break;
	case "option":
		$CATEGORIES = 1;
		$result = getOptions($lang);
		
	break;
	case "add":
		$items["parent"] = $_POST["parent"];
		$items["title_th"] = $_POST["th"];
		$items["title_en"] = $_POST["en"];
		$items["link"] = "category.html";
		//category.html
		//$items["cover"] = $_POST["cover"];
		$result = Insert($items);
		log_debug("Admin Category  > Insert " . print_r($result,true));
	break;
	case "edit":
		$items["id"] = $_POST["id"];
		$items["parent"] = $_POST["parent"];
		$items["title_th"] = $_POST["th"];
		$items["title_en"] = $_POST["en"];
		//$items["cover"] = $_POST["cover"];
		$result = Update($items);
		log_debug("Admin Category  > Update " . print_r($result,true));
	break;
	case "del":
		$items["id"] = $_POST["id"];
		$result = Delete($items);
	break;
	case "item":
		$items["id"] = $id;
		$result = getItems($items);
	break;
	default:
	
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($lang,$start_fetch,$max_fetch){
	$product = new ProductManager();
	$data = $product->get_fetch_category();//$start_fetch,$max_fetch
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			// $menu =  array("id"=>$row->id
						// ,"parent"=>$row->parent
						// ,"title"=>$row->title
		  				// ,"link"=>$row->link);

			$result[] = $row;
	}
	return $result;
}

function getOptions($lang){
	
	$product = new ProductManager();
	$data = $product->getMenu($lang);

	if($data){

		while($row = $data->fetch_object()){

			// $menu =  array("id"=>$row->id
						// ,"parent"=>$row->parent
						// ,"title"=>$row->title
		  				// ,"link"=>$row->link);

			$result[] = $row;
		}

	}
	return $result;
}

function getItems($items){
	
	$product = new ProductManager();
	$data = $product->getProductTypeByID($items["id"]);
	
	if($data){
		
			$row = $data->fetch_object();
			$item =  array("id"=>$row->id
						,"parent"=>$row->parent
						,"title_th"=>$row->title_th
						,"title_en"=>$row->title_en
						,"detail_th"=>$row->detail_th
						,"detail_en"=>$row->detail_en
						,"thumb"=>$row->thumb
		  				,"cover"=>$row->cover);

			$result = $item;
		
	}
	return $result;
}

function Insert($items){
	
	$product = new ProductManager();
	$newid = $product->insert_product_type($items);
	
	//create folder by id product type
	$dir = "../../images/products/".$newid;
	if (!file_exists($dir) && $newid!="0") {
		mkdir($dir, 0777, true);
	}
	
	return "INSERT SUCCESS.";
}

function Update($items){
	
	$product = new ProductManager();
	$result = $product->update_product_type($items);
	return "UPDATE SUCCESS.";
	
}

function Delete($items){
	
	$product = new ProductManager();
	$product->delete_product_type($items["id"]);
	return "DELETE SUCCESS.";
}

?>