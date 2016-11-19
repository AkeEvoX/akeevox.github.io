
function setup_slider()
{
	
	//inter-slider
	$("#inter-slider").lightSlider({
		autoWidth: true
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:true
	 });
	 
	 //local-slider
	$("#local-slider").lightSlider({
		autoWidth: true
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:true
	 });

	//activateSliders();
}

function activateSliders() {

    $('.slider').each(function(){

       var sliderId =  $(this).attr('id');
		console.log(sliderId);
       $("#" + sliderId).lightSlider();

    });
}

function loadprojectlist(local)
{

 //<h3><span class='glyphicon glyphicon-stop'></span><span id='refer.list'>Project List</span></h3>

	var endpoint = "services/organization.php";
	var method='get';
	var args = {"_": new Date().getHours() , "type":"project","local":local};
	utility.service(endpoint,method,args,viewprojectlist);

}

function viewprojectlist(resp){

	var view = $('#refer-list');
	var item = "";
	console.warn(resp);
	$.each(resp.result,function(i,val){
		item += "<tr>";
		item += "<td>"+val.title+"</td>";
		item += "<td>"+val.location+"</td>";
		item += "</tr>";
	});

	view.append(item);
}

function loadreference()
{
	var endpoint = "services/organization.php";
	var method = "get";
	var args = {"_": new Date().getHours() , "type":"refer"};
	
	utility.service(endpoint,method,args,seperateproject);
	

	/*
	$.ajax({
		url:"services/organization.php",
		data:{"_": new Date().getHours() , "type":"refer"},
		dataType:'json',
		type:"GET",
		success: function(data){
			
			try{
				console.log(data.result);

				if(data.result != undefined)
				{

					var inter = data.result.filter(function(item){ return item.local=="0"; });


					var local = $.grep(data.result,function(value,i){
						return (value.local == "1") ;
					});

					displaylocal(local);
					displayinter(inter);
				}
			}catch(err)
			{
				console.error("organization refer :" +err.message);
			}

		},
		complete:function(){

			setup_slider();


		},
		error : function (xhr,status,err)
		{
			console.error("load organization reference error : " + xhr.responseText);
			alert("load organization reference error : "+ xhr.responseText);
		}
	});
	*/
}

function seperateproject(resp){
		if(resp.result != undefined)
				{

					var inter = resp.result.filter(function(item){ return item.local=="0"; });


					var local = $.grep(resp.result,function(value,i){
						return (value.local == "1") ;
					});

					displaylocal(local);
					displayinter(inter);
				}
}

function displayinter(data){
	var view = $('#inter-slider');
	var list = $('#refer-inter-list');
	var item = "";
	var project ="";
	$.each(data,function(idx,val){

		item= "<li ><a href='refer-info.html?id="+val.id+"&local=0'>";
		item+= "<img src='"+val.thumbnail+"' onerror=this.src='images/common/unavaliable.jpg' class='img-fluid' />";
		item+= "<div class='lightslider-desc'><span class='glyphicon glyphicon-stop' ></span>&nbsp;<label>"+val.title+"</label></div>";
		item+= "</a></li>";
		view.append(item);
		project += "<tr>";
		project += "<td>"+val.title+"</td>";
		project += "<td>"+val.detail+"</td>";
		project += "</tr>";

	});


	
	list.append(project);
	
	view.lightSlider({
		autoWidth: true
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:true
	 });
	 
}


function displaylocal(data) {

	var view = $('#local-slider');
	var list = $('#refer-local-list');
	var item = "";
	var project ="";
	$.each(data,function(idx,val){
		item= "<li><a href='refer-info.html?id="+val.id+"&local=1'>";
		item+= "<img src='"+val.thumbnail+"'  onerror=this.src='images/common/unavaliable.jpg' class='img-fluid' />";
		item+= "<div class='lightslider-desc'><span class='glyphicon glyphicon-stop' ></span>&nbsp;<label>"+val.title+"</label></div>";
		item+= "</a></li>";
		view.append(item);
		
		project += "<tr>";
		project += "<td>"+val.title+"</td>";
		project += "<td>"+val.detail+"</td>";
		project += "</tr>";
		
		
	});
	
	list.append(project);
	
	view.lightSlider({
		autoWidth: true
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:true
	 });
	
}



function loadinfo() {
	$.ajax({
		url:"services/attributes.php",
		data:{"_": new Date().getHours() , "type":"chart"},
		dataType:'json',
		type:"GET",
		success: function(data){

			console.log(data.result);

			$('#media-data img').attr('src',data.result.chart);
		},
		error : function (xhr,status,err)
		{
			console.error("load organization chart error : " + xhr.responseText);
			alert("load organization chart error : "+ xhr.responseText);
		}
	});

}

function getreferal(id)
{
	var endpoint = "services/organization.php";
	var method = "get";
	var args = {'_':new Date().getMilliseconds(),'id':id,'type':'referid'};
	utility.service(endpoint,method,args,viewreferal);
}

function viewreferal(resp)
{

	if(resp.result != undefined )
	{
		console.warn(resp.result);
		$('span[id="refer.subject"]').html(resp.result.title);
		$('#title-data').html(resp.result.title);
		$('#content-data').html(resp.result.detail);
		$('#media-data img').attr('src',resp.result.thumbnail);

	}
}
