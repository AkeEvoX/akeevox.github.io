<?php
session_start();
include("../lib/common.php");
include("../lib/logger.php");
//$base_dir = "../../";
include("../controller/ProductManager.php");

if(isset($_SESSION["lang"]) && !empty($_SESSION["lang"])) {
	$lang = $_SESSION["lang"];
}else {
	$_SESSION["lang"] = $lang;
}

$id = "";

$search = GetParameter("search");
$options = GetParameter("options");
$fetch = GetParameter("fetch");
$max_fetch = GetParameter("limit");

$result = SearchProductList($lang,$search,$options,$fetch,$max_fetch);


//var_dump($result);
log_debug("get product > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));  //return

//*************** function ***************

function SearchProductList($lang,$search_text,$search_fillter,$start_fetch,$max_fetch) {
	try
	{
		
		
//proid,code,name,rough,systems,seat,comsumption,overflow,size,shape,faucet,type,outlet
		$product = new ProductManager();
		$data = $product->search_fetch_product($lang,$search_text,$search_fillter,$start_fetch,$max_fetch);

		$items = null;
		if($data){
			while($row = $data->fetch_object())
			{
				$items[] = array(
					"proid"=>$row->proid
					,"code"=>$row->code
					,"name"=>$row->name
					,"rough"=>$row->rough
					,"systems"=>$row->systems
					,"seat"=>$row->seat
					,"comsumption"=>$row->code
					,"overflow"=>$row->overflow
					,"size"=>$row->size
					,"shape"=>$row->shape
					,"faucet"=>$row->faucet
					,"type"=>$row->type
					,"outlet"=>$row->outlet
					,"category"=>$row->category
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
function search_product($name){
	
	
	
	
}

?>