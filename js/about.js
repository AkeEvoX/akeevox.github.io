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
	loadabout();
});


function loadabout()
{
	
	$.ajax({
		url:"services/about",
		data:{"_": new Date().getHours() },
		dataType:'json',
		type:"GET",
		success: function(data){
			
			console.log(data.result);
			//console.warn()
			$('#title-data').html(data.result.title);
			$('#media-data').html(data.result.media);
			$('#content-data').html(data.result.detail);
		},
		error : function (xhr,status,err)
		{
			console.err(xhr.responseText);
			alert("load about information error : "+ xhr.responseText);
		}
	});
	
}