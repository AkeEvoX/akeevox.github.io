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
	
});


/*dropdown menu*/
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});

$(function(){
	$('.tree-toggle').parent().children('ul.tree').toggle(200);
});


function loadmenu(){

	$.ajax({

		url:'services/menu?_=' + new Date().getMilliseconds(),
		type:'GET',
		dataType:'json',
		success:function(data){
			console.log(data);
			//$('#mainmenu').html(data);
		},
		error:function(xhr,status,err){
			alert("generate menu error :"+xhr.responseText);
		}

	});

}

function loadsubmenu(id)
{

	$.ajax({

		url:'services/menu?_=' + new Date().getMilliseconds(),
		type:'GET',
		data: {"id":id} ,
		dataType:'json' ,
		success:function(data){
			
			console.log(data);
			/*
			$('#'+id).html(data);
			$('#mainmenu').html(data);
			*/
		},
		error:function(xhr,status,err){
			alert("generate child menu error :"+xhr.responseText);
		}

	});
}