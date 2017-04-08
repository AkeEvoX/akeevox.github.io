<?php
Session_Start();
include("../lib/common.php");
include("../lib/logger.php");
include("../controller/AttributeManager.php");
include("../controller/ContactManager.php");

/*
if(isset($_SESSION["lang"]) && !empty($_SESSION["lang"])) {
	$lang = $_SESSION["lang"];
}*/

$attrMgr = new AttributeManager();
$result = null;
$type=$_GET["type"];
$opton = "";
if(isset($_GET["option"])) $option=$_GET["option"];
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
		
		/*
		$itemattr = $attrMgr->getItems($lang,$type);
		*/
		//$itemattr = null;
		$itemattr = $attrMgr->getattrs($lang,'sitemap');
		
		//$menu = new MenuManager();
		//$menuresult = $menu->getparentmenu($lang);
		$result["menu.sitemap"]["item"] = "";
		while($row = $itemattr->fetch_object())
		{
			//menu.sitemap
			$result["menu.sitemap"]["item"] .=  "<a href='".$row->options."'>".$row->title."</a><br/>";
		}
		
		/*load contact*/

		$contact = new ContactManager();
		$contactresult = $contact->getContact($lang);
		$result["menu.address"]["item"] = "";
		$result["menu.email"]["item"] = "";
		$result["menu.phone"]["item"] = "";
		$result["menu.social"]["item"] = "";
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
					$result["menu.social"]["item"] .= "<a href='".$row->link."'><img src='".$row->icon."' style='padding-right:5px;'/></a>";
				break;
			}
		}

		break;
	case "index" :

		$itemattr = $attrMgr->getItems($lang,'index');
		/*load attribute*/
		while($row = $itemattr->fetch_object())
		{
			$result[] = array("name"=>$row->name,"value"=>$row->title);
		}
		break;
	case "award" :
			//echo "go to award\r\n";
			//echo "lang=".$lang."\r\n";
			$itemattr = $attrMgr->getItems($lang,'award');
			/*load attribute*/
			while($row = $itemattr->fetch_object())
			{
				$result[] = array("name"=>$row->name,"value"=>$row->title);
			}

			break;
	case "faq" :
			$itemattr = $attrMgr->getItems($lang,'faq');
			while($row = $itemattr->fetch_object())
			{
				$result[] = array("name"=>$row->name,"value"=>$row->title);
			}
			break;
	case "inter" :
			$itemattr = $attrMgr->getItems($lang,'inter');
			while($row = $itemattr->fetch_object())
			{
				$result[] = array("name"=>$row->name,"value"=>$row->title);
			}
			break;
	case "product" :
			$itemattr = $attrMgr->getItems($lang,'product');
			while($row = $itemattr->fetch_object())
			{
				$result[] = array("name"=>$row->name,"value"=>$row->title);
			}
			break;
	case "productdetail" :
		$itemattr = $attrMgr->getItems($lang,'productdetail');
		while($row = $itemattr->fetch_object())
		{
			$result[] = array("name"=>$row->name,"value"=>$row->title);
		}
	break;
	case "series" :
		$itemattr = $attrMgr->getItems($lang,'series');
		while($row = $itemattr->fetch_object())
		{
			$result[] = array("name"=>$row->name,"value"=>$row->title);
		}
	break;
	case "showroom" :
		$itemattr = $attrMgr->getItems($lang,'showroom');
		while($row = $itemattr->fetch_object())
		{
			$result[] = array("name"=>$row->name,"value"=>$row->title);
		}
	break;
	case "other" :
		$itemattr = $attrMgr->getattrs($lang,$option);
		while($row = $itemattr->fetch_object())
		{
			$result[] = array("name"=>$row->name,"value"=>$row->title,"option"=>$row->options);
		}
	break;
	default :

	$itemattr = $attrMgr->getItems($lang,$type);
	while($row = $itemattr->fetch_object())
	{
		$result[] = array("name"=>$row->name,"value"=>$row->title);
	}


	break;

}

echo json_encode(array("result"=>$result,"code"=>"0","lang"=>$lang));

?>
