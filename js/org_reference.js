
function setup_slider()
{

	$("#inter-slider").lightSlider({
		autoWidth: false
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:true
	 });

	$("#local-slider").lightSlider({
		autoWidth: false
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:true
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
		item += "<td>"+val.contury+"</td>";
		item += "</tr>";
	});

	view.append(item);
}

function loadreference()
{
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
}

function displayinter(data){
	var view = $('#inter-slider');
	var list = $('#refer-inter-list');
	var item = "";
	var project ="";
	$.each(data,function(idx,val){

		item+= "<li ><a href='refer-info.html?id="+val.id+"&local=0'>";
		item+= "<img src='"+val.thumbnail+"' class='img-fluid' />";
		item+= "<div class='lightslider-desc'><label>"+val.title+"</label></div>";
		item+= "</a></li>";

		project += "<tr>";
		project += "<td>"+val.title+"</td>";
		project += "<td>"+val.detail+"</td>";
		project += "</tr>";

	});


	view.append(item);
	list.append(project);
}


function displaylocal(data) {
	var view = $('#local-slider');
	var list = $('#refer-local-list');
	var item = "";
	var project ="";
	$.each(data,function(idx,val){
		item+= "<li><a href='refer-info.html?id="+val.id+"&local=1'>";
		item+= "<img src='"+val.thumbnail+"' class='img-fluid' />";
		item+= "<div class='lightslider-desc'><label>"+val.title+"</label></div>";
		item+= "</a></li>";

		project += "<tr>";
		project += "<td>"+val.title+"</td>";
		project += "<td>"+val.detail+"</td>";
		project += "</tr>";
	});
	view.append(item);
	list.append(project);
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
