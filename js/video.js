
function loadList()
{
	var service = 'services/video.php' ;
	var method='GET';
	var args = {"_": new Date().getMilliseconds()}
	//CallService(service,args,setview);
	utility.service(service,method,args,setview,settinglightSlider)
	
}

function loadvideomain(){
	
	var service = 'services/video.php' ;
	var method='GET';
	var args = {"_": new Date().getMilliseconds()}
	//CallService(service,args,setview);
	utility.service(service,method,args,setview,indexlightSlider)
	
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
		itemview += "<img src='"+val.thumbnail+"' class='img-responsive' />";//responsive
		itemview += "<div class='lightslider-desc' >";
		itemview += "<label>"+val.title+"</label>";
		itemview += "</div>";
		itemview += "</li>";
		
		$('#list').append(itemview);
	});


	 /* script pop to media player */
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

function settinglightSlider(){
	
		$("#list").lightSlider({
		autoWidth: false
		,adaptiveHeight:false
	    ,loop:true
	    ,keyPress:false
		,item:3
	 });
	 /*http://sachinchoolur.github.io/lightslider/settings.html*/
}

function indexlightSlider() {
		$("#list").lightSlider({
		autoWidth: false
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:false
		,item:2
		,slideMargin:4
		,slideWidth:200
	 });
}

function setdefaultview(item){
	$('#title').text(item.title);
	$('#mediaplayer').attr('src',item.link);
}
