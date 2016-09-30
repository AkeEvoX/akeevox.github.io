
function loadlistproduct()
{
	
	$.ajax({
		url:"services/product",
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

function loadproduct(id)
{
	
	$.ajax({
		url:"services/product",
		data:{"_": new Date().getHours() , "id":id,"type":"item"},
		dataType:'json',
		type:"GET",
		success: function(data){
			
			console.log(data);
			setviewitem(data.result);
			//console.warn()
		},
		complete : function(){
			
		 	$("#productgallery").unitegallery({
				theme_panel_position: "left"		
			});
		}
		,error : function (xhr,status,err)
		{
			console.error(xhr);
			alert("load product list error : "+ xhr.responseText);
		}
	});

	loadattribute(id);
}

function loadattribute(id)
{
	$.ajax({
		url:"services/product",
		data:{"_": new Date().getHours() , "id":id,"type":"attr"},
		dataType:'json',
		type:"GET",
		success: function(data){
			
			console.log(data);
			setViewAttribute(data);
			//console.warn()
		},
		complete : function(){
			
		 	$("#productgallery").unitegallery({
				theme_panel_position: "left"		
			});
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
		item += "<a href='productdetail.html?id="+val.id+"' class='btn'>View</a>";
		item += "</div>";
		item += "</li>";
		//console.warn(item);
		view.append(item);

	});
	
}

function setViewAttribute(data)
{
	/*
<label class='col-xs-2 control-label' >prod.code</label>
								<div class='col-xs-4'>
									<p id='prod.code' class='form-control-static'>HELLO WORLD'S </p>
								</div>
	*/

	var view = $('#listattribute');
	$.each(data.result,function(i,val){
		var item = "";

		item += "<label class='col-xs-2 control-label' >"+val.label+"</label>";
		item += "<div class='col-xs-4'><p lass='form-control-static'>"+val.title+"</p></div>";
		//console.warn(item);
		view.append(item);

	});
}

function setviewitem(data)
{

	var view = $('#productgallery');
	console.warn(data.image);
	$.each(data.image,function(i,val){
		var item = "";
		item += "<img src='"+val.image+"' data-image='"+val.image+"' data-description=''  />";
		view.append(item);
	});

/*
<div id="productgallery" style="display:none;">

<img alt="Preview Image 1"
	 src="images/products/FAUCET/faucet-1.thumb.png"
	 data-image="images/products/FAUCET/faucet-1.png"
	 data-description="">
	 */
}
