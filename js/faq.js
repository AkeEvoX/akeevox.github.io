function loadList()
{
	var service = 'services/faq.php' ;
	var data = {"_": new Date().getMilliseconds(),"type":"list"}
	CallService(service,data,setview);
}

function LoadItem(id)
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
		itemview += "<br/><a class='btn btn-warning' href='faq_detail.html?id="+val.id+"'><span id='faq.btnView'>VIEW<span></a>";
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
		itemview += "<div class='media-left'><a href='faq_detail.html?id="+val.id+"' ><img src='"+val.thumbnail+"' style='width:150px;' class='media-object' /></a></div>";
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
		itemview += "<div class='media-left'><a href='faq_detail.html?id="+val.id+"' ><img src='"+val.thumbnail+"' style='width:150px;' class='media-object' /></a></div>";
		itemview += "<div class='media-body'>";
		itemview += "<h4 class='media-heading'>"+val.date+"</h4>";
		itemview += val.title + "</div >";//media-body
		itemview += "</div >";//media
		itemview += "<hr/></div >";//row
		$('#recent').append(itemview);
	});
}

function setviewdetail(data)
{
	//console.log(data);
	$('#list').html("");
	var itemview = "";
	var detail
	var faq = data.result[0];

	
	$('span[id="faqdetail"]').text(faq.title);
	itemview += "<div class='col-md-12'>";
	itemview += "<h4 class='media-heading orange' >"+faq.title+"</h4>";
	itemview += "<img src='"+faq.thumbnail+"' class='img-responsive' />"; //1240x500
	itemview += "<div class='media-body' >"+faq.detail+"</div>"; //detail new
	itemview += "</div >"; //column
	//previous and next
	//itemview +=  "</br><div style='text-align:center;'><a href='press_detail.html?id="+(parseInt(press.id)-1)+"' class='btn btn-warning'>Previous</a> <a href='press_detail.html?id="+(parseInt(press.id)+1)+"' class='btn btn-warning'>Next</a></div>" ;

$('#list').append(itemview);
}