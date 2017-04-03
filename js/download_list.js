function loaditems(id){

	var endpoint = 'services/download.php';
	var method ='GET';
	var args = {'_':new Date().getHours(),'id':id};

	utility.service(endpoint,method,args,setview);

}

function setview(data)
{
	$('#list').html("");
	$.each(data.result,function(i,val){
		
		$("span[id='download.submenu']").html(val.name);
		var row = "<h4><span class='glyphicon glyphicon-stop'><span>&nbsp;"+val.name+"</span></h4>" ;
		row += "<div class='row' >";
		var itemview = "";
		$.each(val.item,function(childid,childval){
			itemview += "<div class='col-md-4'>" ;
			itemview += "<div class='view second-effect'>";
			itemview += "<img src='"+childval.thumbnail+"' style='height:240px;'>"; //#image
			itemview += "<div class='thumbnail-desc' style='min-height:50px;'><label>"+childval.title+"</label></div>";
			itemview += "<div class='mask'><a href='"+childval.link+"' target='_blank' class='info' title='click download'></a></div>";//#hover effect
			itemview += "</div>";
			itemview += "</div>" ;
		});

		row += itemview +"</div>";
		$('#list').append(row);
	});

}
