function loadList()
{
	var service = 'services/faq.php' ;
	var data = {"_": new Date().getMilliseconds(),"type":"list"}
	CallService(service,data,setview);
}

function loadItem(id)
{
	var service = 'services/faq.php' ;
	var data = {"_": new Date().getMilliseconds(),"id":id}
	CallService(service,data,setviewdetail);
}

function loadmostview()
{
	var service = 'services/faq.php' ;
	var data = {"_": new Date().getMilliseconds(),"type":"most"}
	CallService(service,data,setmostview);
}

function loadrecentview()
{
	var service = 'services/faq.php' ;
	var data = {"_": new Date().getMilliseconds(),"type":"recent"}
	CallService(service,data,setrecentview);
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

function setpage(){

	var args = {'_':new Date().getHours(),'type':'faq'};
	utility.service('services/attributes.php','GET',args
	,function(response){
		console.warn(response);
		if(response!==undefined)
		{
			console.info('found.');
			$.each(response.result,function(i,val){
				$("span[id='"+val.name+"']").text(val.title);
			});
		}
		else { console.warn('not found.'); }
	}
	,null);

}

function setview(data)
{
	$('#list').html("");
	$.each(data.result,function(i,val){

		var itemview = "";
		itemview += "<div class='row col-md-8'>";
		itemview += "<h4>"+val.title+"</h4>";
		itemview += "<label>"+val.date+"</label>";
		itemview += "<img src='"+val.thumbnail+"' class='img-responsive' />";
		itemview += "<span>"+val.detail+"</span>";
		itemview += "<br/><a class='btn btn-warning' href='#'>VIEW</a>";
		itemview += "</div >";
		$('#list').append(itemview);
	});

}

function setmostview(data)
{
	$('#mostview').html("");
	$.each(data.result,function(i,val){

		var itemview = "";
		itemview += "<div class='row'>";
		itemview += "<div class='media'>";
		itemview += "<div class='media-left'><a href='faq_detail?id="+val.id+"' ><img src='"+val.thumbnail+"' style='width:150px;' class='media-object' /></a></div>";
		itemview += "<div class='media-body'>";
		itemview += "<h4 class='media-heading'>"+val.date+"</h4>";
		itemview += val.title + "</div >";//media-body
		itemview += "</div >";//media
		itemview += "<hr/></div >";//row

		$('#mostview').append(itemview);
	});
}

function setrecentview(data)
{
	$('#recent').html("");
	$.each(data.result,function(i,val){

		var itemview = "";
		itemview += "<div class='row'>";
		itemview += "<div class='media'>";
		itemview += "<div class='media-left'><a href='faq_detail?id="+val.id+"' ><img src='"+val.thumbnail+"' style='width:150px;' class='media-object' /></a></div>";
		itemview += "<div class='media-body'>";
		itemview += "<h4 class='media-heading'>"+val.date+"</h4>";
		itemview += val.title + "</div >";//media-body
		itemview += "</div >";//media
		itemview += "<hr/></div >";//row
		$('#recent').append(itemview);
	});
}
