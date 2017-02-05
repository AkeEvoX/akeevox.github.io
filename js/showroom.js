
function loadshowroominfo(id){
	var endpoint = "services/product.php";
	var method='get';
	var args = {"_": new Date().getMilliseconds() ,"type":"showroom","id":id};
	
	utility.service(endpoint,method,args,setviewinfo,function(){
		load_showroom_list(id);
	});
}

function load_showroom_list(id) {
	
	console.log('cate='+id);
	
	var endpoint = "services/product.php";
	var method='GET';
	var args = {"_": new Date().getMilliseconds() ,"type":"list_room","id":id};//list_series
	utility.service(endpoint,method,args,setviewlist,function(){
		explain_mobile();
	});

}

function setviewinfo(data){
	
	if(data.result==undefined ||data.result==null)
		return;
	
	var item = data.result;

	$('span[id="productname"]').text(item.title);
	$('#showroom_title').text(item.title);
	$('#showroom_detail').text(item.detail);
	//console.log(data.cover);
	$('#showroom_cover').attr('src',item.cover);
}

function setviewlist(data)
{
	if(data.result==undefined ||data.result==null)
		return;
	
	console.debug(data);
	
	var view = $('#viewproduct');
	$.each(data.result,function(i,val){
		var item = "";

		item += "<div class='row'>";
		item += "<label for='code' class='col-md-4 control-label'>"+val.title+" " +val.code+"</label>";
		item += "<div class='col-md-8'><span>"+val.title+"</span></div>";
		item += "</div><hr/><div class='row'>";
		item += "<div class='col-sm-3 col-md-3 thumb' ><img src='"+val.thumb+"' title='"+val.typeid+"' class='img-responsive' onerror=this.src='images/common/unavaliable.jpg'  /></div>";
		item += "<div class='col-xs-12 col-sm-9 col-md-9 plan' ><img src='"+val.plan+"' onerror=this.src='images/common/unavaliable.jpg'  class='img-responsive' /></div>";
		item += "</div>";
		

		view.append(item);

	});

}

function setviewitem(data)
{

	var view = $('#productgallery');
	//console.warn(data);
	//view info
	$('#plan').attr('src',data.plan);
	//view image list
	$.each(data.image,function(i,val){
		var item = "";
		item += "<img src='"+val.image+"' data-image='"+val.image+"' data-description=''  />";
		view.append(item);
	});

}

function explain_mobile(){
	
	$('.plan').find('img').on('error',function(){
		$(this).css({'min-width':'200px'});
	});

}