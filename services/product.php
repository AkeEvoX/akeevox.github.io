<?php
session_start();
include("../lib/common.php");
include("../lib/logger.php");
//$base_dir = "../../";
include("../controller/ProductManager.php");

// if(isset($_SESSION["lang"]) && !empty($_SESSION["lang"])) {
	// $lang = $_SESSION["lang"];
// }else {
	// $_SESSION["lang"] = $lang;
// }

if(isset($_GET["type"])) $type = $_GET["type"]; else $type="";
if(isset($_GET["cate"])) $cate = $_GET["cate"]; else $cate="";
if(isset($_GET["id"])) $id = $_GET["id"] ; else $id="";

switch($type)
{
	case "list" :
		//echo "call list product";
		$result = setProductList($lang,$cate);
	break;
	case "related":

		//call category
		//echo "pro = ".$id;
		$prod = setProduct($lang,$id);
		$cate = $prod["type"];
		$result = setProductRelated($lang,$cate,$id);


	break;
	case "item" :
		$result = setProduct($lang,$id);
	break;
	case "attr":
		$result = setAttribute($lang,$id);
	break;
	case "category":
		$result = setCategory($lang,$id);
	break;
	case "series":
		$result = setSeriesInfo($lang,$id);
	break;
	case "list_series":
		$result = setListSeries($lang,$id);
	break;
	case "showroom":
		$result = setShowRoom($lang,$id);
	break;
	case "list_room":
		$result = setListShowRoom($lang,$id);
	break;
	
	case "menu":
		//echo "route to menu ";
		$result = setMenu($lang);
	break;
	case "info":
		$result = setProductType($lang,$id);
	break;

}
//var_dump($result);
log_debug("get product > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));  //return

//*************** function ***************

function setProductList($lang,$cate) {
	try
	{
		if($cate=="") $cate=5;

		$product = new ProductManager();
		$data = $product->getProductList($lang,$cate);

		$items = null;
		if($data){
			while($row = $data->fetch_object())
			{
				$items[] = array(
					"id"=>$row->id
					,"title"=>$row->title
					,"detail"=>$row->detail
					,"thumb"=>$row->thumb
					,"image"=>$row->image
					,"plan"=>$row->plan
					,"code"=>$row->code
					,"name"=>$row->name
					);
			}
		}
		return $items;
	}
	catch(Exception $e)
	{
		echo "Cannot Get Product List : ".$e->getMessage();
	}
}

//fix series top
function setSeriesInfo($lang,$id) {
	try
	{

		$product = new ProductManager();

		//set id default if is null

		if(empty($id))
		{
			$data=$product->getSeriesDefault($lang);
			$row = $data->fetch_object();
			$id = $row->id;
		}
		//call infor by type series
		$data = $product->getProductType($lang,$id);
		$row = $data->fetch_object();
			$items = array(
				"id"=>$row->id
				,"title"=>$row->title
				,"detail"=>$row->detail
				,"thumb"=>$row->thumb
				,"cover"=>$row->cover
				);
		return $items;
	}
	catch(Exception $e)
	{
		echo "Cannot Get Series : ".$e->getMessage();
	}

}

function setListSeries($lang,$id){
	try
	{
		$product = new ProductManager();
		$data = $product->getSeriestList($lang,$id);
		$items = null;
		if($data){
			while($row = $data->fetch_object())
			{
				$items[] = array(
					"id"=>$row->id
					,"title"=>$row->title
					,"typeid"=>$row->typeid
					,"thumb"=>$row->thumb
					,"plan"=>$row->plan
					,"pro_id"=>$row->pro_id
					,"code"=>$row->code
					,"name"=>$row->name
					);
			}
		}
		return $items;
	}
	catch(Exception $e)
	{
		echo "Cannot Get Series List : ".$e->getMessage();
	}
}

function setShowRoom($lang,$id) {
	try
	{

		$product = new ProductManager();

		//call infor by type series
		$data = $product->getProductType($lang,$id);
		$row = $data->fetch_object();
			$items = array(
				"id"=>$row->id
				,"title"=>$row->title
				,"detail"=>$row->detail
				,"thumb"=>$row->thumb
				,"cover"=>$row->cover
				);
		return $items;
	}
	catch(Exception $e)
	{
		echo "Cannot Get Showroom  : ".$e->getMessage();
	}

}

function setListShowRoom($lang,$id){
	try
	{
		$product = new ProductManager();
		$data = $product->getShowRoomList($lang,$id);
		$items = null;
		if($data){
			while($row = $data->fetch_object())
			{
				$items[] = array(
					"id"=>$row->id
					,"title"=>$row->title
					,"typeid"=>$row->typeid
					,"thumb"=>$row->thumb
					,"plan"=>$row->plan
					,"pro_id"=>$row->pro_id
					,"code"=>$row->code
					,"name"=>$row->name
					);
			}
		}
		return $items;
	}
	catch(Exception $e)
	{
		echo "Cannot Get ShowRoom List : ".$e->getMessage();
	}
}

function setProductRelated($lang,$cate,$id) {
	//echo "cate = ".$cate;
	$product = new ProductManager();
	$data = $product->getProductReleated($lang,$cate,$id);

	$items = null;
	if($data){
		while($row = $data->fetch_object())
		{
			$attrs = setAttribute($lang,$row->id);
			$items[] = array(
				"id"=>$row->id
				,"title"=>$row->title
				,"detail"=>$row->detail
				,"thumb"=>$row->thumb
				,"image"=>$row->image
				,"plan"=>$row->plan
				,"code"=>$row->code
				,"name"=>$row->name
				,"attributes"=>$attrs
				);
		}
	}
	return $items;
}

function setProduct($lang,$id) {
	$product = new ProductManager();
	$data = $product->getProduct($lang,$id);

	$items = null;
	if($data){
	$row = $data->fetch_object();
	$items = array(
			"id"=>$row->id
			,"type"=>$row->typeid
			,"title"=>$row->title
			,"detail"=>$row->detail
			,"thumb"=>$row->thumb
			,"images"=>setImages($id)
			,"plan"=>$row->plan
			,"code"=>$row->code
			,"name"=>$row->name
			,"pdf_file"=>$row->pdf_file
			,"dwg_file"=>$row->dwg_file
			,"symbols"=>set_product_symbol($id)
			,"colors"=>setColor($id)
			//load symbol
			);
	}
	return $items;
}

function setProductType($lang,$id)
{
	$product = new ProductManager();
	$data = $product->getProductType($lang,$id);
//id,title_".$lang." as title ,detail_".$lang." as detail,thumb,cover
	$items = array();
	if($data){
	$row = $data->fetch_object();
	//$id = ["id"];
	$items = array(
			"id"=>$row->id
			,"title"=>$row->title
			,"detail"=>$row->detail
			,"thumb"=>$row->thumb
			,"cover"=>$row->cover
			);
	}
	return $items;
}

function setColor($id){
	$product = new ProductManager();
	$data = $product->getColor($id);
	$item = "";
	if($data){
		while($row= $data->fetch_object())
		{
			$item[] = array(
				"color"=>$row->thumb
				);
		}
	}
	return $item;
}

function set_product_symbol($id){
	$product = new ProductManager();
	$data = $product->get_product_symbol($id);
	$item = "";
	if($data){
		while($row= $data->fetch_object())
		{
			$item[] = array(
				"path"=>$row->path
				);
		}
	}
	return $item;
}


function setImages($id) {
	
	$product = new ProductManager();
	$data = $product->getImages($id);
	$item = "";
	if($data){
		while($row= $data->fetch_object())
		{
			$item[] = array(
				"id"=>$row->id
				,"thumb"=>$row->thumb
				,"image"=>$row->image
				);
		}
	}
	return $item;
}

function setAttribute($lang,$id) {

	$product = new ProductManager();
	$data = $product->getAttributes($lang,$id);
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

function setMenu($lang){

	$product = new ProductManager();
	$data = $product->getMenu($lang);
	if($data){

		while($row = $data->fetch_object()){

			$menu =  array("id"=>$row->id
						,"parent"=>$row->parent
						,"title"=>$row->title
		  				,"link"=>$row->link
		  				,"seq"=>$row->seq
		  				);

			$result[] = $menu;
		}

	}

	return $result;
}
	
function setchildmenu($item,$data)
{
	//if($data)
}

//move array with key
function movearray($arrs,$from,$to){
	$out = array_splice($arrs,$from,1);
	array_splice($arrs,$to,0,$out);
	return $arrs;
}
?>