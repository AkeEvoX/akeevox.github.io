<?php
session_start();
include("../../lib/common.php");
include("../../lib/logger.php");
$base_dir = "../../";
include("../../controller/ProductManager.php");


$type="";
$id="";

$id = GetParameter("id");
$type = GetParameter("type");
$result = "";

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
		$result = Insert($_POST);
		log_debug("Admin Category  > Insert " . print_r($result,true));
	break;
	case "edit":
		$result = Update($_POST);
		log_debug("Admin Category  > Update " . print_r($result,true));
	break;
	case "del":
		$result = Delete($id);
	break;
	case "item":
		$result = get_Items($id);
	break;
	default:
	
	break;
}


echo json_encode(array("result"=> $result ,"code"=>"0"));

/************* function list **************/
function get_list_fetch($lang,$start_fetch,$max_fetch){
	$product = new ProductManager();
	$data = $product->get_fetch_product($lang,$start_fetch,$max_fetch);
	$result = "";
	
	if($data==null) return $result;
	
	
	while($row = $data->fetch_object()){

			$item =  array("id"=>$row->id
						,"category"=>$row->category
						,"title"=>$row->title
		  				,"thumb"=>$row->thumb
						,"active"=>$row->active);

			$result[] = $item;
	}
	return $result;
}

function getOptions($lang){
	
	$product = new ProductManager();
	$data = $product->getMenu($lang);

	if($data){

		while($row = $data->fetch_object()){

			$menu =  array("id"=>$row->id
						,"parent"=>$row->parent
						,"title"=>$row->title
		  				,"link"=>$row->link);

			$result[] = $menu;
		}

	}
	return $result;
}

function get_Items($id){
	
	$product = new ProductManager();
	$data = $product->get_product_info($id);
	
	if($data){
		
			$item = $data->fetch_array();
			$data_attribute = $product->get_attribute_by_product($id);
			
			while($row = $data_attribute->fetch_object()){
				$attr_name = $row->attribute;
				$item[$attr_name] = array("th"=>$row->th,"en"=>$row->en);
			}
			
	}
	
	$result = $item;
	return $result;
}

function Insert($items){
	
	//upload content
	if($_FILES["file_thumbnail"]["name"]!="")
	{
		$filename = "images/products/".$items["cate_id"]."/thumb_". date('Ymd_His') ."_".$_FILES['file_thumbnail']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_thumbnail']['tmp_name'];
		$items["thumb"] = $filename;
		upload_image($source,$distination);
	}
	if($_FILES["file_symbol"]["name"]!="")
	{
		$filename = "images/products/".$items["cate_id"]."/symbol_". date('Ymd_His') ."_".$_FILES['file_symbol']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_symbol']['tmp_name'];
		$items["symbol_file"] = $filename;
		upload_image($source,$distination);
	}
	if($_FILES["file_plan"]["name"]!="")
	{
		$filename = "images/products/".$items["cate_id"]."/plan_". date('Ymd_His') ."_".$_FILES['file_plan']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_plan']['tmp_name'];
		$items["plan"] = $filename;
		upload_image($source,$distination);
	}
	if($_FILES["file_dwg"]["name"]!="")
	{
		$filename = "images/products/".$items["cate_id"]."/dwf_". date('Ymd_His') ."_".$_FILES['file_dwg']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_dwg']['tmp_name'];
		$items["dwg_file"] = $filename;
		upload_image($source,$distination);
	}
	if($_FILES["file_pdf"]["name"]!="")
	{
		$filename = "images/products/".$items["cate_id"]."/pdf_". date('Ymd_His') ."_".$_FILES['file_pdf']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_pdf']['tmp_name'];
		$items["pdf_file"] = $filename;
		upload_image($source,$distination);
	}
	
	$product = new ProductManager();
	$result = $product->insert_product($items);
	
	return "INSERT SUCCESS.";
}

function Update($items){
	
	
	$items["thumb"] = "";
	$items["symbol_file"]="";
	$items["plan"] = "";
	$items["dwg_file"]="";
	$items["pdf_file"]="";
	
	if($_FILES["file_thumbnail"]["name"]!="")
	{
		$filename = "images/products/".$items["cate_id"]."/thumb_". date('Ymd_His') ."_".$_FILES['file_thumbnail']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_thumbnail']['tmp_name'];
		$items["thumb"] = $filename;
		upload_image($source,$distination);
	}
	if($_FILES["file_symbol"]["name"]!="")
	{
		$filename = "images/products/".$items["cate_id"]."/symbol_". date('Ymd_His') ."_".$_FILES['file_symbol']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_symbol']['tmp_name'];
		$items["symbol_file"] = $filename;
		upload_image($source,$distination);
	}
	if($_FILES["file_plan"]["name"]!="")
	{
		$filename = "images/products/".$items["cate_id"]."/plan_". date('Ymd_His') ."_".$_FILES['file_plan']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_plan']['tmp_name'];
		$items["plan"] = $filename;
		upload_image($source,$distination);
	}
	if($_FILES["file_dwg"]["name"]!="")
	{
		$filename = "images/products/".$items["cate_id"]."/dwf_". date('Ymd_His') ."_".$_FILES['file_dwg']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_dwg']['tmp_name'];
		$items["dwg_file"] = $filename;
		upload_image($source,$distination);
	}
	if($_FILES["file_pdf"]["name"]!="")
	{
		$filename = "images/products/".$items["cate_id"]."/pdf_". date('Ymd_His') ."_".$_FILES['file_pdf']['name'];//20010310224010
		$distination =  "../../".$filename;
		$source = $_FILES['file_pdf']['tmp_name'];
		$items["pdf_file"] = $filename;
		upload_image($source,$distination);
	}
	
	
	$product = new ProductManager();
	$result = $product->update_product($items);
	
	return "UPDATE SUCCESS.";
	
}

function Delete($id){
	
	$product = new ProductManager();
	$product->delete_product($id);
	return "DELETE SUCCESS.";
}

?>