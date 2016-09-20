$(document).ready(function(){


	var lang = getParameterByName('lang');
	var label = getParameterByName('label');;
	if(label==undefined)//default thai
	{
		label="Thai";
	}
	$('#lang').html(label+" <span class='caret'></span>");
	
});


/*dropdown menu*/
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});

$(function(){
	$('.tree-toggle').parent().children('ul.tree').toggle(200);
});


function generateMenu(){


	$.ajax({

		url:'services/menu?_=' + new Date().getMilliseconds(),
		type:'GET',
		dataType:'json',
		success:function(data){
			$('#mainmenu').html(data);
		},
		error:function(xhr,status,err){
			alert("generate menu error :"+xhr.responseText);
		}

	});

}
