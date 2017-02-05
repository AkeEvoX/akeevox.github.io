
function loadseriesinfo(id)
{
	console.info('series id = '+id);
	var endpoint = "services/product.php";
	var method='get';
	var args = {"_": new Date().getMilliseconds() ,"type":"series","id":id};
	
	utility.service(endpoint,method,args,setviewinfo,function(){
		loadserieslist(id);
	});

}

function loadserieslist(id)
{
	console.log('cate='+id);
	
	var endpoint = "services/product.php";
	var method='GET';
	var args = {"_": new Date().getMilliseconds() ,"type":"list_series","id":id};//list_series
	
	utility.service(endpoint,method,args,setviewlist,function(){
		explain_mobile();
	});
	
}

function setviewinfo(data){
	
	if(data.result==undefined ||data.result==null)
		return;
	
	var item = data.result;
	
	$('span[id="productname"]').text(item.title);
	$('#series_title').text(item.title);
	$('#series_detail').text(item.detail);
	$('#series_cover').attr('src',item.cover);
}

function setviewlist(data)
{
	if(data.result==undefined ||data.result==null)
		return;
	
	var view = $('#viewproduct');
	var item = "";
	
	console.log(data.result);
	
	$.each(data.result,function(i,val){

		item += "<div class='row'><hr/>";
		item += "<label for='code' class='col-md-4'>"+val.name+" "+val.code+"</label>";
		item += "<div class='col-md-8'><span> "+val.title+"</span></div>";
		item += "</div><hr/><div class='row'>";
		item += "<div class='col-sm-3 col-md-3 thumb' ><img src='"+val.thumb+"' title='"+val.typeid+"' class='img-responsive' onerror=this.src='images/common/unavaliable.jpg' /></div>";
		item += "<div class='col-xs-12 col-sm-9 col-md-9 plan' ><img src='"+val.plan+"' onerror=this.src='images/common/unavaliable.jpg' class='img-fluid' /></div>";
		item += "</div>";
		
	});
	
			view.append(item);
}

function explain(obj){
	
	var src = $(obj).attr('src');
	console.log(src);
	if(src!="images/common/unavaliable.jpg")
	{
		$(obj).css({'min-width':'500px'});
	}
	
	
}

function explain_mobile(){
	
	$('.plan').find('img').on('error',function(){
		$(this).css({'min-width':'200px'});
	});

}

function setviewitem(data)
{

	var view = $('#productgallery');
	console.warn(data);
	//view info

	$('#plan').attr('src',data.plan);
	//view image list
	$.each(data.image,function(i,val){
		var item = "";
		item += "<img src='"+val.image+"' data-image='"+val.image+"' data-description=''  />";
		view.append(item);
	});

}
