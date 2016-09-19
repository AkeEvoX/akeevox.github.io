<?php
Session_Start();
//header("Content-Type: application/json;  charset=UTF8");
include("controllers/ManuManager.php");

//#Declare variable
//protected $menu;

$menu = new MenuManager();
/*
//$menu->setlang();
$data = $menu->getList();

//array_filter(array,callbackfunction);

//$_SESSION["lang"]='TH';


$result = array();
$item = array();

//#   menuid,parent,url,icon,name

while($row = $data->fetch_assoc())
{

	$result.="<li>".$row["name"]."</li>";
	
	//$custid = $row["custid"];
	//$fullname = $row["firstname"] .' '.$row["lastname"] ;
	//$mobile = $row["mobile"] ;
	//$item[] = array("id"=>$custid,"name"=>$fullname,"mobile"=>$mobile);
}
	*/

echo "<li>hello</li>";
//$result = array("result"=>json_encode($item));

//echo json_encode($result);

/*
1.get current lang
2.get menu by lang
*/



?>