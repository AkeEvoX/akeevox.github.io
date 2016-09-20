$(document).ready(function(){
	loaditems();
});

function loaditems(){


var service = 'services/download' ;

	$.ajax({
		url:service,
		type:'GET',
		dataType:'json',
		success:function(data){

			$('#list').html("");
			$.each(data.result,function(i,val){
				setview(val);
			});

		},
		error:function(xhr,status,err){
			alert(err.message);
		}
	});

}

function setview(data)
{
	var row = "<label>"+data.name+"</label>" ;
	row += "<div class='row' >";
	var itemview = "";
	$.each(data.item,function(i,val){
		
//console.log("child="+val.title);
		itemview += "<div class='col-md-4'>" ;
		itemview += "<div class='view second-effect'>";
		itemview += "<img src='"+val.thumbnail+"' style='height:240px;'>"; //#image
		itemview += "<div class='thumbnail-desc'><label>"+val.title+"</label></div>";
		itemview += "<div class='mask'><a href='"+val.link+"' class='info' title='click download'></a></div>";//#hover effect
		itemview += "</div>";
		itemview += "</div>" ;
	});
	
	row += itemview ;
	row += "<a class='btn btn-warning pull-right' href='download_list.html?id="+data.id+"'>More</a>" + "</div><hr />";
	
	console.log(row);
	$('#list').append(row);
}
