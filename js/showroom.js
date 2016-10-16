
function loadshowroominfo(id)
{
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
	});
}

function loadshowroomlist(id)
{
	console.log('cate='+id);
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

}

function setviewinfo(data){

	$('span[id="productname"]').text(data.title);
	$('#showtoom_title').text(data.title);
	$('#showroom_detail').text(data.detail);
	//console.log(data.cover);
	$('#showroom_cover').attr('src',data.cover);
}

function setviewlist(data)
{
	var view = $('#viewproduct');
	$.each(data,function(i,val){
		var item = "";

		item += "<div class='row'>";
		item += "<label for='code' class='col-md-3 control-label'>"+val.title+"</label>";
		item += "<div class='col-md-9'><div class='controls'><p class='form-control-static'> "+val.detail+"</p></div></div>";
		item += "<div class='col-md-3' ><img src='"+val.thumb+"' class='img-responsive' /></div>";
		item += "<div class='col-md-9' ><img src='"+val.plan+"' class='img-responsive' /></div>";
		item += "</div>";
		;

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
