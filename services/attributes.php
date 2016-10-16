<?php
Session_Start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/AttributeManager.php");
include("../controller/MenuManager.php");
include("../controller/ContactManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");

$lang = "th";
if(isset($_SESSION["lang"]) && !empty($_SESSION["lang"])) {
	$lang = $_SESSION["lang"];
}
else {
	$_SESSION["th"] = $lang;
}

$attrMgr = new AttributeManager();
$result = null;
$type=$_GET["type"];

switch($type)
{
	case "menu":


		$itemattr = $attrMgr->getmenu($lang);
		/*load attribute*/
		while($row = $itemattr->fetch_object())
		{
			$itemdata = array("id"=>$row->id
												,"name"=>$row->name
												,"title"=>$row->title
												,"seq"=>$row->seq);
			$result[$row->name] = $itemdata;
		}

		/*load menu*/

		$menu = new MenuManager();
		$menuresult = $menu->getmenu($lang);

		while($row = $menuresult->fetch_object())
		{
			//menu.sitemap
			$result["menu.sitemap"]["item"] .=  "<a href='".$row->link."'>".$row->name."</a><br/>";
		}

		/*load contact*/

		$contact = new ContactManager();
		$contactresult = $contact->getContact($lang);

		while($row = $contactresult->fetch_object())
		{
			switch ($row->typename)
			{
				case "address" :
					$result["menu.address"]["item"] .= $row->title ."<br/>";
				break;
				case "email" :
					$result["menu.email"]["item"] .= $row->title ."<br/>";
				break;
				case "phone" :
					$result["menu.phone"]["item"] .= $row->title ."<br/>";
				break;
				case "social" :
					$result["menu.social"]["item"] .= "<a href='".$row->link."'><img src='".$row->icon."' /></a>";
				break;
			}
		}

		break;
	case "org" :

		break;
	case "contact" :

		break;
	case "index" :

		$itemattr = $attrMgr->getItems($lang,'index');
		/*load attribute*/
		while($row = $itemattr->fetch_object())
		{
			$result[] = array("name"=>$row->name,"title"=>$row->title);
		}
		break;
	case "award" :
			//echo "go to award\r\n";
			//echo "lang=".$lang."\r\n";
			$itemattr = $attrMgr->getItems($lang,'award');
			/*load attribute*/
			while($row = $itemattr->fetch_object())
			{
				$result[] = array("name"=>$row->name,"title"=>$row->title);
			}

			break;
	case "faq" :
			$itemattr = $attrMgr->getItems($lang,'faq');
			while($row = $itemattr->fetch_object())
			{
				$result[] = array("name"=>$row->name,"title"=>$row->title);
			}
			break;
	case "inter" :
			$itemattr = $attrMgr->getItems($lang,'inter');
			while($row = $itemattr->fetch_object())
			{
				$result[] = array("name"=>$row->name,"title"=>$row->title);
			}
			break;
	case "product" :
			$itemattr = $attrMgr->getItems($lang,'product');
			while($row = $itemattr->fetch_object())
			{
				$result[] = array("name"=>$row->name,"title"=>$row->title);
			}
			break;
	case "productdetail" :
		$itemattr = $attrMgr->getItems($lang,'productdetail');
		while($row = $itemattr->fetch_object())
		{
			$result[] = array("name"=>$row->name,"title"=>$row->title);
		}
	break;
	case "series" :
		$itemattr = $attrMgr->getItems($lang,'series');
		while($row = $itemattr->fetch_object())
		{
			$result[] = array("name"=>$row->name,"title"=>$row->title);
		}
	break;
	case "showroom" :
		$itemattr = $attrMgr->getItems($lang,'showroom');
		while($row = $itemattr->fetch_object())
		{
			$result[] = array("name"=>$row->name,"title"=>$row->title);
		}
	break;
	default :

	break;

}

echo json_encode(array("result"=>$result,"code"=>"0","lang"=>$lang));

?>
