function loadList()
{
	var service = 'services/press.php' ;
	var data = {"_": new Date().getMilliseconds()}
	CallService(service,data,setview);
}

function LoadItem(id)
{
	var service = 'services/press.php' ;
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
		itemview += "<div class='col-md-6'>" ;
		itemview += "<div class='media'>";
		itemview += "<div class='media-left'>";
		itemview += "<div class='view second-effect'><img src='"+val.thumbnail+"' class='media-object' />";
		itemview += "<div class='mask'><a href='press_detail.html?id="+val.id+"' class='info' title='view detail'></a></div>";//#hover effect
		itemview += "</div>";//view
		itemview += "</div>";//media-left
		itemview += "<div class='media-body'>";//
			itemview += "<h4 class='media-heading'>"+val.title+"</br><small>Date :"+val.date+"</small></h4>"; //#title
			itemview += "<div class='media-detail'>"+val.detail+"</div>";//#detail
			itemview += "<span class='badge'><a href='press_detail.html?id="+val.id+"' style='color:white;'  ><span id='press.read'></span></a></span>";//#read more.
		itemview += "</div>";//media-body
		itemview += "</div>";//media
		itemview += "</div>" ; //column

		console.log(itemview);
		$('#list').append(itemview);
	});

}

function setviewdetail(data)
{
	$('#list').html("");
	var itemview = "";
	var press = data.result[0];
	$('span[id="pressdetail"]').text(press.title);
	itemview += "<div class='col-md-12'>";
	itemview += "<h4 class='media-heading' style='color:orange'>"+press.title+"</h4>";
	itemview += "<img src='"+press.coverpage+"' class='img-responsive' />"; //1240x500
	itemview += "<div class='media-body' >"+press.detail+"</div>"; //detail new
	itemview += "</div >"; //column
	//previous and next
	//itemview +=  "</br><div style='text-align:center;'><a href='press_detail.html?id="+(parseInt(press.id)-1)+"' class='btn btn-warning'>Previous</a> <a href='press_detail.html?id="+(parseInt(press.id)+1)+"' class='btn btn-warning'>Next</a></div>" ;

$('#list').append(itemview);
}
