function loadList()
{
	var endpoint = 'services/press.php' ;
	var method = 'get';
	var args = {"_": new Date().getMilliseconds()};
	utility.service(endpoint,method,args,setview);
}

function LoadItem(id)
{
	var endpoint = 'services/press.php' ;
	var method = 'get';
	var args = {"_": new Date().getMilliseconds(),"id":id};
	utility.service(endpoint,method,args,setviewdetail);
}

function loadslidepress()
{
	var endpoint  = "services/press.php";
	var method = "get";
	var args = {'_':new Date().getHours(),'type':'slide'} ;
	
	utility.service(endpoint,method,args,setviewslide,indexlightSlider);
	
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

function setviewslide(data){
	console.log(data);
	$('#itemslide').html("");
	$.each(data.result,function(i,val){
		
		var itemview = "";
		itemview += "<li >";
		itemview += "<a href='press_detail.html?id="+val.id+"'>";
		itemview += "<img src='"+val.thumbnail+"' class='img-fluid' style='max-width:100%' />";//responsive
		itemview += "<div class='lightslider-desc' >";
		itemview += "<label>"+val.title+"</label>";
		itemview += "</div>";
		itemview += "</a>";
		itemview += "</li>";
		
		$('#itemslide').append(itemview);
		
	});

}

/*function for slide */
function indexlightSlider() {
	
		$("#itemslide").lightSlider({
		autoWidth: false
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:false
		,item:2
	 });
	 
	 /*
	 		,slideMargin:4
		,slideWidth:200
	 */
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
		itemview += "<div class='media-body'><a href='press_detail.html?id="+val.id+"' style='text-decoration: none;'  >";//
			itemview += "<h4 class='media-heading'>"+val.title+"</br><small>Date :"+val.date+"</small></h4>"; //#title
			itemview += "<div class='media-detail'>"+val.detail+"</div>";//#detail
			itemview += "<span class='badge'><span id='press.read' style='color:white;'></span></span>";//#read more.
		itemview += "</a></div>";//media-body
		itemview += "</div>";//media
		itemview += "</div>" ; //column

		console.log(itemview);
		$('#list').append(itemview);
	});

}

function setviewdetail(data)
{
	console.log(data);
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
