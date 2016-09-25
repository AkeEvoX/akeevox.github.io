$(document).ready(function(){
	loadmenu();
	loadbuttommenu();
	loadchart();
});


function loadchart()
{
	
	$.ajax({
		url:"services/organization",
		data:{"_": new Date().getHours() , "type":"chart"},
		dataType:'json',
		type:"GET",
		success: function(data){
			
			console.log(data.result);
			
			$('#media-data img').attr('src',data.result.chart);
		},
		error : function (xhr,status,err)
		{
			console.error("load organization chart error : " + xhr.responseText);
			alert("load organization chart error : "+ xhr.responseText);
		}
	});
	
}

function loadinfo()
{
	$.ajax({
		url:"services/attributes",
		data:{"_": new Date().getHours() , "type":"chart"},
		dataType:'json',
		type:"GET",
		success: function(data){
			
			console.log(data.result);
			
			$('#media-data img').attr('src',data.result.chart);
		},
		error : function (xhr,status,err)
		{
			console.error("load organization chart error : " + xhr.responseText);
			alert("load organization chart error : "+ xhr.responseText);
		}
	});
	
}
