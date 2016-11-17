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

function loadcountry(){
	
	var endpoint = "services/organization.php";
	var method = "GET";
	var args = {"_": new Date().getHours() , "type":"country"} ;
	
	utility.service(endpoint,method,args,showcountry);
}


function showcountry(resp){
	
	console.log(resp);
if(resp.result!=undefined){
	var view = $('#content-data');
	$.each(resp.result,function(id,val){
		
		var item = val.title+"<br/>";
		view.append(item);
		
	});
}
	
}