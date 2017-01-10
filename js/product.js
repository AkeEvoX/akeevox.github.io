$(document).ready(function(){
	
	$('#btn_compare').on('click',function(){
		product.compare();
	});
	
	$('#btn_pring').on('click',function(){
		//window.print();
		window.open('product_print.html?id='+utility.querystr('id'), 'sharer', 'toolbar=0, status=0, width=576, height=798');
	});

	$('span[id="productdetail.compare.reset"]').on('click',function(){
		product.compare_reset();
	});
	
});

var product = function(){};

product.listmenu = function(){
	
	var args = {'_':new Date().getHours(),'type':'menu'}
	utility.service('services/product.php','GET',args,viewmenu,function(){
		/*set slide dropdown*/
		
		/*hide menu*/
		$('.tree-toggle').parent().children('ul.submenu').toggle(200);

		/*explain submenu*/
		$('.tree-toggle').click(function () {
			$(this).parent().children('ul.tree').toggle(200);
		});
		
	});
}


product.compare = function(){
	
	var id = $('#btn_compare').attr('data-id');
	var thumb = $('#btn_compare').attr('data-thumb');

	var endpoint = 'services/compare.php';
	var method ='get';
	var args = {'_':new Date().getMilliseconds(),'id':id,'thumb':thumb};
	utility.service(endpoint,method,args,setViewCompare,setting_slider);

}

product.compare_reset = function(){
	var endpoint = 'services/clearcache.php';
	var method ='get';
	var args = {'_':new Date().getMilliseconds()};
	utility.service(endpoint,method,args,function(){
		$('#control_compare').hide(); 
	});

	
}

product.compare_remove = function(id){
	var endpoint = 'services/compare.php';
	var method = 'get';
	var args = {'_':new Date().getMilliseconds(),'type':'remove','id':id};
	
	utility.service(endpoint,method,args,setViewCompare,setting_slider);
}

function setting_slider(data){
	
	if(data.responseJSON.result==null || data.responseJSON.result.length=="0" ){
		$('#control_compare').hide();
		return;
	}
		
	$('#control_compare').show();
	/*adjust image slider*/
	$("#compare-slider").lightSlider({
				autoWidth: false
				,adaptiveHeight:true
				,loop:true
				,keyPress:false
				,pager:false
				,slideMargin:5
	});
	/*setting remove compare*/
	$('.icon_close').on('click',function(){			
			var id = $(this).attr('data-id');
			console.log("remove id = "+id);
			product.compare_remove(id);
	});

}

function remove_compare(id){
	var endpoint = 'services/compare.php';
	var method = 'get';
	var args = {'_':new Date().getMilliseconds(),'type':'remove','id':id};
	
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

	//console.warn(menu);
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

			menu +="</ul></li>";
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
				,keyPress:false
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
				,thumb_fixed_size:false
				,thumb_width:100
				,thumb_height:80
				,thumb_loader_type:"light"
				,grid_num_cols:1
				,gridpanel_grid_align: "top"
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
			var name = val.name;
			
			
			if(name != null && name.length > 10)
				name = name.slice(0,10)+"..";
			
			item += "<li class='col-md-3 col-sm-6 col-xs-12' >";
			item += "<div class='port-1 effect-2' >";
			item += "<div class='image-box' >";
			item += "<img src='"+val.thumb+"' onerror=this.src='images/common/unavaliable.jpg' class='img-fluid h150' alt=''>";
			item += "<div class='thumbnail-desc'><label>"+name+"</label><span>"+val.code+"</span></div>";
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
			item += "<img src='"+val.thumb+"' onerror=this.src='images/common/unavaliable.jpg' class='img-responsive' >";
			item += "<div class='lightslider-title'><label>"+val.name+"</label></div>";
			item += "<ul class='lightslider-desc'>";
			//item += "<li>&nbsp;</li>";
			//item += "<li>&nbsp;</li>";
			//item += "<li>&nbsp;</li>";
			//item += "<li>&nbsp;</li>";
			//item += "<li>&nbsp;</li>";
			item += "</ul>";
			item += "</a></li>";

			view.append(item);

		});
	}
}

function setViewCompare(data){

	console.debug(data);
	var view = $('#compare-slider');
	view.html('');
	if(data!==undefined && data.result!=null){
		$.each(data.result,function(i,val){

			var item = "";
			item += "<li  ><div class='icon_close' data-id='"+val.id+"' ><img style='width:24px;height:24px;' src='images/common/close.png' /></div>";
			item += "<a href='javascript:void(0);' >";
			item += "<img src='"+val.thumb+"' onerror=this.src='images/common/unavaliable.jpg' class='img-responsive' >";
			//item += "<div class='lightslider-title'><label>&nbsp;</label></div>";
			//item += "<ul class='lightslider-desc'>";
			//item += "<li>&nbsp;</li>";
			//item += "<li>&nbsp;</li>";
			//item += "<li>&nbsp;</li>";
			//item += "<li>&nbsp;</li>";
			//item += "<li>&nbsp;</li>";
			//item += "</ul>";
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
			var title = val.title == "" ? "&nbsp;" : val.title ; 
			item += "<div class='col-xs-6 col-sm-6' >"
			item += "<label class='col-xs-6 control-label' >"+val.label+"</label>";
			item += "<div class='col-xs-6 col-sm-6'><p lass='form-control'>"+title+"</p></div>";
			item += "</div>"
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
	
		console.log(data);
		$('span[id="productname"]').text(data.title);

		$('#plan').attr('src',data.plan);
		$('#symbol_view').attr('src',data.symbol_file);
		$('#pdf_view').attr('href',data.pdf_file);
		$('#dwg_view').attr('href',data.dwg_file);
		$('#btn_compare').attr('data-id',data.id);//data-thumb
		$('#btn_compare').attr('data-thumb',data.thumb);
		
		//add meta for share facebook
		addmeta(data.title,data.thumb);
		
		var colors = $('#productcolor');
		colors.html("");
		if(data.colors!=null){
			$.each(data.colors,function(i,val){
				var item = "";
				item = "<img src='"+val.color+"'  onerror=this.src='images/common/unavaliable.jpg' /> ";
				colors.append(item);
			});
		}
		
		//view image list
		if(data.image!=null){
			$.each(data.image,function(i,val){
			
				var item = "";
				item += "<img src='"+val.image+"' data-image='"+val.image+"' onerror=this.src='images/common/unavaliable.jpg' data-description=''  />";
				view.append(item);
			});
		}
		
		
		
	}
}

function addmeta(title,image){
	
	var meta = "";
	var url = document.URL;
	var thumb =  document.location.origin +"/"+image;

	 product.info =  {
		 
		url:url,
		image:thumb,
		title:title,
		description : "Product " + title + " of starsanitaryware "
	 }
	 
}
