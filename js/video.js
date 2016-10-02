
function loadList()
{
	var service = 'services/video.php' ;
	var data = {"_": new Date().getMilliseconds()}
	CallService(service,data,setview);
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
	setdefaultview(data.result[0]);//default first video
	$.each(data.result,function(i,val){
		
		var itemview = "";
		itemview += "<li data-link='"+val.link+"' >";
		itemview += "<img src='"+val.thumbnail+"' class='img-responsive' />";
		itemview += "<div class='lightslider-desc' >";
		itemview += "<label>"+val.title+"</label>";
		itemview += "</div>";
		itemview += "</li>";
		
		$('#list').append(itemview);
	});

	$("#list").lightSlider({
		autoWidth: false
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:true
	 });
	 
	 
	$('#list').find('li').click(function(){

	var link = $(this).attr('data-link');
	var title = $(this).children().find('label').text();
	if(link != undefined){ 
		//var url = link.replace("watch?v=", "v/");
		$('#title').text(title);
		$('#mediaplayer').attr('src',link);
	}	
});
}

function setdefaultview(item){
	$('#title').text(item.title);
	$('#mediaplayer').attr('src',item.link);
}
