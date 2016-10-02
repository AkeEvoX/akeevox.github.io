function loadList()
{
	var service = 'services/gallery.php' ;
	var data = {"_": new Date().getMilliseconds()}
	CallService(service,data,setview);
}

function LoadItem(id)
{
	var service = 'services/gallery.php' ;
	var data = {"_": new Date().getMilliseconds(),"id":id}
	CallService(service,data,setviewdetail);
}

function CallService(service,param,callback)
{
	
	$.ajax({
		url:service,
		type:'GET',
		data:param,
		dataType:'json',
		success : callback ,
		error:function(xhr,status,err){
			alert(err.message);
		}
	});
}

function setview(data)
{
	$('#list').html("");
	$.each(data.result,function(i,val){
		
		var itemview = "";
		itemview += "<a class='item' href='#' ><img src='"+val.thumbnail+"' class='img-responsive' /></a>";
		
		$('#list').append(itemview);
	});
	
	 $('.photoGrid').photoGrid({rowHeight:"250"});

}
