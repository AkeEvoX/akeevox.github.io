$(document).ready(function(){


/*
	var lang = getParameterByName('lang');
	var label = getParameterByName('label');;
	if(label==undefined)//default thai
	{
		label="Thai";
	}
	$('#lang').html(label+" <span class='caret'></span>");
	*/
	loadmenu();
	loadbuttommenu();
});


/*dropdown menu*/
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});

$(function(){
	$('.tree-toggle').parent().children('ul.tree').toggle(200);
});

