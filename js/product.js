var product = function(){};

product.listmenu = function(){
	
	var args = {'_':new Date().getHours(),'type':'menu'}
	utility.service('services/product.php','GET',args,viewmenu);
}

function viewmenu(data){

	var list = $('#productlist');

	var parent = data.result.filter(function(item){ return item.parent=="0"; });
	
	var menu = "";
	$.each(parent,function(i,val){

		var child = data.result.filter(function(item){ return item.parent==val.id; });
		if(child.length==0){//not found child
			menu += "<li><label class='tree-toggle nav-header mainmenu'><a href='"+val.link+"'>"+val.title+"</a></label></li>";
		}
		else{
			menu += "<li><label class='tree-toggle nav-header mainmenu'>"+val.title+"</label>";
			menu += "<ul class='nav nav-list tree'>";
			menu += viewchildmenu(child,data,"");
			menu += "</ul></li>";
		}

	});

	console.warn(menu);

	list.append(menu);
	

}

function viewchildmenu(child,data,menu){

	$.each(child,function(i,val){

		var subchild = data.result.filter(function(item){ return item.parent==val.id; });
		var link = val.link+val.id;
		//console.log("count child = "+subchild.length+" of " + val.title + "["+val.id+"]");
		if(subchild.length==0){

			menu += "<li><a href='"+link+"'>"+val.title+"</a></li>";
		}else{

			menu += "<li><label class='tree-toggle nav-header submenu'>"+val.title+"</label>";
			menu += "<ul class='nav nav-list tree submenu'>";
			//console.log(subchild);
			menu += viewchildmenu(subchild,data,"");

			menu +="</ul>";
		}

	});

	
	return menu;
}

function loadcategorylist(id) {

	var endpoint = "services/product.php";
	var method = "GET";
	var args = {"_": new Date().getHours() ,"cate":id,"type":"list"};
	utility.service(endpoint,method,args,setviewlist);

	var args = {"_": new Date().getHours() ,"id":id,"type":"info"};
	utility.service(endpoint,method,args,setproductcover);

}

//function load

function setproductcover(resp)
{
	console.info("set product conver");
	//console.warn(resp);
	$('#logo-category').attr('src',resp.result.cover);
}

function loadshowroomlist() {

	$.ajax({
		url:"services/product.php",
		data:{"_": new Date().getHours(),"type":"showroom"},
		dataType:'json',
		type:"GET",
		success: function(data){

			console.log(data.result);
			//setviewlist(data);
			//console.warn()
		},
		error : function (xhr,status,err)
		{
			console.error(xhr.responseText);
			alert("load showroom list error : "+ xhr.responseText);
		}
	});

}

function loadproductlist() {

	$.ajax({
		url:"services/product.php",
		data:{"_": new Date().getHours() ,"cate":"1","type":"list"},
		dataType:'json',
		type:"GET",
		success: function(data){

			console.log(data.result);
			setviewlist(data);
			//console.warn()
		},
		error : function (xhr,status,err)
		{
			console.error(xhr.responseText);
			alert("load product list error : "+ xhr.responseText);
		}
	});

}

function loadproductreleated(id) {
	$.ajax({
		url:"services/product.php",
		data:{"_": new Date().getHours() ,"id":id,"type":"related"},
		dataType:'json',
		type:"GET",
		success: function(data){

			console.log(data);
			setViewReleated(data);

		},
		complete : function(data){

			//initial slider

			$("#product-slider").lightSlider({
				autoWidth: true
				,item:4
				,adaptiveHeight:true
				,loop:true
				,keyPress:true
				,pager:false
			});

		},
		error : function (xhr,status,err)
		{
			console.error(xhr.responseText);
			alert("load product releated list error : "+ xhr.responseText);
		}
	});
}

function loadproduct(id) {

	$.ajax({
		url:"services/product.php",
		data:{"_": new Date().getHours() , "id":id,"type":"item"},
		dataType:'json',
		type:"GET",
		success: function(data){

			setviewitem(data.result);
		}
		,complete:function(data){


			$("#productgallery").unitegallery({
				theme_panel_position: "left"
				,slider_scale_mode: "fit"
				,thumb_fixed_size:true
				,thumb_width:100								//thumb width
				,thumb_height:60
				,thumb_loader_type:"light"
			});

		}
		,error : function (xhr,status,err)
		{
			console.error("load product error > " + xhr.responseText);
			alert("load product error : "+ xhr.responseText);
		}
	});


}

function loadattribute(id) {
	$.ajax({
		url:"services/product.php",
		data:{"_": new Date().getHours() , "id":id,"type":"attr"},
		dataType:'json',
		type:"GET",
		success: function(data){

			//console.log(data);
			setViewAttribute(data);
		}
		,error : function (xhr,status,err)
		{
			console.error(xhr);
			alert("load product attribute error : "+ xhr.responseText);
		}
	});
}

function setviewlist(data)
{
	if(data!==undefined && data.result!=null)
	{
		var view = $('#viewproduct');

		$.each(data.result,function(i,val){
			var item = "";

			item += "<li class='col-md-3 col-sm-6 col-xs-12' >";
			item += "<div class='port-1 effect-2' >";
			item += "<div class='image-box' >";
			item += "<img src='"+val.thumb+"' class='img-fluid h150' alt=''>";
			item += "<div class='thumbnail-desc'><label>"+val.name+"</label><span>"+val.code+"</span></div>";
			item += "</div>";
			item += "<div class='text-desc'>";
			item += "<p><span class='bigger glyphicon glyphicon-zoom-in orange topbar'></span><p/>";
			item += "<a href='productdetail.html?id="+val.id+"' class='hover-btn'>View</a>";
			item += "</div>";
			item += "</li>";
			//console.warn(item);
			view.append(item);

		});
	}

}

function setViewReleated(data){

	var view = $('#product-slider');
	if(data!==undefined && data.result!=null){
		$.each(data.result,function(i,val){

			var item = "";
			item += "<li  ><a href='productdetail.html?id="+val.id+"' >";
			item += "<img src='"+val.thumb+"' class='img-responsive' >";
			item += "<div class='lightslider-title'><label>"+val.name+"</label></div>";
			item += "<ul class='lightslider-desc'>";
			item += "<li>&nbsp;</li>";
			item += "<li>&nbsp;</li>";
			item += "<li>&nbsp;</li>";
			item += "<li>&nbsp;</li>";
			item += "<li>&nbsp;</li>";
			item += "</ul>";
			item += "</a></li>";

			view.append(item);

		});
	}
}

function setViewAttribute(data)
{
		var view = $('#listattribute');
		if(data!==undefined && data.result!=null){

		$.each(data.result,function(i,val){
			var item = "";

			item += "<label class='col-xs-3 control-label' >"+val.label+"</label>";
			item += "<div class='col-xs-3'><p lass='form-control'>"+val.title+"</p></div>";
			//console.warn(item);
			view.append(item);

		});
	}
}

function setviewitem(data)
{

	var view = $('#productgallery');
	//view info
	if(data!==undefined){

		$('span[id="productname"]').text(data.title);

		$('#plan').attr('src',data.plan);
		//view image list
		if(data.image!=null){
			$.each(data.image,function(i,val){
				var item = "";
				item += "<img src='"+val.image+"' data-image='"+val.image+"' data-description=''  />";
				view.append(item);
			});
		}
	}
}
