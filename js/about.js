
function loadabout()
{
var endpoint = "services/about.php";
var method = "GET";
var args = {"_": new Date().getHours() } ;

utility.service(endpoint,method,args,setabout,null);
/*
	$.ajax({
		url:"services/about.php",
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
*/
}

function setabout(resp)
{
	$('#title-data').html(resp.result.title);
	$('#media-data').html(resp.result.media);
	$('#content-data').html(resp.result.detail);
}
