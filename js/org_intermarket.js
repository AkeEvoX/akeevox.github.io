$(document).ready(function(){
	utility.setpage('intermarket');
	utility.loadmenu();
	utility.loadbuttommenu();
	loadview();
});


function loadview()
{

	$.ajax({
		url:"services/organization.php",
		data:{"_": new Date().getHours() , "type":"inter"},
		dataType:'json',
		type:"GET",
		success: function(data){

			console.log(data.result);

			$('#media-data img').attr('src',data.result.chart);
		},
		error : function (xhr,status,err)
		{
			console.error("load organization inter market error : " + xhr.responseText);
			alert("load organization  inter market error : "+ xhr.responseText);
		}
	});

}

function loadinfo()
{
	$.ajax({
		url:"services/attributes.php",
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
