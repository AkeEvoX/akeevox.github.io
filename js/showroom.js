
function loadshowroominfo(id)
{
	var endpoint = "services/product.php";
	var method='get';
	var args = {"_": new Date().getMilliseconds() ,"type":"showroom","id":id};
	
	utility.service(endpoint,method,args,setviewinfo,function(){
		loadserieslist(id);
	});

	/*
	$.ajax({
		url:"services/product.php",
		data:{"_": new Date().getHours() ,"type":"showroom","id":id},
		dataType:'json',
		type:"GET",
		success: function(data){

			console.log(data.result);
			setviewinfo(data.result);
			//console.warn()
		},
		complete:function(obj){
			var data = obj.responseJSON.result;
			loadshowroomlist(data.id);
		},
		error : function (xhr,status,err)
		{
			console.error(xhr.responseText);
			alert("load series list error : "+ xhr.responseText);
		}
	});*/
}

function loadshowroomlist(id)
{
	
	console.log('cate='+id);
	
	var endpoint = "services/product.php";
	var method='GET';
	var args = {"_": new Date().getMilliseconds() ,"type":"list_room","id":id};//list_series
	utility.service(endpoint,method,args,setviewlist,function(){
		explain_mobile();
	});
	
	/*
	$.ajax({
		url:"services/product.php",
		data:{"_": new Date().getHours() ,"type":"list","cate":id},
		dataType:'json',
		type:"GET",
		success: function(data){

			console.log(data.result);
			setviewlist(data.result);
			//console.warn()
		},
		error : function (xhr,status,err)
		{
			console.error(xhr.responseText);
			alert("load series list error : "+ xhr.responseText);
		}
	});
	*/
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
	
	var view = $('#viewproduct');
	$.each(data,function(i,val){
		var item = "";

		item += "<div class='row'>";
		item += "<label for='code' class='col-md-4 control-label'>"+val.title+" " +val.code+"</label>";
		item += "<div class='col-md-8'><span>"+val.detail+"</span></div>";
		item += "</div><hr/><div class='row'>";
		item += "<div class='col-md-3 thumb' ><img src='"+val.thumb+"' title='"+val.typeid+"' onerror=this.src='images/common/unavaliable.jpg'  class='img-responsive' /></div>";
		item += "<div class='col-md-9 plan' ><img src='"+val.plan+"' onerror=this.src='images/common/unavaliable.jpg'  class='img-fluid' /></div>";
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