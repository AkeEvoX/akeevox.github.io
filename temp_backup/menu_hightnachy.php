
	echo "parent =".$parent."\r\n";
	echo  $result[$parent]["id"]."\r\n";

	//defined item
	$id = $row->id;
	$parent = $row->parent;
	$item = array("id"=>$row->id,"title"=>$row->title);

	if($parent=="0")//keep parent
	{
		$parentArr[$id] = $result[$id] = $item;
		
	}
	else
	{
		$objParent = ''; 
		$find = true;	
		$max = 5;
		while($find)
		{
			echo "check parent " .$parentArr[$parent]["id"]."\r\n";
			$tempParent = $parentArr[$parent];
			if($tempParent["id"]!="")
			{
				echo "found";
				$tempParent["child"][] .= $item;
				$parentArr[$id] = $tempParent;
				$find = false;
			}

			$max-=1;//force exists
			if($max==5) $find = false;
		}

		/*
		$parentId = $parent;
		while($parentArr[$parentId]["parent"]!="0")//find root level
		{
			$parentId = $parentArr[$parentId]["parent"];
		}

		$parentArr[$parentId]["child"][] .= $item;
		*/
		/*
		while($result[$parent]["id"] == $parent )//find parent
		{
			
			$child = $result[$parent]["child"];//find child
			if($child!="")
			{
				while($child[$parent])
				{

				}
			}
			$parentId = $result[$parent]["id"];
		}*/

		//echo "found parent id = " . $parentId;
		//$result[$parentId]["child"][] .= $item;
	}



/*
	if($result[$row->parent]["id"]!="")//skip parent menu
	{
		$item = array("id"=>$row->id
		,"title"=>$row->title);
		$result[$row->parent]["child"][] .= $item ;//add child menu
	}
	else
	{
		$item = array("id"=>$row->id,"title"=>$row->title);
		$result[$row->id] = $item;
	}
*/
