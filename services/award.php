<?php


$rows = "";

for($k=0;$k<2;$k++)
{

	$rows .= "<div class='slide' data-blurred='' >\r\n";
	$rows .= "<div class='content' >\r\n";
	
	for($j=0;$j<3;$j++)
	{

		$rows .= "<div class='row' >\r\n";

		for($i=0;$i<4;$i++)
		{
			$rows .= "<div class='col-md-3' ><img src='holder.js/150x150' /></div>\r\n";
		}
		$rows .= "</div >\r\n";
	}
	$rows .= "</div></div>\r\n";
}



echo $rows;

?>

